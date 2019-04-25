<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="text-right pull-right">
          <h1 class="animated bounceInRight delay-first">
            ثبت محصول جدید
            <i class="tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
          </h1>
          <h6 class="text-muted animated bounceInRight delay-secound">از طریق فرم زیر میتوانید به صورت کامل اطلاعات محصول جدید خود را به ثبت برسانید</h6>
        </div>

        <div class="animated bounceInLeft delay-secound">
          <base-button @click="$router.push('/panel/product')" size="sm" type="warning" class="pull-left">
            <i class="tim-icons icon-double-left"></i>
            بازگشت
          </base-button>
        </div>
      </div>
    </div>

    <md-tabs class="animated bounceInUp delay-last" md-active-tab="tab-info">
      <md-tab id="tab-variations" md-label="تنوع محصولات">
        <div class="col-12 pull-left" v-for="(variation, index) of form.variations" :key="index">
          <div class="row">
            <div class="col-md-6">
              <md-field :class="getValidationClass('name')">
                <label>قیمت</label>
                <md-input v-model="variation.price" :maxlength="$v.name.$params.maxLength.max" />
                <i class="md-icon tim-icons icon-coins"></i>
                <span class="md-helper-text">قیمت فروش محصول</span>
                <span class="md-error" v-show="!$v.name.required">لطفا قیمت محصول را وارد کنید</span>
              </md-field>
            </div>

            <div class="col-md-5">
              <md-field :class="getValidationClass('name')">
                <label>موجودی در انبار</label>
                <md-input v-model="variation.inventory" :maxlength="$v.name.$params.maxLength.max" />
                <i class="md-icon tim-icons icon-bag-16"></i>
                <span class="md-helper-text">توسط فاکتور فروش ها مدیریت خواهد شد</span>
                <span class="md-error" v-show="!$v.name.required">لطفا موجودی این محصول را وارد کنید</span>
              </md-field>
            </div>
            <div class="col-md-1 d-flex align-items-center justify-content-center operation-cell">
              <base-button
                @click="index === 0 ? addVariation() : removeVariation(index)"
                :disabled="canAddVariation && index === 0"
                class="pull-left"
                :type="index === 0 ? 'default' : 'danger'"
                simple
                icon
                size="sm"
              >
                <i v-if="index === 0" class="tim-icons icon-simple-add"></i>
                <i v-else class="tim-icons icon-simple-remove"></i>
              </base-button>
            </div>

            <div class="col-md-4">
              <md-field :class="getValidationClass('name')">
                <label>رنگ</label>
                <md-select v-model="variation.color_id" name="movie" id="movie">
                  <md-option value="fight-club">Fight Club</md-option>
                  <md-option value="godfather">Godfather</md-option>
                  <md-option value="godfather-ii">Godfather II</md-option>
                  <md-option value="godfather-iii">Godfather III</md-option>
                  <md-option value="godfellas">Godfellas</md-option>
                  <md-option value="pulp-fiction">Pulp Fiction</md-option>
                  <md-option value="scarface">Scarface</md-option>
                </md-select>
                <i class="md-icon tim-icons icon-palette"></i>
                <span class="md-helper-text">رنگ های محصول مورد نظر</span>
                <span class="md-error" v-show="!$v.name.required">لطفا گروه بندی محصول را انتخاب کنید</span>
              </md-field>
            </div>

            <div class="col-md-4">
              <md-field :class="getValidationClass('name')">
                <label>گارانتی</label>
                <md-select v-model="variation.warranty_id" name="movie" id="movie">
                  <md-option value="fight-club">Fight Club</md-option>
                  <md-option value="godfather">Godfather</md-option>
                  <md-option value="godfather-ii">Godfather II</md-option>
                  <md-option value="godfather-iii">Godfather III</md-option>
                  <md-option value="godfellas">Godfellas</md-option>
                  <md-option value="pulp-fiction">Pulp Fiction</md-option>
                  <md-option value="scarface">Scarface</md-option>
                </md-select>
                <i class="md-icon tim-icons icon-refresh-01"></i>
                <span class="md-helper-text">گارانتی محصول مورد نظر</span>
                <span class="md-error" v-show="!$v.name.required">لطفا گارانتی محصول را انتخاب کنید</span>
              </md-field>
            </div>

            <div class="col-md-4">
              <md-field :class="getValidationClass('name')">
                <label>سایز</label>
                <md-select v-model="variation.size_id" name="movie" id="movie">
                  <md-option value="fight-club">Fight Club</md-option>
                  <md-option value="godfather">Godfather</md-option>
                  <md-option value="godfather-ii">Godfather II</md-option>
                  <md-option value="godfather-iii">Godfather III</md-option>
                  <md-option value="godfellas">Godfellas</md-option>
                  <md-option value="pulp-fiction">Pulp Fiction</md-option>
                  <md-option value="scarface">Scarface</md-option>
                </md-select>
                <i class="md-icon tim-icons icon-chart-bar-32"></i>
                <span class="md-helper-text">سایز محصول مورد نظر</span>
                <span class="md-error" v-show="!$v.name.required">لطفا گارانتی محصول را انتخاب کنید</span>
              </md-field>
            </div>
          </div>
          <hr class="mb-0 mt-4" v-if="index !== form.variations.length - 1" />
        </div>
      </md-tab>

      <md-tab id="tab-specifications" md-label="اطلاعات فنی">
        <h2 class="mb-0">مشخصات پردازنده</h2>
        <div class="row">
          <div class="col-md-6">
            <md-field :class="getValidationClass('name')">
              <label>نام محصول</label>
              <md-input v-model="form.name" :maxlength="$v.name.$params.maxLength.max" />
              <span class="md-suffix">کیلو گرم</span>
              <span class="md-helper-text">برای مثال : گوشی موبایل Samsung Galaxy S10</span>
              <span class="md-error" v-show="!$v.name.required">لطفا نام محصول را وارد کنید</span>
            </md-field>
          </div>

          <div class="col-md-6">
            <md-field :class="getValidationClass('name')">
              <label>شناسه محصول</label>
              <md-input v-model="form.name" :maxlength="$v.name.$params.maxLength.max" />
              <i class="md-icon tim-icons icon-tag"></i>
              <span class="md-helper-text">برای مثال : SMT-1002</span>
              <span class="md-error" v-show="!$v.name.required">لطفا شناسه محصول را وارد کنید</span>
            </md-field>
          </div>
        </div>
      </md-tab>

      <md-tab id="tab-advantages" md-label="معایب و مزایا">
        <div class="row">
          <div class="col-md-12 advantages">
            <md-chips v-model="form.advantages" md-placeholder="افزودن مزیت ...">
              <label>مزایای محصول</label>
              <span class="md-helper-text">مزیت های محصول خود را در این قسمت وارد کنید</span>
            </md-chips>
          </div>
          <div class="col-md-12 disadvantages">
            <md-chips v-model="form.disadvantages" md-placeholder="افزودن عیب ...">
              <label>معایب محصول</label>
              <span class="md-helper-text">معایب محصول خود را در این قسمت وارد کنید</span>
            </md-chips>
          </div>
        </div>
      </md-tab>

      <md-tab id="tab-images" md-label="تصاویر محصول" dir="ltr">
        <el-upload
          class="upload-photo-gallery"
          action="https://jsonplaceholder.typicode.com/posts/"
          :auto-upload="false"
          list-type="picture-card"
          :on-preview="handlePictureCardPreview"
          :on-change="handleSelectPhotos"
          :on-remove="handleRemove">
          <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog :visible.sync="dialogVisible">
          <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
      </md-tab>

      <md-tab id="tab-description" md-label="توضیحات محصول">
        <base-input label="توضیحات کامل محصول">
          <ckeditor :editor="editor" v-model="form.review" ></ckeditor>
          <small slot="helperText" class="form-text text-muted">متن کامل توضیحات و نقد و بررسی محصول</small>
        </base-input>
        <br/>

        <md-chips v-model="form.tags" md-placeholder="افزودن کلمه کلیدی ...">
          <label>کلمات کلیدی محصول</label>
          <span class="md-helper-text">کلمات کلیدی مرتبط با محصول خود را وارد کنید</span>
        </md-chips>
        <br/>

        <md-field :class="getValidationClass('note')">
          <label>یادداشت</label>
          <md-textarea v-model="form.note" md-autogrow :maxlength="$v.note.$params.maxLength.max"></md-textarea>
          <i class="md-icon tim-icons icon-paper"></i>
          <span class="md-helper-text">این فقط یک یادداشت برای فروشنده است و توسط خریدار قابل رویت نیست</span>
        </md-field>
      </md-tab>
      
      <md-tab id="tab-info" md-label="درباره محصول">
        <div class="row">
          <div class="col-md-6">
            <md-field :class="getValidationClass('name')">
              <label>نام محصول</label>
              <md-input v-model="form.name" :maxlength="$v.name.$params.maxLength.max" />
              <i class="md-icon tim-icons icon-tag"></i>
              <span class="md-helper-text">برای مثال : گوشی موبایل Samsung Galaxy S10</span>
              <span class="md-error" v-show="!$v.name.required">لطفا نام محصول را وارد کنید</span>
            </md-field>
          </div>

          <div class="col-md-6">
            <md-field :class="getValidationClass('code')">
              <label>شناسه محصول</label>
              <md-input v-model="form.code" :maxlength="$v.code.$params.maxLength.max" />
              <i class="md-icon tim-icons icon-badge"></i>
              <span class="md-helper-text">برای مثال : SMT-1002</span>
              <span class="md-error" v-show="!$v.code.required">لطفا شناسه محصول را وارد کنید</span>
            </md-field>
          </div>
        </div>
        <br/>

        <md-field :class="getValidationClass('description')">
          <label>توضیح کوتاه</label>
          <md-textarea v-model="form.description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
          <i class="md-icon tim-icons icon-align-center"></i>
          <span class="md-helper-text">توضیحی مختصر درباره این محصول</span>
          <span class="md-error" v-show="!$v.description.required">لطفا شناسه محصول را وارد کنید</span>
        </md-field>
        <br/>

        <div class="row">
          <div class="col-md-6">
            <md-field :class="getValidationClass('category_id')">
              <label>گروه محصول</label>
              <md-select v-model="form.category_id" name="movie" id="movie">
                <md-option value="fight-club">Fight Club</md-option>
                <md-option value="godfather">Godfather</md-option>
                <md-option value="godfather-ii">Godfather II</md-option>
                <md-option value="godfather-iii">Godfather III</md-option>
                <md-option value="godfellas">Godfellas</md-option>
                <md-option value="pulp-fiction">Pulp Fiction</md-option>
                <md-option value="scarface">Scarface</md-option>
              </md-select>
              <i class="md-icon tim-icons icon-components"></i>
              <span class="md-helper-text">دسته بندی محصول</span>
              <span class="md-error" v-show="!$v.category_id.required">لطفا گروه بندی محصول را انتخاب کنید</span>
            </md-field>
          </div>

          <div class="col-md-6">
            <md-field :class="getValidationClass('aparat_video')">
              <label>لینک ویدیو آپارت</label>
              <!-- <md-input v-model="aparat_video" :maxlength="$v.aparat_video.$params.maxLength.max" /> -->
              <md-input v-model="form.aparat_video" />
              <i class="md-icon tim-icons icon-video-66"></i>
              <span class="md-helper-text">برای مثال : https://www.aparat.com/v/TJcin</span>
              <span class="md-error" v-show="!$v.aparat_video.required">لطفا شناسه محصول را وارد کنید</span>
            </md-field>
          </div>
        </div>
        <br/>

        <div class="row">
          <div class="col-md-6">
            <md-field :class="getValidationClass('brand_id')">
              <label>برند محصول</label>
              <md-select v-model="form.brand_id" name="movie" id="movie">
                <md-option value="fight-club">Fight Club</md-option>
                <md-option value="godfather">Godfather</md-option>
                <md-option value="godfather-ii">Godfather II</md-option>
                <md-option value="godfather-iii">Godfather III</md-option>
                <md-option value="godfellas">Godfellas</md-option>
                <md-option value="pulp-fiction">Pulp Fiction</md-option>
                <md-option value="scarface">Scarface</md-option>
              </md-select>
              <i class="md-icon tim-icons icon-molecule-40"></i>
              <span class="md-helper-text">جهت تفکیف محصولات بر اساس برند</span>
              <span class="md-error" v-show="!$v.brand_id.required">لطفا گروه بندی محصول را انتخاب کنید</span>
            </md-field>
          </div>
          <div class="col-md-3">
            <md-field :class="getValidationClass('label')">
              <label>لیبل محصول</label>
              <md-select v-model="form.label" name="movie" id="movie">
                <md-option value="fight-club">Fight Club</md-option>
                <md-option value="godfather">Godfather</md-option>
                <md-option value="godfather-ii">Godfather II</md-option>
                <md-option value="godfather-iii">Godfather III</md-option>
                <md-option value="godfellas">Godfellas</md-option>
                <md-option value="pulp-fiction">Pulp Fiction</md-option>
                <md-option value="scarface">Scarface</md-option>
              </md-select>
              <i class="md-icon tim-icons icon-tag"></i>
              <span class="md-helper-text">جهت نمایش در صفحه محصولات</span>
              <span class="md-error" v-show="!$v.label.required">لطفا گروه بندی محصول را انتخاب کنید</span>
            </md-field>
          </div>

          <div class="col-3 d-flex align-items-center justify-content-center" dir="ltr">
            <el-switch
              v-model="form.status"
              active-text="ثبت"
              inactive-text="پیش نویس">
            </el-switch>
          </div>
        </div>
      </md-tab>
    </md-tabs>
  </div>
</template>

<script>
import Binding, { bind } from '../../mixins/binding'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import { validationMixin } from 'vuelidate'
import vuexHelper from '../../mixins/vuexHelper'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {},
  mixins: [
    Binding,
    validationMixin,
    vuexHelper
  ],
  data() {
    return {
      type: 'product',
      group: 'product',

      form: {
        name: '',
        code: '',
        description: '',
        category_id: null,
        aparat_video: '',
        brand_id: null,
        label: null,
        status: true,
        review: '',
        tags: [],
        note: '',
        photos: [],
        advantages: [],
        disadvantages: [],
        variations: [
          {
            price: null,
            inventory: null,
            color_id: null,
            warranty_id: null,
            size_id: null,
          },
        ]
      },
      
      dialogImageUrl: '',
      dialogVisible: false,

      editor: ClassicEditor,
    }
  },
  validations: {
    name: {
      required,
      maxLength: maxLength(50)
    },
    code: {
      maxLength: maxLength(20)
    },
    description: {
      maxLength: maxLength(255)
    },
    category_id: {},
    aparat_video: {},
    brand_id: {},
    label: {},
    status: {},
    review: {},
    note: {
      maxLength: maxLength(255)
    },
    advantages: {},
    disadvantages: {},
  },
  computed: {
    canAddVariation() {
      return !this.form.variations[ this.form.variations.length - 1 ].price
    }
  },
  methods: {
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handleSelectPhotos(file, fileList) {
      this.form.photos = fileList.map(item => item.raw )
    },
    addVariation() { 
      this.form.variations = [...this.form.variations, {
        price: null,
        inventory: null,
        color_id: null,
        warranty_id: null,
        size_id: null,
      }]
    },
    removeVariation(index) {
      this.form.variations.splice(index, 1)
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    }
  },
}
</script>

<style scope>
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
