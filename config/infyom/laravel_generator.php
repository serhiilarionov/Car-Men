<?php

$module = 'Auth';
$space = 'Modules/' . $module . '/';

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    */

    'path' => [

        'migration' => base_path($space . 'database/migrations/'),

        'model' => base_path($space . 'Entities/'),

        'datatables' => base_path($space . 'DataTables/'),

        'repository' => base_path($space . 'Repositories/'),

        'routes' => base_path($space . 'Routes/web.php'),

        'api_routes' => base_path($space . 'Routes/api.php'),

        'request' => base_path($space . 'Http/Requests/'),

        'api_request' => base_path($space . 'Http/Requests/API/'),

        'controller' => base_path($space . 'Http/Controllers/'),

        'api_controller' => base_path($space . 'Http/Controllers/API/'),

        'test_trait' => base_path($space . 'Tests/Traits/'),

        'repository_test' => base_path($space . 'Tests/Repositories/'),

        'api_test' => base_path($space . 'Tests/Api/'),

        'views' => base_path($space . 'Resources/views/'),

        'schema_files' => base_path($space . 'Resources/model_schemas/'),

        'templates_dir' => base_path('resources/infyom/infyom-generator-templates/'),

        'modelJs' => base_path($space . 'Resources/assets/js/models/'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => [

        'model' => 'Modules\\' . $module . '\\Entities',

        'datatables' => 'Modules\\' . $module . '\\DataTables',

        'repository' => 'Modules\\' . $module . '\\Repositories',

        'controller' => 'Modules\\' . $module . '\\Http\\Controllers',

        'api_controller' => 'Modules\\' . $module . '\\Http\\Controllers\API',

        'request' => 'Modules\\' . $module . '\\Http\\Requests',

        'api_request' => 'Modules\\' . $module . '\\Http\\Requests\\API',
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    */

    'templates' => 'adminlte-templates',

    /*
    |--------------------------------------------------------------------------
    | Model extend class
    |--------------------------------------------------------------------------
    |
    */

    'model_extend_class' => 'Eloquent',

    /*
    |--------------------------------------------------------------------------
    | API routes prefix & version
    |--------------------------------------------------------------------------
    |
    */

    'api_prefix' => 'api',

    'api_version' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    */

    'options' => [

        'softDelete' => true,

        'tables_searchable_default' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Prefixes
    |--------------------------------------------------------------------------
    |
    */

    'prefixes' => [

        'route' => '',  // using admin will create route('admin.?.index') type routes

        'path' => '',

        'view' => '',  // using backend will create return view('backend.?.index') type the backend views directory

        'public' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Add-Ons
    |--------------------------------------------------------------------------
    |
    */

    'add_on' => [

        'swagger' => true,

        'tests' => true,

        'datatables' => true,

        'menu' => [

            'enabled' => false,

            'menu_file' => 'layouts/menu.blade.php',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timestamp Fields
    |--------------------------------------------------------------------------
    |
    */

    'timestamps' => [

        'enabled' => true,

        'created_at' => 'created_at',

        'updated_at' => 'updated_at',

        'deleted_at' => 'deleted_at',
    ],

];
