<?php

return [
    'role_structure' => [
        'writer' => [
            'subject' => 'r,c,u,d',
            'comment' => 'r,c,a,d',
            'article' => 'r,c,u,d',
        ],
        'seller' => [
            'product' => 'r',
            'brand' => 'r',
            'color' => 'r',
            'unit' => 'r',
            'size' => 'r',
            'warranty' => 'r',
            'specification' => 'r',
            'category' => 'r',
            'review' => 'r',
            'question_and_answer' => 'r',
            'order' => 'r,d,s,sa,sph,si',
            'order_item' => 's',
            'discount' => 'r,c,u,d,ad,rm',
        ],
        'storekeeper' => [
            'brand' => 'r,c,u,d',
            'color' => 'r,c,u,d',
            'unit' => 'r,c,u,d',
            'size' => 'r,c,u,d',
            'warranty' => 'r,c,u,d',
            'specification' => 'r,c,u,d',
            'category' => 'r,c,u,d',
            'product' => 'r,c,u,d',
        ],
        'accountant' => [
            'order' => 'r,d,s,sa,sph,si',
            'order_item' => 's',
            'product' => 'r',
            'category' => 'r',
            'brand' => 'r',
            'color' => 'r',
            'unit' => 'r',
            'size' => 'r',
            'warranty' => 'r',
        ],
        'operator' => [
            'user' => 'r,u,s,sa,sph',
            'review' => 'r',
            'question_and_answer' => 'r',
            'product' => 'r',
            'order' => 'r,s,sa,sph,si',
            'order_item' => 's',
        ],
        'owner' => [
            'brand' => 'at,r,c,u,d,sl,sc',
            'color' => 'at,r,c,u,d,sl,sc',
            'unit' => 'at,r,c,u,d,sl,sc',
            'size' => 'at,r,c,u,d,sl,sc',
            'warranty' => 'at,r,c,u,d,sl,sc',
            'specification' => 'at,r,c,u,d,sl,sc',

            'category' => 'at,r,c,u,d,sl,sc',
            'subject' => 'at,r,c,u,d,sl,sc',
            
            'article' => 'at,r,c,u,d,sl,sc',
            'product' => 'at,r,c,u,d,sl,sc',

            'shipping_method' => 'at,r,c,u,d,sl,sc',
            'order_status' => 'at,r,c,u,d,sl,sc',

            'comment' => 'r,c,a,d,sl',
            'review' => 'r,c,a,d,sl',
            'question_and_answer' => 'r,c,a,d,sl',

            'order' => 'r,d,s,sa,sph,si,sl',
            'order_item' => 's,sc',
            'discount' => 'at,r,c,u,d,ad,rm,sl,sc',

            'user' => 'r,u,d,s,sa,sph,sl',
            'role' => 'at,r,c,u,d,sl,sc',
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
        'at'    => 'active',
        'ad'    => 'add-item',
        'rm'    => 'remove-item',
        's'     => 'see-details',
        'sl'    => 'see-log',
        'sc'    => 'see-creator',
        'sa'    => 'see-address',
        'sph'   => 'see-phone-number',
        'si'    => 'see-items',
        // 'sinv'  => 'see-inventory'
    ],

    'actions_label' => [
        'create'            => 'ثبت',
        'read'              => 'مشاهده',
        'update'            => 'ویرایش',
        'delete'            => 'حذف',
        'accept'            => 'تایید/رد کزدن',
        'active'            => 'فعال/غیرفعال کزدن',
        'add-item'          => 'افزودن به',
        'remove-item'       => 'حذف از',
        'see-details'       => 'مشاهده جزییات',
        'see-log'           => 'مشاهده لاگ تغییرات',
        'see-creator'       => 'مشاهده ثبت کننده',
        'see-address'       => 'مشاهده آدرس',
        'see-phone-number'  => 'مشاهده شماره تلفن',
        'see-items'         => 'مشاهده اقلام',
        // 'see-inventory'     => 'مشاهده موجودی',
    ],

    'permissions_label' => [
        'brand' => 'برند',
        'color' => 'رنگ',
        'unit' => 'واحد',
        'size' => 'سایز',
        'warranty' => 'گارانتی',
        'specification' => 'جدول مشخصات فنی',

        'category' => 'گروه',
        'subject' => 'دسته بندی',
        
        'article' => 'مقاله',
        'product' => 'محصول',

        'shipping_method' => 'روش ارسال',
        'order_status' => 'وضعیت سفارش',

        'comment' => 'نظر',
        'review' => 'نقد و بررسی',
        'question_and_answer' => 'پرسش و پاسخ',

        'order' => 'سفارش',
        'order_item' => 'آیتم سفارش',
        'discount' => 'تخفیف',

        'user' => 'کاربر',
        'role' => 'نقش',
    ],

    'roles_label' => [
        'owner' => [
            'name' => 'مدیر',
            'description' => 'مالک فروشگاه اینترنتی'
        ],
        'writer' => [
            'name' => 'نویسنده',
            'description' => 'نویسنده وبلاگ فروشگاه اینترنتی'
        ],
        'seller' => [
            'name' => 'فروشنده',
            'description' => 'فروشنده محصولات'
        ],
        'storekeeper' => [
            'name' => 'انبار دار',
            'description' => 'مسیول انبار و ثبت محصولات'
        ],
        'accountant' => [
            'name' => 'حساب دار',
            'description' => 'حساب دار و مسیول امور مالی'
        ],
        'operator' => [
            'name' => 'اپراتور',
            'description' => 'اپراتور پشتیبانی فروشگاه اینترنتی'
        ],
    ]
];
