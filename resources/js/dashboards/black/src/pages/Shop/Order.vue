<template>
  <datatable
    :type="type"
    :group="group"
    label="سفارش"
    :fields="getFields"
    :canEdit="false"
    :canCreate="false"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">

    <template v-slot:user-body="slotProps">
      <img class="tilt" :src="slotProps.row.user.avatar ? slotProps.row.user.avatar.thumb : '/images/placeholder-user.png'" />
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
        :disabled="can('change-status-order')"
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
        <base-button class="ml-2" @click="$router.push(`/panel/order/${slotProps.row.id}`)" type="success" size="sm" icon>
          <i class="tim-icons icon-paper"></i>
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
      plural: 'orders',
      type: 'order',
      group: 'shop',
    }
  },
  mounted() {
    this.$store.dispatch('getData', {
      group: 'shop',
      type: 'order_status',
      query: `order_statuses(per_page: 30) { data { id title color } }`
    })
  },
  methods: {
    changeStatus(index, status) {
      var selected_status = this.$store.state.shop.order_status.filter(item => item.id === status)[0];

      axios.post('/graphql/auth', {
        query: `mutation {
          changeOrderStatus(id: "${this.data()[index].id}", status: ${selected_status.id}) {
            status
            message
          }
        }`
      })
      .then(({data}) => {

        if ( data.data.changeOrderStatus.status === 400 )
        {
          this.$notify({
            title: 'خطا',
            message: `متاسفانه وضعیت سفارش مورد نظر تغییری نکرد :)`,
            timeout: 3000,
            type: 'danger',
            verticalAlign: 'top',
            horizontalAlign: 'left',
          })
        }

        this.data()[index].status.color = selected_status.color;
        this.data()[index].status.title = selected_status.title;
        this.data()[index].updated_at = moment().format('YYYY-MM-DD HH:mm:ss');
        this.setData( this.data() )
        
        this.$notify({
          title: 'تغییر کرد',
          message: `وضعیت سفارش مورد نظر با موفقیت به ${selected_status.title} تغییر کرد :)`,
          timeout: 1500,
          type: 'success',
          verticalAlign: 'top',
          horizontalAlign: 'left',
        })
      }).catch( error => console.log(error) );
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
    },

    allQuery() {
      return `
        user {
          id
          first_name
          last_name
          full_name
          avatar { id file_name thumb }
        }
        offer
        total
        status: order_status {
          id
          title
          color
        }`
    },
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
  padding-left: 0px;
  padding-right: 10px !important;
}
.el-input__suffix {
  right: auto;
  left: 5px;
}
</style>
