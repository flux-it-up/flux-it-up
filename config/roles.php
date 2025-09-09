<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles and Permissions Mapping
    |--------------------------------------------------------------------------
    | Define your application's roles and their permissions here.
    | You can easily add/remove permissions without touching seeders.
    */

    'roles' => [

        'customer' => [
            'view dashboard',
            'create orders',
            'view orders',
            'create repair',
            'view repair',
            'manage profile',
            'make payment',
            'view products',
        ],

        'technician' => [
            'update repair',
            'view users',
            'manage site',
        ],

        'support' => [
            'respond tickets',
            'refund payments',
            'update repair',
            'assign repair',
            'assign orders',
            'manage site',
        ],

        'manager' => [
            'assign repair',
            'assign orders',
            'manage inventory',
            'view reports',
            'view users',
            'update users',
            'refund payments',
            'respond tickets',
            'manage site',
        ],

        'admin' => '*', // all permissions

        'super-admin' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Permissions List
    |--------------------------------------------------------------------------
    | This ensures all permissions exist in DB even if not assigned
    | to roles directly (for flexibility).
    */
    'permissions' => [

        // General
        'view dashboard',
        'view reports',
        'access settings',
        'manage site',

        // Orders
        'create orders',
        'view orders',
        'update orders',
        'delete orders',
        'assign orders',

        // Repairs
        'create repair',
        'view repair',
        'update repair',
        'delete repair',
        'assign repair',

        // Products
        'view products',
        'create products',
        'update products',
        'delete products',
        'manage inventory',

        // Users
        'view users',
        'update users',
        'delete users',
        'manage roles',

        // Payments
        'view payments',
        'process payments',
        'refund payments',

        // Support
        'view tickets',
        'respond tickets',
        'close tickets',

        // Customer-specific
        'manage profile',
        'make payment',
    ],
];