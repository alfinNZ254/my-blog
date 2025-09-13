<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'is_published',
        'published_at',
        'article_steps' // Tambahkan ini
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'article_steps' => 'array' // Tambahkan ini
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Otomatis membuat slug sebelum artikel dibuat
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        // Otomatis memperbarui slug saat artikel diperbarui
        static::updating(function ($article) {
            if ($article->isDirty('title')) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope a query to only include published articles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the estimated reading time for the article.
     *
     * @return int
     */
    public function getReadingTimeAttribute()
    {
        // Hitung waktu membaca berdasarkan langkah-langkah jika ada
        if ($this->article_steps) {
            $wordCount = 0;
            foreach ($this->article_steps as $step) {
                $wordCount += str_word_count(strip_tags($step['explanation'] ?? ''));
            }
            return max(ceil($wordCount / 200), 1); // Minimum 1 menit
        }

        // Fallback ke konten jika article_steps tidak tersedia
        $wordCount = str_word_count(strip_tags($this->content));
        return max(ceil($wordCount / 200), 1);
    }

    /**
     * Get the number of steps in the article.
     *
     * @return int
     */
    public function getStepsCountAttribute()
    {
        return $this->article_steps ? count($this->article_steps) : 0;
    }
}
