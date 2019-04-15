<template>
  <datatable
    :type="type"
    :group="group"
    label="سفارش"
    :fields="getFields"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">

    <template v-slot:user-body="slotProps">
      <img class="tilt" :src="slotProps.row.user.avatar ? slotProps.row.user.avatar : '/images/placeholder-user.png'" />
      <p>{{ slotProps.row.user.full_name }}</p>
    </template>

    <template v-slot:shipping_cost-body="slotProps">
      <p>{{ slotProps.row.shipping_cost | price }}</p>
    </template>

    <template v-slot:offer-body="slotProps">
      <p>{{ slotProps.row.offer | price }}</p>
    </template>

    <template v-slot:total-body="slotProps">
      <p>{{ slotProps.row.total | price }}</p>
    </template>

    <template v-slot:final_total-body="slotProps">
      <p>{{ slotProps.row.final_total | price }}</p>
    </template>

    <template v-slot:status-body="slotProps">
      <span class="badge badge-default">{{ slotProps.row.status.title }}</span>
    </template>

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
    
    <template slot="modal" v-if="false">
      <slot></slot>

      <br v-if="has_logo" />
      <base-input :label="'لوگوی ' + label" v-if="has_logo">
        <el-upload
          class="avatar-uploader"
          action="/"
          :auto-upload="false"
          :show-file-list="false"
          :on-change="addImage">
          <img v-if="$store.state[group].selected[type].imageUrl" :src="$store.state[group].selected[type].imageUrl" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
        <small slot="helperText" id="emailHelp" class="form-text text-muted">لوگوی مورد نظر خود را انتخاب
          کنید</small>
      </base-input>
      <br />
      <base-input :label="'دسته بندی های ' + label">
        <el-tree
          dir="ltr"
          :data="$store.state.group.categories"
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
      </base-input>
      <small slot="helperText" id="emailHelp" class="form-text text-muted">برای انتخاب هر دسته بندی تیک قبل آن را انتخاب کنید</small>
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
import filtersHelper from '../../mixins/filtersHelper.js'
import tilt from 'tilt.js'
import {ElTree} from 'element-ui'

export default {
  components: {
    Datatable,
    BaseDropdown,
    ICountUp
  },
  mixins: [
    initDatatable,
    createMixin,
    filtersHelper
  ],
  data() {
    return {
        type: 'order',
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
        name: '',
        description: '',
        categories: [],
        imageFile: null,
        imageUrl: ''
      })

      this.$refs.categories.setCheckedKeys([]);

      this.setAttr('is_open', true)
      this.setAttr('is_creating', true)
    },
    edit(index, row) {
      let data = {};
    
      this.fields.forEach(field => {
        if ( ['logo', 'categories'].includes(field.field) ) return

        data[field.field] = row[field.field]
      });
      data.link = row.link
      data.index = index
      data.categories = row.categories.map( category => category.id )
      data.imageFile = null
      data.imageUrl = row.logo ? row.logo.small : ''

      this.$refs.categories.setCheckedKeys([]);

      this.setAttr('selected', data)

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
  computed: {
    getFields() {
      return [
        {
          field: 'user',
          label: 'خریدار',
          icon: 'icon-caps-small'
        }, {
          field: 'shipping_cost',
          label: 'هزینه ارسال',
          icon: 'icon-badge'
        }, {
          field: 'offer',
          label: 'تخفیف',
          icon: 'icon-badge'
        }, {
          field: 'total',
          label: 'جمع فاکتور',
          icon: 'icon-badge'
        }, {
          field: 'final_total',
          label: 'جمع نهایی',
          icon: 'icon-badge'
        }, {
          field: 'status',
          label: 'وضعیت',
          icon: 'icon-caps-small'
        },
      ]
    },
    
    // hasFilter() {
    //   return this.filter('query') != null 
    //       || this.filter('hasLogo') != null
    //       || this.filter('hasCategories') != null
    //       || this.filter('categories').length != 0
    // },
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
