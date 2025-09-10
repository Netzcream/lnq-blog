<?php

namespace Lnq\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lnq\Blog\Concerns\HasTranslations;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use SoftDeletes, HasTranslations;

    protected $table = 'blog_categories';
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'slug',
        'order',
        'parent_id',
        'created_by',
        'updated_by',
    ];
    protected $casts = ['name' => 'array', 'description' => 'array'];

    // Accessors/mutators simples por campo traducible:
    public function getNameAttribute($v)
    {
        return $this->fromJsonLocale($this->attributes['name'] ?? null);
    }
    public function setNameAttribute($v)
    {
        $this->attributes['name'] = json_encode($this->toJsonLocale('name', $v));
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function getDescriptionAttribute($v)
    {
        $raw = $this->attributes['description'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setDescriptionAttribute($v)
    {
        $this->attributes['description'] = $v ? json_encode($this->toJsonLocale('description', $v)) : null;
    }
    public function scopeOrdered($q)
    {
        return $q->orderBy('parent_id')->orderBy('order');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /** @var User $user */
            $user = Auth::user();
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
            if (!$model->isDirty('created_by')) {

                $model->created_by = $user?->id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $user?->id;
            }
        });
        static::updating(function ($model) {
            /** @var User $user */
            $user = Auth::user();
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $user?->id;
            }
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $product = $this->where('slug', $value)->first();
        if (! $product && preg_match('/^[0-9a-fA-F\-]{36}$/', $value)) {
            $product = $this->where('uuid', $value)->first();
        }
        if (! $product && is_numeric($value)) {
            $product = $this->where('id', $value)->first();
        }
        return $product ?? abort(404);
    }


    public function scopeFindByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }
}
