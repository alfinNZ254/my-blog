<?php

// database/migrations/xxxx_xx_xx_add_article_steps_to_articles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if table exists
        if (!Schema::hasTable('articles')) {
            return; // Table doesn't exist yet, skip this migration
        }

        // Check if column already exists
        if (!Schema::hasColumn('articles', 'article_steps')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->json('article_steps')->nullable()->after('content');
            });
        }
        // If column already exists, do nothing
    }

    public function down()
    {
        // Check if table exists and column exists
        if (Schema::hasTable('articles') && Schema::hasColumn('articles', 'article_steps')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('article_steps');
            });
        }
    }
};
