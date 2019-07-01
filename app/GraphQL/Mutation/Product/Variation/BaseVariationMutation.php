<?php

namespace App\GraphQL\Mutation\Product\Variation;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Product\VariationProps;

class BaseVariationMutation extends MainMutation
{
    use VariationProps;
    
    protected $incrementing = false;

    protected $old_spec;
    
    protected $attributes = [
        'name' => 'VariationMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'product_id' => [
                'type' => Type::string()
            ],
            'size_id' => [
                'type' => Type::int()
            ],
            'color_id' => [
                'type' => Type::int()
            ],
            'warranty_id' => [
                'type' => Type::int()
            ],
            'sales_price' => [
                'type' => Type::int()
            ],
            'inventory' => [
                'type' => Type::int()
            ],
            'sending_time' => [
                'type' => Type::int()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
        ];
    }

    /**
     * Check the request to it'has image or not,
     * then update the data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function updateData($request, $model)
    {
        if ( $request->get('sales_price') !== $model->sales_price )
            $model->old_sale_prices()->create([ 'old_price' => $model->sales_price ]);
        
        $model->update( $this->getRequest( $request ) );

        return $model;
    }
}