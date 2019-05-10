export default {
    methods: {
        setData(data) {
            this.$store.commit('setData', {
                group: this.group,
                type: this.type,
                data: data
            })
        },
        setAttr(attr, data, override = false) {
            let final_data = typeof data === 'object' ? {...this.$store.state[this.group][attr][this.type], ...data} : data;
        
            if ( override ) final_data = data
        
            this.$store.commit('setAttr', {
                attr,
                group: this.group,
                type: this.type,
                data: final_data
            })
        },
        can(permission) {
            return !this.$store.state.permissions.includes(permission)
        },
    
        data() {
            return this.$store.state[this.group][this.type]
        },
        attr(attr) {
            return this.$store.state[this.group][attr][this.type]
        },
        filter(filter) {
            return this.$store.state[this.group].filters[this.type][filter]
        },
        selected(field) {
            return this.$store.state[this.group].selected[this.type][field]
        },
    },
}