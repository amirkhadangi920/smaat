<template>
  <div :style="{ position: 'relative', zIndex: 100 }">
    <div class="row">
      <div class="col-12">
        <div class="text-right pull-right">
          <h1 class="animated bounceInRight delay-first">
            ثبت تخفیف جدید
            <i class="tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
          </h1>
          <h6 class="text-muted animated bounceInRight delay-secound">از طریق فرم زیر میتوانید به صورت کامل اطلاعات تخفیف جدید خود را به ثبت برسانید</h6>
        </div>

        <div class="animated bounceInLeft delay-secound">
          <base-button @click.once="$router.push('/panel/discount')" size="sm" type="warning" class="pull-left">
            <i class="tim-icons icon-double-left"></i>
            بازگشت
          </base-button>
        </div>
      </div>
    </div>

    <card class="animated bounceInUp delay-last text-right mt-3" dir="rtl">        
      <div class="row">
        <div class="col-12">
          <md-field :class="getValidationClass('title')">
            <label>عنوان تخفیف</label>
            <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-tag"></i>
            <span class="md-helper-text">برای مثال : جشنواره تخفیف بهاری</span>
            <span class="md-error" v-show="!$v.title.required">لطفا عنوان تخفیف را وارد کنید</span>
          </md-field>
          <br/>

          <md-field :class="getValidationClass('description')">
            <label>توضیح</label>
            <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
            <i class="md-icon tim-icons icon-align-center"></i>
            <span class="md-helper-text">توضیحی مختصر درباره این تخفیف</span>
          </md-field>
          <br/>
        </div>

        <div class="col-5">
          <base-input label="لوگو" class="mt-2">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="addImage">
              <div v-if="$store.state[group].form[type].logo.url">
                <img :src="$store.state[group].form[type].logo.url" class="avatar" />
                <i @click.prevent="deleteImage" class="el-icon-delete avatar-uploader-icon"></i>
              </div>
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">لوگوی مورد نظر خود را انتخاب کنید</small>
          </base-input>
        </div>

        <div class="col-7">
          <base-input label="دسته بندی های تخفیف">
            <el-tree
              dir="ltr"
              :data="$store.state.group.category"
              :props="defaultProps"
              :accordion="true"
              ref="categories"
              show-checkbox
              node-key="id"
              @check-change="changeSelectedCategories"
              :default-checked-keys="selected('categories')"
              :default-expanded-keys="selected('categories')"
              empty-text="هیچ دسته بندی ای یافت نشد :("
            >
            </el-tree>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">برای انتخاب هر دسته بندی تیک قبل آن را انتخاب کنید</small>
          </base-input>
        </div>
        <br/>

        <div class="col-6">
          <date-picker v-model="started_at" :min="now" type="datetime" element="input_started_at" format="YYYY-MM-DD HH:mm:ss"></date-picker>

          <md-field :class="getValidationClass('started_at')">
            <label>تاریخ شروع</label>
            <md-input id="input_started_at" v-model="started_at" />
            <i class="md-icon tim-icons icon-watch-time"></i>
            <span class="md-helper-text">تخفیف محصولات بعد از این تاریخ معتبر میباشد</span>
            <span class="md-error" v-show="!$v.started_at.required">لطفا تاریخ شروع تخفیف را وارد کنید</span>
          </md-field>
        </div>

        <div class="col-6">
          <date-picker v-model="expired_at" :min="started_at || now" type="datetime" element="input_expired_at" format="YYYY-MM-DD HH:mm:ss"></date-picker>

          <md-field :class="getValidationClass('expired_at')">
            <label>تاریخ پایان</label>
            <md-input id="input_expired_at" v-model="expired_at" />
            <i class="md-icon tim-icons icon-button-pause"></i>
            <span class="md-helper-text">تخفیف محصولات تا قبل از این تاریخ معتبر میباشد</span>
            <span class="md-error" v-show="!$v.expired_at.required">لطفا تاریخ پایان تخفیف را وارد کنید</span>
          </md-field>
        </div>
      </div>
        
      <base-button
        class="pull-left"
        simple
        size="sm" 
        :type="attr('is_creating') ? 'danger' : 'warning'"
        @click.once="attr('is_creating') ? store() : update()">
        {{ attr('is_creating') ? 'ذخیره' : 'بروز رسانی' }} تخفیف
      </base-button>
    </card>
    

    <div class="col-12">
      <div class="text-right pull-right">
        <h2 class="animated bounceInRight delay-first mb-0">
          مدیریت محصولات
          <i class="tim-icons icon-bullet-list-67" :style="{fontSize: '20px'}"></i>
        </h2>
        <h6 class="text-muted animated bounceInRight delay-secound">در این قسمت میتوانید محصولاتی که شامل تخفیف میباشند را مشخص کنید</h6>
      </div>

      <div class="animated bounceInLeft delay-secound operation-cell">
        <el-tooltip content="افزودن تنوع">
          <base-button @click="is_open = true" type="default" size="sm" simple icon>
            <i class="tim-icons icon-simple-add"></i>
          </base-button>
        </el-tooltip>
      </div>
    </div>

    <div class="col-12" dir="rtl">
      <ul class="data-table-header p-2 d-flex justify-content-center">
        <li 
          class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted"
          :style="{width: '40px'}"
        >#</li>
        <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
          محصول
        </li>
        <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
          ویژگی ها
        </li>
        <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
          موجودی
        </li>
        <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
          تخفیف
        </li>
        <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
          تعداد
        </li>
        <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-spin">
          <i class="tim-icons icon-settings hvr-icon"></i>
          عملیات ها
        </li>
      </ul>
      <transition-group
        enter-active-class="animated zoomIn"
        leave-active-class="animated zoomOut" 
        tag="ul"
      >
        <li
          v-for="(row, index) in selected('items')"
          :key="row.id"
          class="data-table-row"
        >
          <ul class="p-2 d-flex justify-content-center">
            <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
              {{ index + 1 }}
            </li>
            <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
              <img class="tilt" :src="row.photos ? row.photos.tiny : '/images/placeholder.png'" />
              {{ row.name }}
            </li>
            <li class="data-table-cell p-2 text-center" >
              <div>
                <span class="badge badge-info feature-data" :style="{ background: row.color.code }" v-if="row.color">
                  <i class="tim-icons icon-bank"></i>
                  رنگ {{ row.color.name }}
                </span>
              </div>
              <div>
                <span class="badge badge-info feature-data" v-if="row.size">
                  <i class="tim-icons icon-bank"></i>
                  سایز {{ row.size.name }}
                </span>
              </div>
              <div>
                <span class="badge badge-warning feature-data" v-if="row.warranty">
                  <i class="tim-icons icon-bank"></i>
                  گارانتی {{ row.warranty.title }}
                </span>
              </div>
            </li>
            <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
              <span v-if="row.inventory">
                {{ row.inventory }} {{ row.unit }}
              </span>
            </li>
            <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
              {{ row.offer }} %
            </li>
            <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
              <span v-if="row.quantity">
                {{ row.quantity }} {{ row.unit }}
              </span>
            </li>
            <li class="data-table-cell operation-cell p-2 d-flex align-items-center justify-content-center">
              <el-tooltip :content="'ویرایش'">
                <base-button @click="edit(index, row)" type="success" size="sm" simple round icon>
                  <i class="tim-icons icon-pencil"></i>
                </base-button>
              </el-tooltip>

              <el-tooltip content="حذف">
                <base-button @click="remove(index, row)" type="danger" size="sm" simple round icon>
                  <i class="tim-icons icon-simple-remove"></i>
                </base-button>
              </el-tooltip>
            </li>
          </ul>
        </li>
      </transition-group>
    </div>

    <md-dialog :md-active.sync="is_open" class="text-right" dir="rtl">
      <md-dialog-title>
        <h2 class="modal-title">
          {{ is_creating ? 'افزودن ' : 'ویرایش ' }}
        </h2>
        <p>از طریق فرم زیر میتوانید {{ is_creating ? 'جدید ثبت کنید' : 'مورد نظر خود را ویرایش کنید' }}</p>
      </md-dialog-title>

      <div class="md-dialog-content">
        <div class="p-2">
          <form @submit.prevent>
            <div class="row">
              <base-input class="col-12" label="محصول" v-if="is_creating">
                
                <el-select
                  class="col-12"
                  v-model="value"
                  filterable
                  remote
                  reserve-keyword
                  placeholder="بخشی از نام محصول را وارد کنید ...."
                  :remote-method="remoteMethod"
                  :loading="loading"
                  @change="getProductVariations"
                >
                  <el-option
                    v-for="item in options"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                    <span class="pull-right d-inline-block" :style="{ width: '40px' }">
                      <img class="tilt" :src="item.photos ? item.photos[0] ? item.photos[0].tiny : '/images/placeholder.png' : '/images/placeholder.png'" />
                    </span>
                    <span class="pull-right">{{ item.name }}</span>
                  </el-option>
                </el-select>

                <small slot="helperText" id="emailHelp" class="form-text text-muted">نام محصول خود را در فیلد بالا جستجو کرده و انتخاب کنید</small>
              </base-input>

              <base-input label="انتخاب تنوع" v-if="is_creating">
                
                <div class="row">
                  <transition-group>
                    <div class="col-3" v-for="item in variations" :key="item.id" @click="form.variation = item.id">
                      <div class="text-center" >
                        <div>
                          <span class="badge badge-info feature-data" :style="{ background: 'pink' }">
                            <i class="tim-icons icon-bank"></i>
                            {{ item.price }} تومان
                          </span>
                          <span class="badge badge-info feature-data" :style="{ background: 'pink' }">
                            <i class="tim-icons icon-bank"></i>
                            {{ item.inventory }} عدد
                          </span>
                        </div>

                        <div>
                          <span class="badge badge-info feature-data" :style="{ background: item.color.code }" v-if="item.color">
                            <i class="tim-icons icon-bank"></i>
                            رنگ {{ item.color.name }}
                          </span>
                        </div>
                        <div>
                          <span class="badge badge-info feature-data" v-if="item.size">
                            <i class="tim-icons icon-bank"></i>
                            سایز {{ item.size.name }}
                          </span>
                        </div>
                        <div>
                          <span class="badge badge-warning feature-data" v-if="item.warranty">
                            <i class="tim-icons icon-bank"></i>
                            گارانتی {{ item.warranty.title }}
                          </span>
                        </div>
                      </div>
                    </div>
                  </transition-group>
                </div>

                <small slot="helperText" id="emailHelp" class="form-text text-muted">تنوع مورد نظر خود جهت اعمال تخفیف را از لیست بالا انتخاب کنید</small>
              </base-input>

              <div class="row col-12 mb-3">
                <div class="col-6">
                  <md-field :class="getValidationClass('offer')">
                    <label>تخفیف</label>
                    <md-input v-model="form.offer" />
                    <i class="md-icon tim-icons icon-watch-time"></i>
                    <span class="md-helper-text">مبلغ محصول پس از اعمال تخفیف</span>
                    <span class="md-error" v-show="!$v.offer.required">لطفا میزان تخفیف را وارد کنید</span>
                  </md-field>
                </div>

                <div class="col-6">
                  <md-field :class="getValidationClass('quantity')">
                    <label>تعداد</label>
                    <md-input v-model="form.quantity" />
                    <i class="md-icon tim-icons icon-button-pause"></i>
                    <span class="md-helper-text">تعداد محصول مورد نظر جهت فروش در تنوع</span>
                    <span class="md-error" v-show="!$v.quantity.required">لطفا تعداد موجودی را وارد کنید</span>
                  </md-field>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <md-dialog-actions>
        <base-button
          class="ml-2"
          type="secondary"
          simple
          size="sm"
          @click="is_open = false">
          لغو
        </base-button>
        
        <base-button
          simple
          size="sm" 
          :type="is_creating ? 'danger' : 'warning'"
          @click="add">
          {{ is_creating ? 'افزودن به تخفیف' : 'بروز رسانی اطلاعات' }}
        </base-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
</template>

<script>
import Binding, { bind } from '../../mixins/binding'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import { validationMixin } from 'vuelidate'
import vuexHelper from '../../mixins/vuexHelper'
import { required, maxLength } from 'vuelidate/lib/validators'
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import moment from 'moment-jalaali'
import createMixin from '../../mixins/createMixin';

export default {
  components: {
    datePicker: VuePersianDatetimePicker
  },
  mixins: [
    createMixin,
    Binding,
    validationMixin,
    vuexHelper
  ],
  data() {
    return {
      type: 'discount',
      group: 'shop',

      options: [],
      variations: [],
      value: '',

      loading: false,
      is_open: false,
      is_creating: false,

      form: {
        variation: null,
        offer: null,
        quantity: null,
      },
      
      defaultProps: {
        children: 'childs',
        label: 'title',
      },
    }
  },
  validations: {
    title: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(255)
    },
    started_at: {
      required
    },
    expired_at: {
      required
    },
    
    offer: { required },
    quantity: { required },
  },
  computed: {
    title: bind('title'),
    description: bind('description'),
    started_at: bind('started_at'),
    expired_at: bind('expired_at'),

    now() {
      return moment().format('jYYYY-jMM-jDD HH:mm:ss')
    }
  },
  mounted() {
    this.$store.dispatch('getData', {
      group: 'group',
      type: 'category',
    })

    if ( this.$route.params.id )
    {
      axios({
        method: 'GET',
        url: `/api/v1/discount/${this.$route.params.id}`,
      }).then(({data}) => {
        this.setAttr('is_creating', false)

        this.setAttr('selected', {
          id: this.$route.params.id,
          link: `/api/v1/discount/${this.$route.params.id}`,
          title: data.data.title,
          description: data.data.description,
          started_at: moment( data.data.started_at ).format('jYYYY-jMM-jDD HH:mm:ss'),
          expired_at: moment( data.data.expired_at ).format('jYYYY-jMM-jDD HH:mm:ss'),
          categories: data.data.categories.map(c => c.id),
          imageFile: null,
          imageUrl: data.data.logo ? data.data.logo.small : '',
          items: data.data.items
        })
      }).catch( error => console.log(error.response) )
    }
  },
  methods: {
    remoteMethod(query) {

      if (query !== '' && query.length >= 3) {
        
        this.loading = true;

        axios({
          method: 'GET',
          url: '/api/v1/product',
          params: {
            query: query
          }
        }).then(({data}) => {
          this.loading = false;
          this.options = data.data
        })
      } else {
        this.options = [];
      }
    },
    addImage(file) {
      this.setAttr('selected', {
        imageFile: file.raw,
        imageUrl: URL.createObjectURL(file.raw)
      })
    },
    getProductVariations(id) {
      axios({
          method: 'GET',
          url: `/api/v1/product/${id}`,
        }).then(({data}) => {
          this.variations = data.data.variations
        })
    },
    add() {
      axios({
        method: 'POST',
        url: `/api/v1/discount/${this.selected('id')}/add/${this.form.variation}`,
        params: {
          offer: this.form.offer * 1,
          quantity: this.form.quantity * 1
        }
      }).then(({data}) => {
        this.is_open = false

        this.$swal.fire({
          title: this.is_creating ? 'اضافه شد' : 'بروزرسانی شد',
          text: `تنوع با موفقیت به تخفیف ${this.selected('name')} اضافه شد :)`,
          type: 'success',
          showConfirmButton: false,
          timer: 1000,
        })
      }).catch(error => console.log(error));
    },
    edit(index, row) {
      console.log( row )
      this.form.variation = row.id
      this.form.offer = row.offer
      this.form.quantity = row.quantity

      this.is_open = true
      this.is_creating = false
    },
    getData() {
      let data = new FormData();

      ['title', 'description', 'started_at', 'expired_at'].forEach(field => {
        let value = this.selected( field )

        data.append(field, value ? value : '')
      });

      this.$refs.categories.getCheckedKeys().forEach(category => {
        data.append('categories[]', category);
      });

      if ( this.selected('imageFile') )
        data.append('logo', this.selected('imageFile'))

      return data
    },
    changeSelectedCategories() {
      this.setAttr('selected', {
        categories: this.$refs.categories.getCheckedKeys(),
      })
    },
    remove(index, row) {
      this.$swal.fire({
        title: `برای حذف محصول ${row.name} از تخفیف ${this.selected('title')} مطمئن هستید ؟`,
        text: "در صورت حذف کردن امکان بازگشت اطلاعات نیست !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
        confirmButtonColor: '#0098f0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله ، مطمئنم !',
        cancelButtonText: 'نه ، اشتباه شده'
      }).then((result) => {
        if (result.value) {

          axios({
            method: 'delete',
            url: row.link
          }).then(response => {
            this.selected('items').splice(index, 1)
            
            this.$swal.fire({
              title: 'حذف شد',
              text: `محصول ${row.name} با موفقیت حذف شد :)`,
              type: 'success',
              showConfirmButton: false,
              timer: 1000,
            })

          }).catch(error => console.log(error));
        }
      })
    },
  },
}
</script>

<style scope>
img {
  width: auto !important;
  height: auto !important;
  margin: auto !important;
}
.md-tab {
  text-align: right;
  direction: rtl;
}
.md-button:not([disabled]).md-focused:before, .md-button:not([disabled]):active:before, .md-button:not([disabled]):hover:before {
  opacity: 0;
}
.md-button {
  outline: none !important;
}
.md-tabs-indicator {
  background: rgb(110, 3, 124) !important;
}
.md-tabs-navigation {
  justify-content: center !important;
}

.upload-photo-gallery img {
  max-height: 100%;
}
.upload-photo-gallery .el-upload.el-upload--picture-card {
  width: 148px;
  margin: 0px 10px;
}

.disadvantages .md-chip {
  background: #ff4c4c;
}
.advantages .md-chip {
  background: #00f2c3;
}
</style>
