<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Response messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in controllers for various
    | messages that we need to return to the api.
    |
    */

    'return' => [
        'all'       => 'لیست تمام :data',
        'single'    => 'اطلاعات :data مورد نظر',
        'paginate'  => 'بخشی از :data ها'
    ],
    'create' => [
        'successful' => ':data مورد نظر با موفقیت ثبت شد'
    ],
    'update' => [
        'successful' => ':data مورد نظر با موفقیت بروزرسانی شد'
    ],
    'delete' => [
        'successful' => ':data مورد نظر با موفقیت حذف شد',
        'plural' => ':data های مورد نظر با موفقیت حذف شدند',
        'failed' => 'متاسفانه هیچ :dataی حذف نشد'
    ],
    'accept' => [
        'successful' => ':data مورد نظر با موفقیت :type شد',
        'plural' => ':data های مورد نظر با موفقیت :type شدند',
        'failed' => 'متاسفانه هیچ :dataی :type نشد',
        'types' => [
            'رد',
            'تایید'
        ]
    ],
    'like' => [
        'successful' => ':type ":data" با موفقیت پسندیده شد',
        'before' => 'شما یکبار این :type رو پسندیده اید'
    ],
    'dislike' => [
        'successful' => ':type ":data" با موفقیت نپسندیده شد',
        'before' => 'شما یکبار این :type رو نپسندیده اید'
    ],

    'order' => [
        'item' => [
            'add' => [
                'success' => 'محصول ":product" با موفقیت به فاکتور #:‌order اضافه شد',
                'failed' => 'متاسفانه محصولی به فاکتور #:order اضافه نشد'
            ],
            'remove' => [
                'success' => 'محصول ":product" با موفقیت از فاکتور #:‌order حذف شد',
                'failed' => 'متاسفانه هیچ محصولی از فاکتور #:order حذف نشد'
            ]
        ],
    ],

    'discount' => [
        'item' => [
            'add' => [
                'success' => 'محصول ":product" با موفقیت به تخفیف :discount اضافه شد',
                'failed' => 'متاسفانه محصولی به تخفیف :discount اضافه نشد'
            ],
            'remove' => [
                'success' => 'محصول ":product" با موفقیت از تخفیف :discount حذف شد',
                'failed' => 'متاسفانه هیچ محصولی از تخفیف :discount حذف نشد'
            ]
        ],
    ],

    'permission' => [
        'attach' => [
            'successful' => 'سطح دسترسی ":permission" به کاربر ":user" با موفقیت داده شد',
            'before' => 'سطح دسترسی ":permission" قبلا به کاربر ":user" داده شده است'
        ],
        'detach' => [
            'successful' => 'سطح دسترسی ":permission" از کاربر ":user" با موفقیت گرفته شد',
            'before' => 'سطح دسترسی ":permission" قبلا از کاربر ":user" گرفته شده است'
        ],
    ],

    'password_reset' => 'رمز عبور کاربر ":user" با موفقیت بروزرسانی شد',

    'copy_header_row' => 'کلیه سطرهای جدول با موفقیت برای عنوان جدید کپی شدند',
];
