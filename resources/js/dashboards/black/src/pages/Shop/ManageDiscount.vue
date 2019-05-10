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
          <base-button @click="$router.push('/panel/discount')" size="sm" type="warning" class="pull-left">
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
              <img v-if="$store.state[group].selected[type].imageUrl" :src="$store.state[group].selected[type].imageUrl" class="avatar">
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
        @click="attr('is_creating') ? store() : update()">
        {{ attr('is_creating') ? 'ذخیره' : 'بروز رسانی' }} تخفیف
      </base-button>
    </card>
    

    <card class="animated bounceInUp delay-last text-right mt-3" dir="rtl">

      <div class="row">
        <el-select v-model="value" placeholder="Select">
          <el-option
            v-for="item in cities"
            :key="item.value"
            :label="item.label"
            :value="item.value">
            <span style="float: left">{{ item.label }}</span>
            <span style="float: right; color: #8492a6; font-size: 13px">{{ item.value }}</span>
          </el-option>
        </el-select>
      </div>
    </card>
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

      cities: [{
        value: 'Beijing',
        label: 'Beijing'
      }, {
        value: 'Shanghai',
        label: 'Shanghai'
      }, {
        value: 'Nanjing',
        label: 'Nanjing'
      }, {
        value: 'Chengdu',
        label: 'Chengdu'
      }, {
        value: 'Shenzhen',
        label: 'Shenzhen'
      }, {
        value: 'Guangzhou',
        label: 'Guangzhou'
      }],
      value: '',
      
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
    }
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
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('JWT')}`
        },
        url: `/api/v1/discount/${this.$route.params.id}`,
      }).then(({data}) => {
        this.setAttr('is_creating', false)

        this.setAttr('selected', {
          link: `/api/v1/discount/${this.$route.params.id}`, 
          title: data.data.title,
          description: data.data.description,
          started_at: moment( data.data.started_at ).format('jYYYY-jMM-jDD HH:mm:ss'),
          expired_at: moment( data.data.expired_at ).format('jYYYY-jMM-jDD HH:mm:ss'),
          categories: data.data.categories.map(c => c.id),
          imageFile: null,
          imageUrl: data.data.logo ? data.data.logo.small : ''
        })
      }).catch( error => console.log(error.response) )
    }
  },
  methods: {
    addImage(file) {
      this.setAttr('selected', {
        imageFile: file.raw,
        imageUrl: URL.createObjectURL(file.raw)
      })
    },
    store() {
      //
    },
    update() {
      this.storeInServer({
        data: this.getData(),
        type: this.type,
        label: this.label,
        url: this.selected('link'), 
        callback: response => {
          return console.log( response )
          let index = this.selected('index');
          this.data()[index] = response;

          this.setData( this.data() )

          this.setAttr('is_open', false)
        }
      })
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
.md-content.md-tabs-content {
  margin-top: 30px;
  text-align: right;
  background: rgb(255, 255, 255);
  box-shadow: rgb(253, 93, 147) 0px 0px 90px -35px;
  border-radius: 5px;
  transition: height 300ms ease 0s;
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
