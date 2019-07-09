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
        
        is_incrementing: {
            user: true 
        },


        has_timestamps: {
            user: true,
            role: true,
        },

        is_mutation_loading: {
            user: false,
            role: false,
        },
        
        is_query_loading: {
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

        image_field: {
            user: 'avatar',
        },

        form: {
            user: {
                first_name: {
                    type: 'String',
                    value: ''
                },
                last_name: {
                    type: 'String',
                    value: ''
                },
                avatar: {
                    type: 'Upload',
                    value: null,
                    file: null,
                    url: ''
                },
                email: {
                    type: 'String',
                    value: ''
                },
                national_code: {
                    type: 'String',
                    value: ''
                },
                gender: {
                    type: 'Boolean',
                    value: null,
                    clientResolver: gender => {
                        return gender === 'true' ? true : gender === 'false' ? false : null
                    }
                },
                permissions: {
                    type: '[Int]',
                    value: [],
                    serverResolver: permissions => permissions.map(p => p.id),
                    clientResolver: (permissions, state) => {
                        let finalPermissions = []

                        permissions.forEach(permission => {
                            if ( !_.find( state.permissions_list, ['id', permission]).disabled )
                                finalPermissions.push(permission)
                        })
                        
                        return finalPermissions
                    }
                },
                roles: {
                    type: '[Int]',
                    value: [],
                    serverResolver: roles => roles.map(p => p.id)
                },
                is_deleted_image: {
                    type: 'Boolean',
                    value: false
                }
            },

            role: {
                display_name: {
                    type: 'String',
                    value: ''
                },
                description: {
                    type: 'String',
                    value: ''
                },
                permissions: {
                    type: '[Int]',
                    value: [],
                    serverResolver: permissions => permissions.map(p => p.id)
                },
            }
        },

        selected: {
            user: {
                id: null,
                index: null
            },
            role: {
                id: null,
                index: null
            },
        },
    },
}