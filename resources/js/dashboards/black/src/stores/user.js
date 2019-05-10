export default {
    state: {
        user: [],
        role: [],

        filters: {
            user: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            role: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
        },

        has_loaded: {
            user: false,
            role: false,
        },

        is_open: {
            user: false,
            role: false,
        },
        
        is_creating: {
            user: false,
            role: false,
        },
        
        is_loading: {
            user: false,
            role: false,
        },

        is_grid_view: {
            user: false,
            role: false,
        },

        has_more: {
            user: true,
            role: true,
        },

        page: {
            user: 1,
            role: 1,
        },

        chart_object: {
            user: null,
            role: null,
        },

        counts: {
            user: {
                total: 0,
                trash: 0
            },
            role: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            user: {
                labels: [],
                data: [],
            },       
            role: {
                labels: [],
                data: [],
            },       
        },

        selected_items: {
            user: [],
            role: [],
        },

        selected: {
            user: {
                first_name: '',
                last_name: '',
                imageUrl: '',
                imageFile: null,
                address: '',
                email: '',
                national_code: '',
                permissions: [],
                roles: []
            },
            role: {
                display_name: '',
                description: '',
                permissions: []
            },
        },
    },
}