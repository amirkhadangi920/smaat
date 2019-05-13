import {mapActions, mapMutations} from 'vuex'
import { arrayExpression } from 'babel-types';

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

    handleDelete(index, row) {
      this.$swal.fire({
        title: `برای پاک کردن ${this.label} ${row.name} مطمئن هستید ؟`,
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

          axios.delete(row.link)
            .then(response => {
              this.data().splice(index, 1)
              this.setData( this.data() )
              
              this.setAttr('counts', {
                total: this.attr('counts').total - 1,
                trash: this.attr('counts').trash + 1,
              })

              this.$swal.fire({
                title: 'حذف شد',
                text: `برند ${row.name} با موفقیت حذف شد :)`,
                type: 'success',
                showConfirmButton: false,
                timer: 1000,
              })

            }).catch(error => console.log(error));
        }
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
    handleDeleteMultiple() {

      this.$swal.fire({
        title: `برای پاک کردن برندهای انتخاب شده مطمئن هستید ؟`,
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

          var ids = [];

          this.attr('selected_items').forEach( item => {

            ids = [...ids, this.data()[item].id]
          })

          axios.delete(`/api/v1/${this.type}/${ids.join(',')}`)
            .then(response => {
              this.attr('selected_items').forEach(item => {
                this.$store.state[this.group][this.type].splice(item, 1)
              });

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
