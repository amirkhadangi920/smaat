import voca from 'voca'

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

    data() {
      return this.$store.state[this.group][this.type]
    },
    attr(attr) {
        return this.$store.state[this.group][attr][this.type]
    },

    handleDelete(index, row)
    {
      this.$swal.fire({
        title: `برای پاک کردن ${this.label} "${row.name ? row.name : row.title ? row.title : 'انتخاب شده'}" مطمئن هستید ؟`,
        text: "در صورت پاک کردن امکان بازگشت اطلاعات نیست !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
        confirmButtonColor: '#0098f0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله ، مطمئنم !',
        cancelButtonText: 'نه ، اشتباه شده'
      }).then((result) => {
        if (result.value) {
          this.setAttr('is_query_loading', true)

          const mutation = voca.camelCase(`delete ${this.type}`)

          axios.post('/graphql/auth', {
            query: `mutation {
              ${mutation} (id: ${ this.attr('is_incrementing') ? `"${row.id}"` : row.id }) {
                status
                message
              }
            }`
          }).then(({data}) => {
            this.setAttr('is_query_loading', false)

            const result = data.data[mutation]
            
            if ( result.status === 400 )
            {
              return this.$swal.fire({
                title: 'حذف نشد',
                text: `متاسفانه هیچ یک از ${this.label} ها حذف نشد :(`,
                type: 'error',
                showConfirmButton: false,
                timer: 1000,
              })
            }

            this.afterDelete(index, row);

            this.$swal.fire({
              title: 'حذف شد',
              text: `${this.label} "${row.name ? row.name : row.title ? row.title : 'انتخاب شده'}" با موفقیت حذف شد :)`,
              type: 'success',
              showConfirmButton: false,
              timer: 1000,
            })
          }).catch(error => {
            this.setAttr('is_query_loading', false)
            console.log(error)
          });
        }
      })
    },
    afterDelete(index)
    {
      this.data().splice(index, 1)
      this.setData( this.data() )
      
      this.setAttr('counts', {
        total: this.attr('counts').total - 1,
        trash: this.attr('counts').trash + 1,
      })
    },
    handleSelectionChange(items) {
      this.changeSelected({
        type: this.type,
        items: {
          items: this.$store.state.feature.selected_items[this.type] = items.map(value => value.id)
        }
      })
    },
    handleDeleteMultiple()
    {
      this.$swal.fire({
        title: `برای پاک کردن ${this.label}های انتخاب شده مطمئن هستید ؟`,
        text: "در صورت پاک کردن امکان بازگشت اطلاعات نیست !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
        confirmButtonColor: '#0098f0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله ، مطمئنم !',
        cancelButtonText: 'نه ، اشتباه شده'
      }).then((result) => {
        if (result.value) {
          this.setAttr('is_query_loading', true)

          var ids = [];

          this.attr('selected_items').forEach( item => {
            ids = [...ids, this.data()[item].id]
          })

          if ( this.attr('is_incrementing') )
            ids = '"' + ids.join('", "') + '"'

          else
            ids.join(',')
          
          const mutation = voca.camelCase(`delete ${this.type}`)

          axios.post('/graphql/auth', {
            query: `mutation {
              ${mutation} (ids: [${ids}]) {
                status
                message
              }
            }`
          }).then(({data}) => {
            this.setAttr('is_query_loading', false)

            const result = data.data[mutation]
            
            if ( result.status === 400 )
            {
              return this.$swal.fire({
                title: 'حذف نشد',
                text: `متاسفانه هیچ یک از ${this.label} ها حذف نشد :(`,
                type: 'error',
                showConfirmButton: false,
                timer: 1000,
              })
            }

            let newDataArray = this.$store.state[this.group][this.type].filter((item, index) => {
              return !this.attr('selected_items').includes(index) || ( this.ignoreOperations && this.ignoreOperations.includes(item.id) )
            })

            this.setData(newDataArray);

            this.setAttr('counts', {
              total: this.attr('counts').total - this.attr('selected_items').length,
              trash: this.attr('counts').trash + this.attr('selected_items').length,
            })

            this.setAttr('selected_items', [], true)
            this.selected_items = [];

            this.$swal.fire({
              title: 'حذف شدند',
              text: `${this.label} هایی که انتخاب کردید با موفقیت حذف شدند :)`,
              type: 'success',
              timer: 1000,
              showConfirmButton: false,
            })

          }).catch(error => {
            this.setAttr('is_query_loading', false)
            
            if (error.response) {
              this.$swal.fire({
                title: 'خطایی رخ داد !',
                text: error.response.data.message,
                type: 'error',
                timer: 5000,
                confirmButtonText: 'بسیار خب :('
                // showConfirmButton: false,
              })
            } else {
              console.log(error)
            }
          });
        }
      })
    },
  }
};
