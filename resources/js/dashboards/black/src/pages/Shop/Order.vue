<template>
  <datatable
    :type="type"
    :group="group"
    label="سفارش"
    :fields="getFields"
    :canSearch="false"
    
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

    <template v-slot:offer-body="slotProps">
      <p>{{ slotProps.row.offer | price }} <span class="text-muted text-small" :style="{fontSize: '10px'}">تومان</span></p>
    </template>

    <template v-slot:final_total-body="slotProps">
      <p>{{ slotProps.row.final_total | price }} <span class="text-muted text-small" :style="{fontSize: '10px'}">تومان</span></p>
    </template>

    <template v-slot:status-body="slotProps">
      <el-select
        :disabled="can('change-order-status')"
        @change="changeStatus(slotProps.index, $event)"
        v-model="slotProps.row.status.id"
        :style="{ borderColor: slotProps.row.status.color }"
        placeholder="تغییر روش ارسال"
      >
        <el-option
          v-for="item in $store.state.shop.order_status"
          :key="item.id"
          :label="item.title"
          :value="item.id"
        >
          <div class="status-item" :style="{ borderLeft: `7px solid ${item.color}` }">
            {{ item.title }}
          </div>
        </el-option>
      </el-select>
    </template>

    <template #custom-operations="slotProps">
      <el-tooltip content="مشاهده اطلاعات">
        <base-button simple class="ml-2" @click="$router.push(`/panel/order/${slotProps.row.id}`)" type="info" size="sm" icon>
          i
        </base-button>
      </el-tooltip>
    </template>

    <template slot="filter-labels"></template>
    <template slot="modal"></template>
  </datatable>
</template>

<script>
import {BaseDropdown} from '../../components'
import Datatable from '../../components/BaseDatatable.vue'
import ICountUp from 'vue-countup-v2';
import tilt from 'tilt.js'

import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'
import filtersHelper from '../../mixins/filtersHelper.js'

import moment from 'moment'

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
    }
  },
  mounted() {
    this.$store.dispatch('getData', {
      group: 'shop',
      type: 'order_status',
    })
  },
  created() {
    setTimeout( () => $('.tilt').tilt({scale: 1.1}) ,300)
    setTimeout( () => $('.tilt-fixed').tilt() ,300)
  },
  methods: {
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

    changeStatus(index, status) {
      var selected_status = this.$store.state.shop.order_status.filter(item => item.id === status)[0];

      axios({
        method: 'PUT',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('JWT')}`
        },
        url: `/api/v1/order/status/${this.data()[index].id}/${selected_status.id}`,
      }).then(({data}) => {
        this.data()[index].status = selected_status;
        this.data()[index].last_update_time = moment().format('YYYY-MM-DD HH:mm:ss');
        this.setData( this.data() )
        
        this.$notify({
          title: 'تغییر کرد',
          message: `وضعیت سفارش مورد نظر با موفقیت به ${selected_status.title} تغییر کرد :)`,
          timeout: 1500,
          type: 'success',
          verticalAlign: 'top',
          horizontalAlign: 'left',
        })
      }).catch( error => console.log(error.response) );
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
          field: 'user',
          label: 'خریدار',
          icon: 'icon-caps-small'
        }, {
          field: 'offer',
          label: 'تخفیف',
          icon: 'icon-badge'
        }, {
          field: 'final_total',
          label: 'جمع فاکتور',
          icon: 'icon-badge'
        }, {
          field: 'status',
          label: 'وضعیت',
          icon: 'icon-caps-small'
        },
      ]
    }
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>

<style scope>
.el-select {
  border-radius: 5px;
  border: 1.5px solid rgb(211, 211, 211);
  transition: border-color 300ms;
}
.el-select-dropdown__item {
  padding: 0px;
}
.status-item {
  text-align: right;
  padding: 0px 10px;
}
.el-input {
  min-width: 140px;
}
.el-input__inner {
  border-color: transparent !important;
  font-weight: bold;
}
</style>
