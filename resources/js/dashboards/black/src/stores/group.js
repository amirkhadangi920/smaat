export default {
    state: {
        category: [],
        subject: [],

        has_loaded: {
            category: false,
            subject: false,
        },

        is_open: {
            category: false,
            subject: false,
        },
        
        is_creating: {
            category: false,
            subject: false,
        },
        
        is_loading: {
            category: false,
            subject: false,
        },

        chart_object: {
            category: null,
            subject: null,
        },

        counts: {
            category: {
                total: 0,
                trash: 0
            },
            subject: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            category: {
                labels: [],
                data: [],
            },       
            subject: {
                labels: [],
                data: [],
            },       
        },

        selected_items: {
            category: [],
            subject: [],
        },

        selected: {
            category: {
                title: '',
                description: '',
                body: '',
                subject: [],
                imageFile: null,
                imageUrl: ''
            },
            subject: {
                name: '',
                description: '',
                category: [],
                logoFile: null,
                imageUrl: ''
            },
        },
    },
}