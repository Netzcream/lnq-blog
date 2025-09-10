1 Crear estructura del paquete Blog
(packages/Blog con su composer.json, src/, routes/, views/, etc.). ok

2 Registrar el paquete en Composer
usando repositorio path para poder cargarlo dentro del proyecto principal. ok

3 Configurar ServiceProvider
para cargar rutas, migraciones, vistas y traducciones del Blog. OK

4 Definir rutas públicas y de dashboard
(/blog/{slug} y /dashboard/blog/*) con sus controladores. OK

5 Crear modelos y migraciones
(Post, Category, etc.) con soporte a traducciones. OK

6 Armar vistas por defecto
públicas + dashboard, con layout básico y sobreescribibles. OK

7 Gestionar permisos del Blog
(blog.view, blog.create, etc.) integrados al sistema de roles de la app. OK

8 Hacer el paquete autoconcluyente
incluir scripts/librerías propias (ej: WYSIWYG), sin depender del main.

9 Publicar assets y vistas
para que la app pueda sobreescribir y adaptarlos (layouts, estilos, etc.).


{            "type": "path",            "url": "packages/lnq/blog"        }
        
{ "type": "vcs", "url": "git@github.com:netzcream/lnq-blog.git" }
composer require luniqo/blog:* 
php artisan vendor:publish --tag=blog-config
php artisan migrate
php artisan vendor:publish --tag=blog-views
php artisan blog:sync-permissions



php artisan vendor:publish --provider="Lnq\Blog\BlogServiceProvider" --tag=blog-config
php artisan vendor:publish --provider="Lnq\Blog\BlogServiceProvider" --tag=blog-views
php artisan vendor:publish --provider="Lnq\Blog\BlogServiceProvider" --tag=blog-assets

@can('blog.view')
  <a href="{{ route('blog.admin.index') }}">Blog</a>
@endcan

cd packages/lnq/blog
git add .
git commit -m "lo que cambiaste"
git push origin main
git tag v0.1.1
git push --tags
