<template>
  <div class="text-right" dir="rtl" :style="{ position: 'relative', zIndex: 10 }">
    
    <div class="row">
      <div class="col-12">
        <div class="text-right pull-right mb-3">
          <h2 class="animated bounceInRight delay-secound mb-0" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
            <i class="header-nav-icon tim-icons icon-puzzle-10" :style="{fontSize: '25px'}"></i>
            اطلاعات فاکتور <span :style="{ color: '#ff3d3d' }">#{{ info.id }}</span>
          </h2>
          <h6 class="header-description animated bounceInRight delay-secound">تمام اطلاعات مربوط به این فاکتور را میتوانید در بخش های زیر مشاهده کنید</h6>
        </div>

        <div class="pull-left">
          <base-button :style="{ position: 'relative', zIndex: 100 }" @click.once="$router.push('/panel/order')" size="sm" type="warning">
            بازگشت
            <i class="tim-icons icon-double-left ml-0"></i>
          </base-button>
        </div>
      </div>
    </div>

    <div class="row" v-if="this.info.coordinates && this.info.coordinates.lat">
      <l-map
        ref="map"
        style="height: 300px; width: 100%"
        :options="{
          key: 'web.8HU2Ho1RdkaEAT79wJPPdc1ddkgRH0iPIcSqBThP'
        }"
        :zoom="zoom"
        :center="[info.coordinates.lat, info.coordinates.lng]"
        :zoomAnimation="true"
        :zoomAnimationThreshold="10"
        :fadeAnimation="true"
        :markerZoomAnimation="true"
        :noBlockingAnimations="true"
        @update:zoom="zoomUpdated"
        @update:center="centerUpdated"
        @update:bounds="boundsUpdated"
      >
        <l-tile-layer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></l-tile-layer>
        <l-marker :lat-lng="[info.coordinates.lat, info.coordinates.lng]">
          <l-icon
            :icon-size="[40, 50]"
            :icon-anchor="[20, 50]"
            icon-url="/location_marker.svg" >
          </l-icon>   
        </l-marker>
        <l-circle-marker ref="location" :lat-lng="location" v-if="location" :radius="8" color="#0043ff" />
        <l-control position="bottomright">
          <el-tooltip content="موقعیت من">
            <base-button @click="location ? $refs.map.setCenter({ lat: location[0], lng: location[1] }) : false" class="pt-2" type="success" size="sm" icon round>
              <i class="material-icons m-0 hvr-icon" :style="{ paddingTop: '5px' }">my_location</i>
            </base-button>
          </el-tooltip>

          <el-tooltip content="موقعیت سفارش">
            <base-button @click="$refs.map.setCenter({ lat: info.coordinates.lat, lng: info.coordinates.lng })" class="pt-2" type="warning" size="sm" icon round>
              <i class="material-icons m-0 hvr-icon">local_shipping</i>
            </base-button>
          </el-tooltip>
        </l-control>

        <l-control position="bottomleft">
          <span class="badge badge-danger" v-if="info.postal_code">
            {{ info.postal_code }}
            <i class="material-icons">confirmation_number</i>
          </span>

          <span class="badge badge-warning" v-if="info.destination">
            <i class="material-icons">place</i>
            {{ info.destination }}
          </span>
        </l-control>
      </l-map>
    </div>

    <div class="row  mt-4">
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
            <img :style="{ maxHeight: '100px'}" class="tilt mb-2" :src="info.user.avatar ? info.user.avatar.thumb : '/images/placeholder-user.png'" /><br/>
            <p><span class="text-muted">نام و نام خانوادگی :</span> {{ info.user.full_name }}</p>
            <p><span class="text-muted">آدرس ایمیل :</span> {{ info.user.email }}</p>
            <p><span class="text-muted">کد ملی :</span> {{ info.user.national_code }}</p>
            <p><span class="text-muted">جنسیت :</span>
              <span class="badge badge-default">{{ info.user.gender === null ? 'نا مشخص' : info.user.gender ? 'مذکر' : 'مونث' }}</span>
            </p>
            <p>
              <span class="text-muted">آخرین خرید :</span>
              {{ info.user.last_purchase }}
              <span v-if="!info.user.last_purchase" class="badge badge-warning">تا کنون خریدی انجام نشده</span>
            </p>
            <p>
              <span class="text-muted">تعداد دفعات خرید :</span>
              <span v-if="!info.user.purchase_counts" class="badge badge-warning">تا کنون خریدی انجام نشده</span>
              <span v-else>{{ info.user.purchase_counts }} مرتبه</span>
            </p>
            <p>
              <span class="text-muted">مجموع دریافتی :</span>
              <span v-if="!info.user.total_payments" class="badge badge-warning">تا کنون خریدی انجام نشده</span>
              <span v-else>{{ info.user.total_payments }} تومانمرتبه</span>
            </p>
          </div>
        </card>

        <card>
          <div class="col-12 text-right pull-right mb-3 card-header-out-effect user-phones">
            <h4 class="animated bounceInRight delay-secound mb-0">
              <i class="tim-icons icon-mobile" :style="{fontSize: '25px'}"></i>
              شماره تلفن ها
            </h4>
            <h6 class="text-muted animated bounceInRight delay-last">کلیه شماره تلفن های مشتری</h6>
          </div>
          <div class="col-12" v-if="info.user.phones.length">
            <table class="w-100 text-center">
              <thead>
                <tr>
                  <th>نوع</th>
                  <th>شماره</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="phone in info.user.phones" :key="phone.id">
                  <td>{{ phone.type }}</td>
                  <td>{{ phone.phone_number }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="alert alert-warning pull-right m-0" v-else>این مشتری شماره تلفنی تا کنون ثبت نکرده است :(</div>
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
              {{ info.auth_code }}
              <span v-if="!info.auth_code" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">کد رهگیری :</span>
              {{ info.payment_code }}
              <span v-if="!info.payment_code" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">آدرس مقصد :</span>
              {{ info.destination }}
              <span v-if="!info.destination" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">کد پستی :</span>
              {{ info.postal_code }}
              <span v-if="!info.postal_code" class="badge badge-warning">
                ثبت نشده
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">تاریخ ثبت سفارش :</span>
              {{ info.created_at }}
            </p>
            <p>
              <span class="text-muted">تاریخ آخرین ویرایش اطلاعات :</span>
              <span v-if="info.updatet_at !== info.created_at">{{ info.updatet_at }}</span>
              <span v-if="info.updatet_at === info.created_at" class="badge badge-warning">
                تاکنون تغییری صورت نگرفته
                <i class="tim-icons icon-simple-remove ml-0"></i>
              </span>
            </p>
            <p>
              <span class="text-muted">تاریخ پرداخت :</span>
              {{ info.paid_at }}
              <span v-if="!info.paid_at" class="badge badge-danger">
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
          <div class="col-12" v-if="info.method">
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
          <div class="alert alert-warning pull-right m-0" v-else>وضعیت سفارش هنوز مشخص نشده است :(</div>
        </card>
      </div>  
      <div class="col-md-4">
        <div class="col-12">
          <el-timeline class="pull-right col-12">
            <el-timeline-item
              v-for="(status, index) in info.status_changes.filter((item, index) => index < 6)"
              :key="index"
              :color="status.color"
            >
              <div :style="{ fontSize: '12px' }">
                <el-card>
                  <p class="text-muted hvr-icon-bob" :title="status.changed_at | time('تغییر یافته')">
                    <i class="tim-icons icon-check-2 text-info hvr-icon"></i>
                    {{ status.changed_at | ago }}
                    </p>
                  <p>
                    در وضعیت
                    <span class="badge badge-primary" :style="{ background: status.color }">
                      <i class="material-icons">{{ status.icon }}</i>
                      {{ status.title | truncate(50) }}
                    </span>
                    قرار گرفت
                  </p>
                </el-card>
              </div>
            </el-timeline-item>
          </el-timeline>

          <md-empty-state
            v-if="info.status_changes.length === 0"
            md-icon="track_changes"
            md-label="عدم تغییر وضعیت"
            md-description="وضعیت این سفارش تاکنون هیچ تغییری نداشته است :(">
            <!-- <md-button class="md-primary md-raised">Create first project</md-button> -->
          </md-empty-state>
        </div>
      </div>    
    </div>
    <hr class="mb-3" />

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
          :style="item.id !== (info.status ? info.status.id : null ) ? { color: item.color, borderColor: item.color } : { background: item.color }"
          :simple="item.id !== (info.status ? info.status.id : null )" 
          type="default"
        >
          <i v-if="item.icon" class="material-icons">{{ item.icon }}</i>
          {{ item.title | truncate(50) }}
        </base-button>
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
        :canSelect="false"
        :fields="[
          {
            field: 'product',
            label: 'محصول',
            icon: 'icon-basket-simple'
          }, {
            field: 'offer',
            label: 'تخفیف',
            icon: 'icon-scissors'
          }, {
            field: 'price',
            label: 'مبلغ',
            icon: 'icon-coins'
          }, {
            field: 'count',
            label: 'تعداد',
            icon: 'icon-chart-pie-36'
          }, {
            field: 'sending_time',
            label: 'زمان ارسال',
            icon: 'icon-delivery-fast'
          }, {
            field: 'features',
            label: 'ویژگی ها',
            icon: 'icon-molecule-40'
          },
        ]"
        :methods="{}"
        
        :has_loaded="true"
        :is_grid_view="false"
        :has_times="false"
        :has_operation="false"
      >
        <template #product-body="props">
          <img class="tilt" :src="props.row.variation.product.photos.length ? props.row.variation.product.photos[0].thumb : '/images/placeholder.png'" />
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
  </div>
</template>

<script>
import BaseTable from '../../components/BaseTable'
import filtersHelper from '../../mixins/filtersHelper.js'
import 'owl.carousel/dist/assets/owl.carousel.css';
import _ from 'lodash'
import moment from 'moment'

import { LMap, LTileLayer, LMarker, LIcon, LControl, LCircleMarker } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css'

export default {
  mixins: [
    filtersHelper
  ],
  components: {
    BaseTable,
    LMap,
    LTileLayer,
    LMarker,
    LControl,
    LCircleMarker,
    LIcon
  },
  metaInfo() {
    return {
      title: `سفارش #${this.$route.params.id}`,
    }
  },
  data() {
    return {
      zoom: 12,
      center: [36.2605, 59.6168],
      bounds: null,
      location: null,
      
      icon: L.icon({
        iconUrl: 'static/images/baseball-marker.png',
        iconSize: [32, 37],
        iconAnchor: [16, 37]
      }),
      staticAnchor: [16, 37],
      customText: 'Foobar',
      iconSize: 64,

      info: {
        user: {
          phones: []
        },
        method: {},
        status: {},
        status_changes: [],
        items: []
      },
      
      is_loaded: false
    }
  },
  mounted()
  {
    this.$watchLocation({ enableHighAccuracy: true })
    .then(({lat, lng}) => this.location = [lat, lng])

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
              email national_code gender
              phones { id type phone_number }
              avatar { id file_name thumb }
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
                  id name photos { id file_name thumb }
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
      query: `order_statuses(per_page: 30) {
        data { id title color icon created_at updated_at }
        total trash chart { month count }
      }`
    })
  },
  methods: {
    zoomUpdated (zoom) {
      this.zoom = zoom
    },
    centerUpdated (center) {
      this.center = center
    },
    boundsUpdated (bounds) {
      this.bounds = bounds
    },
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
          return this.$notify({
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
  },
  computed: {
    dynamicSize () {
      return [this.iconSize, this.iconSize * 1.15];
    },
    dynamicAnchor () {
      return [this.iconSize / 2, this.iconSize * 1.15];
    }
  }
}
</script>

<style scope>
.leaflet-marker-icon.leaflet-zoom-animated.leaflet-interactive {
  width: 40px !important;
  height: 50px !important;
}
.leaflet-control-attribution.leaflet-control {
  display: none;
}

.vue2leaflet-map {
  border-radius: 10px;
  margin-bottom: 20px;
  box-shadow: 0px 5px 35px -7px
}
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
  box-shadow: 0px 5px 18px -8px #f83600, 0px 3px 15px -9px #000;
}
.card-header-out-effect.order-info {
  background: linear-gradient(to bottom right, #ED213A, #93291E) !important;
  box-shadow: 0px 5px 18px -8px #93291E, 0px 3px 15px -9px #000;
}
.card-header-out-effect.shipping-method {
  background: linear-gradient(to bottom right, #409eff, #087df0) !important;
  box-shadow: 0px 5px 18px -8px #087df0, 0px 3px 15px -9px #000;
}
.card-header-out-effect.user-phones {
  background: linear-gradient(to bottom right, #00f2c3, #409eff) !important;
  box-shadow: 0px 5px 18px -8px #087df0, 0px 3px 15px -9px #000;
}
</style>
