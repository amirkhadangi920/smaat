<?php

return [
    'role_structure' => [
        'owner' => [
            'brand' => 'c,u,d',
            'color' => 'c,u,d',
            'unit' => 'c,u,d',
            'size' => 'c,u,d',
            'warranty' => 'c,u,d',
            
            'article' => 'c,u,d',
            'product' => 'c,u,d',

            'shipping_method' => 'c,u,d',
            'order_status' => 'c,u,d',

            'comment' => 'c,a,d',
            'review' => 'c,a,d',
            'question_and_answer' => 'c,a,d',

            'order' => 'r,c,u,d',
        ],
    ],
    // 'permission_structure' => [
    //     'cru_user' => [
            // 'profile' => 'c,r,u'
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
