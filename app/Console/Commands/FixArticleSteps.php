<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class FixArticleSteps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:fix-steps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix article_steps data format in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to fix article_steps data...');

        $articles = Article::all();
        $fixed = 0;
        $skipped = 0;

        foreach ($articles as $article) {
            $steps = $article->article_steps;
            
            // If it's already an array, skip
            if (is_array($steps)) {
                $skipped++;
                continue;
            }
            
            // If it's a string, try to decode and save
            if (is_string($steps)) {
                $decoded = json_decode($steps, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $article->article_steps = $decoded;
                    $article->save();
                    $fixed++;
                    $this->line("Fixed article: {$article->title} (ID: {$article->id})");
                } else {
                    // Invalid JSON, set to null
                    $article->article_steps = null;
                    $article->save();
                    $fixed++;
                    $this->warn("Cleared invalid JSON for article: {$article->title} (ID: {$article->id})");
                }
            } else {
                // Null or other type, ensure it's null
                if ($steps !== null) {
                    $article->article_steps = null;
                    $article->save();
                    $fixed++;
                } else {
                    $skipped++;
                }
            }
        }

        $this->info("Completed! Fixed: {$fixed}, Skipped: {$skipped}");
        return Command::SUCCESS;
    }
}

