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
    :ignoreOperations="ignoreOperations"
    ref="datatable">

    <template #title-body="slotProps">
      <el-popover
        placement="top-end"
        width="300"
        trigger="hover"
        :disabled="typeof slotProps.row.title === 'string' ? slotProps.row.title.length <= 50 : false"
        :content="slotProps.row.title"
      >
        <p slot="reference" class="md-list-item-text text-center" :style="{ overflow: 'visible' }">
          <i v-if="slotProps.row.icon" class="material-icons">{{ slotProps.row.icon }}</i>
          {{ slotProps.row.title | truncate(50) }}
        </p>
      </el-popover>
    </template>
    
    <template v-slot:color-body="slotProps">
      <span class="badge badge-primary p-2" v-if="slotProps.row.color" :style="{ background: slotProps.row.color }">
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      </span>
    </template>
    
    <template slot="modal">
      <div class="row">
        <div class="col-md-8">
          <md-field :class="getValidationClass('title')">
            <label>نام وضعیت</label>
            <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-caps-small"></i>
            <span class="md-helper-text">برای مثال : در حال بسته بندی</span>
            <span class="md-error" v-show="!$v.title.required">لطفا نام وضعیت را وارد کنید</span>
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
          <label>توضیحات وضعیت</label>
          <md-textarea v-model="description" :maxlength="$v.description.$params.maxLength.max"></md-textarea>
          <i class="md-icon tim-icons icon-paper"></i>
          <span class="md-helper-text">توضیحی مختصر درباره وضعیت سفارش</span>
        </md-field>

        <md-field>
          <label>آیکون</label>
          <md-select v-model="icon" >
            <md-optgroup v-for="group in $store.state.icons" :key="group.label" :label="group.label">
              <md-option
              v-for="icon in group.icons"
              :key="icon"
              :value="icon">{{ icon }} <span class="material-icons pull-left">{{ icon }}</span></md-option>
            </md-optgroup>
          </md-select>
          <i class="md-icon tim-icons material-icons">{{ icon }}</i>
          <span class="md-helper-text">آیکون وضعیت سفارش را مشخص کنید</span>
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
    Datatable,
  },
  mixins: [
    initDatatable,
    createMixin,
    Binding,
    validationMixin
  ],
  metaInfo: {
    title: 'وضعیت های سفارش',
  },
  data() {
    return {
      plural: 'order_statuses',
      type: 'order_status',
      group: 'shop',
      label: 'وضعیت سفارش',

      ignoreOperations: [1, 2, 3, 4]
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
      required,
    },
  },
  computed: {
    title: bind('title'),
    color: bind('color'),
    icon: bind('icon'),
    description: bind('description'),
    
    getFields() {
      return [
        {
          field: 'title',
          label: 'عنوان',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات',
          icon: 'icon-paper'
        }, {
          field: 'color',
          label: 'رنگ',
          icon: 'icon-palette'
        }
      ]
    },
    
    allQuery() {
      return `title description color icon`
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
.el-color-picker {
  height: 33px;
}
</style>
