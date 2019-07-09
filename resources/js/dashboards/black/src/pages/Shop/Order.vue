<template>
  <datatable
    :type="type"
    :group="group"
    :label="label"
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
      <table class="spec-feature-table">
        <tbody>
          <tr>
            <td>
              <img class="tilt" :src="slotProps.row.user.avatar ? slotProps.row.user.avatar.thumb : '/images/placeholder-user.png'" />
            </td>
            <td class="text-right">
              {{ slotProps.row.user.full_name || truncate(30) }}
            </td>
          </tr>
        </tbody>
      </table>
    </template>

    <template v-slot:offer-body="slotProps">
      <p v-if="slotProps.row.offer">{{ slotProps.row.offer | price }} <span class="text-muted text-small" :style="{fontSize: '10px'}">تومان</span></p>
      <span v-else class="badge badge-success">رایگان</span>
    </template>

    <template v-slot:final_total-body="slotProps">
      <p v-if="slotProps.row.final_total">{{ slotProps.row.final_total | price }} <span class="text-muted text-small" :style="{fontSize: '10px'}">تومان</span></p>
      <span v-else class="badge badge-success">رایگان</span>
    </template>

    <template v-slot:status-body="slotProps">
      <el-select
        class="order-status-select"
        v-if="slotProps.row.status"
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
          <div class="status-item" :style="{ borderRight: `7px solid ${item.color}` }">
            {{ item.title | truncate(50) }}
            <i v-if="item.icon" class="material-icons pull-left">{{ item.icon }}</i>
          </div>
        </el-option>
      </el-select>

      <span v-else class="badge badge-warning">
        نا مشخص :(
      </span>
    </template>

    <template #custom-operations="slotProps">
      <el-tooltip content="مشاهده اطلاعات">
        <base-button class="ml-2" @click="$router.push(`/panel/order/${slotProps.row.id}`)" type="success" size="sm" icon>
          <i class="tim-icons icon-paper"></i>
        </base-button>
      </el-tooltip>
    </template>
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
    Datatable,
  },
  mixins: [
    initDatatable,
    createMixin,
    filtersHelper
  ],
  metaInfo: {
    title: 'سفارشات',
  },
  data() {
    return {
      plural: 'orders',
      type: 'order',
      group: 'shop',
      label: 'سفارش',
    }
  },
  mounted() {
    this.$store.dispatch('getData', {
      group: 'shop',
      type: 'order_status',
      query: `order_statuses(per_page: 30) {
        data { id title color icon created_at updated_at }
        total trash chart { month count }
      }`
    })
  },
  methods: {
    changeStatus(index, status) {
      this.setAttr('is_query_loading', true)

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
        this.setAttr('is_query_loading', false)

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
      }).catch( error => {
        console.log(error)
        this.setAttr('is_query_loading', false)
      });
    },
  },
  computed: {
    getFields() {
      return [
        {
          field: 'user',
          label: 'خریدار',
          icon: 'icon-single-02'
        }, {
          field: 'offer',
          label: 'تخفیف',
          icon: 'icon-scissors'
        }, {
          field: 'final_total',
          label: 'جمع فاکتور',
          icon: 'icon-credit-card'
        }, {
          field: 'status',
          label: 'وضعیت',
          icon: 'icon-refresh-02'
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
  beforeRouteLeave(to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>

<style scope>
.order-status-select input {
  height: 30px !important;
}
.order-status-select .el-select__caret {
  line-height: 12px;
}

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
