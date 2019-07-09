<template>
  <div>
    <transition name="fade" mode="out-in">
      <div v-show="attr('has_loaded')">
        <div class="row mb-3" :style="{ position: 'relative', zIndex: 2 }">
          <div class="row col-12">
            <div class="col-12 text-right">
              <div class="pull-right">
                <h1 class="animated bounceInRight delay-first" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
                  مدیریت <span :style="{ color: '#ff3d3d' }">{{ label }}</span> ها
                  <i class="header-nav-icon tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
                </h1>
                <h6 class="header-description animated bounceInRight delay-secound">با استفاده از جدول زیر ، امکان مدیریت کامل {{ label }} های وبسایت برای شما ممکن خواهد شد</h6>
              </div>
              <div class="pull-left animated bounceInDown delay-last">
                <flip-clock :options="{
                  label: false,
                  clockFace: 'TwentyFourHourClock'
                }" />
              </div>
            </div>
          </div>
        </div>

        <transition name="fade">
          <slot name="charts">
            <div class="row details mb-3" :style="{ position: 'relative', zIndex: 2 }" dir="rtl">
              <div class="col-md-3">
                <div class="tilt">
                  <card class="text-right mb-4 animated bounceInLeft delay-secound total-card" :style="{ marginBottom: '32px !important', transformStyle: 'preserve-3d' }">
                    <i class="tim-icons icon-attach-87"></i>
                    <h5 class="card-category" style="transform: translateZ(20px)">کل {{ label }} های موجود</h5>
                    <h3 class="card-title" style="transform: translateZ(30px)">
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
                </div>
                <div class="tilt" :style="{ position: 'relative', top: '0px', right: '0px' }">
                  <card class="text-right mb-0 animated bounceInLeft delay-last responsive trash-card" :style="{ transformStyle: 'preserve-3d' }">
                    <i class="tim-icons icon-trash-simple"></i>
                    <h5 class="card-category" style="transform: translateZ(20px)">{{ label}} های حذف شده</h5>
                    <h3 class="card-title" style="transform: translateZ(30px)">
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
              </div>

              <div class="col-md-9 text-right animated bounceInRight delay-secound chart-card">
                <card type="chart" class="mb-3">
                  <template slot="header">
                    <h5 class="card-category">نمودار زمانی ثبت {{ label }} ها</h5>
                  </template>
                  <div class="chart-area">
                    <canvas id="myChart" height="100%"></canvas>
                  </div>
                  <!-- <div class="chart-area" :style="{ height: '60px', position: 'absolute', top: '0px', right: '0px' }">
                    <canvas id="miniChart" height="100%"></canvas>
                  </div> -->
                </card>
              </div>
            </div>
          </slot>
        </transition>

        <div class="row table">
          <div class="w-100">
            <div class="animated bounceInLeft delay-secound mt-2 pull-right" v-if="false">
              <el-tooltip content="نمای جدول">
                <i class="tim-icons icon-bullet-list-67"></i>
              </el-tooltip>
              <el-switch 
                v-model="layout"
                @change="changeLayout"
                active-color="#133051"
                inactive-color="#254c78">
              </el-switch>
              <el-tooltip content="نمای کارد">
                <i class="tim-icons icon-components"></i>
              </el-tooltip>
            </div>

            <div class="animated bounceInLeft delay-secound">
              <input type="text" v-if="canSearch" :value="filter('query')" @keyup.enter="search" dir="rtl" class="pull-right form-control col-3 ml-2 d-inline-block" placeholder="جستجو کنید ...">

              <base-button @click="methods.create" v-if="canCreate" :disabled="can(`create-${type}`)" size="sm" :type="can(`create-${type}`) ? 'info' : 'success'">
                افزودن {{ label }} جدید
                <i class="tim-icons icon-simple-add"></i>
              </base-button>
              
              <transition name="fade">
                <base-button @click="handleDeleteMultiple" v-if="canDelete" v-show="attr('selected_items').length >= 1" size="sm" type="danger">
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
                  <i class="tim-icons icon-trash-simple"></i>
                </base-button>
              </transition>

              <slot name="custom-buttons"></slot>
            </div>
          </div>
        </div>

        <!-- <div class="row">
          <transition name="fade">
            <div class="col-12 pt-3 animated bounceInLeft delay-last filters-row" v-show="attr('has_loaded')" dir="rtl">
              <slot name="filter-labels"></slot>
            </div>
          </transition>
        </div> -->

        <base-table
          :tableData="data()"
          :type="type"
          :group="group"
          :label="label"
          :fields="fields"
          :methods="methods"
          :canDelete="canDelete"
          :canEdit="canEdit"
          :ignoreOperations="ignoreOperations"
          :has_loaded="attr('has_loaded')"
          :is_grid_view="attr('is_grid_view')"
          :has_times="true"
          :has_operation="true"
        >
          <template 
            v-for="(item, index) in fields"
            :slot="`${item.field}-header`"
            slot-scope="slotData"
          >
            <slot
              :name="`${item.field}-header`"
              v-bind="slotData"
            />
          </template>
        
          <template 
            v-for="(item, index) in fields"
            :slot="`${item.field}-body`"
            slot-scope="slotData"
          >
            <slot
              :name="`${item.field}-body`"
              v-bind="slotData"
            />
          </template>

          <template #custom-operations="slotProps">
            <slot
              name="custom-operations"
              :row="slotProps.row"
              :index="slotProps.index"
            />
          </template>
        </base-table>

        <el-pagination
          v-if="attr('counts').total > 10"
          dir="rtl"
          class="text-center"
          :hide-on-single-page="false"
          layout="prev, pager, next"
          :current-page="attr('page')"
          :total="attr('counts').total"
          @current-change="$parent.handlePagination"
        >
        </el-pagination>

        <md-dialog :md-active.sync="$store.state[group].is_open[type]" class="text-right" dir="rtl">
          <md-dialog-title>
            <h2 class="modal-title">
              {{ attr('is_creating') ? 'ثبت ' + label : 'ویرایش ' + label }}
            </h2>
            <p>از طریق فرم زیر میتوانید {{ label }} {{ attr('is_creating') ? 'جدید ثبت کنید' : 'مورد نظر خود را ویرایش کنید' }}</p>
          </md-dialog-title>

          <div class="md-dialog-content">
            <div class="p-2">
              <form @submit.prevent>
                <slot name="modal"></slot>
              </form>
            </div>
          </div>

          <md-dialog-actions>
            <base-button
              class="ml-2"
              type="danger"
              size="sm"
              @click="setAttr('is_open', false)"
            >
              <i class="tim-icons icon-simple-remove"></i>
              لغو
            </base-button>
            
            <base-button
              size="sm" 
              :loading="attr('is_mutation_loading')"
              :type="attr('is_creating') ? 'success' : 'warning'"
              @click="attr('is_creating') ? methods.store() : methods.update()"
            >
              <transition name="fade" mode="out-in">
                <semipolar-spinner
                  :animation-duration="2000"
                  :size="17"
                  color="#fff"
                  v-if="attr('is_mutation_loading')"
                />
                <span v-else class="pull-right ml-2" >
                  <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
                  <i v-else class="tim-icons icon-pencil"></i>
                </span>
              </transition>
              {{ attr('is_creating') ? 'ذخیره' : 'بروز رسانی' }} {{ label }}
            </base-button>
          </md-dialog-actions>
        </md-dialog>
      </div>
    </transition>

    <transition name="fade">
      <div class="main-panel-loading" v-if="!attr('has_loaded')">
        <fingerprint-spinner
          :animation-duration="1000"
          :size="100"
          color="#fff"
        />
      </div>
    </transition>

    <transition name="loading">
      <div class="query-loader" v-if="attr('is_query_loading')">
        <half-circle-spinner
          :animation-duration="800"
          :size="40"
          color="#fff"
        />
      </div>
    </transition>
  </div>
</template>

<script>
  import deleteMixin from '../mixins/deleteMixin'
  import createMixin from '../mixins/createMixin'
  import FiltersHelper from '../mixins/filtersHelper'
  import BaseTable from './BaseTable.vue'

  import {Tooltip} from 'element-ui'
  import {Modal} from '../components'
  import ICountUp from 'vue-countup-v2';
  import {BaseAlert} from '../../src/components'
  import Checkbox from './Checkbox.vue'
  import LineChart from '../components/Charts/LineChart';
  import { FlipClock } from '@mvpleung/flipclock';
  import {SemipolarSpinner, HalfCircleSpinner, FingerprintSpinner} from 'epic-spinners'
  
  import * as chartConfigs from '../components/Charts/config';
  import config from '../config';
  import 'owl.carousel/dist/assets/owl.carousel.css';

  import { mapMutations } from 'vuex';
  import 'hover.css'
  import 'animate.css'
  import anime from 'animejs'
  import fab from 'vue-fab'

  export default {
    props: {
      methods: {
        type: Object,
        required: true
      },
      group: {
        type: String,
        required: true
      },
      type: {
        type: String,
        required: true
      },
      label: {
        type: String,
        required: true
      },
      fields: {
        type: Array,
        required: true
      },
      canCreate: {
        type: Boolean,
        default: true
      },
      canEdit: {
        type: Boolean,
        default: true
      },
      canDelete: {
        type: Boolean,
        default: true
      },
      canSearch: {
        type: Boolean,
        default: () => true
      },
      ignoreOperations: {
        type: Array,
        default: () => []
      },
      getdata: Array
    },
    components: {
      BaseTable,
      fab,
      LineChart,
      Modal,
      Tooltip,
      BaseAlert,
      ICountUp,
      Checkbox,
      FlipClock,
      SemipolarSpinner,
      HalfCircleSpinner,
      FingerprintSpinner
    },
    mixins: [
        deleteMixin,
        createMixin,
        FiltersHelper
    ],
    data() {
      return {
        layout: this.attr('is_grid_view'),
        selected_items: this.attr('selected_items'),
        
        entered_count: 0,
        is_finished: false,
        test_loading: false
      }
    },
    mounted() {
      setInterval(() => {
        this.test_loading = !this.test_loading
      }, 5000);
    },
    computed: {
      all_items_selected: {
        get () {
          return this.tableData().length === this.attr('selected_items').length
        },
        set (value) { }
      },
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
    methods: {
      cache(){
          console.log('Cache Cleared');
      },
      alert(){
          alert('Clicked on alert icon');
      },
      handleScroll() {
        console.log('dsf')
      },
      search(event)
      {
        this.setAttr('filters', { query: event.target.value })
        this.$parent.handleSearch( event.target.value )
      },

      enter(el, done) {
        el.style.marginTop = `-${el.offsetHeight + 15}px`

        anime({
          targets: el,
          marginTop: {
            value: 0,
          },
          marginBottom: {
            value: 15,
          },
          scale: {
            value: 1,
            delay: 150
          },
          round: 2,
          easing: 'easeOutExpo',
          complete() {
            done()
          }
        })
      },
      leave(el, done) {
        anime({
          targets: el,
          marginTop: {
            value: -(el.offsetHeight + 15),
            delay: 150
          },
          scale: {
            value: 0
          },
          round: 2,
          duration: 500,
          easing: 'easeOutCubic',
          complete() {
            done()
          }
        })
      },
      afterEnter(el) {
        el.style.animationDelay = 'unset'

        if ( ++this.entered_count === this.tableData().length )
          this.is_finished = true
      },

      handleSelectAll(event) {
        let temp = event.target.checked ? Array.apply(null, {length: this.tableData().length }).map( (v, i) => i) : []

        this.selected_items = temp;
        this.setAttr('selected_items', temp, true)
      },
      handleSelectedChange(value) {
        this.setAttr('selected_items', this.selected_items, true)
      },
      moreInfo(event) {
        event.target.parentNode.parentNode.parentNode.parentNode.classList.toggle('active');
      },
      lessInfo(event) {
        event.target.parentNode.classList.toggle('active');
      },
      changeLayout(value) {
        if ( value ) 
          $('.data-table').removeClass(['animated', 'bounceInUp', 'delay-last']).addClass(['animated', 'bounceOutDown'])
        else
          $('.data-grid').removeClass(['animated', 'bounceInUp', 'delay-last']).addClass(['animated', 'bounceOutDown'])

        setTimeout( () => {
          this.setAttr('is_grid_view', value)

          if ( value ) 
            $('.data-table').removeClass(['animated', 'bounceOutDown']).addClass(['animated', 'bounceInUp', 'delay-last'])
          else
            $('.data-grid').removeClass(['animated', 'bounceOutDown']).addClass(['animated', 'bounceInUp', 'delay-last'])
        }, 800)
      },
      closePanel() {
        $('footer.footer').fadeOut(500)
        $('.navbar-brand').removeClass(['animated', 'fadeIn', 'delay-1s']).addClass(['animated', 'fadeOut'])
        $('.delay-first').removeClass('delay-first').addClass('delay-last-out');
        $('.delay-first').removeClass('delay-secound').addClass('delay-secound-out');
        $('.delay-last').removeClass('delay-last').addClass('delay-first-out');
        $('.bounceInUp').removeClass(['animated', 'bounceInUp']).addClass(['animated', 'bounceOutDown']);
        $('.bounceInDown').removeClass(['animated', 'bounceInDown']).addClass(['animated', 'bounceOutUp']);
        $('.bounceInLeft').removeClass(['animated', 'bounceInLeft']).addClass(['animated', 'bounceOutLeft']);
        $('.bounceInRight').removeClass(['animated', 'bounceInLeft']).addClass(['animated', 'bounceOutRight']);
      },
      
      setAttr(attr, data, override = false) {
        let final_data = typeof data === 'object' ? {...this.$store.state[this.group][attr][this.type], ...data} : data;

        if ( override ) final_data = data

        this.$store.commit('setAttr', {
          attr,
          group: this.group,
          type: this.type,
          data: final_data
        })
      },

      tableData(attr) {
          return this.$store.state[this.group][this.type]
      },
      attr(attr) {
          return this.$store.state[this.group][attr][this.type]
      },
      filter(filter) {
          return this.$store.state[this.group].filters[this.type][filter]
      },
      selected(field) {
          return this.$store.state[this.group].selected[this.type][field]
      },
      can(permission) {
        return !this.$store.state.permissions.includes(permission)
      }
    },
  }
</script>

<style>

.main-panel-loading {
  width: 100%;
  height: 100%;
  left: 0px;
  top: 0px;
  z-index: 100;
  position: fixed;
  background: #0001353b;
  display: flex;
  align-items: center;
  justify-content: center;
}

.query-loader {
  width: 75px;
  height: 60px;
  position: fixed;
  z-index: 100;
  bottom: 50px;
  left: 0px;
  border-radius: 0px 44% 44% 0px;
  padding: 10px;
  padding-left: 23px;
  box-shadow: 0px 5px 15px -14px #19375a, 0px 4px 10px -11px #0076ff !important;
  background: linear-gradient(60deg,#0c2646 0,#204065 60%,#2a5788);
  transition: left 200ms;
}

.loading-enter-to, .loading-leave {
  left: 0px !important;
}
.loading-leave-to, .loading-enter {
  left: -80px !important;
}

.header-description {
  color: #e4e4e4de !important;
  font-weight: bold;
  margin-top: 3px;
  text-shadow: 1px 2px 10px #00000047;
}

.btn .semipolar-spinner {
  float: right;
  margin-left: 10px;
}

  .flip-clock-wrapper ul {
    width: 30px;
    height: 40px;
  }
  .flip-clock-wrapper ul li {
    line-height: 50px;
  }
  .flip-clock-wrapper ul li a div div.inn {
    background: #eaeaea;
    color: #333;
    font-size: 20px;
  }
  .flip-clock-divider {
    height: 55px;
  }
  .flip-clock-dot.top {
    width: 6px;
    height: 6px;
    top: 18px;
    background: #dfdfdf;
  }
  .flip-clock-dot.bottom {
    width: 6px;
    height: 6px;
    bottom: 18px;
    background: #dfdfdf;
  }

  .row.details.small .chart-card {
    max-width: 30%;
  }
  .row.details.small .card-chart .card-body {
    height: 70px;
  }
  .row.details.small .card-chart #myChart {
    opacity: 0;
  }
  .row.details.small .card-chart #miniChart {
    opacity: 1;
  }
  .row.details.small .card-chart .card-header {
    margin-top: -45px;
  }
  .row.details.small .tilt:last-of-type {
    top: -92px;
    right: 65%;
  }
  .row.details.small .tilt .card {
    width: 50%;
    height: 60px;
  }
  .row.details.small .tilt .card .card-category {
    margin-top: -85%;
  }
  .row.details.small .tilt .card .tim-icons {
    font-size: 60px;
  }
  

  .tilt .card {
    width: 100%;
    height: 140px;
  }

  .flip-list-move {
    transition: transform 500ms !important;
  }

  .md-field {
    border-bottom: 1px solid #878787;
    transition: border-bottom-color 300ms;
  }
  .md-field.md-invalid {
    border-bottom-color: #ff0000;
  }
  .md-field.md-focused:before {
    background: #f56c6c;
    bottom: -1px;
  }
  .md-field .md-count {
    left: 0px;
    right: auto;
  }
  .md-field .md-icon,.md-field.md-has-textarea .md-icon {
    font-size: 20px !important;
    right: auto !important;
    left: 0px;
    top: 0px !important;
  }
  .md-field label {
    right: 0px;
  }
  .md-field .md-error {
    color: #ff0000;
    right: 0px;
  }
  .md-chip.md-deletable.md-duplicated {
    background: #4c4c4c;
  }
  .md-menu-content-container {
    background: #fff;
  }
  .md-list {
    direction: rtl;
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }

  .list-enter-active, .list-leave-active {
    transition: margin-top 800ms !important;
  }
  .list-enter, .list-leave-to {
    margin-top: -50px;
  }
  
  .filters-row {
    min-height: 42px !important;
  }

  .delay-first {
    animation-delay: 100ms;
  }
  .delay-first-out {
    animation-delay: 0ms;
  }
  .delay-secound {
    animation-delay: 400ms;
  }
  .delay-secound-out {
    animation-delay: 300ms;
  }
  .delay-last {
    animation-delay: 500ms;
  }
  .delay-last-out {
    animation-delay: 400ms;
  }

  .swal2-popup {
    direction: rtl;
  }

  .tim-icons {
    margin-left: 5px;
  }

  .total-card {
    background: linear-gradient(to bottom right, #fe8c00, #f83600) !important;
    box-shadow: 0px 6px 35px -20px #19375a, 0px 5px 30px -25px #0076ff;
  }
  .card-chart {
    /* background: transparent !important; */
    box-shadow: none !important;
  }
  .trash-card {
    background: linear-gradient(to bottom right, #ED213A, #93291E) !important;
    box-shadow: 0px 6px 35px -20px #19375a, 0px 5px 30px -25px #0076ff;
  }
  .total-card, .trash-card {
    overflow: hidden;
  }
  .total-card *, .trash-card * {
    color: #fff !important;
    font-weight: bold !important;
  }
  .total-card p, .trash-card p {
    color: #ffffffb5 !important;
  }
  .total-card i, .trash-card i {
    font-size: 120px;
    position: absolute;
    top: -18px;
    left: -20px;
    color: #ffffff52 !important;
  }
  .trash-card i {
    transform: rotate(40deg);
  }

  .badge-default {
    color: #344675 !important;
    background: transparent !important;
    border: 1px solid #344675 !important;
  }

  h1 {
    margin-bottom: 0px !important;
  }

  ul {
    list-style-type: none;
    padding: 0px;
  }

  .owl-stage-outer {
    padding-top: 50px;
  }

  .data-grid-item .operation-cell {
    float: left;
    position: absolute;
    top: 20px;
    left: 20px;
  }

  .data-grid-item {
    height: 300px;
    margin-bottom: 50px !important;
    direction: rtl !important;
    text-align: right !important;
    border-radius: 0px 50px !important;
  }

  @media only screen and (max-width: 768px) {
    .card.responsive {
      margin-bottom: 30px !important;
    }

    .row.details .tilt {
      width: 50%;
      float: right;
    }

    .row.details .tilt:first-of-type {
      padding-left: 10px;
    }
    .row.details .tilt:last-of-type {
      padding-right: 10px;
    }
  }
  .chart-card .card-body {
    height: 270px;
  }

  .data-grid-item .card-body {
    padding-bottom: 0px !important;
  }
  .data-grid-item.card-empty .card-category {
    color: #ff6060 !important;
  }
  .data-grid-item .card-footer, .data-grid-item .card-header {
    padding-top: 0px !important;
  }

  .white-content .card:not(.card-white) {
    box-shadow: 0px 5px 15px -14px #19375a, 0px 4px 10px -11px #0076ff !important;
  }

  .remove-button {
    cursor: pointer;
  }

  .el-dropdown-menu {
    text-align: right;
  }
  .el-dropdown-menu i {
    margin-right: 0px;
    margin-left: 5px;
  }

  .data-table {
    perspective: 600px;
    transform-origin: top center; 
    transform-style: preserve-3d;
    background: transparent;
    margin-bottom: 20px;
    text-align: center;
  }

  .data-table-cell i.tim-icons {
    color: #254a75;
  }

  .operation-cell i {
    margin: 0px;
  }

  .data-table-row, .data-table-header {
    width: 100%;
    float: right;
    overflow: hidden;
    margin-bottom: 15px;
  }
  .data-table-row ul, ul.data-table-header {
    padding-left: 35px !important;
  }

  .data-table-row ul::before {
    z-index: -1;
    content: '';
    width: 60%;
    height: 100%;
    top: 0px;
    left: -52%;
    position: absolute;
    border-radius: unset;
    background: linear-gradient(to right, #254c78, transparent);
  }

  .data-table-row ul li:first-of-type {
    text-shadow: 0px 10px 37px #440139;
  }

  .data-table-hidden-cell {
    content: '';
    position: absolute;
    top: 0px;
    left: -95%;
    width: 100%;
    height: 100%;
    border-radius: 6px;
    color: #fff;
    font-size: 18px;
    text-align: right;
    padding: 5px;
    padding-right: 40%;
    background: linear-gradient(to right, #420a39, #803173d1, transparent);
    transition: left 300ms;
  }

  .data-table-row.active .data-table-hidden-cell {
    left: 0%;
  }

  .data-table-row td {
    padding: 8px;
  }
  .data-table-row td:first-child {
    border-radius: 0px 6px 6px 0px !important;
  }

  .data-table-row td:last-child {
    border-radius: 6px 0px 0px 6px !important;
  }

  .md-dialog {
    border-radius: 7px;
    background: #fff;
    overflow: hidden;
    max-height: 90%;
  }
  .md-dialog-content {
    max-height: 78%;
    overflow: auto;
  }

  .md-dialog.md-dialog-fullscreen {
    box-shadow: 0px 5px 15px -14px #19375a, 0px 4px 10px -11px #0076ff !important;
  }

  .modal.show .modal-dialog {
    -webkit-transform: translate(0, 0%) !important;
    transform: translate(0, 0%) !important;
  }

  .modal-content .modal-header button {
    left: 10px !important;
  }

  .md-dialog-title {
    background: url('/images/modal-header.png') center bottom;
    /* height: 130px; */
    background-size: cover;
    display: block !important;
    text-align: center;
    position: relative;
  }
  .md-dialog-title::after {
    content: '';
    background: linear-gradient(to bottom, #ff8d726e, transparent);
    width: 100%;
    height: 70px;
    position: absolute;
    top: 0px;
    left: 0px;
  }
  .md-dialog-actions {
    width: 100%;
    position: absolute;
    bottom: 0px;
    left: 0px;
  }

  .md-dialog-title h2 {
    position: relative;
    z-index: 3;
    color: #5a5a5a !important;
    text-shadow: 0px 2px 10px #888;
    font-size: 35px;
    margin-top: -5px;
    font-weight: bold;
  }
  .md-dialog-title p {
    position: relative;
    display: block;
    color: #4646464f !important;
    text-shadow: 0px 2px 10px #bbb;
    font-size: 14px;
    font-weight: bold;
    z-index: 1;
  }

  .el-upload .el-icon-delete.avatar-uploader-icon {
    width: 30px;
    height: 30px;
    font-size: 20px;
    border-radius: 5px;
    position: absolute;
    top: 5px;
    left: 5px;
    background: #3031333d;
    color: #fff;
    opacity: 0;
    line-height: 30px;
    transition: opacity 200ms, background 200ms;
  }
  .el-upload:hover .el-icon-delete.avatar-uploader-icon {
    opacity: 1;
  }
  .el-upload .el-icon-delete.avatar-uploader-icon:hover {
    background: #ff000087;
  }

  button.swal2-confirm {
    background: linear-gradient(to bottom left, #00f2c3, #0098f0) !important;
  }

  button.swal2-cancel {
    background: linear-gradient(to bottom left, #fd5d93, #ec250d) !important;
  }

  /* Tree rtl problem */
  /* .el-tree-node__content>.el-checkbox {
    margin-right: 0px;
    margin-left: 8px;
  } */

  .el-checkbox__inner {
    margin-top: 10px;
  }

  /* form modal */
  @media (min-width: 991px) {
    .modal-dialog.big {
      max-width: 70% !important;
      margin-left: 4% !important;
    }
  }

  @media (max-width: 991px) {
    .modal-dialog.big {
      max-width: 90% !important;
    }

    .header-nav-icon {
      opacity: 0;
    }

    .navbar-wrapper {
      margin-top: 32px;
    }
    .navbar-toggler-bar {
      background: #fff !important;
      height: 2px !important;
      width: 30px !important;
    }
    .navbar-toggler-bar.bar2 {
      width: 25px !important;
    }
  }

  /* Upload image */
  .avatar-uploader {
    text-align: center;
  }

  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
    max-height: inherit;
  }

  .el-pagination .el-icon-arrow-right, .el-pagination .el-icon-arrow-left {
    transform: scaleX(-1);
  }
  .el-pagination li, .el-pagination button {
    background: transparent !important;
  }
  .el-pager li {
    transition: color 200ms;
  }
  .el-pagination li.active {
    background: linear-gradient(to bottom right, #ff8d72, #f56c6c) !important;
    padding: 5px;
    color: #fff !important;
    line-height: 20px;
    border-radius: 5px;
    box-shadow: 0px 5px 10px -4px #ff8d72, 0px 4px 6px -5px #000 !important;
    text-shadow: 1px 2px 7px #0000005c;
  }
  .el-pager li:hover {
    color: #ff8d72;
  }
</style>