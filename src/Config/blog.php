<?php
return [
    'public_prefix' => 'blog',
    'admin_prefix'  => 'dashboard/blog',
    'admin_middleware' => ['web', 'auth'],
    'editor' => env('BLOG_EDITOR', 'textarea'),
    'permissions' => [
        'blog.view',
        'blog.create',
        'blog.edit',
        'blog.delete',
        'blog.publish',
    ],
];
