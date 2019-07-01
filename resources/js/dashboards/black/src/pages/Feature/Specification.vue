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
    
    <template v-slot:categories-body="slotProps">
      <transition-group name="list">
        <span
          v-for="item in slotProps.row.categories.filter( (category, index) => index < 3)"
          :key="item.id"
          class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
          <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
          {{ item.title }}
        </span>

        <el-dropdown v-if="slotProps.row.categories.length > 3" :key="slotProps.row.categories.map((c) => c.id).join(',')">
          <span class="el-dropdown-link badge badge-default">
            باقی گروه ها <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item
              v-for="item in slotProps.row.categories.filter( (category, index) => index < 3)"
              :key="item.id">
              {{ item.title }}
            </el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </transition-group>
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
      <br/>

      <base-input label="دسته بندی های جدول مشخصات">
        <el-tree
          class="rtl"
          dir="ltr"
          :data="$store.state.group.category"
          :props="defaultProps"
          :accordion="true"
          ref="categories"
          show-checkbox
          node-key="id"
          @check-change="changeSelectedCategories"
          :default-checked-keys="selected('categories')"
          :default-expanded-keys="selected('categories')"
          empty-text="هیچ دسته بندی ای یافت نشد :("
        >
        </el-tree>
      <small slot="helperText" id="emailHelp" class="form-text text-muted">برای انتخاب هر دسته بندی تیک قبل آن را انتخاب کنید</small>
      </base-input>
    </template>

    <template #custom-operations="slotProps">
      <el-tooltip content="مدیریت جدول">
        <base-button class="m-0" @click="manageTable(slotProps.index, slotProps.row)" type="success" size="sm" icon>
          <i class="tim-icons icon-bullet-list-67"></i>
        </base-button>
      </el-tooltip>
    </template>

  </datatable>
</template>

<script>
import {Tooltip} from 'element-ui'
import {BaseDropdown} from '../../components'
import Datatable from '../../components/BaseDatatable.vue'
import RemoteSelect from '../../components/RemoteSelect'

import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'

import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {
    Datatable,
    BaseDropdown,
    RemoteSelect
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

      // spec_categories: [],

      defaultProps: {
        children: 'childs',
        label: 'title',
      },
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

    // axios.get('/graphql/auth', {
    //   params: {
    //     query: `{
    //       specCategories { id }
    //     }`
    //   }
    // }).then(({data}) => this.spec_categories = data.data.specCategories.map(i => i.id) )
  },
  methods: {
    manageTable(index, row)
    {
      this.setAttr('is_creating', false)

      this.$router.push(`/panel/specification/${row.id}`)
    },
    changeSelectedCategories() {
      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: 'categories',
        value: this.$refs.categories.getCheckedKeys()
      })
    },
    afterCreate()
    {
      setTimeout(() => this.$refs.categories.setCheckedKeys([]) , 100);
    },
    afterEdit(row)
    {
      setTimeout(() => this.$refs.categories.setCheckedKeys(
        row.categories.map(i => i.id)
      ), 100);
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
          field: 'categories',
          label: 'دسته بندی ها',
          icon: 'icon-time-alarm'
        }
      ]
    },
    allQuery() {
      return `
        title
        description
        categories {
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