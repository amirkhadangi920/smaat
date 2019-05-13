export default {
    state: {
        shipping_method: [],
        order_status: [],
        order: [],
        discount: [],

        filters: {
            shipping_method: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            order_status: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            order: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            discount: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
        },

        has_loaded: {
            shipping_method: false,
            order_status: false,
            order: false,
            discount: false,
        },

        is_open: {
            shipping_method: false,
            order_status: false,
            order: false,
            discount: false,
        },
        
        is_creating: {
            shipping_method: false,
            order_status: false,
            order: false,
            discount: false,
        },
        
        is_loading: {
            shipping_method: false,
            order_status: false,
            order: false,
            discount: false,
        },

        is_grid_view: {
            shipping_method: false,
            order_status: false,
            order: false,
            discount: false,
        },

        has_more: {
            shipping_method: true,
            order_status: true,
            order: true,
            discount: true,
        },

        page: {
            shipping_method: 1,
            order_status: 1,
            order: 1,
            discount: 1,
        },

        chart_object: {
            shipping_method: null,
            order_status: null,
            order: null,
            discount: null,
        },

        counts: {
            shipping_method: {
                total: 0,
                trash: 0
            },
            order_status: {
                total: 0,
                trash: 0
            },
            order: {
                total: 0,
                trash: 0
            },
            discount: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            shipping_method: {
                labels: [],
                data: [],
            },       
            order_status: {
                labels: [],
                data: [],
            },
            order: {
                labels: [],
                data: [],
            },       
            discount: {
                labels: [],
                data: [],
            },  
        },

        selected_items: {
            shipping_method: [],
            order_status: [],
            order: [],
            discount: [],
        },

        selected: {
            shipping_method: {
                name: '',
                description: '',
                cost: null,
                minimum: null,
                imageFile: null,
                imageUrl: '',
            },
            order_status: {
                title: '',
                description: '',
                color: ''
            },
            order: {},
            discount: {
                title: '',
                description: '',
                start_at: '',
                expired_at: '',
                categories: [],
                logoFile: null,
                imageUrl: '',
                items: [],
            },
        },
    },
}