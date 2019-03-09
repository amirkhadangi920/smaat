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

    'copy_header_row' => 'کلیه سطرهای جدول با موفقیت برای عنوان جدید کپی شدند',
];
