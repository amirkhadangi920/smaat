import Vue from 'vue'
import Vuex from 'vuex'

import feature from './feature'
import group from './group'
import blog from './blog'
import product from './product'
import shop from './shop'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        feature,
        group,
        blog,
        product,
        shop
    },
    state: {
        permissions: []
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
        setPermissions(state, permissions)
        {
            return state.permissions = permissions
        }
    },
    actions: {
        getData({ commit, state }, inputs)
        {
            if( state[inputs.group][inputs.type].length > 0 )
                return state[inputs.group][inputs.type]

            axios.get(`/api/v1/${inputs.type}`).then(({data}) => {
                commit('setData', {
                    group: inputs.group,
                    type: inputs.type,
                    data: data.data
                })
            })
        },
        getPermissions({ commit, state }, inputs)
        {
            if( state.permissions.length > 0 )
                return state.permissions

            axios({
                method: 'get',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('API_TOKEN')}`
                },
                url: '/api/v1/user/permissions'
            }).then(({data}) => {
                commit('setPermissions', data.data)
            }).catch(error => {
                localStorage.removeItem('API_TOKEN')
                window.location = "/login"
            })
        },
    }
})