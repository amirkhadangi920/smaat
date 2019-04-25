export default {
    state: {
        product: [],
        review: [],
        question_and_answer: [],

        filters: {
            product: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            review: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            question_and_answer: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
        },

        has_loaded: {
            product: false,
            review: false,
            question_and_answer: false,
        },

        is_open: {
            product: false,
            review: false,
            question_and_answer: false,
        },
        
        is_creating: {
            product: false,
            review: false,
            question_and_answer: false,
        },
        
        is_loading: {
            product: false,
            review: false,
            question_and_answer: false,
        },

        is_grid_view: {
            product: false,
            review: false,
            question_and_answer: false,
        },

        has_more: {
            product: true,
            review: true,
            question_and_answer: true,
        },

        page: {
            product: 1,
            review: 1,
            question_and_answer: 1,
        },

        counts: {
            product: {
                total: 0,
                trash: 0
            },
            review: {
                total: 0,
                trash: 0
            },
            question_and_answer: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            product: {
                labels: [],
                data: [],
            },
            review: {
                labels: [],
                data: [],
            },
            question_and_answer: {
                labels: [],
                data: [],
            },
        },

        selected_items: {
            product: [],
            review: [],
            question_and_answer: [],
        },

        selected: {
            review: {
                name: '',
                description: '',
                categories: [],
                logoFile: null,
                imageUrl: ''
            },
            question_and_answer: {
                name: '',
                description: '',
                categories: [],
                logoFile: null,
                imageUrl: ''
            },
        },
    },
}