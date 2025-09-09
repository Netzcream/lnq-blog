<?php

namespace Lnq\Blog\Console;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class SyncPermissions extends Command
{
    protected $signature = 'blog:sync-permissions';
    protected $description = 'Sincroniza permisos del módulo Blog';

    public function handle(): int
    {
        $perms = config('blog.permissions', []);
        foreach ($perms as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $this->info('Permisos de Blog sincronizados.');
        return self::SUCCESS;



    }
}
