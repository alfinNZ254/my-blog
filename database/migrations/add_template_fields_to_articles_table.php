<?php

// database/migrations/add_template_fields_to_articles_table.php
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

        // Add columns only if they don't exist
        $columnsToAdd = [
            'template_type' => function($table) {
                $table->string('template_type')->default('tutorial');
            },
            'article_sections' => function($table) {
                $table->json('article_sections')->nullable();
            },
            'difficulty_level' => function($table) {
                $table->integer('difficulty_level')->default(1);
            },
            'prerequisites' => function($table) {
                $table->json('prerequisites')->nullable();
            },
            'estimated_time' => function($table) {
                $table->integer('estimated_time')->nullable();
            },
            'technologies' => function($table) {
                $table->json('technologies')->nullable();
            },
        ];

        foreach ($columnsToAdd as $columnName => $callback) {
            if (!Schema::hasColumn('articles', $columnName)) {
                try {
                    Schema::table('articles', $callback);
                } catch (\Exception $e) {
                    // Skip if column addition fails
                    \Log::info("Could not add column {$columnName}: " . $e->getMessage());
                }
            }
        }
    }

    public function down()
    {
        // Check if table exists
        if (!Schema::hasTable('articles')) {
            return;
        }

        // Drop columns only if they exist
        $columnsToDrop = [
            'template_type', 
            'article_sections', 
            'difficulty_level', 
            'prerequisites', 
            'estimated_time',
            'technologies'
        ];

        $existingColumns = [];
        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('articles', $column)) {
                $existingColumns[] = $column;
            }
        }

        if (!empty($existingColumns)) {
            Schema::table('articles', function (Blueprint $table) use ($existingColumns) {
                $table->dropColumn($existingColumns);
            });
        }
    }
};
