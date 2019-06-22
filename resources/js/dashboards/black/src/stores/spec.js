export default {
    state: {
        spec_row: [],
        spec_header: [],
        spec_default: [],

        filters: {
            spec_row: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            spec_header: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
        },

        has_loaded: {
            spec_row: false,
            spec_header: false,
            spec_default: false,
        },

        is_open: {
            spec_row: false,
            spec_header: false,
            spec_default: false,
        },

        is_incrementing: {},

        has_timestamps: {
            spec_row: true,
            spec_header: true,
            spec_default: false,
        },
        
        is_creating: {
            spec_row: false,
            spec_header: false,
            spec_default: false,
        },
        
        is_loading: {
            spec_row: false,
            spec_header: false,
            spec_default: false,
        },

        is_grid_view: {
            spec_row: false,
            spec_header: false,
            spec_default: false,
        },

        has_more: {
            spec_row: true,
            spec_header: true,
            spec_default: true,
        },

        page: {
            spec_row: 1,
            spec_header: 1,
            spec_default: 1,
        },

        chart_object: {
            spec_row: null,
            spec_header: null,
            spec_default: null,
        },

        counts: {
            spec_row: {
                total: 0,
                trash: 0
            },
            spec_header: {
                total: 0,
                trash: 0
            },
            spec_default: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            spec_row: {
                labels: [],
                data: [],
            },       
            spec_header: {
                labels: [],
                data: [],
            },       
            spec_default: {
                labels: [],
                data: [],
            },       
        },

        selected_items: {
            spec_row: [],
            spec_header: [],
            spec_default: [],
        },

        image_field: {
            // 
        },

        form: {
            spec_row: {
                spec_header_id: {
                    type: 'Int',
                    value: null
                },
                title: {
                    type: 'String',
                    value: ''
                },
                description: {
                    type: 'String',
                    value: ''
                },
                help: {
                    type: 'String',
                    value: ''
                },
                postfix: {
                    type: 'String',
                    value: ''
                },
                prefix: {
                    type: 'String',
                    value: ''
                },
                is_filterable: {
                    type: 'Boolean',
                    value: null
                },
                is_multiple: {
                    type: 'Boolean',
                    value: null
                },
                is_required: {
                    type: 'Boolean',
                    value: null
                },
            },
            spec_header: {
                spec_id: {
                    type: 'Int',
                    value: null
                },
                title: {
                    type: 'String',
                    value: ''
                },
                description: {
                    type: 'String',
                    value: ''
                },
            },
            spec_default: {
                spec_row_id: {
                    type: 'Int',
                    value: null
                },
                value: {
                    type: 'String',
                    value: ''
                }
            },
        },

        selected: {
            spec_row: {
                id: null,
                index: null
            },
            spec_header: {
                id: null,
                index: null
            },
            spec_default: {
                id: null,
                index: null
            },
        },
    },
}