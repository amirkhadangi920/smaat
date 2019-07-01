<template>
  <datatable
    :type="type"
    :group="group"
    label="تخفیف"
    :fields="getFields"
    :canSearch="false"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">


    <template v-slot:logo-body="slotProps">
      <img class="tilt" :src="slotProps.row.logo ? slotProps.row.logo.thumb : '/images/placeholder.png'" />
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

    <template v-slot:times-body="slotProps">
      <div :style="{ fontSize: '12px' }">
        <el-tooltip :content="slotProps.row.started_at | time('شروع شده')" placement="left">
          <p class="text-muted hvr-icon-bob"><i class="tim-icons icon-watch-time text-info hvr-icon"></i> {{ slotProps.row.started_at | ago }}</p>
        </el-tooltip>

        <el-tooltip :content="slotProps.row.expired_at | time('پایان یافته')" placement="left">
          <p class="text-muted hvr-icon-hang"><i class="tim-icons icon-button-pause text-warning hvr-icon"></i> {{ slotProps.row.expired_at | ago }}</p>
        </el-tooltip>
      </div>
    </template>

    <template #custom-operations="slotProps"></template>

    <template slot="filter-labels"></template>
  </datatable>
</template>

<script>
import Datatable from '../../components/BaseDatatable.vue'

import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'
import filtersHelper from '../../mixins/filtersHelper.js'

import moment from 'moment'

export default {
  components: {
    Datatable
  },
  mixins: [
    initDatatable,
    createMixin,
    filtersHelper
  ],
  data() {
    return {
      plural: 'discounts',
      type: 'discount',
      group: 'shop',
    }
  },
  methods: {
    create() {
      this.setAttr('is_creating', true)
      this.$router.push('/panel/discount/create')
    },
    edit(index, row) {
      this.setAttr('is_creating', false)
      this.$router.push(`/panel/discount/${row.id}/edit`)
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
  },
  computed: {
    getFields() {
      return [
        {
          field: 'logo',
          label: 'لوگو',
          icon: 'icon-caps-small'
        }, {
          field: 'title',
          label: 'عنوان',
          icon: 'icon-badge'
        }, {
          field: 'categories',
          label: 'دسته بندی ها',
          icon: 'icon-badge'
        }, {
          field: 'times',
          label: 'شروع / پایان',
          icon: 'icon-caps-small'
        },
      ]
    },
    allQuery() {
      return `
        title
        started_at
        expired_at
        categories {
          id
          title
        }
        logo {
          id
          file_name
          thumb
        }`
    },
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>
