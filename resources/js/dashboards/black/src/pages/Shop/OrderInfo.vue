<template>
  <div class="text-right" dir="rtl" :style="{ position: 'relative', zIndex: 10 }">
    <div class="row">
      <div class="col-12">
        <div class="text-right pull-right mb-3">
          <h2 class="animated bounceInRight delay-secound mb-0" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
            <i class="tim-icons icon-puzzle-10" :style="{fontSize: '25px'}"></i>
            اطلاعات فاکتور <span :style="{ color: '#ff3d3d' }">#{{ info.id }}</span>
          </h2>
          <h6 class="text-muted animated bounceInRight delay-secound">تمام اطلاعات مربوط به این فاکتور را میتوانید در بخش های زیر مشاهده کنید</h6>
        </div>

        <div class="pull-left">
          <base-button @click="$router.push('/panel/order')" size="sm" type="warning">
            بازگشت
            <i class="tim-icons icon-double-left ml-0"></i>
          </base-button>
        </div>
      </div>
    </div>
    <hr class="mt-0 mb-3"/>
    <div class="row">
      <div class="col-md-4">
        <card>
          <div class="col-12 text-right pull-right mb-3 card-header-out-effect user-info">
            <h4 class="animated bounceInRight delay-secound mb-0">
              <i class="tim-icons icon-single-02" :style="{fontSize: '25px'}"></i>
              اطلاعات مشتری
            </h4>
            <h6 class="text-muted animated bounceInRight delay-last">کلیه اطلاعات مشتری در این قسمت قرار میگیرد</h6>
          </div>
          <div class="col-12">
            <img :style="{ maxHeight: '100px'}" class="tilt mb-2" :src="info.user.avatar ? info.user.avatar.tiny : '/images/placeholder-user.png'" /><br/>
            <p><span class="text-muted">نام و نام خانوادگی :</span> {{ info.user.full_name }}</p>
            <p><span class="text-muted">آدرس ایمیل :</span> {{ info.user.email }}</p>
            <p>
              <span class="text-muted">آدرس :</span>
              {{ info.user.address }}
              <span v-if="!info.user.address" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">شماره تلفن ها :</span>
              <span v-if="!info.user.phnoes" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <ul v-if="info.user.phonse">
              <li v-for="(phone, index) of info.user.phonse" :key="index">{{phone.type}} : {{ phone.value }}</li>
            </ul>
            <p>
              <span class="text-muted">کد پستی :</span>
              {{ info.user.postal_code }}
              <span v-if="!info.user.postal_code" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">آخرین خرید :</span>
              {{ info.user.last_purchase }}
              <span v-if="!info.user.last_purchase" class="badge badge-warning">تا کنون خریدی انجام نشده</span>
            </p>
            <p><span class="text-muted">رید :</span> {{ info.user.purchase_counts }} مرتبه</p>
            <p><span class="text-muted">مجموع دریافتی :</span> {{ info.user.total_payments }} تومان</p>
          </div>
        </card>
      </div>
      <div class="col-md-4">
        <card>
          <div class="col-12 text-right pull-right mb-3 card-header-out-effect order-info">
            <h4 class="animated bounceInRight delay-secound mb-0">
              <i class="tim-icons icon-paper" :style="{fontSize: '25px'}"></i>
              اطلاعات سفارش
            </h4>
            <h6 class="text-muted animated bounceInRight delay-last">کلیه اطلاعات سفارش در این قسمت قرار میگیرد</h6>
          </div>
          <div class="col-12">
            <p>
              <span class="text-muted">شناسه پرداخت :</span>
              {{ info.user.auth_code }}
              <span v-if="!info.user.auth_code" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">کد رهگیری :</span>
              {{ info.user.payment_code }}
              <span v-if="!info.user.payment_code" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">آدرس مقصد :</span>
              {{ info.user.destination }}
              <span v-if="!info.user.destination" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">کد پستی :</span>
              {{ info.user.postal_code }}
              <span v-if="!info.user.postal_code" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">تاریخ ثبت سفارش :</span>
              {{ info.user.created_at }}
            </p>
            <p>
              <span class="text-muted">تاریخ آخرین ویرایش اطلاعات :</span>
              <span v-if="info.user.updatet_at !== info.user.created_at">{{ info.user.updatet_at }}</span>
              <span v-if="info.user.updatet_at === info.user.created_at" class="badge badge-warning">
                تاکنون تغییری صورت نگرفته
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">تاریخ پرداخت :</span>
              {{ info.user.paid_at }}
              <span v-if="!info.user.paid_at" class="badge badge-danger">
                پرداخت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
          </div>
        </card>

        <card>
          <div class="col-12 text-right pull-right mb-3 card-header-out-effect shipping-method">
            <h4 class="animated bounceInRight delay-secound mb-0">
              <i class="tim-icons icon-delivery-fast" :style="{fontSize: '25px'}"></i>
              روش ارسال
            </h4>
            <h6 class="text-muted animated bounceInRight delay-last">کلیه اطلاعات درباره روش ارسال در این قسمت قرار میگیرد</h6>
          </div>
          <div class="col-12">
            <p>
              <span class="text-muted">روش ارسال :</span>
              {{ info.method.name }} 
              <span v-if="!info.method.name" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">هزینه ارسال :</span>
              {{ info.method.cost | price }} <span class="text-muted" v-if="info.method.cost">تومان</span> 
              <span v-if="!info.method.cost" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
          </div>
        </card>
      </div>  
      <div class="col-md-4">
        <div class="col-12">
          <el-timeline class="pull-right col-12">
            <el-timeline-item
              v-for="(status, index) in info.status_changes.filter((item, index) => index < 5)"
              :key="index"
              :color="status.color"
            >
              <div :style="{ fontSize: '12px' }">
                <el-card>
                  <p class="text-muted hvr-icon-bob" :title="status.changed_at | time('تغییر یافته')">
                    <i class="tim-icons icon-check-2 text-info hvr-icon"></i>
                    {{ status.changed_at | ago }}
                    </p>
                  <p>در وضعیت <span class="badge badge-primary" :style="{ background: status.color }">{{ status.title }}</span> قرار گرفت</p>
                </el-card>
              </div>
            </el-timeline-item>
          </el-timeline>
        </div>
      </div>    
    </div>

    <hr class="mb-3" />
    <div class="row">
      <base-table
        class="w-100"
        :tableData="info.items"
        type="order"
        group="shop"
        label="سفارش"
        :fields="[
          {
            field: 'product',
            label: 'محصول',
            icon: 'icon-single-copy-04'
          }, {
            field: 'offer',
            label: 'تخفیف',
            icon: 'icon-single-copy-04'
          }, {
            field: 'price',
            label: 'مبلغ',
            icon: 'icon-single-copy-04'
          }, {
            field: 'count',
            label: 'تعداد',
            icon: 'icon-single-copy-04'
          }, {
            field: 'sending_time',
            label: 'زمان ارسال',
            icon: 'icon-single-copy-04'
          }, {
            field: 'features',
            label: 'ویژگی ها',
            icon: 'icon-single-copy-04'
          },
        ]"
        :methods="{}"
        
        :has_loaded="true"
        :is_grid_view="false"
        :has_times="false"
        :has_operation="false"
      >
        <template #product-body="props">
          <img class="tilt" :src="props.row.variation.product.photos ? props.row.variation.product.photos.tiny : '/images/placeholder.png'" />
          {{ props.row.variation.product.name }}
        </template>

        <template #offer-body="props">
          {{ props.row.offer | comma }}  <span class="text-muted text-small mr-1" :style="{fontSize: '10px'}">تومان</span>
        </template>

        <template #price-body="props">
          {{ props.row.price | comma }}  <span class="text-muted text-small mr-1" :style="{fontSize: '10px'}">تومان</span>
        </template>
        
        <template #count-body="props">
          {{ props.row.count | comma }} <span class="text-muted mr-1" :style="{fontSize: '10px'}"> {{ props.row.variation.product.unit.title }}</span>
        </template>
        
        <template #sending_time-body="props">
          {{ props.row.variation.sending_time }} <span class="text-muted mr-1" :style="{fontSize: '10px'}"> روز</span>
        </template>
        
        <template #features-body="props">
          <div>
            <div>
              <span class="badge badge-info feature-data" :style="{ background: props.row.variation.color.code }" v-if="props.row.variation.color">
                <i class="tim-icons icon-bank"></i>
                رنگ {{ props.row.variation.color.name }}
              </span>
            </div>
            <div>
              <span class="badge badge-info feature-data" v-if="props.row.variation.size">
                <i class="tim-icons icon-bank"></i>
                سایز {{ props.row.variation.size.name }}
              </span>
            </div>
            <div>
              <span class="badge badge-warning feature-data" v-if="props.row.variation.warranty">
                <i class="tim-icons icon-bank"></i>
                گارانتی {{ props.row.variation.warranty.title }}
              </span>
            </div>
          </div>
        </template>
      </base-table>

      <div class="col-12" v-if="false">
        <ul class="animated bounceInUp delay-last" v-if="info.items.length !== 0">
          <li
            class="detail-header animated bounceInUp"
            :style="{ background: '#f9f9f9', animationDelay: `${1000}ms` }"
          >
            <ul class="p-2 d-flex justify-content-center">
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-end" >
                جمع فاکتور :
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-start" >
                {{ info.total | price }}  <span v-if="info.total" class="text-muted mr-2">تومان</span>
              </li>
            </ul>
          </li>
          <li
            class="detail-header animated bounceInUp"
            :style="{ background: '#f9f9f9', animationDelay: `${1100}ms` }"
          >
            <ul class="p-2 d-flex justify-content-center">
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-end" >
                هزینه ارسال :
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-start" >
                {{ info.shipping_cost | price }}  <span v-if="info.shipping_cost" class="text-muted mr-2">تومان</span>
              </li>
            </ul>
          </li>
          <li
            class="detail-header animated bounceInUp"
            :style="{ background: '#f9f9f9', animationDelay: `${1200}ms` }"
          >
            <ul class="p-2 d-flex justify-content-center">
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-end" >
                تخفیف سفارش :
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-start" >
                {{ info.offer | price }}  <span v-if="info.offer" class="text-muted mr-2">تومان</span>
              </li>
            </ul>
          </li>
          <li
            class="detail-header animated bounceInUp"
            :style="{ background: '#f9f9f9', animationDelay: `${1300}ms` }"
          >
            <ul class="p-2 d-flex justify-content-center">
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-end" >
                جمع نهایی :
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-start" >
                {{ info.final_total | price }}  <span v-if="info.final_total" class="text-muted mr-2">تومان</span>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    
    <div class="row">
      <div class="col-12 text-right pull-right mb-3">
        <h3 class="animated bounceInRight delay-secound mb-0">
          <i class="tim-icons icon-refresh-02" :style="{fontSize: '25px'}"></i>
          تغییر وضعیت سفارش
        </h3>
        <h6 class="text-muted animated bounceInRight delay-last">با کلیک بر رو هر دکمه میتوانید وضعیت سفارش را تغییر دهید</h6>
      </div>

      <div class="col-12">
        <base-button
          size="sm"
          v-for="item of $store.state.shop.order_status" 
          :key="item.id"
          @click="changeStatus(item.id)"
          :style="item.id !== info.status.id ? { color: item.color, borderColor: item.color } : {}"
          :simple="item.id !== info.status.id" 
          type="default"
        >
          {{ item.title }}
        </base-button>
      </div>
    </div>
  </div>
</template>

<script>
import BaseTable from '../../components/BaseTable'
import filtersHelper from '../../mixins/filtersHelper.js'
import 'owl.carousel/dist/assets/owl.carousel.css';
import _ from 'lodash'
import moment from 'moment'

export default {
  mixins: [
    filtersHelper
  ],
  components: { BaseTable },
  data() {
    return {
      info: {
        user: {},
        method: {},
        status: {},
        status_changes: [],
        items: []
      }
    }
  },
  mounted()
  {
    axios.get('/graphql/auth', {
      params: {
        query: `{
          order (id: "${this.$route.params.id}") {
            id
            destination
            phone_number
            coordinates { lat lng }
            postal_code
            offer
            total
            shipping_cost
            paid_at created_at updated_at
            status: order_status { id title color }
            status_changes { id title color changed_at }
            method: shipping_method { id name cost }
            city { id name }
            user {
              id
              first_name last_name full_name
              email
              phones { id type phone_number }
              addresses { id type address postal_code }
              avatar { tiny }
              national_code
            }
            items {
              id
              count
              price
              offer
              variation {
                id
                inventory
                sending_time
                color { id name code }
                size { id name }
                warranty { id title expire }
                product { 
                  id name photos { tiny }
                  unit { id title }
                }
              }
            }
          }
        }`
      }
    })
    .then( ({data}) => {
      this.info = data.data.order;
    })
    .catch( () => this.$router.push('/panel/order') )

    this.$store.dispatch('getData', {
      group: 'shop',
      type: 'order_status',
      query: `order_statuses(per_page: 30) { data { id title color } }`
    })
  },
  methods: {
    changeStatus(status)
    {
      var selected_status = this.$store.state.shop.order_status.filter(item => item.id === status)[0];

      axios.post('/graphql/auth', {
        query: `mutation {
          changeOrderStatus(id: "${this.$route.params.id}", status: ${selected_status.id}) {
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

        this.info.status = selected_status
        this.info.updated_at = moment().format('YYYY-MM-DD HH:mm:ss')
        this.info.status_changes = [{
          id: selected_status.id,
          color: selected_status.color,
          title: selected_status.title,
          changed_at: moment().format('YYYY-MM-DD HH:mm:ss')
        }, ...this.info.status_changes]
        
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
    
    getStatus(status) {
      let value = this.$store.state.shop.order_status.filter(item => item.id === status)

      return value.length !== 0 ? value[0] : { id: null, title: '', color: null }
    }
  },
}
</script>

<style scope>
.feature-data {
  /* display: block !important; */
  margin-bottom: 7px;
  padding: 5px;
}
.el-card__body {
  padding: 5px 10px !important;
}
.owl-stage-outer {
  padding: 0px;
}
.detail-header {
  float: right;
  width: 50%;
  background: transparent !important;
}
.detail-header li {
  width: 50%;
  text-align: left !important;
}
.detail-header li:last-of-type {
  width: 50%;
  text-align: right !important;
}
.card-header-out-effect {
  padding: 10px;
  margin-top: -35px !important;
  border-radius: 5px;
}
.card-header-out-effect h4 {
  font-weight: bold;
  color: #fff !important;
}
.card-header-out-effect h6 {
  color: #efefef !important;
}
.card-header-out-effect.user-info {
  background: linear-gradient(to bottom right, #fe8c00, #f83600) !important;
  box-shadow: 0px 5px 30px -10px #f83600, 0px 3px 30px -14px #000;
}
.card-header-out-effect.order-info {
  background: linear-gradient(to bottom right, #ED213A, #93291E) !important;
  box-shadow: 0px 5px 30px -10px #93291E, 0px 3px 30px -14px #000;
}
.card-header-out-effect.shipping-method {
  background: linear-gradient(to bottom right, #409eff, #087df0) !important;
  box-shadow: 0px 5px 30px -10px #087df0, 0px 3px 30px -14px #000;
}
</style>
