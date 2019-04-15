<template>
  <datatable
    :type="type"
    :group="group"
    label="وضعیت سفارش"
    :fields="getFields"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">

    <template v-slot:color-body="slotProps">
      <span class="badge badge-primary p-2" v-if="slotProps.row.color" :style="{ background: slotProps.row.color }">
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      </span>
    </template>
    
    <template slot="modal">
      <div class="row">
        <div class="col-md-8">
          <md-field :class="getValidationClass('name')">
            <label>نام وضعیت</label>
            <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-tag"></i>
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
import initDatatable from '../../mixins/initDatatable'
import tilt from 'tilt.js'
import {ElTree} from 'element-ui'

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
    initDatatable,
    createMixin,
    Binding,
    validationMixin
  ],
  data() {
    return {
        type: 'order_status',
        group: 'shop',

        defaultProps: {
          children: 'childs',
          label: 'title',
        },
    }
  },
  created() {
    setTimeout( () => $('.tilt').tilt({scale: 1.1}) ,300)
    setTimeout( () => $('.tilt-fixed').tilt() ,300)
  },
  methods: {
    closePanel() {
      this.$refs.datatable.closePanel();
    },
    create() {
      this.setAttr('selected', {
        title: '',
        description: '',
        color: ''
      })

      this.setAttr('is_open', true)
      this.setAttr('is_creating', true)
    },
    edit(index, row) {
      this.setAttr('selected', {
        index: index,
        link: row.link,
        title: row.title,
        description: row.description,
        color: row.color
      })    

      this.setAttr('is_open', true)
      this.setAttr('is_creating', false)
    },
    getData() {
      let data = new FormData();

      this.fields.forEach(field => {
        if ( ['logo', 'categories'].includes(field.field) ) return

        let value = selected( field.field )

        data.append(field.field, value ? value : '')
      });

      this.$refs.categories.getCheckedKeys().forEach(category => {
        data.append('categories[]', category);
      });

      if ( selected('imageFile') )
        data.append('logo', selected('imageFile'))

      return data
    },
    
    changeSelectedCategories() {
      this.setAttr('selected', {
        categories: this.$refs.categories.getCheckedKeys(),
      })
    },
    filterLogo(command) {
      this.setAttr('filters', { hasLogo: command })

      this.changeTableData();
    },
    filterCategory(command) {
      this.setAttr('filters', {
        hasCategories: command,
        categories: this.$refs.filter_categories.getCheckedKeys()
      })

      if ( typeof this.filter('categories') == 'object' && this.filter('categories').length == 0 ) {
        this.setAttr('filters', {categories: []})
      }

      this.setAttr('filters', {
        categories_string: this.$refs.filter_categories.getCheckedNodes()
          .map( (category => category.title ))
          .join(' ، ')
      })

      this.changeTableData();
    },
    filterSearch() {
      this.changeTableData();
    },
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
          icon: 'icon-badge'
        }, {
          field: 'color',
          label: 'رنگ',
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
