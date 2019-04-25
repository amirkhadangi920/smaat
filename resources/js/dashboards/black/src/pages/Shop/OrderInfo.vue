<template>
  <div class="text-right" dir="rtl">
    <div class="row">
      <div class="col-12">
        <div class="text-right pull-right mb-3">
          <h2 class="animated bounceInRight delay-secound mb-0">
            <i class="tim-icons icon-puzzle-10" :style="{fontSize: '25px'}"></i>
            اطلاعات فاکتور <span class="text-muted">#{{ info.id }}</span>
          </h2>
          <h6 class="text-muted animated bounceInRight delay-last">تمام اطلاعات مربوط به این فاکتور را میتوانید در بخش های زیر مشاهده کنید</h6>
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
        <div class="col-12 text-right pull-right mb-3">
          <h3 class="animated bounceInRight delay-secound mb-0">
            <i class="tim-icons icon-single-02" :style="{fontSize: '25px'}"></i>
            اطلاعات مشتری
          </h3>
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
      </div>
      <div class="col-md-4">
        <div class="col-12 text-right pull-right mb-3">
          <h3 class="animated bounceInRight delay-secound mb-0">
            <i class="tim-icons icon-paper" :style="{fontSize: '25px'}"></i>
            اطلاعات سفارش
          </h3>
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
            {{ info.user.create_time }}
          </p>
          <p>
            <span class="text-muted">تاریخ آخرین ویرایش اطلاعات :</span>
            <span v-if="info.user.last_update_time !== info.user.create_time">{{ info.user.last_update_time }}</span>
            <span v-if="info.user.last_update_time === info.user.create_time" class="badge badge-warning">
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

        <div class="col-12 text-right pull-right mt-3 mb-3">
          <h3 class="animated bounceInRight delay-secound mb-0">
            <i class="tim-icons icon-delivery-fast" :style="{fontSize: '25px'}"></i>
            روش ارسال
          </h3>
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
      </div>  
      <div class="col-md-4">
        <div class="col-12">
          <el-timeline class="pull-right col-12">
            <el-timeline-item
              v-for="(status, index) in getDatetimes"
              :key="index"
              :color="getStatus(status.status).color"
            >
              <div :style="{ fontSize: '12px' }">
                <el-card>
                  <p class="text-muted hvr-icon-bob"><i class="tim-icons icon-check-2 text-info hvr-icon"></i> {{ status.time | timestampAgo }}</p>
                  <p>در وضعیت <span class="badge badge-primary" :style="{ background: getStatus(status.status).color }">{{ getStatus(status.status).title }}</span> قرار گرفت</p>
                </el-card>
              </div>
            </el-timeline-item>
          </el-timeline>
        </div>
      </div>    
    </div>

    <hr class="mb-3" />
    <div class="row">
      <div class="col-12">
        <ul class="data-table-header p-2 d-flex justify-content-center animated bounceInUp delay-second">
          <li 
            class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted"
            :style="{width: '40px'}"
          >#
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-badge hvr-icon"></i>
            محصول
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-caps-small hvr-icon"></i>
            تخفیف
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-refresh-02 hvr-icon"></i>
            مبلغ
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-refresh-02 hvr-icon"></i>
            تعداد
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-refresh-02 hvr-icon"></i>
            زمان ارسال
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-refresh-02 hvr-icon"></i>
            ویژگی ها
          </li>
          <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
            <i class="tim-icons icon-time-alarm hvr-icon"></i>
            افزودن
          </li>
        </ul>
        <md-empty-state
          v-show="info.items.length === 0"
          md-icon="search"
          md-label="هیچ پاسخی یافت نشد"
          :md-description="`تا کنون هیچ پاسخی برای این سفارش ثبت نشده است :(`">
        </md-empty-state>
        <ul class="animated bounceInUp delay-last" v-if="info.items.length !== 0">
          <li
            v-for="(row, index) of info.items" :key="index"
            class="data-table-row animated bounceInUp"
            :style="{ background: '#f9f9f9', animationDelay: `${500 + index * 100}ms` }"
          >
            <ul class="p-2 d-flex justify-content-center">
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
                {{ index + 1 }}
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                <img class="tilt" :src="row.photos ? row.photos.tiny : '/images/placeholder.png'" />
                {{ row.name }}
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.offer | comma }}  <span class="text-muted text-small mr-1" :style="{fontSize: '10px'}">تومان</span>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.price | price }}  <span class="text-muted text-small mr-1" :style="{fontSize: '10px'}">تومان</span>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.count | comma }} <span class="text-muted mr-1" :style="{fontSize: '10px'}"> {{ row.unit }}</span>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                {{ row.sending_time }} <span class="text-muted mr-1" :style="{fontSize: '10px'}"> روز</span>
              </li>
              <li class="data-table-cell p-2 text-center" >
                <div>
                  <span class="badge badge-info feature-data" :style="{ background: row.color.code }" v-if="row.color">
                    <i class="tim-icons icon-bank"></i>
                    رنگ {{ row.color.name }}
                  </span>
                </div>
                <div>
                  <span class="badge badge-info feature-data" v-if="row.size">
                    <i class="tim-icons icon-bank"></i>
                    سایز {{ row.size.name }}
                  </span>
                </div>
                <div>
                  <span class="badge badge-warning feature-data" v-if="row.warranty">
                    <i class="tim-icons icon-bank"></i>
                    گارانتی {{ row.warranty.title }}
                  </span>
                </div>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                <div :style="{ fontSize: '12px' }">
                  <el-tooltip :content="row.create_time | created" placement="left">
                    <p class="text-muted hvr-icon-bob"><i class="tim-icons icon-check-2 text-info hvr-icon"></i> {{ row.create_time | ago }}</p>
                  </el-tooltip>
                </div>
              </li>
            
              <span class="animation-circle" :class="`type${(index % 3) + 1}`"></span>
              <span class="animation-circle small" v-if="index % 3 !== 1" :class="`type${3 - (index % 3)}`"></span>
            </ul>
          </li>

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

      <div class="col-12" v-if="$store.state.shop.order_status.length !== 0">
        <base-button
          size="sm"
          v-for="item of $store.state.shop.order_status" 
          :key="item.id"
          :style="item.id !== info.status.id ? { color: item.color, borderColor: item.color } : {}"
          @click="changeStatus(item.id)"
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
import filtersHelper from '../../mixins/filtersHelper.js'
import 'owl.carousel/dist/assets/owl.carousel.css';
import _ from 'lodash'

export default {
  mixins: [
    filtersHelper
  ],
  data() {
    return {
      info: {
        user: {},
        method: {},
        items: []
      }
    }
  },
  mounted() {
    axios.get(`/api/v1/order/${this.$route.params.id}`).then( ({data}) => {
      this.info = data.data;
    }).catch( () => this.$router.push('/panel/order') )

    this.$store.dispatch('getData', {
      group: 'shop',
      type: 'order_status',
    })

    require('owl.carousel/dist/owl.carousel.js')
    setTimeout( () => $('.owl-carousel').owlCarousel({
      rtl:true,
      margin:10,
      nav:false,
      responsive:{
        0:    { items: 1 },
        600:  { items: 2 },
        1000: { items: 6 }
      }
    }), 200);
  },
  methods: {
    changeStatus(status) {
      axios({
        method: 'PUT',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('JWT')}`
        },
        url: `/api/v1/order/status/${this.info.id}/${status}`,
      }).then(({data}) => {
        this.info.status = this.getStatus(status)
        this.info.datetimes = data.data

        this.$notify({
          title: 'تغییر کرد',
          message: `وضعیت سفارش مورد نظر با موفقیت تغییر کرد :)`,
          timeout: 5000,
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
    
    getStatus(status) {
      let value = this.$store.state.shop.order_status.filter(item => item.id === status)

      return value.length !== 0 ? value[0] : { id: null, title: '', color: null }
    }
  },
  computed: {
    getDatetimes() {
      return _.take( _.reverse( this.info.datetimes ), 4 )
    }
  }
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
</style>
