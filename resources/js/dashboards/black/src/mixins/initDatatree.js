import anime from 'animejs'

export default {
  mounted()
  {
    if (this.data().length === 0)
    {
      axios.post('/graphql/auth', {
        query: `{
          allData: ${this.plural} {
            id title description logo { id file_name thumb } childs {
              id title description logo { id file_name thumb } childs {
                id title description logo { id file_name thumb } childs {
                  id title description logo { id file_name thumb } childs {
                    id title description logo { id file_name thumb } childs {
                      id title description logo { id file_name thumb }
                    }
                  }
                }
              }
            }
          }
        }`
      })
      .then(({data}) => this.setData(data.data.allData) )
      .then(() => this.load(true) )
      .catch(error => console.log(error))
    }
    else
    {
      let data = this.data()
      this.setData([])
      this.load(false)

      setTimeout(() => {

        this.setData(data)
        this.load(true)
        
        setTimeout(() => {
          this.createChart()
        }, 200);
        
      }, 300)
    }
  },
  methods: {
    setData(data) {
      this.$store.commit('setData', {
        group: this.group,
        type: this.type,
        data: data
      })
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
    can(permission) {
      return !this.$store.state.permissions.includes(permission)
    },
    data() {
      return this.$store.state[this.group][this.type]
    },
    attr(attr) {
      return this.$store.state[this.group][attr][this.type]
    },
    load(status) {
      this.setAttr('has_loaded', status)
    },
  },
};
