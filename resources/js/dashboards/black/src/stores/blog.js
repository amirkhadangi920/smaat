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

        is_mutation_loading: {
            article: false,
            comment: false,
        },

        is_query_loading: {
            article: false,
            comment: false,
        },

        is_open: {
            article: false,
            comment: false,
        },

        is_incrementing: {
            article: true,
        },

        has_timestamps: {
            article: true,
            comment: true,
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

        image_field: {
            article: 'image',
        },

        form: {
            article: {
                title: {
                    type: 'String',
                    value: ''
                },
                description: {
                    type: 'String',
                    value: ''
                },
                body: {
                    type: 'String',
                    value: ''
                },
                reading_time: {
                    type: 'Int',
                    value: ''
                },
                tags: {
                    type: '[String]',
                    value: [],
                    clientResolver: tags => tags.map(tag => tag.name)
                },
                subjects: {
                    type: '[Int]',
                    value: [],
                    serverResolver: subjects => subjects.map(subject => subject.id)
                },
                image: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
            },
        },

        selected: {
            article: {
                id: null,
                index: null
            },
            comment: {
                id: null,
                index: null

                // name: '',
                // description: '',
                // categories: [],
                // logoFile: null,
                // imageUrl: ''
            },
        },
    },
}