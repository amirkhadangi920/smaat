<template>
  <datatable
    :type="type"
    :group="group"
    :label="label"
    :fields="getFields"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">
    
    <template v-slot:logo-body="slotProps">
      <img class="tilt" :src="slotProps.row.logo ? slotProps.row.logo.thumb : '/images/placeholder.png'" />
    </template>

    <template v-slot:cost-body="slotProps">
      <p v-if="slotProps.row.cost">{{ slotProps.row.cost | comma }} <span class="text-muted text-small" :style="{fontSize: '10px'}">تومان</span></p>
      <span v-else class="badge badge-success">رایگان</span>
    </template>

    <template slot="modal">
      <md-field :class="getValidationClass('name')">
        <label>عنوان روش ارسال</label>
        <md-input v-model="name" :maxlength="$v.name.$params.maxLength.max" />
        <i class="md-icon tim-icons icon-caps-small"></i>
        <span class="md-helper-text">برای مثال : پست پیشتاز</span>
        <span class="md-error" v-show="!$v.name.required">لطفا عنوان روش ارسال را وارد کنید</span>
      </md-field>
      <br/>

      <md-field :class="getValidationClass('description')">
        <label>توضیحات روش ارسال</label>
        <md-textarea v-model="description" :maxlength="$v.description.$params.maxLength.max"></md-textarea>
        <i class="md-icon tim-icons icon-paper"></i>
        <span class="md-helper-text">توضیحی مختصر درباره روش ارسال</span>
      </md-field>

      <div class="row">
        <div class="col-md-5">
          <base-input label="لوگوی روش ارسال">
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

        <div class="col-md-7">
          <md-field :class="getValidationClass('cost')">
            <label>هزینه روش ارسال</label>
            <md-input v-model="cost" type="number" />
            <i class="md-icon tim-icons icon-coins"></i>
            <span class="md-helper-text">هزینه روش ارسال بر حسب تومان</span>
            <span class="md-error" v-show="!$v.cost.required">لطفا هزینه روش ارسال را وارد کنید</span>
          </md-field>

          <md-field :class="getValidationClass('minimum')">
            <label>حداقل مبلغ سفارش</label>
            <md-input v-model="minimum" type="number" />
            <i class="md-icon tim-icons icon-delivery-fast"></i>
            <span class="md-helper-text">حداقل مبلغ فاکتور برای استفاده از این روش ارسال</span>
            <span class="md-error" v-show="!$v.cost.required">لطفا حداقل مبلغ سفارش را وارد کنید</span>
          </md-field>
        </div>
      </div>
      
    </template>
  </datatable>
</template>

<script>
import Datatable from '../../components/BaseDatatable.vue'

import createMixin from '../../mixins/createMixin'
import filtersHelper from '../../mixins/filtersHelper.js'
import initDatatable from '../../mixins/initDatatable'
import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {
    Datatable,
  },
  mixins: [
    Binding,
    validationMixin,
    initDatatable,
    createMixin,
    filtersHelper
  ],
  metaInfo: {
    title: 'روش های ارسال کالا',
  },
  data() {
    return {
        plural: 'shipping_methods',
        type: 'shipping_method',
        group: 'shop',
        label: 'روش ارسال'
    }
  },
  validations: {
    name: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(255)
    },
    cost: {
      required,
    },
    minimum: {
      required
    }
  },
  computed: {
    name: bind('name'),
    description: bind('description'),
    cost: bind('cost'),
    minimum: bind('minimum'),

    getFields() {
      return [
        {
          field: 'logo',
          label: 'لوگو',
          icon: 'icon-image-02'
        }, {
          field: 'name',
          label: 'نام',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات',
          icon: 'icon-paper'
        }, {
          field: 'cost',
          label: 'هزینه',
          icon: 'icon-coins'
        }
      ]
    },
    
    allQuery() {
      return `
        name
        description
        cost
        minimum
        logo { id file_name thumb }`
    },
  },
  beforeRouteLeave(to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>