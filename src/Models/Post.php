<?php
namespace Lnq\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lnq\Blog\Concerns\HasTranslations;

class Post extends Model
{
    use SoftDeletes, HasTranslations;

    protected $table = 'blog_posts';
    protected $fillable = [
        'title','excerpt','content','slug','category_id',
        'is_published','published_at','extra_data'
    ];
    protected $casts = [
        'title'=>'array','excerpt'=>'array','content'=>'array',
        'published_at'=>'datetime','extra_data'=>'array',
        'is_published'=>'boolean',
    ];

    // traducibles
    public function getTitleAttribute($v) {
        $raw = $this->attributes['title'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setTitleAttribute($v) { $this->attributes['title'] = json_encode($this->toJsonLocale('title', $v)); }

    public function getExcerptAttribute($v) {
        $raw = $this->attributes['excerpt'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setExcerptAttribute($v) { $this->attributes['excerpt'] = $v ? json_encode($this->toJsonLocale('excerpt', $v)) : null; }

    public function getContentAttribute($v) {
        $raw = $this->attributes['content'] ?? null;
        return $this->fromJsonLocale($raw ? json_decode($raw, true) : null);
    }
    public function setContentAttribute($v) { $this->attributes['content'] = $v ? json_encode($this->toJsonLocale('content', $v)) : null; }

    // relaciones
    public function category() { return $this->belongsTo(Category::class, 'category_id'); }

    // scopes
    public function scopePublished($q) {
        return $q->where('is_published', true)->whereNotNull('published_at')->where('published_at','<=',now());
    }
}
