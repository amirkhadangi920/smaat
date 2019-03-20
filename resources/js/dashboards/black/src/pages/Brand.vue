<template>
  <div class="row">
    <div class="col-12">

      <h1 class="text-right">
        مدیریت برند
        <h6 class="text-muted">با استفاده از جدول زیر ، امکان مدیریت کامل برند های وبسایت برای شما ممکن خواهد شد</h6>
      </h1>

      <transition name="fade">
        <el-table
          v-show="has_loaded"
          dir="rtl"
          :data="tableData"
          height="500"
          :stripe="true"
          empty-text="متاسفانه هیچ داده ای یافت نشد :("
          style="width: 100%">
          
          <el-table-column type="selection" width="55"></el-table-column>
          
          <el-table-column type="index" width="50" prop="id"></el-table-column>

          <el-table-column label="لوگو" prop="logo">
            <template slot-scope="scope">
              <img :src="scope.row.logo ? scope.row.logo.tiny : null" />
            </template>
          </el-table-column>
          
          <el-table-column label="نام" prop="name">
          </el-table-column>
          
          <el-table-column label="توضیحات" prop="description">
          </el-table-column>

          <el-table-column label="دسته بندی ها" prop="categories">
            <template slot-scope="props">
              <ul>
                <li v-for="item in props.row.categories" :key="item.id">
                  <a href="" :title="item.description">{{ item.title }}</a>
                </li>
              </ul>
            </template>
          </el-table-column>

          <el-table-column align="left">
            <template slot="header" slot-scope="scope">
              <el-input v-model="search" size="mini" placeholder="جتسجو کنید ..." />
            </template>
            <template slot-scope="scope">
              <base-button @click="show_edit = true" type="success" size="sm" icon>
                <i class="tim-icons icon-pencil"></i>
              </base-button>

              <base-button @click="handleDelete(scope.$index, scope.row)" type="danger" size="sm" icon>
                <i class="tim-icons icon-simple-remove"></i>
              </base-button>
            </template>
          </el-table-column>
        </el-table>
      </transition>


      <modal :show.sync="show_edit" class="text-right" dir="rtl">
        <template slot="header">
            <h2 class="modal-title" id="exampleModalLabel">ویرایش برند</h2>
        </template>
        <div>
          <form @submit.prevent>
            <base-input label="عنوان برند" type="text" placeholder="نام برند را وارد کنید ..."></base-input>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">برای مثال : سامسونگ</small>
            
            <base-input label="توضیحات برند" placeholder="توضیحات برند را وارد کنید ...">
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </base-input>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">برای مثال : گوشی های هوشمند پرچمدار سامسونگ</small>

            <br/>

            <base-input label="دسته بندی های برند">
              <el-tree
                dir="ltr"
                :data="data3"
                :props="defaultProps"
                show-checkbox
                @check-change="handleCheckChange">
              </el-tree>
            </base-input>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">برای انتخاب هر دسته بندی تیک قبل آن رو انتخاب کنید</small>

            <br/>
            <base-input label="لوگوی برند" placeholder="توضیحات برند را وارد کنید ...">
              <el-upload
                class="avatar-uploader"
                action="https://jsonplaceholder.typicode.com/posts/"
                :show-file-list="false"
                :on-success="handleAvatarSuccess"
                :before-upload="beforeAvatarUpload">
                <img v-if="imageUrl" :src="imageUrl" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
              </el-upload>
            </base-input>

          </form>
        </div>
        <template slot="footer">
            <base-button type="secondary" @click="show_edit = false">Close</base-button>
            <base-button type="primary">Save changes</base-button>
        </template>
      </modal>
    </div>
  </div>
</template>

<script>
  import {Modal} from '../components'

  export default {
    components: {
      Modal
    },
    data() {
      return {
        tableData: [],
        has_loaded: false,
        show_edit: false,
        dialog: false,
        search: '',
        imageUrl: '',

        data3: [],
        defaultProps: {
            children: 'childs',
            label: 'title',
        },
      }
    },
    created() {
      document.body.classList.toggle('white-content');
      
      axios.get('/api/v1/brand').then((response) => {
        this.tableData = response.data.data;
      }).then( () => {
        this.has_loaded = true;
      })


      axios.get('/api/v1/category').then((response) => {
        console.log( response.data.data );
        this.data3 = response.data.data;
      }).then( () => {
        this.has_loaded = true;
      })
    },
    methods: {
      handleEdit(index, row) {
        console.log(index, row);
      },
      handleDelete(index, row) {
        this.$swal.fire({
          title: `برای پاک کردن برند ${row.name} مطمین هستید ؟`,
          text: "در صورت پاک کردن امکان بازگشت اطلاعات نیست !",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
          confirmButtonColor: '#0098f0',
          cancelButtonColor: '#d33',
          confirmButtonText: 'بله ، مطمینم !',
          cancelButtonText: 'نه ، اشتباه شده'
        }).then((result) => {
          if (result.value) {
            
            axios({
              method: 'delete',
              headers: {
                'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg0Y2M0NjAxODk5N2FiN2U1ZTZhNzY3OGM2ZGNmNGZmOWZiNmM4NWVlMzM1NDFkMDliMGFmY2M0ZTA5NDI2Yjk1YzY2MjU2OTA3YWYwYjIwIn0.eyJhdWQiOiIxIiwianRpIjoiODRjYzQ2MDE4OTk3YWI3ZTVlNmE3Njc4YzZkY2Y0ZmY5ZmI2Yzg1ZWUzMzU0MWQwOWIwYWZjYzRlMDk0MjZiOTVjNjYyNTY5MDdhZjBiMjAiLCJpYXQiOjE1NTMwMjY3MDksIm5iZiI6MTU1MzAyNjcwOSwiZXhwIjoxNTg0NjQ5MTA5LCJzdWIiOiI1YTRmZmY5OTVmMDAiLCJzY29wZXMiOltdfQ.XhsYW4HGlcdwn5kOpG5N5yJ_EsrEfh8_G-Qb4eyjB4651_wabJuBVz8ujN0H3WaA6Mr7pM4hABjB0983FInKUPd_KSg0jebfr4su9xUZKgzZK00hB7huby4mp2CvBHtVepmrrXuApDHt5Z0eRtVMFYGknu2YPKlFIz4ljCP_G3O7H_eAGyA3WsUoJGJnj4npUP8z5d0qs0U5LbFMUXu2MfdbZiiQyLdgCTp-17wahja-TVmO5GNjqLCNgfOZHlEOU32o_gcy-XZIPqmqLr4USuOh7TDqBZ5lMTNF6EGFMGsz8eRsLPR6kNjTTKb0F4faer9rF-cGEtNwubmJyQUGxC7OsJSu28ncT3LoZOlejf6f5jBQfKKVWSmAyddqroVdWFgOtZb0i5dTyuHR75ZeU2PRSWozI7eULF6t-1Ew3_RW5sJt2vr7ZPwzEaRuI00u1s0RhDuibwktDxacJjyNNpijJz8oTtpVUKnO1gk7-TLC_KNUKs8VySTvMhaekL19tKuNJiQV23C7P3bgUN4mbvyPSihRh6F-IbMXies5x-PRueO1B_lf9i_43KcLgFFveJXF46TzFUFOJx2dJHKohDyZ0fTr5KV-YKK5sOPKUPH1lvIzqBN9DJZXwQf7vWzZ41pWbuFslikeynXOB8YQcb1DgnC_AKTLWEI1h-GCsys'
              },
              url: row.link
            }).then( response => {
              
              this.tableData.splice(index, 1);
      
              this.$swal.fire({
                title: 'حذف شد',
                text: `برند ${row.name} با موفقیت حذف شد :)`,
                type: 'success',
                confirmButtonText: 'بسیار خب :)'
              })

            }).catch( error => console.log(error) );
          }
        })
      }
    },
  }

</script>

<style>
  
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }

  img {
    max-height: 50px;
  }

  .modal.show .modal-dialog {
    -webkit-transform: translate(0, 0%) !important;
    transform: translate(0, 0%) !important;
  }

  .modal-content .modal-header button {
    left: 10px !important;
  }

  .el-table th {
    text-align: center !important;
  }
  .el-table td {
    text-align: center !important;
  }
  
  button.swal2-confirm {
    background: linear-gradient(to bottom left, #00f2c3, #0098f0) !important;
  }

  button.swal2-cancel {
    background: linear-gradient(to bottom left, #fd5d93, #ec250d) !important;
  }

  /* Upload image */
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>
