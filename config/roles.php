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
            'create orders',
            'view orders',
            'create repair',
            'view repair',
            'manage profile',
            'make payment',
        ],

        'technician' => [
            'view repair',
            'update repair',
            'assign repair',
        ],

        'support' => [
            'view orders',
            'update orders',
            'respond tickets',
            'refund payments',
        ],

        'manager' => [
            'assign repair',
            'assign orders',
            'manage inventory',
            'view reports',
            'view users',
            'update users',
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