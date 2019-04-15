<template>
  <div>
    <div v-for="(header, index) of headers" :key="header.id" class="row mb-3">
      <div class="col-12">
        <div class="text-right pull-right">
          <h2 class="animated bounceInRight delay-first mb-0">
            {{ header.title }}
            <i class="tim-icons icon-bullet-list-67" :style="{fontSize: '20px'}"></i>
          </h2>
          <h6 class="text-muted animated bounceInRight delay-secound">{{ header.description }}</h6>
        </div>

        <div class="animated bounceInLeft delay-secound operation-cell">
          <el-tooltip content="ویرایش">
            <base-button @click="edit_header(index, header)" type="success" size="sm" icon>
              <i class="tim-icons icon-pencil"></i>
            </base-button>
          </el-tooltip>

          <el-tooltip content="حذف">
            <base-button type="danger" size="sm" icon>
              <i class="tim-icons icon-simple-remove"></i>
            </base-button>
          </el-tooltip>
        </div>
      </div>

      <div class="col-12" dir="rtl">
        <ul class="data-table-header p-2 d-flex justify-content-center">
          <li 
            class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted"
            :style="{width: '40px'}"
          >
          <transition name="fade" mode="out-in">
            <span v-if="header.rows.length === 0">#</span>
            <ICountUp
              v-if="header.rows.length !== 0"
              :endVal="header.rows.length"
              :options="{
                useEasing: true,
                useGrouping: true,
              }"
            />
          </transition>
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
            <checkbox>
              <input type="checkbox" />
              <!-- <input type="checkbox" v-model="all_items_selected" @change="handleSelectAll" /> -->
            </checkbox>
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            عنوان
          </li>
          <!-- <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            توضیحات
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            راهنما
          </li> -->
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            لیبل
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            مقادیر
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            چندانتخابی
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            اجباری
          </li>
          <!-- <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-time-alarm hvr-icon"></i>
            ثبت / ویرایش
          </li> -->
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
            v-for="(row, index) in header.rows"
            :key="row.id"
            class="data-table-row"
          >
            <ul class="p-2 d-flex justify-content-center">
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
                {{ index + 1 }}
              </li>
              <li :style="{width: '40px'}" class="data-table-cell d-flex align-items-center justify-content-center">
                <checkbox>
                  <input type="checkbox" :value="index" />
                  <!-- <input type="checkbox" :value="index" v-model="selected_items" @change="handleSelectedChange(index)" /> -->
                </checkbox>
              </li>
              <!-- <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.title }}
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.description }}
              </li> -->
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.title }}
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.label }}
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                <div v-if="row.values">
                  <span
                    v-for="item in row.values.filter( (item, index) => index < 3)"
                    :key="item.id"
                    class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
                    <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
                    {{ item }}
                  </span>

                  <el-dropdown v-if="row.values.length > 3" :key="row.values.map((c) => c.id).join(',')">
                    <span class="el-dropdown-link badge badge-default">
                      باقی مقادیر <i class="el-icon-arrow-down el-icon--right"></i>
                    </span>
                    <el-dropdown-menu slot="dropdown">
                      <el-dropdown-item
                        v-for="item in row.values.filter( (item, index) => index < 3)"
                        :key="item.id">
                        {{ item }}
                      </el-dropdown-item>
                    </el-dropdown-menu>
                  </el-dropdown>
                </div>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                <i v-if="row.multiple" class="tim-icons icon-check-2 text-success"></i>
                <i v-else-if="!row.multiple" class="tim-icons icon-simple-remove text-danger"></i>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                <i v-if="row.required" class="tim-icons icon-check-2 text-success"></i>
                <i v-else-if="!row.required" class="tim-icons icon-simple-remove text-danger"></i>
              </li>
              <li class="data-table-cell operation-cell p-2 d-flex align-items-center justify-content-center">
                <el-tooltip :content="'ویرایش'">
                  <base-button @click="edit_row(index, row)" type="success" size="sm" icon>
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                </el-tooltip>

                <el-tooltip :content="'حذف'">
                  <base-button type="danger" size="sm" icon>
                    <i class="tim-icons icon-simple-remove"></i>
                  </base-button>
                </el-tooltip>

                <base-button v-if="row.description != null" type="default" size="sm" icon>
                  <i class="tim-icons icon-alert-circle-exc"></i>
                </base-button>
              </li>
            </ul>
          </li>
        </transition-group>
      </div>

      <modal :show.sync="is_open_header" class="text-right" dir="rtl">
        <template slot="header">
          <h2 class="modal-title">
            {{ is_creating_header ? 'ثبت عنوان جدول' : 'ویرایش عنوان جدول' }}
          </h2>
          <p>از طریق فرم زیر میتوانید عنوان جدول {{ is_creating_header ? 'جدید ثبت کنید' : 'مورد نظر خود را ویرایش کنید' }}</p>
        </template>
        <div>
          <form @submit.prevent>
            <md-field :class="getValidationClass('name')">
              <label>عنوان</label>
              <md-input v-model="selected.header.title" :maxlength="$v.title.$params.maxLength.max" />
              <i class="md-icon tim-icons icon-tag"></i>
              <span class="md-helper-text">برای مثال : مشخصات پردازنده</span>
              <span class="md-error" v-show="!$v.title.required">لطفا عنوان را وارد کنید</span>
            </md-field>
            <br/>
            <md-field :class="getValidationClass('description')">
              <label>توضیحات</label>
              <md-textarea v-model="selected.header.description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
              <i class="md-icon tim-icons icon-paper"></i>
              <span class="md-helper-text">توضیحی مختصر درباره این عنوان</span>
            </md-field>
          </form>
        </div>
        <template slot="footer">
          <base-button
            type="secondary"
            @click="is_open_header = false">
            لغو
          </base-button>
          
          <base-button 
            :type="is_creating_header ? 'primary' : 'danger'"
            @click="is_creating_header ? methods.store() : methods.update()">
            {{ is_creating_header ? 'ذخیره' : 'بروز رسانی' }} عنوان جدول مشخصات
          </base-button>
        </template>
      </modal>

      <modal :show.sync="is_open_row" class="text-right" dir="rtl">
        <template slot="header">
          <h2 class="modal-title">
            {{ is_creating_row ? 'ثبت ردیف جدول' : 'ویرایش ردیف جدول' }}
          </h2>
          <p>از طریق فرم زیر میتوانید ردیف جدول {{ is_creating_row ? 'جدید ثبت کنید' : 'مورد نظر خود را ویرایش کنید' }}</p>
        </template>
        <div>
          <form @submit.prevent>
            <div class="row">
              <div class="col-8">
                <md-field :class="getValidationClass('title')">
                  <label>عنوان</label>
                  <md-input v-model="selected.row.title" :maxlength="$v.title.$params.maxLength.max" />
                  <i class="md-icon tim-icons icon-tag"></i>
                  <span class="md-helper-text">برای مثال : نوع پردازنده</span>
                  <span class="md-error" v-show="!$v.title.required">لطفا عنوان ردیف را وارد کنید</span>
                </md-field>
              </div>
              <div class="col-4">
                <md-field :class="getValidationClass('label')">
                  <label>لیبل</label>
                  <md-input v-model="selected.row.label" :maxlength="$v.title.$params.maxLength.max" />
                  <i class="md-icon tim-icons icon-puzzle-10"></i>
                  <span class="md-helper-text">برای مثال : گیگابایت</span>
                  <span class="md-error" v-show="!$v.title.required">لیبل مورد نظر در انتهای تمامی مقادیر این سطر قرار خواهد گرفت</span>
                </md-field>
              </div>
            </div>
            <br/>

            <md-field :class="getValidationClass('description')">
              <label>توضیحات</label>
              <md-textarea v-model="selected.row.description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
              <i class="md-icon tim-icons icon-paper"></i>
              <span class="md-helper-text">توضیحی مختصر درباره این ردیف</span>
            </md-field>
            <br/>

            <md-field :class="getValidationClass('description')">
              <label>راهنما</label>
              <md-textarea v-model="selected.row.help" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
              <i class="md-icon tim-icons icon-alert-circle-exc"></i>
              <span class="md-helper-text">راهنمایی کوتاه جهت نمایش به کاربران درباره این ردیف</span>
            </md-field>
            <br/>

            <md-chips v-model="selected.row.values" md-placeholder="افزودن مقدار ...">
              <label>مقادیر</label>
              <i class="md-icon tim-icons icon-tag"></i>
              <span class="md-helper-text"></span>
            </md-chips>
            <br/>

            <div class="row" dir="ltr">
              <el-switch
                class="col-6 d-flex justify-content-center"
                v-model="selected.row.multiple"
                active-text="چند انتخابی"
                inactive-text="تک انتخابی">
              </el-switch>
              <el-switch
                class="col-6 d-flex justify-content-center"
                v-model="selected.row.required"
                active-text="اجباری"
                inactive-text="اختیاری">
              </el-switch>
            </div>
            <br/>
          </form>
        </div>
        <template slot="footer">
          <base-button
            type="secondary"
            @click="is_open_row = false">
            لغو
          </base-button>
          
          <base-button 
            :type="is_creating_header ? 'primary' : 'danger'"
            @click="is_creating_header ? methods.store() : methods.update()">
            {{ is_creating_header ? 'ذخیره' : 'بروز رسانی' }} عنوان جدول مشخصات
          </base-button>
        </template>
      </modal>
    </div>
  </div>
</template>

<script>
import ICountUp from 'vue-countup-v2';
import Checkbox from '../../components/Checkbox.vue'
import {Modal} from '../../components'

import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  mixins: [ validationMixin ],
  components: {
    ICountUp,
    Checkbox,
    Modal
  },
  data() {
    return {
      headers: [],
      selected: {
        header: {
          index: '',
          title: '',
          description: ''
        },
        row: {
          index: '',
          title: '',
          label: '',
          description: '',
          help: '',
          values: [],
          required: true,
          multiple: false
        },
      },
      
      is_creating_header: false,
      is_creating_row: false,
      is_open_header: false,
      is_open_row: false,
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
  },
  methods: {
    edit_header(index, header) {
      this.selected.header.index = index
      this.selected.header.title = header.title
      this.selected.header.description = header.description

      this.is_creating_header = false;
      this.is_open_header = true;
    },
    edit_row(index, row) {
      this.selected.row = row
      this.selected.row.values = row.values ? row.values : []
      this.selected.row.index = index
      console.log(row)

      this.is_creating_row = false;
      this.is_open_row = true;
    },

    getValidationClass (fieldName) {
      const field = this.$v[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validate() {
      this.$v.$touch()

      return !this.$v.$invalid;
    },
  },
  mounted() {
    axios(`/api/v1/spec/${this.$route.params.id}`).then(({data}) => {
      console.log(data)
      this.headers = data.data.headers
    })
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>