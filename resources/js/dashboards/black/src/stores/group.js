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

        image_field: {
            category: 'logo',
            subject: 'logo',
        },

        form: {
            category: {
                title: {
                    type: 'String',
                    value: ''
                },
                description: {
                    type: 'String',
                    value: ''
                },
                parent_id: {
                    type: 'Int',
                    value: null
                },
                logo: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
            },
            subject: {
                title: {
                    type: 'String',
                    value: ''
                },
                description: {
                    type: 'String',
                    value: ''
                },
                parent_id: {
                    type: 'Int',
                    value: null
                },
                logo: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
            },
        },

        selected: {
            category: {
                id: null,
                index: null
            },
            subject: {
                id: null,
                index: null
            },
        },

        query: {
            category: `{
                categories {
                    id title childs {
                        id title childs {
                            id title childs {
                                id title childs {
                                    id title childs { id title }
                                }
                            }
                        }
                    }
                }
            }`,
            subject: `{
                subjects {
                    id title childs {
                        id title childs {
                            id title childs {
                                id title childs {
                                    id title childs { id title }
                                }
                            }
                        }
                    }
                }
            }`
        },

        handleQuery: {
            category: (res) => res.data.categories,
            subject: (res) => res.data.subjects,
        }
    },
}