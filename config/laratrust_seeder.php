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
            'discount' => 'r,c,u,d,ad,rm',

            'user' => 'r,u,d',
            'role' => 'r,c,u,d',
        ],
    ],
    // 'permission_structure' => [
    //     'cru_user' => [
            // 'profile' => 'c,r,u'
    //     ],
    // ],
    'permissions_map' => [
        'c'     => 'create',
        'r'     => 'read',
        'u'     => 'update',
        'd'     => 'delete',
        'a'     => 'accept',
        'ad'    => 'add-item',
        'rm'    => 'remove-item',
    ],

    'actions_label' => [
        'create'        => 'ثبت',
        'read'          => 'مشاهده',
        'update'        => 'ویرایش',
        'delete'        => 'حذف',
        'accept'        => 'تایید',
        'add-item'      => 'افزودن به',
        'remove-item'   => 'حذف از',
    ],

    'permissions_label' => [
        'brand' => 'برند',
        'color' => 'رنگ',
        'unit' => 'واحد',
        'size' => 'سایز',
        'warranty' => 'گارانتی',
        
        'article' => 'مقاله',
        'product' => 'محصول',

        'shipping_method' => 'روش ارسال',
        'order_status' => 'وضعیت سفارش',

        'comment' => 'نظر',
        'review' => 'نقد و بررسی',
        'question_and_answer' => 'پرسش و پاسخ',

        'order' => 'سفارش',
        'discount' => 'تخفیف',

        'user' => 'کاربر',
        'role' => 'نقش',
    ],

    'roles_label' => [
        'owner' => [
            'name' => 'مدیر',
            'description' => 'مالک فروشگاه اینترنتی'
        ]
    ]
];
