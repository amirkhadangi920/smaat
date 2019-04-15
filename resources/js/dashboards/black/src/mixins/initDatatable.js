export default {
  mounted() {
    if( this.data().length === 0 )
    {
      axios.get(`/api/v1/${this.type}`, {
          params: this.filters
      }).then((response) => {
        this.setData( response.data.data )

        this.setAttr('counts', {
          total: response.data.meta.total,
          trash: response.data.meta.trash,
        })

        this.setAttr('charts', {
          labels: response.data.chart.map( period => period.month ),
          data: response.data.chart.map( period => period.count )
        })
        if ( response.data.links && response.data.links.next === null )
          this.setAttr('has_more', false)

      }).then(() => {
        setTimeout( () => this.load(true), 500 )
      })
    } else {
      setTimeout( () => this.load(true), 500 )
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
      let final_data = typeof data === 'object' ? {...this.$store.state[this.group][attr][this.type], ...data} : data;

      if ( override ) final_data = data

      this.$store.commit('setAttr', {
        attr,
        group: this.group,
        type: this.type,
        data: final_data
      })
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
    
    load(status) {
      this.setAttr('has_loaded', status)
    },
    

    changeTableData()
    {
      axios.get(`/api/v1/${this.type}`, {
        params: this.attr('filters')
      }).then((response) => {
        setTimeout( () => {
          this.setData( response.data.data )
          
          setTimeout( () => $('.tilt').tilt({scale: 1.1}), 300)
        }, 500);
      })
    },

    loadMore() {
      this.setPage({
        type: this.type,
        page: this.$store.state.feature.page[this.type] + 1
      })
      this.setLoadingSatus({
        type: this.type,
        status: true
      })

      axios.get(`/api/v1/${this.type}`, {
        params: {
          page: this.$store.state.feature.page[this.type],
        },
      }).then(({ data }) => {
        setTimeout( () => {
          if ( data.links.next === null ) {
            this.setHasMoreStatus({
              type: this.type,
              status: false
            })
          }

          var time = 0;
          data.data.forEach(item => {
            setTimeout( () => {
              this.setFeature({
                type: this.type,
                data: [...this.$store.state.feature[this.type], item]
              })
            }, time)
            time += 200;
          });

          this.setLoadingSatus({
            type: this.type,
            status: false
          })
        }, 300)
      });
    },
  },
};
