export default {
    state: {
        article: [],
        comment: [],

        filters: {
            article: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            comment: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
        },

        has_loaded: {
            article: false,
            comment: false,
        },

        is_open: {
            article: false,
            comment: false,
        },
        
        is_creating: {
            article: false,
            comment: false,
        },
        
        is_loading: {
            article: false,
            comment: false,
        },

        is_grid_view: {
            article: false,
            comment: false,
        },

        has_more: {
            article: true,
            comment: true,
        },

        page: {
            article: 1,
            comment: 1,
        },

        chart_object: {
            article: null,
            comment: null,
        },

        counts: {
            article: {
                total: 0,
                trash: 0
            },
            comment: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            article: {
                labels: [],
                data: [],
            },       
            comment: {
                labels: [],
                data: [],
            },       
        },

        selected_items: {
            article: [],
            comment: [],
        },

        selected: {
            article: {
                title: '',
                description: '',
                body: '',
                reading_time: null,
                tags: [],
                subjects: [],
                imageFile: null,
                imageUrl: ''
            },
            comment: {
                name: '',
                description: '',
                categories: [],
                logoFile: null,
                imageUrl: ''
            },
        },
    },
}