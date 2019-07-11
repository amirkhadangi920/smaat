<?php

use App\Helpers\CustomSeeder;
use App\Models\{
    Places\City,
    Group\Category,
    Product\Variation,
    Discount\Discount,
    Promocode\Promocode
};
use App\Models\Financial\{ OrderStatus, ShippingMethod, Order };
use App\User;

class OrderTablesSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = User::whereEmail('support@smaat.ir')->first()->id ?? null;
        $order_statuses = [];


        $order_statuses[] = OrderStatus::create([
            'id'            => 1,
            'user_id'       => $user_id,
            'title'         => 'سبد خرید',
            'color'         => '#F59C52',
            'icon'          => 'shopping_cart',
            'description'   => 'سفارش هم اکنون یک سبد خرید است و شامل اقلامی است که مشتری به سبد خرید خود اضافه کرده است ، به مرحله پرداخت نرسیده است'
        ]);

        $order_statuses[] = OrderStatus::create([
            'id'            => 2,
            'user_id'       => $user_id,
            'title'         => 'در انتظار پرداخت',
            'color'         => '#F5502E',
            'icon'          => 'payment',
            'description'   => 'مشتری اقدام به پرداخت صورت حساب خود از درگاه پرداخت بانکی کرده است'
        ]);

        $order_statuses[] = OrderStatus::create([
            'id'            => 3,
            'user_id'       => $user_id,
            'title'         => 'پرداخت شده',
            'color'         => '#396EF2',
            'icon'          => 'bookmark_border',
            'description'   => 'مبلغ سفارش به صورت کامل پرداخت شده است و در انتظار بررسی میباشد'
        ]);

        $order_statuses[] = OrderStatus::create([
            'id'            => 4,
            'user_id'       => $user_id,
            'title'         => 'لغو شده',
            'color'         => '#F23939',
            'icon'          => 'cancel_presentation',
            'description'   => 'سفارش مورد نظر به هر دلیلی لغو شده است'
        ]);

        foreach( $order_statuses as $item )
        {
            $item->tenant_id = null;
            $item->save();
        }

        die('All Order status was created \n');

        ShippingMethod::where('id', '!=', null)->forceDelete();
        OrderStatus::where('id', '!=', null)->forceDelete();

        $this->createShippingMethods();

        $this->createOrderStatuses();

        $orders = $this->createOrders();

        Variation::all()->take( rand(5, 10) )->each( function ( $variation ) use ( $orders ) {
            $orders->random()->items()->save(
                factory(\App\Models\Financial\OrderItem::class)->make([
                    'variation_id'  => $variation->id,
                    'price'         => $variation->sales_price,
                    'order_id'      => $orders->random()->id
                ])
            );
        });
        
        $discounts = $this->createDiscounts();

        Category::all()->take( rand(5, 10) )->each( function( $category ) use( $discounts ) {
            $category->discounts()->sync( $discounts->random() );
        });

        Variation::all()->take( rand(5, 10) )->each( function ( $variation ) use ( $discounts ) {
            $discounts->random()->items()->saveMany( 
                factory( App\Models\Discount\DiscountItem::class, rand(1, 5) )->make([
                    'discount_id'    => $discounts->random()->id,
                    'variation_id'  => $variation->id,
                ])
            );  
        });
    }

    public function createShippingMethods()
    {
        return $this->shippings = $this->createTable(
            ShippingMethod::class,
            ['id', 'name', 'cost', 'is_active']
        );
    }
    
    public function createOrderStatuses()
    {        
        return $this->order_statuses = $this->createTable(
            OrderStatus::class,
            ['id', 'title', 'description', 'color']
        );
    }

    public function createOrders()
    {
        return $this->orders = $this->createTable(
            Order::class,
            [
                'id', 'user_id', 'offer', 'total', 'order_status_id', 'paid_at', 'created_at'
            ],
            [
                'user_id'               => \App\User::all()->random()->id,
                'shipping_method_id'    => $this->shippings->random()->id,
                'city_id'               => City::all()->random()->id,
                'order_status_id'       => $this->order_statuses->random()->id,
                // 'promocode_id'          => Promocode::all()->random()->id,
            ]
        );
    }

    public function createDiscounts()
    {
        return $this->discounts = $this->createTable(
            Discount::class,
            ['id', 'title', 'type', 'status', 'start_at', 'expired_at'],
            [ 'user_id' => \App\User::all()->random()->id ]
        );
    }
}
