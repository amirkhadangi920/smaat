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
    ref="datatable"
  >

    <template slot="filter-labels"></template>
    
    <template v-slot:photos-body="slotProps">
      <div>
        <img class="tilt" :src="slotProps.row.photos && slotProps.row.photos.length !== 0 ? slotProps.row.photos[0].thumb : '/images/placeholder.png'" />
        <span v-if="!slotProps.row.is_active" :style="{ marginTop: '-50%', background: '#f13b3bc7' }" class="d-block position-relative badge badge-danger">پیش نویس</span>
      </div>
    </template>

    <template v-slot:brand-body="slotProps">
      {{ slotProps.row.brand ? slotProps.row.brand.name : '' }}
    </template>

    <template v-slot:categories-body="slotProps">
      <transition-group name="list">
        <el-popover
          v-for="item in slotProps.row.categories.filter( (i, index) => index < 3)"
          :key="item.id"
          placement="top-end"
          width="300"
          trigger="hover"
          :disabled="typeof item.title === 'string' ? item.title.length <= 20 : false"
          :content="item.title"
        >
          <span
            slot="reference"
            class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
            <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
            {{ item.title | truncate(20) }}
          </span>
        </el-popover>

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
import Datatable from '../../components/BaseDatatable.vue'

import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'

export default {
  components: {
    Datatable
  },
  mixins: [
    initDatatable,
    createMixin,
  ],
  metaInfo: {
    title: 'محصولات',
  },
  data() {
    return {
        type: 'product',
        plural: 'products',
        group: 'product',
        label: 'محصول',

        defaultProps: {
          children: 'childs',
          label: 'title',
        },
    }
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
          icon: 'icon-image-02'
        }, {
          field: 'name',
          label: 'نام محصول',
          icon: 'icon-caps-small'
        }, {
          field: 'brand',
          label: 'برند',
          icon: 'icon-atom'
        }, {
          field: 'categories',
          label: 'دسته بندی',
          icon: 'icon-components'
        }, {
          field: 'votes',
          label: 'نظرات',
          icon: 'icon-heart-2'
        }
      ]
    },
    
    allQuery() {
      return `
        name
        is_active
        photos {
          id
          file_name
          thumb
        }
        brand {
          name
        }
        categories {
          id
          title
        }
        votes {
          likes
          dislikes
        }`
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
