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

        is_mutation_loading: {
            category: false,
            subject: false,
        },
        
        is_query_loading: {
            category: false,
            subject: false,
        },
        
        is_incrementing: {
            // 
        },

        has_timestamps: {
            category: true,
            subject: true,
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
                parent_id: {
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
                icon: {
                    type: 'String',
                    value: ''
                },
                logo: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
                is_deleted_image: {
                    type: 'Boolean',
                    value: false
                }
            },
            subject: {
                parent_id: {
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
                icon: {
                    type: 'String',
                    value: ''
                },
                logo: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
                is_deleted_image: {
                    type: 'Boolean',
                    value: false
                }
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
                allData: categories {
                    data {
                        id title description icon logo { id file_name thumb } childs {
                            id title description icon logo { id file_name thumb } childs {
                                id title description icon logo { id file_name thumb } childs {
                                    id title description icon logo { id file_name thumb } childs {
                                        id title description icon
                                    }
                                }
                            }
                        }
                    }
                    total trash chart { month count }
                }
            }`,
            subject: `{
                allData: subjects {
                    data {
                        id title description icon logo { id file_name thumb } childs {
                            id title description icon logo { id file_name thumb } childs {
                                id title description icon logo { id file_name thumb } childs {
                                    id title description icon logo { id file_name thumb } childs {
                                        id title description icon
                                    }
                                }
                            }
                        }
                    }
                    total trash chart { month count }
                }
            }`
        },
    },
}