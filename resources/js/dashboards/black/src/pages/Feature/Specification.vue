<template>
  <datatable
    :type="type"
    :group="group"
    label="جدول مشخصات"
    :fields="getFields"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">

    <template slot="filter-labels" v-if="false">
      <span class="pull-right text-muted ml-2" v-show="hasFilter">فیتلر های اعمال شده :</span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterLogo(null)"
        v-show="filter('hasLogo') == 1">
        فقط عکس دار ها
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>
      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterLogo(null)"
        v-show="filter('hasLogo') == 0">
        فقط بدون عکس
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterCategory(null)"
        v-show="filter('hasCategories') == 1">
        فقط با دسته بندی ها
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>
      <span 
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterCategory(null)"
        v-show="filter('hasCategories') == 0">
        فقط بدون دسته بندی ها
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="$refs.filter_categories.setCheckedNodes([]); filterCategory( filter('hasCategories') )"
        v-show="filter('categories') && filter('categories_string')">
        فقط برای گروه {{ filter('categories').length !== 1 ? 'های' : '' }} : <b>{{ filter('categories_string') }}</b>
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="$store.state[group].filters[type].query = null; filterSearch()"
        v-show="filter('query')">
        جستجو برای : {{ filter('query') }}
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>
    </template>
    
    <template v-slot:category-body="slotProps">
      <a href="#">{{ slotProps.row.category ? slotProps.row.category.title : '' }}</a>
    </template>

    <template slot="modal">
      <md-field :class="getValidationClass('title')">
        <label>عنوان جدول</label>
        <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
        <i class="md-icon tim-icons icon-tag"></i>
        <span class="md-helper-text">میتوانید از نام خود گروه استفاده کنید</span>
        <span class="md-error" v-show="!$v.title.required">لطفا عنوان جدول را وارد کنید</span>
      </md-field>
      <br/>
      <md-field :class="getValidationClass('description')">
        <label>توضیحات جدول</label>
        <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
        <i class="md-icon tim-icons icon-paper"></i>
        <span class="md-helper-text">توضیحی مختصر درباره جدول</span>
      </md-field>

      <!-- <el-cascader
        :options="$store.state.group.category"
        :value="['id']"
        label="title"
        children="childs"  
      >
      </el-cascader> -->
      <br/>
      <hr/>

      <el-collapse>
        <el-collapse-item name="1">
          <template slot="title">
            <div class="row col-12">
              <h3 class="col-8" :style="{margin: '0px'}">مخشصات پردازنده</h3>

              <div class="col-4">
                <el-tooltip class="pull-left" :content="'ویرایش '">
                  <base-button type="success" size="sm" icon>
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                </el-tooltip>

                <el-tooltip class="pull-left" :content="'حذف '">
                  <base-button type="danger" size="sm" icon>
                    <i class="tim-icons icon-simple-remove"></i>
                  </base-button>
                </el-tooltip>
              </div>
            </div>
          </template>

          <div>Consistent with real life: in line with the process and logic of real life, and comply with languages and habits that the users are used to;</div>
          <div>Consistent within interface: all elements should be consistent, such as: design style, icons and texts, position of elements, etc.</div>
        </el-collapse-item>
        <el-collapse-item title="Feedback" name="2">
          <div>Operation feedback: enable the users to clearly perceive their operations by style updates and interactive effects;</div>
          <div>Visual feedback: reflect current state by updating or rearranging elements of the page.</div>
        </el-collapse-item>
      </el-collapse>
    </template>

  </datatable>
</template>

<script>
import {Tooltip} from 'element-ui'
import {BaseDropdown} from '../../components'
import Datatable from '../../components/BaseDatatable.vue'

import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'

import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {
    Datatable,
    BaseDropdown,
  },
  mixins: [
    initDatatable,
    createMixin,
    validationMixin,
    Binding
  ],
  data() {
    return {
      plural: 'specs',
      type: 'spec',
      group: 'feature',
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
  mounted() {
    this.$store.dispatch('getData', {
      group: 'group',
      type: 'category',
    })
  },
  created() {
    setTimeout( () => $('.tilt').tilt({scale: 1.1}) ,300)
    setTimeout( () => $('.tilt-fixed').tilt() ,300)
  },
  methods: {
    closePanel() {
      this.$refs.datatable.closePanel();
    },
    edit(index, row)
    {
      this.setAttr('is_creating', false)

      this.$router.push(`/panel/specification/${row.id}`)
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
    title: bind('title'),
    description: bind('description'),

    getFields() {
      return [
        {
          field: 'title',
          label: 'عنوان جدول',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات',
          icon: 'icon-single-copy-04'
        }, {
          field: 'category',
          label: 'دسته بندی',
          icon: 'icon-time-alarm'
        }
      ]
    },
    allQuery() {
      return `
        title
        description
        category {
          id
          title
        }
      `
    }
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>