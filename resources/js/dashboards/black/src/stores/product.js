export default {
    state: {
        product: [],
        label: [],
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
            label: {
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
            label: false,
            review: false,
            question_and_answer: false,
        },

        image_field: {
            // 
        },

        is_mutation_loading: {
            product: false,
            label: false,
            variation: false,
            review: false,
            question_and_answer: false,
        },
        
        is_query_loading: {
            product: false,
            label: false,
            variation: false,
            review: false,
            question_and_answer: false,
        },

        is_open: {
            product: false,
            label: false,
            variation: false,
            review: false,
            question_and_answer: false,
        },
        
        is_incrementing: {
            product: true,
            variation: true 
        },

        has_timestamps: {
            product: true,
            label: true,
            variation: true,
            review: true,
            question_and_answer: true,
        },
        
        is_creating: {
            product: false,
            label: false,
            variation: false,
            review: false,
            question_and_answer: false,
        },
        
        is_loading: {
            product: false,
            label: false,
            review: false,
            question_and_answer: false,
        },

        is_grid_view: {
            product: false,
            label: false,
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

        chart_object: {
            product: null,
            label: null,
            review: null,
            question_and_answer: null,
        },

        counts: {
            product: {
                total: 0,
                trash: 0
            },
            label: {
                total: 0,
                trash: 0
            },
            variation: {
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
            label: [],
            variation: [],
            review: [],
            question_and_answer: [],
        },

        form: {
            review: {
                // 
            },
            question_and_answer: {
                // 
            },
            product: {
                name: {
                    type: 'String',
                    value: ''
                },
                code: {
                    type: 'String',
                    value: ''
                },
                second_name: {
                    type: '[String]',
                    value: []
                },
                description: {
                    type: 'String',
                    value: ''
                },
                brand_id: {
                    type: 'Int',
                    value: null
                },
                label_id: {
                    type: 'Int',
                    value: null
                },
                unit_id: {
                    type: 'Int',
                    value: null
                },
                spec_id: {
                    type: 'Int',
                    value: null
                },
                accessories: {
                    type: '[String]',
                    value: []
                },
                categories: {
                    type: '[Int]',
                    value: []
                },
                colors: {
                    type: '[Int]',
                    value: []
                },
                photos: {
                    type: '[ImageColorInput]',
                    value: []
                },
                short_review: {
                    type: 'String',
                    value: ''
                },
                aparat_video: {
                    type: 'String',
                    value: ''
                },
                expert_review: {
                    type: 'String',
                    value: ''
                },
                tags: {
                    type: '[String]',
                    value: []
                },
                advantages: {
                    type: '[String]',
                    value: []
                },
                disadvantages: {
                    type: '[String]',
                    value: []
                },
                deleted_images: {
                    type: '[Int]',
                    value: []
                },
                specs: {
                    type: '[SpecInput]',
                    value: []
                },
                is_active: {
                    type: 'Boolean',
                    value: null
                },
            },
            label: {
                title: {
                    type: 'String',
                    value: null
                },
                description: {
                    type: 'String',
                    value: null
                },
                color: {
                    type: 'String',
                    value: null
                },
            },
            variation: {
                product_id: {
                    type: 'String',
                    value: ''
                },
                sales_price: {
                    type: 'Int',
                    value: null
                },
                inventory: {
                    type: 'Int',
                    value: null
                },
                sending_time: {
                    type: 'Int',
                    value: null
                },
                color_id: {
                    type: 'Int',
                    value: null
                },
                warranty_id: {
                    type: 'Int',
                    value: null
                },
                size_id: {
                    type: 'Int',
                    value: null
                },
            }
        },

        selected: {
            review: {
                id: null,
                index: null
            },
            question_and_answer: {
                id: null,
                index: null
            },
            product: {
                id: null,
                index: null
            },
            label: {
                id: null,
                index: null
            },
            variation: {
                id: null,
                index: null
            },
        },
    },
}