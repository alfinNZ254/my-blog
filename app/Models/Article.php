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
        $steps = $this->getArticleStepsArray();

        if (!empty($steps)) {
            $wordCount = 0;
            foreach ($steps as $step) {
                $wordCount += str_word_count(strip_tags($step['explanation'] ?? ''));
            }
            return max(ceil($wordCount / 200), 1); // Minimum 1 menit
        }

        // Fallback ke konten jika article_steps tidak tersedia
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        return max(ceil($wordCount / 200), 1);
    }

    /**
     * Get the number of steps in the article.
     *
     * @return int
     */
    public function getStepsCountAttribute()
    {
        $steps = $this->getArticleStepsArray();
        return is_array($steps) ? count($steps) : 0;
    }

    /**
     * Get article steps as array, handling both JSON string and array formats.
     *
     * @return array
     */
    public function getArticleStepsArray()
    {
        $steps = $this->article_steps;
        
        // If already an array, return it
        if (is_array($steps)) {
            return $steps;
        }
        
        // If it's a string, try to decode it
        if (is_string($steps)) {
            $decoded = json_decode($steps, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }
        
        // Return empty array if invalid
        return [];
    }
}
