<?php

// Feature Queries
use App\GraphQL\Query\Feature\{
    Brand\BrandQuery, Brand\BrandsQuery,
    Color\ColorQuery, Color\ColorsQuery,
    Size\SizeQuery, Size\SizesQuery,
    Unit\UnitQuery, Unit\UnitsQuery,
    Warranty\WarrantyQuery, Warranty\WarrantiesQuery
};

// Group Queries
use App\GraphQL\Query\Group\{
    Category\CategoryQuery, Category\CategoriesQuery,
    Subject\SubjectQuery, Subject\SubjectsQuery
};

// Financial Queries
use App\GraphQL\Query\Financial\{
    Discount\DiscountQuery, Discount\DiscountsQuery,
    Promocode\PromocodeQuery, Promocode\PromocodesQuery,
    Order\OrderQuery, Order\OrdersQuery,
    OrderStatus\OrderStatusQuery, OrderStatus\OrderStatusesQuery,
    ShippingMethod\ShippingMethodQuery, ShippingMethod\ShippingMethodsQuery
};

// Opinion Queries
use App\GraphQL\Query\Opinion\{
    Comment\CommentQuery, Comment\CommentsQuery,
    Review\ReviewQuery, Review\ReviewsQuery,
    QuestionAndAnswer\QuestionAndAnswerQuery, QuestionAndAnswer\QuestionAndAnswersQuery
};

// Option Queries
use App\GraphQL\Query\Option\{
    SiteSetting\SiteSettingQuery,
    UserSetting\UserSettingQuery
};

// Shop Queries
use App\GraphQL\Query\Shop\{
    Product\ProductQuery, Product\ProductsQuery,
    Spec\SpecQuery, Spec\SpecsQuery
};

// Blog Queries
use App\GraphQL\Query\Blog\Article\{ ArticlesQuery, ArticleQuery };

// User Queries
use App\GraphQL\Query\User\{
    User\UserQuery, User\UsersQuery,
    Role\RoleQuery, Role\RolesQuery,
    Cart\CartQuery,
    Compare\CompareQuery, Compare\CompareProductsQuery,
    User\MeQuery,
    Favorite\FavoriteQuery
};

// Feature Mutations
use App\GraphQL\Mutation\Feature\{
    Brand\CreateBrandMutation, Brand\UpdateBrandMutation, Brand\DeleteBrandMutation,
    Size\CreateSizeMutation, Size\UpdateSizeMutation, Size\DeleteSizeMutation,
    Color\CreateColorMutation, Color\UpdateColorMutation, Color\DeleteColorMutation,
    Unit\CreateUnitMutation, Unit\UpdateUnitMutation, Unit\DeleteUnitMutation,
    Warranty\CreateWarrantyMutation, Warranty\UpdateWarrantyMutation, Warranty\DeleteWarrantyMutation
};

// Group Mutations
use App\GraphQL\Mutation\Group\{
    Category\CreateCategoryMutation, Category\UpdateCategoryMutation, Category\DeleteCategoryMutation,
    Subject\CreateSubjectMutation, Subject\UpdateSubjectMutation, Subject\DeleteSubjectMutation
};

// Financial Mutations
use App\GraphQL\Mutation\Financial\{
    Discount\CreateDiscountMutation, Discount\UpdateDiscountMutation, Discount\DeleteDiscountMutation,
    Discount\AddDiscountMutation, Discount\RemoveDiscountMutation,

    Order\UpdateOrderMutation, Order\DeleteOrderMutation, Order\StatusOrderMutation,
    OrderStatus\CreateOrderStatusMutation, OrderStatus\UpdateOrderStatusMutation, OrderStatus\DeleteOrderStatusMutation,
    ShippingMethod\CreateShippingMethodMutation, ShippingMethod\UpdateShippingMethodMutation, ShippingMethod\DeleteShippingMethodMutation,

   Promocode\CreatePromocodeMutation, Promocode\UpdatePromocodeMutation, Promocode\DeletePromocodeMutation
};

// Product Mutations
use App\GraphQL\Mutation\Opinion\{
    Comment\CreateCommentMutation, Comment\UpdateCommentMutation, Comment\DeleteCommentMutation,
    Review\CreateReviewMutation, Review\UpdateReviewMutation, Review\DeleteReviewMutation,
    QuestionAndAnswer\CreateQuestionAndAnswerMutation, QuestionAndAnswer\UpdateQuestionAndAnswerMutation, QuestionAndAnswer\DeleteQuestionAndAnswerMutation
};

// Product Mutations
use App\GraphQL\Mutation\Product\{
    Product\CreateProductMutation, Product\UpdateProductMutation, Product\DeleteProductMutation
};

// Blog Mutations
use App\GraphQL\Mutation\Blog\{
    Article\ActiveArticleMutation, Article\CreateArticleMutation, Article\UpdateArticleMutation, Article\DeleteArticleMutation
};

// User Mutations
use App\GraphQL\Mutation\User\{
    User\CreateUserMutation, User\UpdateUserMutation, User\DeleteUserMutation,
    User\LoginUserMutation, User\RegisterUserMutation,

    Role\CreateRoleMutation, Role\UpdateRoleMutation, Role\DeleteRoleMutation,
    
    Cart\AddCartMutation, Cart\RemoveCartMutation,
    Compare\AddCompareMutation, Compare\RemoveCompareMutation,
    Favorite\AddFavoriteMutation, Favorite\RemoveFavoriteMutation
};

// Spec Mutations
use App\GraphQL\Mutation\Spec\{
    Spec\CreateSpecMutation, Spec\UpdateSpecMutation, Spec\DeleteSpecMutation,
    SpecHeader\CreateSpecHeaderMutation, SpecHeader\UpdateSpecHeaderMutation, SpecHeader\DeleteSpecHeaderMutation,
    SpecRow\CreateSpecRowMutation, SpecRow\UpdateSpecRowMutation, SpecRow\DeleteSpecRowMutation
};

// Feature Types
use App\GraphQL\Type\Feature\BrandType;
use App\GraphQL\Type\Feature\SizeType;
use App\GraphQL\Type\Feature\ColorType;
use App\GraphQL\Type\Feature\UnitType;
use App\GraphQL\Type\Feature\WarrantyType;
// Financial Types
use App\GraphQL\Type\Financial\DiscountType;
use App\GraphQL\Type\Financial\OrderType;
use App\GraphQL\Type\Financial\OrderItemType;
use App\GraphQL\Type\Financial\OrderStatusType;
use App\GraphQL\Type\Financial\ShippingMethodType;
use App\GraphQL\Type\Financial\DiscountItemType;
// Spec Types
use App\GraphQL\Type\Spec\SpecType;
use App\GraphQL\Type\Spec\SpecHeaderType;
use App\GraphQL\Type\Spec\SpecRowType;
// Product Types
use App\GraphQL\Type\Product\ProductType;
use App\GraphQL\Type\Product\VariationType;
// Blog Types
use App\GraphQL\Type\Blog\ArticleType;
// Group Types
use App\GraphQL\Type\Group\CategoryType;
use App\GraphQL\Type\Group\SubjectType;
// User Types
use App\GraphQL\Type\User\UserType;
use App\GraphQL\Type\User\RoleType;
// Place Types
use App\GraphQL\Type\Place\CityType;
use App\GraphQL\Type\Place\ProvinceType;
use App\GraphQL\Type\Place\CountryType;
// Opinion Types
use App\GraphQL\Type\Opinion\CommentType;
use App\GraphQL\Type\Opinion\ReviewType;
use App\GraphQL\Type\Opinion\QuestionAndAnswerType;
// Helper Types
use App\GraphQL\Interfaces\CharacterInterface;
use App\GraphQL\Type\ResultMessageType;
use App\GraphQL\Type\ImageType;
use App\GraphQL\Type\TagType;
use App\GraphQL\Type\ArrayDataType;
use App\GraphQL\Type\User\PermissionType;
use App\GraphQL\Type\AuditType;
use App\GraphQL\Helpers\MyCustomPaginationFields;
use App\GraphQL\Type\ChartRecordType;
use App\GraphQL\Type\VotesType;
use App\GraphQL\Type\Spec\SpecDefaultType;
use App\GraphQL\Type\Spec\SpecDataType;
use App\GraphQL\Type\User\MeType;
use App\GraphQL\Type\Option\SiteSettingType;
use App\GraphQL\Type\Option\UserSettingType;
use App\GraphQL\Type\User\UserPhoneType;
use App\GraphQL\Type\User\UserAddressType;
use App\GraphQL\Type\Group\ScoringFieldType;
use App\GraphQL\Type\Product\PriceChangeType;
use App\GraphQL\Type\CoordinateType;
use App\GraphQL\Type\Financial\MeOrderType;
use App\GraphQL\Type\Financial\MeOrderItemType;
use App\GraphQL\Type\Financial\PromocodeType;

return [

    // The prefix for routes
    'prefix' => 'graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each route
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    // ]
    //
    'routes' => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Rebing\GraphQL\GraphQLController@query',
    //     'mutation' => '\Rebing\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => \Rebing\GraphQL\GraphQLController::class . '@query',

    // Any middleware for the graphql route group
    'middleware' => [],

    // Additional route group attributes
    //
    // Example:
    //
    // 'route_group_attributes' => ['guard' => 'api']
    //
    'route_group_attributes' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema' => 'default',

    // The schemas for query and/or mutation. It expects an array of schemas to provide
    // both the 'query' fields and the 'mutation' fields.
    //
    // You can also provide a middleware that will only apply to the given schema
    //
    // Example:
    //
    //  'schema' => 'default',
    //
    //  'schemas' => [
    //      'default' => [
    //          'query' => [
    //              'users' => 'App\GraphQL\Query\UsersQuery'
    //          ],
    //          'mutation' => [
    //
    //          ]
    //      ],
    //      'user' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\ProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //      'user/me' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\MyProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //  ]
    //
    'schemas' => [
        'default' => [
            'query' => [
                // Feature
                'brand' => BrandQuery::class,
                'brands' => BrandsQuery::class,
                'color' => ColorQuery::class,
                'colors' => ColorsQuery::class,
                'unit' => UnitQuery::class,
                'units' => UnitsQuery::class,
                'size' => SizeQuery::class,
                'sizes' => SizesQuery::class,
                'warranty' => WarrantyQuery::class,
                'warranties' => WarrantiesQuery::class,
                
                // Financial
                'order_status' => OrderStatusQuery::class,
                'order_statuses' => OrderStatusesQuery::class,
                'shipping_method' => ShippingMethodQuery::class,
                'shipping_methods' => ShippingMethodsQuery::class,

                // Option
                'siteSetting' => SiteSettingQuery::class,

                // Shop
                'product' => ProductQuery::class,
                'products' => ProductsQuery::class,

                // Blog
                'article' => ArticleQuery::class,
                'articles' => ArticlesQuery::class,

                // Group
                'category' => CategoryQuery::class,
                'categories' => CategoriesQuery::class,
                'subject' => SubjectQuery::class,
                'subjects' => SubjectsQuery::class,
                
                // User
                'cart' => CartQuery::class,
                'compare' => CompareQuery::class,
                'compareProducts' => CompareProductsQuery::class,
            ],
            'mutation' => [
                // User
                'login'         => LoginUserMutation::class,
                'register'      => RegisterUserMutation::class,

                // Cart
                'addCart'       => AddCartMutation::class,
                'removeCart'    => RemoveCartMutation::class,

                // Compare
                'addCompare'    => AddCompareMutation::class,
                'removeCompare' => RemoveCompareMutation::class,
            ],
            'middleware' => ['CORS'],
            'method' => ['get', 'post'],
        ],

        'auth' => [
            'query' => [
                // Feature
                'brand' => BrandQuery::class,
                'brands' => BrandsQuery::class,
                'color' => ColorQuery::class,
                'colors' => ColorsQuery::class,
                'unit' => UnitQuery::class,
                'units' => UnitsQuery::class,
                'size' => SizeQuery::class,
                'sizes' => SizesQuery::class,
                'warranty' => WarrantyQuery::class,
                'warranties' => WarrantiesQuery::class,
                
                // Financial
                'discount' => DiscountQuery::class,
                'discounts' => DiscountsQuery::class,
                'promocode' => PromocodeQuery::class,
                'promocodes' => PromocodesQuery::class,
                'order' => OrderQuery::class,
                'orders' => OrdersQuery::class,
                'order_status' => OrderStatusQuery::class,
                'order_statuses' => OrderStatusesQuery::class,
                'shipping_method' => ShippingMethodQuery::class,
                'shipping_methods' => ShippingMethodsQuery::class,

                // Opinion
                'comment' => CommentQuery::class,
                'comments' => CommentsQuery::class,
                'review' => ReviewQuery::class,
                'reviews' => ReviewsQuery::class,
                'question_and_answer' => QuestionAndAnswerQuery::class,
                'question_and_answers' => QuestionAndAnswersQuery::class,

                // Option
                'siteSetting' => SiteSettingQuery::class,
                'userSetting' => UserSettingQuery::class,

                // Shop
                'product' => ProductQuery::class,
                'products' => ProductsQuery::class,
                'spec' => SpecQuery::class,
                'spec' => SpecsQuery::class,

                // Blog
                'article' => ArticleQuery::class,
                'articles' => ArticlesQuery::class,

                // Group
                'category' => CategoryQuery::class,
                'categories' => CategoriesQuery::class,
                'subject' => SubjectQuery::class,
                'subjects' => SubjectsQuery::class,

                // User
                'user' => UserQuery::class,
                'me' => MeQuery::class,
                'users' => UsersQuery::class,
                'role' => RoleQuery::class,
                'roles' => RolesQuery::class,
                'cart' => CartQuery::class,
                'compare' => CompareQuery::class,
                'favorites' => FavoriteQuery::class,
                'compareProducts' => CompareProductsQuery::class,
            ],
            'mutation' => [
                // Blog
                'activeArticle' => ActiveArticleMutation::class,
                'createArticle' => CreateArticleMutation::class,
                'updateArticle' => UpdateArticleMutation::class,
                'deleteArticle' => DeleteArticleMutation::class,


                // Feature
                'createBrand' => CreateBrandMutation::class,
                'updateBrand' => UpdateBrandMutation::class,
                'deleteBrand' => DeleteBrandMutation::class,

                'createColor' => CreateColorMutation::class,
                'updateColor' => UpdateColorMutation::class,
                'deleteColor' => DeleteColorMutation::class,

                'createSize' => CreateSizeMutation::class,
                'updateSize' => UpdateSizeMutation::class,
                'deleteSize' => DeleteSizeMutation::class,

                'createUnit' => CreateUnitMutation::class,
                'updateUnit' => UpdateUnitMutation::class,
                'deleteUnit' => DeleteUnitMutation::class,

                'createWarranty' => CreateWarrantyMutation::class,
                'updateWarranty' => UpdateWarrantyMutation::class,
                'deleteWarranty' => DeleteWarrantyMutation::class,

                
                // Financial
                'createDiscount' => CreateDiscountMutation::class,
                'updateDiscount' => UpdateDiscountMutation::class,
                'deleteDiscount' => DeleteDiscountMutation::class,
                'addDiscount'    => AddDiscountMutation::class,
                'removeDiscount' => RemoveDiscountMutation::class,

                'createOrderStatus' => CreateOrderStatusMutation::class,
                'updateOrderStatus' => UpdateOrderStatusMutation::class,
                'deleteOrderStatus' => DeleteOrderStatusMutation::class,

                'createPromocode' => CreatePromocodeMutation::class,
                'updatePromocode' => UpdatePromocodeMutation::class,
                'deletePromocode' => DeletePromocodeMutation::class,

                'createShippingMethod' => CreateShippingMethodMutation::class,
                'updateShippingMethod' => UpdateShippingMethodMutation::class,
                'deleteShippingMethod' => DeleteShippingMethodMutation::class,

                'updateOrder' => UpdateOrderMutation::class,
                'deleteOrder' => DeleteOrderMutation::class,
                'changeOrderStatus' => StatusOrderMutation::class,

                
                // Group
                'createCategory' => CreateCategoryMutation::class,
                'updateCategory' => UpdateCategoryMutation::class,
                'deleteCategory' => DeleteCategoryMutation::class,
                
                'createSubject' => CreateSubjectMutation::class,
                'updateSubject' => UpdateSubjectMutation::class,
                'deleteSubject' => DeleteSubjectMutation::class,


                // Opinion
                'createComment' => CreateCommentMutation::class,
                'updateComment' => UpdateCommentMutation::class,
                'deleteComment' => DeleteCommentMutation::class,

                'createReview' => CreateReviewMutation::class,
                'updateReview' => UpdateReviewMutation::class,
                'deleteReview' => DeleteReviewMutation::class,

                'createQuestionAndAnswer' => CreateQuestionAndAnswerMutation::class,
                'updateQuestionAndAnswer' => UpdateQuestionAndAnswerMutation::class,
                'deleteQuestionAndAnswer' => DeleteQuestionAndAnswerMutation::class,

                
                // Product
                'createProduct' => CreateProductMutation::class,
                'updateProduct' => UpdateProductMutation::class,
                'deleteProduct' => DeleteProductMutation::class,

                
                // Spec
                'createSpec' => CreateSpecMutation::class,
                'updateSpec' => UpdateSpecMutation::class,
                'deleteSpec' => DeleteSpecMutation::class,
                
                'createSpecHeader' => CreateSpecHeaderMutation::class,
                'updateSpecHeader' => UpdateSpecHeaderMutation::class,
                'deleteSpecHeader' => DeleteSpecHeaderMutation::class,
                
                'createSpecRow' => CreateSpecRowMutation::class,
                'updateSpecRow' => UpdateSpecRowMutation::class,
                'deleteSpecRow' => DeleteSpecRowMutation::class,

                
                // User
                'updateUser'    => UpdateUserMutation::class,
                'deleteUser'    => DeleteUserMutation::class,

                'createRole'    => CreateRoleMutation::class,
                'updateRole'    => UpdateRoleMutation::class,
                'deleteRole'    => DeleteRoleMutation::class,
                

                // Cart
                'addCart'       => AddCartMutation::class,
                'removeCart'    => RemoveCartMutation::class,
                
                // Compare
                'addCompare'    => AddCompareMutation::class,
                'removeCompare' => RemoveCompareMutation::class,

                // Favorite
                'addFavorite'   => AddFavoriteMutation::class,
                'removeFavorite'=> RemoveFavoriteMutation::class,
            ],
            'middleware' => ['auth:api', 'CORS'],
            'method' => ['get', 'post', 'put', 'delete']
        ]
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    'types' => [
        // Feature
        'brand'             => BrandType::class,
        'size'              => SizeType::class,
        'color'             => ColorType::class,
        'unit'              => UnitType::class,
        'warranty'          => WarrantyType::class,

        // Financial
        'discount'          => DiscountType::class,
        'discount_item'     => DiscountItemType::class,
        'order'             => OrderType::class,
        'promocode'         => PromocodeType::class,
        'me_order'          => MeOrderType::class,
        'order_item'        => OrderItemType::class,
        'me_order_item'     => MeOrderItemType::class,
        'order_status'      => OrderStatusType::class,
        'shipping_method'   => ShippingMethodType::class,

        // Opinion
        'comment'           => CommentType::class,
        'review'            => ReviewType::class,
        'question_and_answer'=> QuestionAndAnswerType::class,

        // Option
        'site_settings'     => SiteSettingType::class,
        'user_settings'     => UserSettingType::class,

        // Product
        'product'           => ProductType::class,
        'variation'         => VariationType::class,
        'price_change'      => PriceChangeType::class,

        // Blog
        'article'           => ArticleType::class,

        // Specification
        'spec'              => SpecType::class,
        'spec_header'       => SpecHeaderType::class,
        'spec_row'          => SpecRowType::class,
        'spec_data'         => SpecDataType::class,
        'spec_default'      => SpecDefaultType::class,

        // Group
        'category'          => CategoryType::class,
        'scoring_field'     => ScoringFieldType::class,
        'subject'           => SubjectType::class,

        // User
        'user'              => UserType::class,
        'user_phone'        => UserPhoneType::class,
        'user_address'      => UserAddressType::class,
        'role'              => RoleType::class,
        'me'                => MeType::class,
        'permission'        => PermissionType::class,

        // Place
        'city'              => CityType::class,
        'province'          => ProvinceType::class,
        'country'           => CountryType::class,


        'coordinate'        => CoordinateType::class,
        'audit'             => AuditType::class,
        'votes'             => VotesType::class,
        'data_array'        => ArrayDataType::class,
        'image'             => ImageType::class,
        'tag'               => TagType::class,
        'result'            => ResultMessageType::class,
        'Character'         => CharacterInterface::class,
        'chart_record'      => ChartRecordType::class,
    ],

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],

    /**
     * Custom Error Handling
     *
     * Expected handler signature is: function (array $errors, callable $formatter): array
     *
     * The default handler will pass exceptions to laravel Error Handling mechanism
     */
    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key'    => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://github.com/webonyx/graphql-php#security
     * for details. Disabled by default.
     */
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
    'pagination_type' => \App\GraphQL\Helpers\PaginationType::class,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     */
    'graphiql' => [
        'prefix' => '/graphiql/{graphql_schema?}',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],
];
