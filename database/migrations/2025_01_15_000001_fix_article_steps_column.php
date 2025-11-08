<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if column exists, if not create it
        if (!Schema::hasColumn('articles', 'article_steps')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->json('article_steps')->nullable()->after('content');
            });
        } else {
            // If column exists, ensure it's JSON type
            Schema::table('articles', function (Blueprint $table) {
                $table->json('article_steps')->nullable()->change();
            });
        }

        // Fix existing data: convert JSON strings to proper JSON
        // Note: This will be handled by the FixArticleSteps command for better control
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the column, just in case
        // Schema::table('articles', function (Blueprint $table) {
        //     $table->dropColumn('article_steps');
        // });
    }
};

