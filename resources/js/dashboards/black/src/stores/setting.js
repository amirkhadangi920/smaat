export default {
    state: {
        site_info: [],
        site_slider: [],
        site_posters: [],

        filters: {
            site_info: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
            site_slider: {
                query: null,
                hasLogo: null,
                hasCategories: null,
                categories: [],
                categories_string: null
            },
        },

        has_loaded: {
            site_info: false,
            site_slider: false,
            site_posters: false,
        },

        is_open: {
            site_info: false,
            site_slider: false,
            site_posters: false,
        },

        is_incrementing: {},

        has_timestamps: {
            site_info: false,
            site_slider: false,
            site_posters: false,
        },
        
        is_creating: {
            site_info: false,
            site_slider: false,
            site_posters: false,
        },

        is_mutation_loading: {
            site_info: false,
            site_slider: false,
            site_posters: false,
            user_info: false,
            user_password: false,
        },
        
        is_query_loading: {
            site_info: false,
            site_slider: false,
            site_posters: false,
            user_info: false,
            user_password: false,
        },
        
        is_loading: {
            site_info: false,
            site_slider: false,
            site_posters: false,
        },

        is_grid_view: {
            site_info: false,
            site_slider: false,
            site_posters: false,
        },

        has_more: {
            site_info: true,
            site_slider: true,
            site_posters: true,
        },

        page: {
            site_info: 1,
            site_slider: 1,
            site_posters: 1,
        },

        chart_object: {
            site_info: null,
            site_slider: null,
            site_posters: null,
        },

        counts: {
            site_info: {
                total: 0,
                trash: 0
            },
            site_slider: {
                total: 0,
                trash: 0
            },
            site_posters: {
                total: 0,
                trash: 0
            },
        },

        charts: {
            site_info: {
                labels: [],
                data: [],
            },       
            site_slider: {
                labels: [],
                data: [],
            },       
            site_posters: {
                labels: [],
                data: [],
            },       
        },

        selected_items: {
            site_info: [],
            site_slider: [],
            site_posters: [],
        },

        image_field: {
            // 
        },

        form: {
            site_info: {
                title: {
                    type: 'String',
                    value: ''
                },
                description: {
                    type: 'String',
                    value: ''
                },
                phone: {
                    type: 'String',
                    value: ''
                },
                address: {
                    type: 'String',
                    value: ''
                },
                theme_color: {
                    type: 'String',
                    value: ''
                },
                banner_link: {
                    type: 'String',
                    value: ''
                },
                logo: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
                watermark: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
                banner: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
                header_banner: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
                is_enabled: {
                    type: 'Boolean',
                    value: null
                },
            },
            site_slider: {
                slider: {
                    type: '[SliderItemInput]',
                    value: null
                },
            },
            site_posters: {
                posters: {
                    type: '[SliderItemInput]',
                    value: null
                },
            },
        },

        selected: {
            site_info: {
                id: null,
                index: null
            },
            site_slider: {
                id: null,
                index: null
            },
            site_posters: {
                id: null,
                index: null
            },
        },
    },
}