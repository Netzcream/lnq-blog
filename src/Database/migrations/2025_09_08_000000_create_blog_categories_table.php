<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $t) {
            $t->id();
            $t->uuid('uuid')->unique();
            $t->json('name');                 // traducible
            $t->json('description')->nullable();
            $t->string('slug');
            $t->foreignId('parent_id')->nullable()
                ->constrained('blog_categories')
                ->nullOnDelete();

            $t->unsignedInteger('order')->default(0);
            $t->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->index(['parent_id','order']);
            $t->timestamps();
            $t->softDeletes();

            $t->unique(['slug', 'deleted_at'], 'blog_categories_slug_deleted_at_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
