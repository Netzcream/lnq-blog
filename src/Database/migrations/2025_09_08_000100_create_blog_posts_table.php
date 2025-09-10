<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $t) {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->json('title');
            $t->json('excerpt')->nullable();
            $t->json('content')->nullable();
            $t->string('slug');
            $t->foreignId('category_id')->nullable()->constrained('blog_categories')->nullOnDelete();
            $t->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->boolean('is_published')->default(false);
            $t->timestamp('published_at')->nullable();
            $t->json('extra_data')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->unique(['slug', 'deleted_at'], 'blog_posts_slug_deleted_at_unique');
            $t->index(['is_published', 'published_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
