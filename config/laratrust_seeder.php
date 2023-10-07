<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'root' => [
            'company'       => 'c,r,u,d',
            'users'         => 'c,r,u,d',
            'roles'         => 'c,r,u,d',
            'permissions'   => 'c,r,u,d',
            'teams'         => 'c,r,u,d',
            'profile'       => 'r,u',
            'employees'     => 'c,r,u,d',
            'clients'       => 'c,r,u,d',
            'province'      => 'c,r,u,d',
            'cities'        => 'c,r,u,d',
            'districts'     => 'c,r,u,d',
            'villages'      => 'c,r,u,d',
            'branch'        => 'c,r,u,d',
            'branch_area'   => 'c,r,u,d',
            'warehouse'     => 'c,r,u,d',    
        ],
        'owner' => [
            'company'       => 'r',
            'users'         => 'c,r,u,d',
            'roles'         => 'c,r,u,d',
            'permissions'   => 'c,r,u,d',
            'teams'         => 'c,r,u,d',
            'profile'       => 'r,u',
            'employees'     => 'c,r,u,d',
            'clients'       => 'c,r,u,d',
            'province'      => 'c,r,u,d',
            'cities'        => 'c,r,u,d',
            'districts'     => 'c,r,u,d',
            'villages'      => 'c,r,u,d',
            'branch'        => 'c,r,u,d',
            'branch_area'   => 'c,r,u,d',
            'warehouse'     => 'c,r,u,d',
        ],
        'board-of-director' => [
            'company'       => 'r',
            'profile'       => 'r,u',
            'employees'     => 'c,r,u,d',
            'clients'       => 'c,r,u,d',
            'province'      => 'c,r,u,d',
            'cities'        => 'c,r,u,d',
            'districts'     => 'c,r,u,d',
            'villages'      => 'c,r,u,d',
            'branch'        => 'c,r,u,d',
            'branch_area'   => 'c,r,u,d',
            'warehouse'     => 'c,r,u,d',
        ],
        'general-manager-operation' => [
            'company'       => 'r',
            'profile'       => 'r,u',
        ],
        'general-manager-sales' => [
            'company'       => 'r',
            'profile'       => 'r,u',
        ],
        'branch-manager' => [
            'company'       => 'r',
            'profile'       => 'r,u',
        ],
        'manager' => [
            'company'       => 'r',
            'profile'       => 'r,u',
            'teams'         => 'r',
        ],
        'supervisor' => [
            'company'       => 'r',
            'profile'       => 'r,u',
            'teams'         => 'r',
        ],
        'leader' => [
            'company'       => 'r',
            'profile'       => 'r,u',
            'teams'         => 'r',
        ],
        'staff-specialist' => [
            'company'       => 'r',
            'profile'       => 'r,u',
            'teams'         => 'r',
        ],
        'staff' => [
            'company'       => 'r',
            'profile'       => 'r,u',
            'teams'         => 'r',
        ],
        'technician' => [
            'company'       => 'r',
            'profile'       => 'r,u',
            'teams'         => 'r',
        ],
        'client' => [
            'profile'       => 'r,u'
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
