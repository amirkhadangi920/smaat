import voca from 'voca'

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
    clearForm()
    {
      this.$store.commit('clearForm', {
        group: this.group,
        type: this.type
      })
    },
    fillFormForEditing(row)
    {
      this.$store.commit('fillFormForEditing', {
        group: this.group,
        type: this.type,
        row
      })
    },
    data() {
      return this.$store.state[this.group][this.type]
    },
    attr(attr) {
        return this.$store.state[this.group][attr][this.type]
    },

    create()
    {
      this.clearForm()
      
      if ( typeof this.afterCreate === "function" )
        this.afterCreate();

      this.setAttr('is_open', true)
      this.setAttr('is_creating', true)
    },
    edit(index, row)
    {
      if ( typeof this.getRowData === "function" )
      {
        const rowData = row
        row = this.getRowData(row);

        return row.then( ({data}) => this.handleEdit(index, {
          ...rowData,
          ...data.data.singleData
        }))
      }

      return this.handleEdit(index, row)
    },
    handleEdit(index, row)
    {
      this.fillFormForEditing(row)

      this.setAttr('selected', {
        index,
        id: row.id
      })
    
      if ( typeof this.afterEdit === "function" )
        this.afterEdit(row);

      this.setAttr('is_open', true)
      this.setAttr('is_creating', false)
    },
    store()
    {
      this.storeInServer({
        callback: ({data}) => {

          let arr = this.data()
          arr.unshift(data)

          this.setData( arr )

          this.setAttr('is_open', false)
          this.setAttr('is_creating', false)
        }
      })
    },
    update()
    {
      this.storeInServer({
        callback: ({data}) => {
          let index = this.attr('selected').index;
          this.data()[index] = data;

          this.setData( this.data() )

          this.setAttr('is_open', false)
        }
      })
    },

    getAllFormData()
    {
      const form = this.attr('form');
      
      let args = '', params = '', variables = {};

      for( let key in form )
      {
        params += `$${key}: ${form[key].type}, `
        args += `${key}: $${key}, `
        variables[key] = form[key].clientResolver ? form[key].clientResolver( form[key].value ) : form[key].value
      }

      params = params.substr(0, params.length - 2)
      args = args.substr(0, args.length - 2)

      return {
        params,
        args,
        variables
      }
    },

    addImage(file)
    {
      this.$store.commit('setFormImage', {
        group: this.group,
        type: this.type,
        file: file.raw
      })
    },

    storeInServer(options)
    {
      if ( !this.validate() ) return;
    
      const mutation = voca.camelCase(
        this.attr('is_creating') ? `create ${this.type}` : `update ${this.type}`
      )

      const form = this.getAllFormData()      
      
      if ( !this.attr('is_creating') && this.group !== 'setting' )
      {
        if ( this.attr('is_incrementing') )
          form.args = `id: "${ this.attr('selected').id }", ` + form.args

        else
          form.args = `id: ${ this.attr('selected').id }, ` + form.args
      }

      const query = {
        query: `mutation manageData(${form.params}) {
          data: ${mutation} (${form.args}) {
            ${this.group !== 'setting' ? 'id' : ''}
            ${this.allQuery}

            ${ this.attr('has_timestamps') ? 'created_at updated_at' : ''}
          }
        }`,
        variables: typeof this.getVariables === "function" ? this.getVariables() : form.variables
      }

      // return console.log( query )

      let fd = new FormData();

      fd.append('operations' , JSON.stringify(query));

      if ( this.attr('image_field') )
      {
        const image_field = this.attr('image_field')
  
        let file = this.attr('form')[image_field].file

        if ( file )
        {
          let map = { image: [`variables.${image_field}`] }
          fd.append('map' , JSON.stringify(map))
          fd.append('image', file)
        }
        else
          fd.append('map' , '{}')
      }
      else
        fd.append('map' , '{}')

      if ( typeof this.changeFormData === "function" )
        fd = this.changeFormData(fd);      


      axios.post('/graphql/auth', fd).then(({data}) =>
      {
        // return console.log( data )
        var msg = this.attr('is_creating') ? 'ثبت شد' : 'بروزرسانی شد'
          
        if ( this.attr('is_creating') ) {
          this.setAttr('counts', {
            total: this.attr('counts').total + 1,
          })
        }

        this.$swal.fire({
          title: msg,
          text: `${this.label} با موفقیت ${msg}:)`,
          type: 'success',
          showConfirmButton: false,
          timer: 1000,
        })

        options.callback(data.data)

      }).catch(this.errorResolver)
    },

    errorResolver(error)
    {
      console.log(error)

      if ( error.type === 'validation' )
      {
        for (let key in error.messages)
        {
          error.messages[key].forEach(error =>
          {
            this.$notify({
              title: 'خطا اعتبار سنجی',
              message: error,
              timeout: 10000,
              type: 'danger',
              verticalAlign: 'top',
              horizontalAlign: 'left',
            })
          })
        }
      }
    }
  }
}
