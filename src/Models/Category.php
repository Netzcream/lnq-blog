<?php
namespace Lnq\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lnq\Blog\Concerns\HasTranslations;

class Category extends Model
{
    use SoftDeletes, HasTranslations;

    protected $table = 'blog_categories';
    protected $fillable = ['name','description','slug','order'];
    protected $casts = ['name'=>'array','description'=>'array'];

    // Accessors/mutators simples por campo traducible:
    public function getNameAttribute($v) { return $this->fromJsonLocale($this->attributes['name'] ?? null); }
    public function setNameAttribute($v) { $this->attributes['name'] = json_encode($this->toJsonLocale('name', $v)); }

    public function getDescriptionAttribute($v) {
        $raw = $this->attributes['description'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setDescriptionAttribute($v) {
        $this->attributes['description'] = $v ? json_encode($this->toJsonLocale('description', $v)) : null;
    }

    public function posts() { return $this->hasMany(Post::class, 'category_id'); }
}
