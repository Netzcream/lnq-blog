<?php

namespace Lnq\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lnq\Blog\Concerns\HasTranslations;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use SoftDeletes, HasTranslations;

    protected $table = 'blog_posts';
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'slug',
        'category_id',
        'is_published',
        'published_at',
        'created_by',
        'updated_by',
        'extra_data'
    ];
    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'content' => 'array',
        'published_at' => 'datetime',
        'extra_data' => 'array',
        'is_published' => 'boolean',
    ];

    // traducibles
    public function getTitleAttribute($v)
    {
        $raw = $this->attributes['title'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setTitleAttribute($v)
    {
        $this->attributes['title'] = json_encode($this->toJsonLocale('title', $v));
    }

    public function getExcerptAttribute($v)
    {
        $raw = $this->attributes['excerpt'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setExcerptAttribute($v)
    {
        $this->attributes['excerpt'] = $v ? json_encode($this->toJsonLocale('excerpt', $v)) : null;
    }

    public function getContentAttribute($v)
    {
        $raw = $this->attributes['content'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setContentAttribute($v)
    {
        $this->attributes['content'] = $v ? json_encode($this->toJsonLocale('content', $v)) : null;
    }

    // relaciones
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // scopes
    public function scopePublished($q)
    {
        return $q->where('is_published', 1)->whereNotNull('published_at')->where('published_at', '<=', now());
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
