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
    create() {
      this.setAttr('is_creating', true)
      this.$router.push('/panel/product/create')
    },
    edit(index, row) {
      this.setAttr('is_creating', false)
      this.$router.push(`/panel/product/${row.id}/edit`)
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
