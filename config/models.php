<?php
use App\Models\Feature\{
    Brand,
    Color,
    Size,
    Unit,
    Warranty
};
use App\Models\Article;
use App\Models\Financial\{
    Order,
    OrderStatus,
    ShippingMethod
};
use App\Models\Discount\Discount;
use App\Models\Group\{
    Category,
    Subject
};
use App\Models\Opinion\{
    Comment,
    QuestionAndAnswer,
    Review
};
use App\Models\Product\{
    Product,
    Variation
};
use App\Models\Spec\Spec;

return [
    // Blog models
    'article'               => Article::class,

    // Feature models
    'brand'                 => Brand::class,
    'color'                 => Color::class,
    'size'                  => Size::class,
    'unit'                  => Unit::class,
    'warranty'              => Warranty::class,

    // Financial models
    'discount'              => Discount::class,
    'order'                 => Order::class,
    'order_status'          => OrderStatus::class,
    'shipping_method'       => ShippingMethod::class,

    // Group models
    'category'              => Category::class,
    'subject'               => Subject::class,

    // Opinion models
    'comment'               => Comment::class,
    'question_and_answer'   => QuestionAndAnswer::class,
    'review'                => Review::class,

    // Product models
    'product'               => Product::class,
    'variation'             => Variation::class,

    // Specification models
    'spec'                  => Spec::class,
];
