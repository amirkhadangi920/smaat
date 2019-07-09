import Vue from 'vue'
import Vuex from 'vuex'

import feature from './feature'
import group from './group'
import blog from './blog'
import product from './product'
import shop from './shop'
import user from './user'
import spec from './spec'
import setting from './setting'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        feature,
        group,
        blog,
        product,
        shop,
        user,
        spec,
        setting
    },
    state: {
        permissions: [],
        permissions_list: [],
        me: {
            id: null,
            first_name: '',
            last_name: '',
            full_name: '',
            email: '',
            avatar: {
                thumb: ''
            }
        },
        siteSetting: {
            title: null
        },
        icons: [
            {
                label: 'Action',
                icons: [
                    'accessibility',
                    'accessible',
                    'account_balance',
                    'account_balance_wallet',
                    'account_box',
                    'account_circle',
                    'add_shopping_cart',
                    'alarm',
                    'alarm_add',
                    'alarm_off',
                    'alarm_on',
                    'all_inbox',
                    'android',
                    'announcement',
                    'arrow_right_alt',
                    'aspect_ratio',
                    'assessment',
                    'assignment',
                    'assignment_ind',
                    'assignment_late',
                    'bookmarks',
                    'autorenew',
                    'build',
                    'commute',
                    'compare_arrows',
                    'credit_card',
                    'dashboard',
                    'delete',
                    'event',
                    'flight_land',
                    'flight_takeoff',
                    'gavel',
                    'grade',
                    'group_work',
                    'help',
                    'home',
                    'hourglass_empty',
                    'invert_colors',
                    'language',
                    'loyalty',
                    'motorcycle',
                    'pan_tool',
                    'perm_camera_mic',
                    'perm_phone_msg',
                    'perm_device_information',
                    'print',
                    'redeem',
                    'room',
                    'rowing',
                    'settings_brightness',
                    'settings_bluetooth',
                    'settings',
                    'settings_input_antenna',
                    'settings_input_component',
                    'settings_input_hdmi',
                    'settings_overscan',
                    'settings_voice',
                    'shopping_basket',
                    'store',
                    'theaters',
                    'timeline',
                    'touch_app',
                    'track_changes',
                    'verified_user',
                ]
            },
            {
                label: 'Alert',
                icons: [
                    'add_alert',
                    'error',
                    'warning',
                ]
            },
        ]
    },
    mutations: {
        setData(state, data)
        {
            return state[data.group][data.type] = data.data
        },
        setAttr(state, data)
        {
            return state[data.group][data.attr][data.type] = data.data
        },
        setFormData(state, data)
        {
            return state[data.group].form[data.type][data.field].value = data.value
        },
        setFormImage(state, data)
        {
            const field = state[data.group].image_field[data.type]

            return state[data.group].form[data.type][field] = {
                type: 'Upload',
                value: null,
                file: data.file ? data.file : null,
                url: data.file ? URL.createObjectURL(data.file) : ''
            }
        },
        clearForm(state, data)
        {
            let form = state[data.group].form[data.type]

            for (let field in form)
            {
                switch ( form[field].type )
                {
                    case 'String':
                        form[field].value = ''
                        break;

                    case 'Int':
                    case 'Boolean':
                        form[field].value = field === 'is_deleted_image' ? false : null
                        break;

                    case '[Int]':
                    case '[String]':
                    case '[Upload]':
                        form[field].value = []
                        break;

                    case 'Upload':
                        form[field].value = null
                        form[field].file = null
                        form[field].url = ''
                        break;
                }
            }

            return state[data.group].form[data.type] = form
        },
        fillFormForEditing(state, data)
        {
            let form = state[data.group].form[data.type]

            for (let field in form)
            {
                let value = data.row[field]
                
                if ( typeof form[field].serverResolver === "function" )
                    value = form[field].serverResolver(value)

                switch ( form[field].type )
                {
                    case 'String':
                        form[field].value = value ? value : ''
                        break;

                    case 'Int':
                    case 'Boolean':
                        form[field].value = value ? value : field === 'is_deleted_image' ? false : null
                        break;

                    case '[Int]':
                    case '[String]':
                    case '[Upload]':
                        form[field].value = value ? value : []
                        break;

                    case 'Upload':
                        form[field].value = null
                        form[field].file = null
                        form[field].url = value ? value.medium ? value.medium : value.thumb : ''
                        break;
                }
            }

            return state[data.group].form[data.type] = form
        },
        setPermissions(state, permissions)
        {
            return state.permissions = permissions.map(value => value.name)
        },
        setMeInfo(state, data)
        {
            return state.me = data
        },
        setSiteSetting(state, data)
        {
            return state.siteSetting = data
        },
        setPermissionsList(state, permissions)
        {
            return state.permissions_list = permissions
        }
    },
    actions: {
        getData({ commit, state }, inputs)
        {
            if( state[inputs.group][inputs.type].length > 0 )
                return state[inputs.group][inputs.type]

            var query;

            if ( state[inputs.group].query  && state[inputs.group].query[inputs.type] )
            {
                query = state[inputs.group].query[inputs.type]
            }
            else
            {
                query = `{
                    allData: ${inputs.query}
                }`
            }

            axios.get('/graphql/auth', {
                params: {
                    query: query
                }
            }).then(({data}) => {

                commit('setData', {
                    group: inputs.group,
                    type: inputs.type,
                    data: state[inputs.group].handleQuery && state[inputs.group].handleQuery[inputs.type]
                        ? state[inputs.group].handleQuery[inputs.type](data)
                        : data.data.allData.data
                })

                commit('setAttr', {
                    group: inputs.group,
                    type: inputs.type,
                    attr: 'counts',
                    data: {
                        total: data.data.allData.total,
                        trash: data.data.allData.trash
                    }
                })

                commit('setAttr', {
                    group: inputs.group,
                    type: inputs.type,
                    attr: 'charts',
                    data: {
                        labels: data.data.allData.chart.map(period => period.month),
                        data: data.data.allData.chart.map(period => period.count)
                    }
                })
            })
        },
        getPermissions({ commit, state }, inputs)
        {
            if( state.permissions.length > 0 )
                return state.permissions

            axios.get('/graphql/auth', {
                params: {
                    query: `{
                        me {
                            id
                            first_name
                            last_name
                            full_name
                            email
                            avatar { id file_name thumb }
                            allPermissions { id name display_name description }
                        }

                        siteSetting {
                            title
                        }
                    }`
                }
            })
            .then(({data}) => {
                if ( data.data.me.allPermissions.length === 0 )
                {
                    localStorage.removeItem('JWT')
                    window.location = "/login"    
                }

                commit('setPermissions', data.data.me.allPermissions)
                commit('setPermissionsList', data.data.me.allPermissions)
                commit('setMeInfo', data.data.me)
                commit('setSiteSetting', data.data.siteSetting)
            })
            .catch(error => {
                localStorage.removeItem('JWT')
                window.location = "/login"
            })
        },
    }
})