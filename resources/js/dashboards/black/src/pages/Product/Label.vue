<template>
  <datatable
    :type="type"
    :group="group"
    label="لیبل محصول"
    :fields="getFields"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"  
    ref="datatable"
  >

    <template slot="filter-labels"></template>
    
    <template v-slot:color-body="slotProps">
      <span class="badge badge-primary p-2" v-if="slotProps.row.color" :style="{ background: slotProps.row.color }">
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      </span>
    </template>

    <template slot="modal">
      <div class="row">
        <div class="col-md-8">
          <md-field :class="getValidationClass('title')">
            <label>عنوان لیبل</label>
            <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-tag"></i>
            <span class="md-helper-text">برای مثال : خارج از تولید</span>
            <span class="md-error" v-show="!$v.title.required">لطفا عنوان را وارد کنید</span>
          </md-field>
        </div>

        <div class="col-md-4">
          <md-field :class="getValidationClass('color')">
            <el-color-picker v-model="color"></el-color-picker>
            <span class="md-helper-text">رنگ را انتخاب کنید</span>
            <span class="md-error" v-show="!$v.color.required">لطفا رنگ را انتخاب کنید</span>
          </md-field>
        </div>

        <md-field :class="getValidationClass('description')">
          <label>توضیحات</label>
          <md-textarea v-model="description" :maxlength="$v.description.$params.maxLength.max"></md-textarea>
          <i class="md-icon tim-icons icon-paper"></i>
          <span class="md-helper-text">توضیحی مختصر درباره لیبل</span>
        </md-field>
      </div>
    </template>
  </datatable>
</template>

<script>
import Datatable from '../../components/BaseDatatable.vue'
import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'

import Binding, { bind } from '../../mixins/binding'

import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {
    Datatable
  },
  mixins: [
    initDatatable,
    createMixin,
    Binding,
    validationMixin
  ],
  data() {
    return {
        type: 'label',
        plural: 'labels',
        group: 'product',
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
    color: {
      // 
    },
  },
  computed: {
    title: bind('title'),
    color: bind('color'),
    description: bind('description'),
    
    getFields() {
      return [
        {
          field: 'title',
          label: 'عنوان',
          icon: 'icon-badge'
        }, {
          field: 'description',
          label: 'توضیحات',
          icon: 'icon-caps-small'
        }, {
          field: 'color',
          label: 'رنگ',
          icon: 'icon-caps-small'
        }
      ]
    },
    
    allQuery() {
      return `title description color`
    },
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>
