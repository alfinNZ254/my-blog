<?php

// database/migrations/add_template_fields_to_articles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('template_type')->default('tutorial'); // tutorial, review, tips, etc
            $table->json('article_sections')->nullable(); // Store structured content
            $table->integer('difficulty_level')->default(1); // 1=Beginner, 2=Intermediate, 3=Advanced
            $table->json('prerequisites')->nullable(); // Prerequisites for tutorial
            $table->integer('estimated_time')->nullable(); // Estimated completion time in minutes
            $table->json('technologies')->nullable(); // Technologies used
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'template_type', 
                'article_sections', 
                'difficulty_level', 
                'prerequisites', 
                'estimated_time',
                'technologies'
            ]);
        });
    }
};
