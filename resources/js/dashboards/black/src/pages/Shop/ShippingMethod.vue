<template>
  <datatable
    :type="type"
    :group="group"
    label="متد ارسال"
    :fields="getFields"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">
    
    <template v-slot:logo-body="slotProps">
      <img class="tilt" :src="slotProps.row.logo ? slotProps.row.logo.tiny : '/images/placeholder.png'" />
    </template>

    <template v-slot:cost-body="slotProps">
      {{ slotProps.row.cost | comma }}
    </template>

    <template slot="modal">
      <div class="row">
        <div class="col-md-5">
          <base-input label="لوگوی روش ارسال">
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

        <div class="col-md-7">
          <md-field :class="getValidationClass('name')">
            <label>عنوان روش ارسال</label>
            <md-input v-model="name" :maxlength="$v.name.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-tag"></i>
            <span class="md-helper-text">برای مثال : پست پیشتاز</span>
            <span class="md-error" v-show="!$v.name.required">لطفا عنوان روش ارسال را وارد کنید</span>
          </md-field>

          <md-field :class="getValidationClass('description')">
            <label>توضیحات روش ارسال</label>
            <md-textarea v-model="description" :maxlength="$v.description.$params.maxLength.max"></md-textarea>
            <i class="md-icon tim-icons icon-paper"></i>
            <span class="md-helper-text">توضیحی مختصر درباره روش ارسال</span>
          </md-field>
        </div>
      </div>
      <br/>

      <div class="row">
        <div class="col-md-6">
          <md-field :class="getValidationClass('cost')">
            <label>هزینه روش ارسال</label>
            <md-input v-model="cost" type="number" />
            <i class="md-icon tim-icons icon-coins"></i>
            <span class="md-helper-text">هزینه روش ارسال بر حسب تومان</span>
            <span class="md-error" v-show="!$v.cost.required">لطفا هزینه روش ارسال را وارد کنید</span>
          </md-field>
        </div>
        <div class="col-md-6">
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
import {Tooltip} from 'element-ui'
import {BaseDropdown} from '../../components'
import Datatable from '../../components/BaseDatatable.vue'
import ICountUp from 'vue-countup-v2';
import {mapActions, mapMutations} from 'vuex'
import createMixin from '../../mixins/createMixin'
import filtersHelper from '../../mixins/filtersHelper.js'
import initDatatable from '../../mixins/initDatatable'
import tilt from 'tilt.js'

import Binding, { bind } from '../../mixins/binding'

import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {
    Datatable,
    BaseDropdown,
    ICountUp
  },
  mixins: [
    validationMixin,
    initDatatable,
    createMixin,
    filtersHelper
  ],
  data() {
    return {
        type: 'shipping_method',
        group: 'shop',

        defaultProps: {
          children: 'childs',
          label: 'title',
        },
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
  methods: {
    closePanel() {
      this.$refs.datatable.closePanel();
    },
    create() {
      this.setAttr('selected', {
        name: '',
        description: '',
        cost: null,
        minimum: null,
        imageFile: null,
        imageUrl: '',
      })

      this.setAttr('is_open', true)
      this.setAttr('is_creating', true)
    },
    edit(index, row) {
      this.setAttr('selected', {
        index: index,
        link: row.link,
        name: row.name,
        description: row.description,
        cost: row.cost,
        minimum: row.cost,
        imageFile: null,
        imageUrl: row.logo ? row.logo.small : '',
      })    

      this.setAttr('is_open', true)
      this.setAttr('is_creating', false)
    },
    getData() {
      let data = new FormData();

      this.getFields.forEach(field => {
        if ( ['logo'].includes(field.field) ) return

        if ( this.selected( field.field ) ) data.append(field.field, this.selected( field.field ))
      });

      data.append('minimum', this.selected('minimum'))

      if ( this.selected('imageFile') )
        data.append('logo', this.selected('imageFile'))

      return data
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
          icon: 'icon-badge'
        }, {
          field: 'name',
          label: 'نام',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات',
          icon: 'icon-badge'
        }, {
          field: 'cost',
          label: 'هزینه',
          icon: 'icon-badge'
        }
      ]
    },
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>

<style>
img {
  max-height: 20px;
  margin-left: 10px;
}
</style>