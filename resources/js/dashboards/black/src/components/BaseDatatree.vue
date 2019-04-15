<template>
  <div>
    <div class="row mb-3">
      <div class="col-12">
        <div class="text-right pull-right">
        <h1 class="animated bounceInRight delay-first">
          جزئیات {{ label }} ها
          <i class="tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
        </h1>
        <h6 class="text-muted animated bounceInRight delay-secound">کلیه نمودار ها و اطلاعات موجود درباره ی {{ label }} ها</h6>
        </div>

        <div class="animated bounceInLeft delay-secound">
          <base-button size="sm" type="info" class="pull-left">
            <i class="tim-icons icon-pencil"></i>
            افزودن {{ label }} جدید
          </base-button>
          
          <!-- <transition name="fade">
            <base-button v-show="attr('selected_items').length >= 1" size="sm" type="danger"
              class="pull-left">
              <i class="tim-icons icon-trash-simple"></i>
              حذف
              <ICountUp
                :style="{display: 'inline'}"
                :endVal="attr('selected_items').length"
                :options="{
                  useEasing: true,
                  useGrouping: true,
                }"
              />
              مورد انتخاب شده
            </base-button>
          </transition> -->
        </div>
      </div>
    </div>

    <div class="row">
      <div class="row" v-if="attr('has_loaded')" dir="rtl">
        <div class="col-md-3">
          <card class="text-right mb-4 animated bounceInRight delay-secound tilt" :style="{ marginBottom: '32px !important', transformStyle: 'preserve-3d' }">
            <h5 class="card-category" style="transform: translateZ(20px)">کل {{ label }} های موجود</h5>
            <h3 class="card-title" style="transform: translateZ(30px)">
              <i class="tim-icons icon-attach-87 text-success"></i>
              <ICountUp
                style="transform: translateZ(30px)"
                :endVal="attr('counts').total"
                :options="{
                  useEasing: true,
                  useGrouping: true,
                  separator: ',',
                  suffix: ' ' + label
                }"
              />
            </h3>
            <p class="card-text text-muted" :style="{fontSize: '10px', transform: 'translateZ(15px)'}">تعداد {{ label }} هایی که تا کنون در وبسایت ثبت شده است</p>
          </card>
          <card class="text-right mb-0 animated bounceInRight delay-last tilt responsive" :style="{ transformStyle: 'preserve-3d' }">
            <h5 class="card-category" style="transform: translateZ(20px)">{{ label}} های حذف شده</h5>
            <h3 class="card-title" style="transform: translateZ(30px)">
              <i class="tim-icons icon-trash-simple text-danger"></i>
              <ICountUp
                style="transform: translateZ(30px)"
                :endVal="attr('counts').trash"
                :options="{
                  useEasing: true,
                  useGrouping: true,
                  separator: ',',
                  suffix: ' ' + label
                }"
              />
            </h3>
            <p class="card-text text-muted" :style="{fontSize: '10px', transform: 'translateZ(15px)'}">تعداد {{ label }} هایی که تا کنون حذف کرده اید</p>
          </card>
        </div>

        <div class="col-md-9 text-right animated bounceInLeft delay-secound">
          <card type="chart" class="mb-3">
            <template slot="header">
              <h5 class="card-category">نمودار زمانی ثبت {{ label }} ها</h5>
            </template>
            <div class="chart-area">
              <line-chart style="height: 100%"
                ref="chart"
                chart-id="green-line-chart"
                :chart-data="greenLineChart.chartData"
                :gradient-stops="greenLineChart.gradientStops"
                :extra-options="greenLineChart.extraOptions">
              </line-chart>
            </div>
          </card>
        </div>
      </div>
    </div>

    <div class="row mt-3 mb-3">
      <div class="col-12">
        <div class="text-right pull-right">
          <h1 class="animated bounceInRight delay-secound">
            مدیریت {{ label }} ها
            <i class="tim-icons icon-puzzle-10" :style="{fontSize: '25px'}"></i>
          </h1>
          <h6 class="text-muted animated bounceInRight delay-last">با استفاده از جدول زیر ، امکان مدیریت کامل {{ label }} های وبسایت برای شما ممکن خواهد شد</h6>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <el-tree
          :data="$store.state.group[type]"
          show-checkbox
          node-key="id"
          empty-text="هیچ گونه اطلاعاتی یافت نشد :("
          :props="defaultProps">
          <div class="custom-tree-node col-11" slot-scope="{ node, data }">
            <div class="pull-left d-flex align-items-center">
              <img :src="data.logo ? data.logo.tiny : '/images/placeholder.png'" />
              <div class="pull-right">
                <h3 class="mb-0">{{ node.label }}</h3>
                <p class="text-muted">{{ data.description }}</p>
              </div>
            </div>
            
            <div class="operation-cell pull-right">
              <el-tooltip :content="'ویرایش'">
                <base-button @click="edit_row(index, row)" type="success" size="sm" icon>
                  <i class="tim-icons icon-pencil"></i>
                </base-button>
              </el-tooltip>

              <el-tooltip :content="'حذف'">
                <base-button class="pull-right" type="danger" size="sm" icon>
                  <i class="tim-icons icon-simple-remove"></i>
                </base-button>
              </el-tooltip>
            </div>
          </div>
        </el-tree>
      </div>
    </div>
  </div>
</template>

<script>
import initMixin from '../mixins/initDatatable'
import LineChart from './Charts/LineChart';
import ICountUp from 'vue-countup-v2';
  
import * as chartConfigs from './Charts/config';
import config from '../config.js';

export default {
    props: [ 'label', 'type' ],
  mixins: [
    initMixin
  ],
  components: {
    LineChart,
    ICountUp
  },
  data() {
    return {
        group: 'group',

        defaultProps: {
          children: 'childs',
          label: 'title',
        },
    }
  },
  methods: {
    closePanel() {
      this.$refs.datatable.closePanel();
    },
    changeSelectedSubjects() {
      this.setAttr('selected', {
        categories: this.$refs.subjects.getCheckedKeys(),
      })
    },

    create() {
      this.setAttr('selected', {
        title: '',
        description: '',
        body: '',
        reading_time: null,
        tags: [],
        subjects: [],
        imageFile: null,
        imageUrl: ''
      })

      this.setAttr('is_open', true)
      this.setAttr('is_creating', true)
    },
    edit(index, row) {
      axios(row.link).then(({data}) => {
        data = data.data

        this.$refs.subjects.setCheckedKeys([]);

        this.setAttr('selected', {
          index: index,
          link: data.link,
          title: data.title,
          description: data.description,
          body: data.body,
          tags: data.tags,
          reading_time: data.reading_time,
          subjects: data.subjects.map( subject => subject.id ),
          imageFile: null,
          imageUrl: data.image ? row.image.small : '',
        })    

        this.setAttr('is_open', true)
        this.setAttr('is_creating', false)
      })
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
    getValidationClass (fieldName) {
      const field = this.$v[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validate() {
      this.$v.$touch()

      return !this.$v.$invalid;
    },
  },
  computed: {
    // title: bind('title'),
    // description: bind('description'),

    greenLineChart() {
      return {
        extraOptions: chartConfigs.greenChartOptions,
        chartData: {
          labels: this.$store.state[this.group].charts[this.type].labels,
          datasets: [{
            label: `تعداد ${this.label} های ثبت شده `,
            fill: true,
            borderColor: config.colors.danger,
            borderWidth: 2,
            borderDash: [],
            borderDashOffset: 0.0,
            pointBackgroundColor: config.colors.danger,
            pointBorderColor: 'rgba(255,255,255,0)',
            pointHoverBackgroundColor: config.colors.danger,
            pointBorderWidth: 20,
            pointHoverRadius: 4,
            pointHoverBorderWidth: 15,
            pointRadius: 4,
            data: this.$store.state[this.group].charts[this.type].data,
          }]
        },
        gradientColors: ['rgba(66,134,121,0.15)', 'rgba(66,134,121,0.0)', 'rgba(66,134,121,0)'],
        gradientStops: [1, 0.4, 0],
      }
    }
  },
}
</script>

<style>
.el-tree {
  background: transparent;
}
.el-tree .operation-cell {
  height: 70px;
  display: flex;
  align-items: center;
}

/* .el-tree-node__content {
  height: 70px;
  margin-bottom: 15px;
  background: #fff !important;
  border-radius: 10px;
  transition: transform 200ms, box-shadow 250ms;
} */

.el-tree-node__content:hover {
  transform: scale(1.01);
  box-shadow: 0px 0px 70px -30px #ff00d3;
}

.el-tree-node__children {
  margin-left: 5%;
}

.custom-tree-node img {
  max-height: 50px;
  width: 50px;
  margin-right: 10px;
}
</style>