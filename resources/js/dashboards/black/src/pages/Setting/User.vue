<template>
  <div class="row" :style="{ position: 'relative', zIndex: 10 }">
    <div class="row col-12 mb-3">
      <div class="col-12 text-right">
        <div class="pull-right">
          <h1 class="animated bounceInRight delay-first" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
            تنظیمات <span :style="{ color: '#ff3d3d' }">حساب</span> کاربری
            <i class="header-nav-icon tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
          </h1>
          <h6 class="header-description animated bounceInRight delay-secound">با استفاده از این بخش میتوانید اطلاعات حساب خود را مدیریت کرده یا رمز عبور خود را تغییر دهید</h6>
        </div>
        <div class="pull-left animated bounceInDown delay-last">
          <flip-clock :options="{
            label: false,
            clockFace: 'TwentyFourHourClock'
          }" />
        </div>
      </div>
    </div>

    <card class="text-right animated bounceInBottom delay-last" v-if="is_loaded" dir="rtl">
      <span slot="header">
        ویرایش اطلاعات کاربری
      </span>

      <div class="row">
        <div class="col-md-4">
          <base-input label="عکس آواتار">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="addImage">
              <div v-if="$store.state[group].form[type].avatar.url">
                <img
                  :src="$store.state[group].form[type].avatar.url"
                  class="avatar"
                  :style="{ borderRadius: '0px', width: '100% !important' }"
                />
                <i @click.prevent="deleteImage" class="el-icon-delete avatar-uploader-icon"></i>
              </div>
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">عکس پروفایل حساب شما</small>
          </base-input>
        </div>

        <div class="col-md-8">
          <div class="row">
            <div class="col-md-4">
              <md-field :class="getValidationClass('first_name')">
                <label>نام</label>
                <md-input v-model="info.first_name" :maxlength="$v.first_name.$params.maxLength.max" />
                <i class="md-icon tim-icons icon-badge"></i>
                <span class="md-helper-text">برای مثال : علی رضا</span>
              </md-field>
            </div>

            <div class="col-md-4">
              <md-field :class="getValidationClass('last_name')">
                <label>نام خانوادگی</label>
                <md-input v-model="info.last_name" :maxlength="$v.last_name.$params.maxLength.max" />
                <i class="md-icon tim-icons icon-badge"></i>
                <span class="md-helper-text">برای مثال : حسین زاده</span>
              </md-field>
            </div>
            
            <div class="col-md-4">
              <md-field :class="getValidationClass('national_code')">
                <label>کد ملی</label>
                <md-input v-model="info.national_code" :maxlength="$v.national_code.$params.maxLength.max" />
                <i class="md-icon tim-icons icon-single-02"></i>
                <span class="md-helper-text">برای مثال : ۰۹۲۱۲۳۴۵۶۷</span>
              </md-field>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7">
              <md-field :class="getValidationClass('email')">
                <label>آدرس ایمیل</label>
                <md-input v-model="info.email" :maxlength="$v.email.$params.maxLength.max" />
                <i class="md-icon tim-icons icon-email-85"></i>
                <span class="md-helper-text">برای مثال : info@example.com</span>
              </md-field>
            </div>

            <div class="col-md-5">
              <md-field :class="getValidationClass('gender')">
                <label>جنسیت</label>
                <md-select v-model="info.gender" >
                  <md-option value="false">مونث</md-option>
                  <md-option value="true">مذکر</md-option>
                  <md-option value="null">نا مشخص</md-option>
                </md-select>
                <i class="md-icon tim-icons icon-satisfied"></i>
                <span class="md-helper-text">جنسیت خود را مشخص کنید</span>
              </md-field>
            </div>
          </div>

          <div class="row d-flex justify-content-center mt-3">
            <base-button
              @click="updateInfo"
              :loading="is_update_info_loading"
              size="sm"
              type="warning"
            >
              <transition name="fade" mode="out-in">
                <semipolar-spinner
                  :animation-duration="2000"
                  :size="17"
                  color="#fff"
                  v-if="is_update_info_loading"
                />
                <span v-else class="pull-right ml-2" >
                  <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
                  <i v-else class="tim-icons icon-pencil"></i>
                </span>
              </transition>
              بروز رسانی اطلاعات کلی
            </base-button>
          </div>
        </div>
      </div>
    </card>

    <card class="text-right animated bounceInBottom delay-last" v-if="is_loaded" dir="rtl">
      <span slot="header">
        بروزرسانی رمز عبور
      </span>

      <div class="row">
        <div class="col-md-4">
          <md-field>
            <label>رمز عبور کنونی</label>
            <md-input type="password" v-model="password.current" :maxlength="100" />
            <!-- <i class="md-icon tim-icons icon-paper"></i> -->
            <span class="md-helper-text">رمز عبور فعلی خود را وارد کنید</span>
          </md-field>
        </div>

        <div class="col-md-4">
          <md-field>
            <label>رمز عبور جدید</label>
            <md-input type="password" v-model="password.main" :maxlength="100" />
            <!-- <i class="md-icon tim-icons icon-paper"></i> -->
            <span class="md-helper-text">رمز عبور جدید را وارد کنید</span>
          </md-field>
        </div>

        <div class="col-md-4">
          <md-field :class="getValidationClass('first_name')">
            <label>تکرار رمز عبور جدید</label>
            <md-input type="password" v-model="password.confirm" :maxlength="100" />
            <!-- <i class="md-icon tim-icons icon-paper"></i> -->
            <span class="md-helper-text">تکرار رمز عبور جدید را وارد کنید</span>
          </md-field>
        </div>
      </div>

      <base-button
        @click="updatePassword"
        size="sm"
        :loading="is_update_password_loading"
        type="warning"
      >
        <transition name="fade" mode="out-in">
          <semipolar-spinner
            :animation-duration="2000"
            :size="17"
            color="#fff"
            v-if="is_update_password_loading"
          />
          <span v-else class="pull-right ml-2" >
            <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
            <i v-else class="tim-icons icon-pencil"></i>
          </span>
        </transition>
        تغییر رمز عبور
      </base-button>
    </card>

    <transition name="fade">
      <div class="main-panel-loading" v-if="!is_loaded">
        <fingerprint-spinner
          :animation-duration="1000"
          :size="100"
          color="#fff"
        />
      </div>
    </transition>
  </div>
</template>
<script>
import { FlipClock } from '@mvpleung/flipclock';
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
import binding, { bind } from '../../mixins/binding';
import createMixin from '../../mixins/createMixin'
import {SemipolarSpinner, FingerprintSpinner} from 'epic-spinners'

export default {
  components: {
    FlipClock,
    SemipolarSpinner,
    FingerprintSpinner
  },
  mixins: [
    validationMixin,
    binding,
    createMixin
  ],
  metaInfo: {
    title: 'اطلاعات کاربری',
  },
  validations: {
    first_name: {
      maxLength: maxLength(20)
    },
    last_name: {
      maxLength: maxLength(30)
    },
    email: {
      maxLength: maxLength(100)
    },
    national_code: {
      maxLength: maxLength(10)
    },
  },
  data() {
    return {
      type: 'user',
      group: 'user',
      label: 'اطلاعات کاربری',

      info: {
        first_name: '',
        last_name: '',
        email: '',
        national_code: '',
        gender: null,
        avatar: {
          file: null,
          url: ''
        }
      },
      password: {
        current: '',
        main: '',
        confirm: ''
      },

      is_loaded: false,
      is_query_loading: false,
      is_update_info_loading: false,
      is_update_password_loading: false,
    }
  },
  mounted()
  {
    axios.get('/graphql/auth', {
      params: {
        query: `{
          me { ${this.allQuery} }
        }`
      }
    })
    .then(({data}) => {
      this.info = data.data.me

      if ( this.info.avatar )
        this.$store.state.user.form.user.avatar.url = this.info.avatar.small

      this.is_loaded = true
    })
  },
  methods:
  {
    validate()
    {
      return true
    },
    updateInfo()
    {
      this.is_update_info_loading = true

      this.setAttr('selected', { id: this.$store.state.me.id })

      this.storeInServer({
        callback: ({data}) => {
          this.$store.commit('setMeInfo', data)
          this.is_update_info_loading = false
        }
      })
    },
    updatePassword()
    {
      this.is_update_password_loading = true

      axios.post('/graphql/auth', {
        query: `mutation {
          updateUserPassword (
            current_password: "${this.password.current}",
            password: "${this.password.main}",
            password_confirmation: "${this.password.confirm}"
          ) {
            status
            message
          }
        }`
      })
      .then(({data}) =>
      {
        this.is_update_password_loading = false

        if ( data.data.updateUserPassword.status === 400 )
        {
          return this.$swal.fire({
            title: 'تغییری نکرد',
            text: data.data.updateUserPassword.message,
            type: 'error',
            timer: 2000,
          })
        }

        this.$swal.fire({
          title: 'تغییر کرد',
          text: 'رمز عبور با موفقیت تغییر کرد ، لطفا دوباره وارد حساب خود شوید',
          type: 'success',
          timer: 2000,
        })

        setTimeout(() => {
          localStorage.removeItem('JWT');
          window.location.replace('/login')
        }, 2000);
      })
      .catch(error => {
        this.is_update_password_loading = false
        this.errorResolver(error)
      })
    },
    getVariables()
    {
      return {
        first_name: this.info.first_name,
        last_name: this.info.last_name,
        email: this.info.email,
        national_code: this.info.national_code,
        gender: this.info.gender === 'true' ? true : this.info.gender === 'false' ? false : null,
        avatar: null
      }
    }
  },
  computed: {
    allQuery()
    {
      return `
        id
        first_name
        last_name
        full_name
        email
        national_code
        gender
        avatar {
          id file_name thumb small
        }
      `
    }
  }
}
</script>