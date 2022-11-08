<?php
# @Author : zhoulei1
# @Time   : 2022-11-08
# @File   : rbac.php


return [

    'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',

    // upload setting
    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk' => 'admin',

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file' => 'files',
        ],
    ],

    // database settings
    'database' => [

        'connection' => '',

        // User tables and model.
        'users_table' => 'admin_users',
        'users_model' => App\Models\AdminUser::class,

        // Role table and model.
        'roles_table' => 'admin_roles',
        'roles_model' => App\Models\AdminRole::class,

        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => App\Models\AdminPermission::class,

        // Menu table and model.
        'menu_table' => 'admin_menu',
        'menu_model' => App\Models\AdminMenu::class,

        // Pivot table for table above.
        'role_users_table' => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table' => 'admin_role_menu',
    ],

];
