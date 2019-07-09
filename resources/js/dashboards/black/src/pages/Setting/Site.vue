<template>
  <div class="row" :style="{ position: 'relative', zIndex: 10 }">
    <div class="row col-12 mb-3">
      <div class="col-12 text-right">
        <div class="pull-right">
          <h1 class="animated bounceInRight delay-first" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
            مدیریت <span :style="{ color: '#ff3d3d' }">تنظیمات</span> سایت
            <i class="header-nav-icon tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
          </h1>
          <h6 class="header-description animated bounceInRight delay-secound">با استفاده از بخش زیر میتوانید تنظیمات کلی وبسایت خود را مدیریت کنید</h6>
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
        اطلاعات کلی
      </span>

      <div class="row">
        <div class="col-md-4">
          <md-field :class="getValidationClass('title')">
            <label>عنوان فروشگاه</label>
            <md-input v-model="info.title" :maxlength="$v.title.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-caps-small"></i>
            <span class="md-helper-text">در تب مرورگر نمایش داده میشود</span>
          </md-field>

          <md-field :class="getValidationClass('description')">
            <label>توضیحات سایت</label>
            <md-textarea v-model="info.description" :maxlength="$v.description.$params.maxLength.max"></md-textarea>
            <i class="md-icon tim-icons icon-paper"></i>
            <span class="md-helper-text">در قسمت پاصفحه وبسایت نمایش داده میشود</span>
          </md-field>
        </div>

        <div class="col-md-4">
          <base-input label="عکس لوگو">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="file => addImage('logo', file)">
              <img
                v-if="info.logo.url"
                :src="info.logo.url"
                class="avatar"
                :style="{ borderRadius: '0px', width: '100% !important' }"
              />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">لوگوی اصلی وبسایت</small>
          </base-input>
        </div>

        <div class="col-md-4">
          <base-input label="عکس واترمارک">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="file => addImage('watermark', file)">
              <img
                v-if="info.watermark.url"
                :src="info.watermark.url"
                class="avatar"
                :style="{ borderRadius: '0px', width: '100% !important' }"
              />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">تصویر واترمارک بر روی تصاویر محصولات حک میشود</small>
          </base-input>
        </div>
      </div>
      <br/>

      <div class="row">
        <div class="col-md-4">
          <md-field :class="getValidationClass('phone')">
            <label>شماره تلفن فروشگاه</label>
            <md-input v-model="info.phone" />
            <i class="md-icon tim-icons icon-mobile"></i>
            <span class="md-helper-text">جهت نمایش در سایت</span>
          </md-field>
        </div>

        <div class="col-md-8">
          <md-field :class="getValidationClass('address')">
            <label>آدرس فروشگاه</label>
            <md-textarea v-model="info.address" md-autogrow :maxlength="$v.address.$params.maxLength.max"></md-textarea>
            <i class="md-icon tim-icons icon-map-big"></i>
            <span class="md-helper-text">در قسمت پاصفحه وبسایت نمایش داده میشود</span>
          </md-field>
        </div>
      </div>
      <br/>

      <div class="row">
        <div class="col-md-6">
          <base-input label="عکس سر تیتر">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="file => addImage('banner', file)">
              <img
                v-if="info.banner.url"
                :src="info.banner.url"
                class="avatar"
                :style="{ borderRadius: '0px', width: '100% !important' }"
              />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">عکس سرتیتر قالب در تمامی صفحات قرار میگیرد</small>
          </base-input>
        </div>
        
        <div class="col-md-6">
          <base-input label="بنر ابتدایی">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="file => addImage('header_banner', file)">
              <img
                v-if="info.header_banner.url"
                :src="info.header_banner.url"
                class="avatar"
                :style="{ borderRadius: '0px', width: '100% !important' }"
              />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">این تصویر در اولین بخش قالب قرار خواهد گرفت</small>
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3" dir="ltr">
          <base-input label="وضعیت سایت">
            <el-switch
              class="d-block mb-1"
              v-model="info.is_enabled"
              active-text="فعال"
              inactive-text="غیرفعال">
            </el-switch>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">در صورت غیر فعال کردن سایت برای کاربران قابل مشاهده نیست</small>
          </base-input>
        </div>
        
        <div class="col-md-3">
          <md-field :class="getValidationClass('theme_color')">
            <el-color-picker v-model="info.theme_color"></el-color-picker>
            <span class="md-helper-text pt-2">رنگ قالب فروشگاه انتخاب کنید</span>
          </md-field>
        </div>

        <div class="col-md-6">
          <md-field :class="getValidationClass('banner_link')">
            <label>لینک بنر بالا</label>
            <md-input v-model="info.banner_link" />
            <i class="md-icon tim-icons icon-link-72"></i>
            <span class="md-helper-text">میتوانید هریک از لینک های سایت را قرار دهید</span>
          </md-field>
        </div>
      </div>

      <base-button
        @click="updateInfo"
        size="sm"
        type="warning"
        :loading="is_update_site_info"
      >
        <transition name="fade" mode="out-in">
          <semipolar-spinner
            :animation-duration="2000"
            :size="17"
            color="#fff"
            v-if="is_update_site_info"
          />
          <span v-else class="pull-right ml-2" >
            <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
            <i v-else class="tim-icons icon-pencil"></i>
          </span>
        </transition>
        بروز رسانی تنظیمات کلی
      </base-button>
    </card>

    <div class="row">
      <div class="col-md-6">
        <card class="text-right animated bounceInBottom delay-last" v-if="is_loaded" dir="rtl">
          <span slot="header">
            مدیریت پوسترها
          </span>

          <div class="row" v-for="(slide, index) in posters" :key="index">
            <div class="col-md-12">
              <base-input label="تصویر پوستر">
                <el-upload
                  class="avatar-uploader"
                  action="/"
                  :auto-upload="false"
                  :show-file-list="false"
                  :on-change="file => addImage('poster', file, index)">
                  <img
                    v-if="slide.image.url"
                    :src="slide.image.url"
                    class="avatar"
                    :style="{ borderRadius: '0px', width: '100% !important' }"
                  />
                  <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
                <small slot="helperText" id="emailHelp" class="form-text text-muted">تصویر پس زمینه هر پوستر</small>
              </base-input>
            </div>
            <div class="col-md-12">
              <md-field>
                <label>عنوان پوستر</label>
                <md-input v-model="slide.title" />
                <i class="md-icon tim-icons icon-caps-small"></i>
                <span class="md-helper-text">عنوان پوستر مورد نظر</span>
              </md-field>

              <md-field>
                <label>عنوان دکمه</label>
                <md-input v-model="slide.button" />
                <i class="md-icon tim-icons icon-bold"></i>
                <span class="md-helper-text">عنوان دکمه پوستر مورد نظر</span>
              </md-field>            

              <md-field>
                <label>لینک دکمه</label>
                <md-textarea v-model="slide.link" md-autogrow></md-textarea>
                <i class="md-icon tim-icons icon-link-72"></i>
                <span class="md-helper-text">میتواند از لینک های خود وبسایت استفاده شود</span>
              </md-field>
              
              <md-field>
                <label>پاراگرف</label>
                <md-textarea v-model="slide.description" md-autogrow></md-textarea>
                <i class="md-icon tim-icons icon-paper"></i>
                <span class="md-helper-text">پاراگرف زیر عنوان برای پوستر مورد نظر</span>
              </md-field>
            </div>
            <hr class="w-100 pull-right m-3" v-if="index !== slider.length - 1" />
          </div>

          <div v-if="!posters.length" class="alert alert-warning">
            متاسفانه هیچ پوستری برای وبسایت ثبت نشده است :(
          </div>

          <div class="operation-cell d-flex justify-content-center mt-3">
            <el-tooltip content="افزودن پوستر جدید">
              <base-button @click="posters.push({ image: {} })" class="hvr-icon-spin ml-2" type="success" size="sm" icon>
                <i class="tim-icons icon-simple-add hvr-icon" :style="{ fontSize: '18px !important' }"></i>
              </base-button>
            </el-tooltip>          
            
            <el-tooltip content="حذف آخرین پوستر">
              <base-button @click="posters.pop()" class="hvr-icon-spin ml-2" type="danger" size="sm" icon>
                <i class="tim-icons icon-trash-simple hvr-icon" :style="{ fontSize: '18px !important' }"></i>
              </base-button>
            </el-tooltip>

            <base-button
              @click="updateSlider('posters')"
              :loading="is_update_site_posters"
              class="hvr-icon-spin"
              type="warning"
              size="sm"
            >
              <transition name="fade" mode="out-in">
                <semipolar-spinner
                  :animation-duration="2000"
                  :size="17"
                  color="#fff"
                  v-if="is_update_site_posters"
                />
                <span v-else class="pull-right ml-2" >
                  <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
                  <i v-else class="tim-icons icon-pencil"></i>
                </span>
              </transition>
              بروزرسانی پوسترها
            </base-button>
          </div>
        </card>
      </div>    

      <div class="col-md-6">
        <card class="text-right animated bounceInBottom delay-last" v-if="is_loaded" dir="rtl">
          <span slot="header">
            مدیریت اسلایدر
          </span>

          <div class="row" v-for="(slide, index) in slider" :key="index">
            <div class="col-md-12">
              <base-input label="تصویر اسلاید">
                <el-upload
                  class="avatar-uploader"
                  action="/"
                  :auto-upload="false"
                  :show-file-list="false"
                  :on-change="file => addImage('slide', file, index)">
                  <img
                    v-if="slide.image.url"
                    :src="slide.image.url"
                    class="avatar"
                    :style="{ borderRadius: '0px', width: '100% !important' }"
                  />
                  <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
                <small slot="helperText" id="emailHelp" class="form-text text-muted">این تصویر در اولین بخش قالب قرار خواهد گرفت</small>
              </base-input>
            </div>
            <div class="col-md-12">
              <md-field>
                <label>عنوان اسلاید</label>
                <md-input v-model="slide.title" />
                <i class="md-icon tim-icons icon-caps-small"></i>
                <span class="md-helper-text">عنوان اسلاید مورد نظر</span>
              </md-field>

              <md-field>
                <label>عنوان دکمه</label>
                <md-input v-model="slide.button" />
                <i class="md-icon tim-icons icon-bold"></i>
                <span class="md-helper-text">عنوان دکمه اسلاید مورد نظر</span>
              </md-field>            

              <md-field>
                <label>لینک دکمه</label>
                <md-textarea v-model="slide.link" md-autogrow></md-textarea>
                <i class="md-icon tim-icons icon-link-72"></i>
                <span class="md-helper-text">میتواند از لینک های خود وبسایت استفاده شود</span>
              </md-field>
              
              <md-field>
                <label>پاراگرف</label>
                <md-textarea v-model="slide.description" md-autogrow></md-textarea>
                <i class="md-icon tim-icons icon-paper"></i>
                <span class="md-helper-text">پاراگرف زیر عنوان برای اسلاید مورد نظر</span>
              </md-field>
            </div>
            <hr class="w-100 pull-right m-3" v-if="index !== slider.length - 1" />
          </div>


          <div v-if="!slider.length" class="alert alert-warning">
            متاسفانه اسلایدر وبسایت در حال حاضر خالیست :(
          </div>

          <div class="operation-cell d-flex justify-content-center mt-3">
            <el-tooltip content="افزودن اسلاید جدید">
              <base-button @click="slider.push({ image: {} })" class="hvr-icon-spin ml-2" type="success" size="sm" icon>
                <i class="tim-icons icon-simple-add hvr-icon" :style="{ fontSize: '18px !important' }"></i>
              </base-button>
            </el-tooltip>          
            
            <el-tooltip content="حذف آخرین اسلاید">
              <base-button @click="slider.pop()" class="hvr-icon-spin ml-2" type="danger" size="sm" icon>
                <i class="tim-icons icon-trash-simple hvr-icon" :style="{ fontSize: '18px !important' }"></i>
              </base-button>
            </el-tooltip>
            
            <base-button
              @click="updateSlider('slider')"
              :loading="is_update_site_slider"
              class="hvr-icon-spin"
              type="warning"
              size="sm"
            >
              <transition name="fade" mode="out-in">
                <semipolar-spinner
                  :animation-duration="2000"
                  :size="17"
                  color="#fff"
                  v-if="is_update_site_slider"
                />
                <span v-else class="pull-right ml-2" >
                  <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
                  <i v-else class="tim-icons icon-pencil"></i>
                </span>
              </transition>
              بروزرسانی اسلایدر
            </base-button>
          </div>
        </card>
      </div>
    </div>

    <transition name="fade">
      <div class="main-panel-loading" v-if="!is_loaded">
        <fingerprint-spinner
          :animation-duration="1000"
          :size="100"
          color="#fff"
        />
      </div>
    </transition>

    <transition name="loading">
      <div class="query-loader" v-if="attr('is_query_loading')">
        <half-circle-spinner
          :animation-duration="800"
          :size="40"
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
import binding from '../../mixins/binding';
import createMixin from '../../mixins/createMixin'
import {SemipolarSpinner, HalfCircleSpinner, FingerprintSpinner} from 'epic-spinners'

export default {
  components: {
    FlipClock,
    SemipolarSpinner,
    HalfCircleSpinner,
    FingerprintSpinner
  },
  mixins: [
    validationMixin,
    binding,
    createMixin
  ],
  metaInfo: {
    title: 'تنظیمات سایت',
  },
  validations: {
    title: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(250)
    },
    address: {
      maxLength: maxLength(250)
    },
    phone: {
      // 
    },
    theme_color: {
      // 
    },
  },
  data() {
    return {
      type: null,
      group: 'setting',
      label: 'تنظیمات',

      info: {
        title: '',
        description: '',
        address: '',
        phone: '',
        theme_color: '',
        is_enabled: true,
        banner_link: '',
        logo: {
          file: null,
          url: ''
        },
        watermark: {
          file: null,
          url: ''
        },
        banner: {
          file: null,
          url: ''
        },
        header_banner: {
          file: null,
          url: ''
        },
      },
      slider: [
        // 
      ],
      posters: [
        // 
      ],

      is_loaded: false,
      is_update_site_info: false,
      is_update_site_slider: false,
      is_update_site_posters: false,
    }
  },
  mounted()
  {
    axios.get('/graphql/auth', {
      params: {
        query: `{
          siteSetting {
            title description phone address
            theme_color is_enabled
            logo { small }
            banner { small }
            header_banner { small }
            watermark { small }
            slider {
              image { small }
              title description button link
            }
            posters {
              image { small }
              title description button link
            }
          }
        }`
      }
    })
    .then(({data}) => {
      this.info = data.data.siteSetting
      this.info.logo = { url: this.info.logo ? this.info.logo.small : null, file: null }
      this.info.watermark = { url: this.info.watermark ? this.info.watermark.small : null, file: null }
      this.info.banner = { url: this.info.banner ? this.info.banner.small : null, file: null }
      this.info.header_banner = { url: this.info.header_banner ? this.info.header_banner.small : null, file: null }

      this.slider = data.data.siteSetting.slider.map(i => {
        return { ...i, ...{ image: { url: i.image ? i.image.small : '', file: null } } }
      })
      this.posters = data.data.siteSetting.posters.map(i => {
        return { ...i, ...{ image: { url: i.image ? i.image.small : '', file: null } } }
      })

      this.is_loaded = true
    })
  },
  methods:
  {
    addImage(type, file, index = null)
    {
      const fileObj = { file: file.raw, url: URL.createObjectURL(file.raw) }

      if ( type === 'poster' || type === 'slide' )
        this[ type === 'poster' ? 'posters' : 'slider' ][index].image = fileObj
      
      else
        this.info[type] = fileObj
    },
    validate()
    {
      return true
    },
    updateInfo()
    {
      this.is_update_site_info = true
      this.type = 'site_info'

      this.storeInServer({
        callback: ({data}) => {
          this.is_update_site_info = false
          return console.log( data )
        }
      })
    },
    updateSlider(type)
    {
      this.type = type === 'slider' ? 'site_slider' : 'site_posters'

      type === 'slider' ? this.is_update_site_slider = true : this.is_update_site_posters = true

      this.storeInServer({
        callback: ({data}) => {
          type === 'slider' ? this.is_update_site_slider = false : this.is_update_site_posters = false
          return console.log( data )
        }
      })
    },
    getVariables()
    {
      if ( this.type === 'site_slider' )
      {
        return {
          slider: this.slider.map(i => {
            return {
              title: i.title,
              description: i.description,
              button: i.button,
              link: i.link,
              image: null
            }
          })
        }
      }
      else if ( this.type === 'site_posters' )
      {
        return {
          posters: this.posters.map(i => {
            return {
              title: i.title,
              description: i.description,
              button: i.button,
              link: i.link,
              image: null
            }
          })
        }
      }

      return {
        title: this.info.title,
        description: this.info.description,
        phone: this.info.phone,
        address: this.info.address,
        theme_color: this.info.theme_color,
        is_enabled: this.info.is_enabled,
        banner_link: this.info.banner_link,
        logo: null,
        watermark: null,
        banner: null,
        header_banner: null
      }
    },
    changeFormData(fd)
    {
      if ( this.type === 'site_posters' )
      {
        if ( this.posters.filter(i => i.image.file).length === 0 )
          return fd;

        let map = {}

        this.posters.forEach((poster, index) => {
          if ( !poster.image.file )
            return
          map[`images_${index}`] = [`variables.posters.${index}.image`]
          fd.append(`images_${index}`, poster.image.file) 
        })

        fd.delete('map')
        fd.append('map' , JSON.stringify(map))

        return fd;
      }
      else if ( this.type === 'site_slider' )
      {
        if ( this.slider.filter(i => i.image.file).length === 0 )
          return fd;

        let map = {}

        this.slider.forEach((slide, index) => {
          if ( !slide.image.file )
            return

          map[`images_${index}`] = [`variables.slider.${index}.image`]
          fd.append(`images_${index}`, slide.image.file)
        })

        fd.delete('map')
        fd.append('map' , JSON.stringify(map))

        return fd;
      }

      fd.delete('map')
      let map = {}

      if ( this.info.logo.file )
      {
        map.logo = [`variables.logo`]
        fd.append('logo', this.info.logo.file) 
      }

      if ( this.info.watermark.file )
      {
        map.watermark = [`variables.watermark`]
        fd.append('watermark', this.info.watermark.file) 
      }

      if ( this.info.banner.file )
      {
        map.banner = [`variables.banner`]
        fd.append('banner', this.info.banner.file) 
      }

      if ( this.info.header_banner.file )
      {
        map.header_banner = [`variables.header_banner`]
        fd.append('header_banner', this.info.header_banner.file) 
      }

      
      fd.append('map' , JSON.stringify(map))

      return fd
    }
  },
  computed: {
    allQuery()
    {
      return `status message`
    }
  }
}
</script>
<style>
</style>
