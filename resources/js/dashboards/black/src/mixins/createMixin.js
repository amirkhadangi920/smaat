export default {
  methods: {
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

    store() {
      if( !this.validate() ) return;
      
      this.storeInServer({
        data: this.getData(),
        type: this.type,
        label:this.label,
        callback: response => {
          let arr = this.data()
          arr.unshift(response)

          this.setData( arr )

          this.setAttr('is_open', false)
          this.setAttr('is_creating', false)
        }
      })
  
    },
    update() {
      this.storeInServer({
        data: this.getData(),
        type: this.type,
        label: this.label,
        url: this.selected('link'), 
        callback: response => {
          let index = this.selected('index');
          this.data()[index] = response;

          this.setData( this.data() )

          this.setAttr('is_open', false)
        }
      })
    },

    addImage(file) {
      this.setAttr('selected', {
        imageFile: file.raw,
        imageUrl: URL.createObjectURL(file.raw)
      })
    },

    storeInServer(options) {
      let groupData = this.$store.state[this.group]
      
      if( !groupData.is_creating[this.type] )
        options.data.append('_method', 'PUT');

      axios({
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Accept': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('JWT')}`
        },
        url: options.url !== undefined ? options.url : `/api/v1/${options.type}`,
        data: options.data
      }).then(response => {
        var msg = groupData.is_creating[this.type] ? 'ثبت شد' : 'بروزرسانی شد'
        
        if ( groupData.is_creating[this.type] ) {
          this.setAttr('counts', {
            total: this.attr('counts').total + 1,
          })
        }

        this.$swal.fire({
          title: msg,
          text: `${options.label} با موفقیت ${msg}:)`,
          type: 'success',
          showConfirmButton: false,
          timer: 1000,
        })

        options.callback(response.data.data)
      }).catch(error => {
        if (error.response) {
          console.log( error.response )

          if (error.response.status === 422) {

            for (let key in error.response.data.errors) {
              if (!error.response.data.errors.hasOwnProperty(key)) continue;

              error.response.data.errors[key].forEach(error => {
                this.$notify({
                  title: 'خطا',
                  message: error,
                  timeout: 10000,
                  type: 'danger',
                  verticalAlign: 'top',
                  horizontalAlign: 'left',
                })
              });
            }
          }
        }
      });
    },
  }
}
