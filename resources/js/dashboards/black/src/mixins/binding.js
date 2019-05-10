export default {
  methods: {
    selected(field) {
      return this.$store.state[this.group].selected[this.type][field]
    },
    setAttr(attr, data, override = false) {
      let final_data = typeof data === 'object' ? {
        ...this.$store.state[this.group][attr][this.type],
        ...data
      } : data;

      if (override) final_data = data

      this.$store.commit('setAttr', {
        attr,
        group: this.group,
        type: this.type,
        data: final_data
      })
    },

    getValidationClass (fieldName) {
      const field = this.$v[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validate() {
      this.$v.$touch()

      return !this.$v.$invalid;
    },
  },
}

export function bind(field) {
  return {
    get() {
      return this.selected(field)
    },
    set(value) {
      let data = {}
      data[field] = value

      this.setAttr('selected', data)
    }
  }
}
