<?php

return [
    'role_structure' => [
        'super_admin' => [
            'users'                     => 'c,r,u,d',
            'general_assembly_members'  => 'c,r,u,d',
            'donors'                    => 'c,r,u,d',
            'invoices'                  => 'c,r,u,d',
            'services'                  => 'c,r,u,d',
            'photos'                    => 'c,r,u,d',
            'videos'                    => 'c,r,u,d',
            'blogs'                     => 'c,r,u,d',
            'neighborhoods'             => 'c,r,u,d',
            'contacts'                  => 'r,d',
            'sliders'                   => 'c,r,u,d',
            'gifts'                     => 'c,r,u,d',
            'branches'                  => 'c,r,u,d',
            'partners'                  => 'c,r,u,d',
            'get_to_know_us'            => 'c,r,u,d',
            'accounts'                  => 'c,r,u,d',
            'donations'                 => 'r,u,d',
            'settings'                  => 'r,u',
            'albir_friends'             => 'r,u',
            'modules'                   => 'c,r,u,d',
            'surveys'                   => 'c,r,u,d',
            'lift_centers'              => 'c,r,d',
        ],
        'admin' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
