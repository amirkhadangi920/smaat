export default {
    state: {
        brand: [],
        size: [],
        warranty: [],
        color: [],
        unit: [],
        spec: [],

        filters: {
            brand: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            size: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            warranty: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            color: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            unit: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            spec: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
        },

        has_loaded: {
            brand: false,
            size: false,
            warranty: false,
            color: false,
            unit: false,
            spec: false,
        },

        is_open: {
            brand: true,
            size: false,
            warranty: false,
            color: false,
            unit: false,
            spec: false,
        },
        
        is_creating: {
            brand: false,
            size: false,
            warranty: false,
            color: false,
            unit: false,
            spec: false,
        },
        
        is_loading: {
            brand: false,
            size: false,
            warranty: false,
            color: false,
            unit: false,
            spec: false,
        },

        is_grid_view: {
            brand: false,
            size: false,
            warranty: false,
            color: false,
            unit: false,
            spec: false,
        },

        has_more: {
            brand: true,
            size: true,
            warranty: true,
            color: true,
            unit: true,
            spec: true,
        },

        page: {
            brand: 1,
            size: 1,
            warranty: 1,
            color: 1,
            unit: 1,
            spec: 1,
        },

        chart_object: {
            brand: null,
            size: null,
            warranty: null,
            color: null,
            unit: null,
            spec: null,
        },

        counts: {
            brand: {
                total: 0,
                trash: 0
            },
            size: {
                total: 0,
                trash: 0
            },
            warranty: {
                total: 0,
                trash: 0
            },
            color: {
                total: 0,
                trash: 0
            },
            unit: {
                total: 0,
                trash: 0
            },
            spec: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            brand: {
                labels: [],
                data: [],
            },
            size: {
                labels: [],
                data: [],
            },
            warranty: {
                labels: [],
                data: [],
            },
            color: {
                labels: [],
                data: [],
            },
            unit: {
                labels: [],
                data: [],
            },          
            spec: {
                labels: [],
                data: [],
            },          
        },

        selected_items: {
            brand: [],
            size: [],
            warranty: [],
            color: [],
            unit: [],
            spec: [],
        },

        selected: {
            brand: {
                name: '',
                description: '',
                categories: [],
                imageFile: null,
                imageUrl: ''
            },
            size: {
                name: '',
                description: '',
                categories: [],
            },
            warranty: {
                title: '',
                expire: '',
                categories: [],
                imageFile: null,
                imageUrl: ''
            },
            color: {
                name: '',
                description: '',
                categories: [],
            },
            unit: {
                title: '',
                description: '',
                categories: [],
            },
            spec: {
                title: '',
                description: '',
                categories: [],
            },
        },
    },
}