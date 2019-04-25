<template>
  <datatable
    :type="type"
    :group="group"
    label="محصول"
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
    
    <template v-slot:photos-body="slotProps">
      <img class="tilt" :src="slotProps.row.photos ? slotProps.row.photos.tiny : '/images/placeholder.png'" />
    </template>

    <template v-slot:brand-body="slotProps">
      <a href="#">{{ slotProps.row.brand.name }}</a>
    </template>

    <template v-slot:category-body="slotProps">
      <a href="#">{{ slotProps.row.category.title }}</a>
    </template>

    <template v-slot:votes-body="slotProps">
      <div :style="{ fontSize: '12px' }">
        <el-tooltip :content="slotProps.row.votes.dislikes + ' بار پسندیده شده'" placement="left">
          <p class="text-muted hvr-icon-bob" :style="{display: 'block'}"><i class="tim-icons icon-heart-2 text-default hvr-icon"></i> {{ slotProps.row.votes.dislikes }}</p>
        </el-tooltip>

        <el-tooltip :content="slotProps.row.votes.dislikes + ' بار نسپندیده شده'" placement="left">
          <p class="text-muted hvr-icon-hang"><i class="tim-icons icon-heart-2 text-danger hvr-icon"></i> {{ slotProps.row.votes.likes }}</p>
        </el-tooltip>
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

export default {
  components: {
    Datatable,
    BaseDropdown,
    ICountUp
  },
  mixins: [
    initDatatable,
    createMixin,
  ],
  data() {
    return {
        type: 'product',
        group: 'product',

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
      this.$router.push('/panel/product/create')
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
          field: 'photos',
          label: 'تصویر محصول',
          icon: 'icon-badge'
        }, {
          field: 'name',
          label: 'نام محصول',
          icon: 'icon-badge'
        }, {
          field: 'brand',
          label: 'برند',
          icon: 'icon-caps-small'
        }, {
          field: 'category',
          label: 'دسته بندی',
          icon: 'icon-caps-small'
        }, {
          field: 'label',
          label: 'لیبل',
          icon: 'icon-caps-small'
        }, {
          field: 'votes',
          label: 'نظرات',
          icon: 'icon-heart-2'
        }
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
