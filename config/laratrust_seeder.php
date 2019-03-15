<?php

return [
    'role_structure' => [
        'owner' => [
            'article' => 'c,u,d',
            'product' => 'c,u,d',
        ],
    ],
    // 'permission_structure' => [
    //     'cru_user' => [
    //         // 'profile' => 'c,r,u'
    //     ],
    // ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'a' => 'accept',
    ]
];
