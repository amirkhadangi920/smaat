<template>
  <div :style="{ position: 'relative', zIndex: 10 }">
    <div class="row owl-carousel mb-5">
      <card class="text-right mb-0 animated bounceInLeft delay-last responsive trash-card" :style="{ transformStyle: 'preserve-3d' }">
        <i class="tim-icons icon-trash-simple"></i>
        <h5 class="card-category" style="transform: translateZ(20px)">تعداد محصولات</h5>
        <h3 class="card-title" style="transform: translateZ(30px)">
          10 محصول
        </h3>
        <p class="card-text text-muted" :style="{fontSize: '10px', transform: 'translateZ(15px)'}">تعداد محصولاتی که تا کنون ثبت کرده اید</p>
      </card>
    </div>
    
    <div class="row text-right">
      <div class="col-md-12 text-right">
        <h2 class="animated bounceInRight delay-first mb-0">
          آخرین محصولات
          <i class="tim-icons icon-bullet-list-67" :style="{fontSize: '20px'}"></i>
        </h2>
        <h6 class="text-muted animated bounceInRight delay-secound">آخرین محصولاتی که در فروشگاه ثبت کرده اید</h6>
      </div>
    </div>
    <div class="row owl-carousel">
      <card v-for="product in products" :key="product.id" dir="rtl" class="text-right">
        <img slot="image" class="card-img-top" :src="product.photos.length ? product.photos[0].small : '/images/placeholder.png'" alt="product image"/>
        <h4 class="card-title">
          {{ product.name }}
          <span class="badge badge-warning ml-1 hvr-grow-shadow hvr-icon-grow" v-if="product.brand">
            <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
            {{ product.brand.name }}
          </span>
        </h4>
        <p class="card-text text-muted">{{ product.description }}</p>

        <transition-group name="list">
          <span
            v-for="item in product.categories.filter( (category, index) => index < 3)"
            :key="item.id"
            class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
            <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
            {{ item.title }}
          </span>

          <el-dropdown v-if="product.categories.length > 3" :key="product.categories.map((c) => c.id).join(',')">
            <span class="el-dropdown-link badge badge-default">
              باقی گروه ها <i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item
                v-for="item in product.categories.filter( (category, index) => index < 3)"
                :key="item.id">
                {{ item.title }}
              </el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </transition-group>
      </card>
    </div>

    <div class="row">
      <div class="col-md-6" v-for="(item, index) in [comments, reviews]" :key="index">
        <div class="row text-right">
          <div class="col-md-6 text-right">
            <h4 class="animated bounceInRight delay-first mb-0">
              <i class="tim-icons icon-single-copy-04" :style="{fontSize: '20px'}"></i>
              <span v-if="index === 0">آخرین نظرات</span>
              <span v-if="index === 1">آخرین نقد ها</span>
              <span v-if="index === 2">آخرین پرسش پاسخ ها</span>
            </h4>
          </div>
        </div>

        <base-table
          :tableData="item"
          type="order"
          group="shop"
          label="سفارش"
          :fields="[
            {
              field: 'title',
              label: 'عنوان',
              icon: 'icon-caps-small'
            }, {
              field: 'status',
              label: 'وضعیت',
              icon: 'icon-refresh-02'
            }
          ]"
          :canSelect="false"
          :methods="{ }"
          :has_loaded="is_loaded"
          :has_times="true"
          :has_operation="false"
        >
          <template v-slot:writer-body="slotProps">
            <div class="info-cell">
              <div class="mb-2">
                <img class="tilt" :src="slotProps.row.article.image ? slotProps.row.article.image.thumb : '/images/placeholder.png'" />
                <a href="#" :style="{display: 'block'}">{{ slotProps.row.article.title }}</a>
              </div>

              <div>
                <img class="tilt" :src="slotProps.row.writer.avatar ? slotProps.row.writer.avatar.thumb : '/images/placeholder-user.png'" />
                <a href="#">{{ slotProps.row.writer.full_name }}</a>
              </div>
            </div>
          </template>

          <template #status-body="slotProps">
            <i v-if="slotProps.row.is_accept" class="text-success tim-icons icon-check-2"></i>
            <i v-else class="text-danger tim-icons icon-simple-remove"></i>
          </template>
        </base-table>
      </div>
    </div>

    <div class="row text-right">
      <div class="col-md-12 text-right">
        <h2 class="animated bounceInRight delay-first mb-0">
          آخرین مقالات
          <i class="tim-icons icon-single-copy-04" :style="{fontSize: '20px'}"></i>
        </h2>
        <h6 class="text-muted animated bounceInRight delay-secound">آخرین مقالاتی که در وبلاگ ثبت کرده اید</h6>
      </div>
    </div>
    <div class="row owl-carousel">
      <card v-for="article in articles" :key="article.id" class="text-right">
        <img slot="image" class="card-img-top" :src="article.image ? article.image.small : '/images/placeholder.png'" alt="article image"/>
        <h4 class="card-title">
          {{ article.title }}
          <span class="badge badge-info ml-1 hvr-grow-shadow hvr-icon-grow" v-if="article.reading_time">
            <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
            مطالعه در{{ article.reading_time }} دقیقه
          </span>
        </h4>
        <p class="card-text text-muted">{{ article.description }}</p>

        <transition-group name="list">
          <span
            v-for="item in article.subjects.filter( (category, index) => index < 3)"
            :key="item.id"
            class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
            <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
            {{ item.title }}
          </span>

          <el-dropdown v-if="article.subjects.length > 3" :key="article.subjects.map((c) => c.id).join(',')">
            <span class="el-dropdown-link badge badge-default">
              باقی گروه ها <i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item
                v-for="item in article.subjects.filter( (category, index) => index < 3)"
                :key="item.id">
                {{ item.title }}
              </el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </transition-group>
      </card>
    </div>

    <div class="row text-right">
      <div class="col-md-12 text-right">
        <h2 class="animated bounceInRight delay-first mb-0">
          آخرین سفارشات
          <i class="tim-icons icon-cart" :style="{fontSize: '20px'}"></i>
        </h2>
        <h6 class="text-muted animated bounceInRight delay-secound">آخرین سفارشاتی که در وبسایت ثبت شده است</h6>
      </div>
    </div>
    <div class="row">
      <base-table
        :tableData="orders"
        type="order"
        group="shop"
        label="سفارش"
        :fields="[
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
        ]"
        :canSelect="false"
        :methods="{ }"
        :has_loaded="is_loaded"
        :has_times="true"
        :has_operation="false"
      >
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
          <span v-if="slotProps.row.status" class="badge" :style="{ border: `1px solid ${slotProps.row.status.color}` }">{{ slotProps.row.status.title }}</span>
          <span v-else class="badge badge-warning">نا مشخص :(</span>
        </template>
      </base-table>
    </div>
  </div>
</template>
<script>
import BaseTable from '../components/BaseTable'
import filtersHelper from '../mixins/filtersHelper';

export default {
  components: {
    BaseTable
  },
  mixins: [
    filtersHelper,
  ],
  metaInfo: {
    title: 'داشبورد',
  },
  data() {
    return {
      orders: [],
      comments: [],
      reviews: [],
      article: [],
      question_and_answers: [],
      products: [],
      articles: [],
      

      is_loaded: false,
    }
  },
  computed: {
    enableRTL() {
      return this.$route.query.enableRTL;
    },
    isRTL() {
      return this.$rtl.isRTL;
    },
    bigLineChartCategories() {
      return this.$t('dashboard.chartCategories');
    }
  },
  methods: {
    initBigChart(index) {
      let chartData = {
        datasets: [{
          fill: true,
          borderColor: config.colors.primary,
          borderWidth: 2,
          borderDash: [],
          borderDashOffset: 0.0,
          pointBackgroundColor: config.colors.primary,
          pointBorderColor: 'rgba(255,255,255,0)',
          pointHoverBackgroundColor: config.colors.primary,
          pointBorderWidth: 20,
          pointHoverRadius: 4,
          pointHoverBorderWidth: 15,
          pointRadius: 4,
          data: this.bigLineChart.allData[index]
        }],
        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      }
      this.$refs.bigChart.updateGradients(chartData);
      this.bigLineChart.chartData = chartData;
      this.bigLineChart.activeIndex = index;
    }
  },
  mounted()
  {
    require('owl.carousel/dist/owl.carousel.js')

    axios.post('/graphql/auth', {
      query: `{
        products {
          data {
            id name description photos { id file_name small } categories { id title } colors { id name code } brand { id name }
          }
          total
        }
        
        articles {
          data {
            id title description reading_time image { id file_name small } subjects { id title }
          }
        }

        orders {
          data {
            id offer total created_at updated_at
            status: order_status { id title color }
            user {
              id first_name last_name full_name avatar { id file_name thumb }
            }
          }
          total
        }
        
        users {
          data {
            id
            first_name
            last_name
            full_name
            email
            avatar { id file_name small }
          }
          total
        }
        
        comments(per_page: 5) {
          data { id title is_accept created_at updated_at }
        }
        reviews(per_page: 5) {
          data { id title is_accept created_at updated_at }
        }
        question_and_answers(per_page: 5) {
          data { id title is_accept created_at updated_at }
        } 
      }`
    })
    .then(({data}) => {
      this.products = data.data.products.data
      this.articles = data.data.articles.data
      this.orders = data.data.orders.data
      this.comments = data.data.comments.data
      this.reviews = data.data.reviews.data
      this.question_and_answers = data.data.question_and_answers.data

      this.is_loaded = true
    })
    .then(() => {
      $('.owl-carousel').owlCarousel({
        rtl: true,
        nav: false,
        loop: true,
        margin: 10,
        responsive: {
            0: { items:1 },
            600: { items:2 },
            1000: { items: 3 }
        }
      })
    })
  },
};
</script>

<style>

.card .card-image img {
  max-height: 150px;
}

</style>