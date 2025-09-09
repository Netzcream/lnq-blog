<?php

namespace Lnq\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $base = __DIR__;
        $this->mergeConfigFrom($base . '/Config/blog.php', 'blog');
    }

    public function boot(): void
    {
        $base = __DIR__;
        $this->loadRoutesFrom($base . '/routes/web.php');
        $this->loadRoutesFrom($base . '/routes/admin.php');
        $this->loadMigrationsFrom($base . '/Database/migrations');
        $this->loadViewsFrom($base . '/Resources/views', 'blog');
        $this->loadTranslationsFrom($base . '/Resources/lang', 'blog');

        $this->publishes([$base . '/Config/blog.php' => config_path('blog.php')], 'blog-config');
        $this->publishes([$base . '/Resources/views' => resource_path('views/vendor/blog')], 'blog-views');
        $this->publishes([$base . '/Resources/assets' => public_path('vendor/blog')], 'blog-assets');
        $this->publishes([
            $base . '/Resources/assets' => public_path('vendor/blog')
        ], 'blog-assets');

        if ($this->app->runningInConsole()) {
            $this->commands([\Lnq\Blog\Console\SyncPermissions::class]);
        }
    }
}
