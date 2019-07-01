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
                file: data.file,
                url: URL.createObjectURL(data.file)
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
                        form[field].value = null
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
                        form[field].value = value ? value : null
                        break;

                    case '[Int]':
                    case '[String]':
                    case '[Upload]':
                        form[field].value = value ? value : []
                        break;

                    case 'Upload':
                        form[field].value = null
                        form[field].file = null
                        form[field].url = value ? value.thumb : ''
                        break;
                }
            }

            return state[data.group].form[data.type] = form
        },
        setPermissions(state, permissions)
        {
            return state.permissions = permissions.map(value => value.name)
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
            })
        },
        getPermissions({ commit, state }, inputs)
        {
            if( state.permissions.length > 0 )
                return state.permissions

            axios({
                method: 'get',
                url: '/api/v1/user/permissions'
            }).then(({data}) => {
                commit('setPermissions', data.data)
                commit('setPermissionsList', data.data)
            }).catch(error => {
                localStorage.removeItem('JWT')
                window.location = "/login"
            })
        },
    }
})