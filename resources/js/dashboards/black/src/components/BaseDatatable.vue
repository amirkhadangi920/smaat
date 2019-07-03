<template>
  <transition name="fade">
    <div v-show="attr('has_loaded')">
      <div class="row mb-3" :style="{ position: 'relative', zIndex: 2 }">
        <div class="row col-12">
          <div class="col-12 text-right">
            <div class="pull-right">
              <h1 class="animated bounceInRight delay-first" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
                مدیریت <span :style="{ color: '#ff3d3d' }">{{ label }}</span> ها
                <i class="tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
              </h1>
              <h6 class="text-muted animated bounceInRight delay-secound">با استفاده از جدول زیر ، امکان مدیریت کامل {{ label }} های وبسایت برای شما ممکن خواهد شد</h6>
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
        <div class="col-12">
          <div class="animated bounceInLeft delay-secound mt-2 pull-right">
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


            <input type="text" v-if="canSearch" :value="filter('query')" @keyup.enter="search" dir="rtl" class="form-control col-3 ml-2 d-inline-block" placeholder="جستجو کنید ...">
          </div>

          <div class="animated bounceInLeft delay-secound pull-left">
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

      <div class="row">
        <transition name="fade">
          <div class="col-12 pt-3 animated bounceInLeft delay-last filters-row" v-show="attr('has_loaded')" dir="rtl">
            <slot name="filter-labels"></slot>
          </div>
        </transition>
      </div>

      <base-table
        :tableData="data()"
        :type="type"
        :group="group"
        :label="label"
        :fields="fields"
        :methods="methods"
        :canDelete="canDelete"
        :canEdit="canEdit"
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
            :type="attr('is_creating') ? 'success' : 'warning'"
            @click="attr('is_creating') ? methods.store() : methods.update()"
          >
            <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
            <i v-else class="tim-icons icon-pencil"></i>
            {{ attr('is_creating') ? 'ذخیره' : 'بروز رسانی' }} {{ label }}
          </base-button>
        </md-dialog-actions>
      </md-dialog>
    </div>
  </transition>
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
        default: true
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
      FlipClock
    },
    mixins: [
        deleteMixin,
        createMixin,
        FiltersHelper
    ],
    data() {
      return {
        bgColor: '#778899',
        position: 'top-right',
        fabActions: [
          {
            name: 'cache',
            icon: 'cached'
          },
          {
            name: 'alertMe',
            icon: 'add_alert'
          }
        ],

        layout: this.attr('is_grid_view'),
        selected_items: this.attr('selected_items'),
        
        entered_count: 0,
        is_finished: false,
      }
    },
    created() {

      return;

      setTimeout( () => {
        const startAt = 140
        const endAt = 250
        var setAnims = false
        var frame, duration;

        setInterval(() => {
          // document.querySelector('.row.details').classList.toggle('small')          
        }, 4000);


        document.querySelector('.main-panel').addEventListener('scroll', (e) => {

          if ( e.srcElement.scrollTop > startAt )
          {
            if ( !setAnims ) {
              setAnims = true

              animation.reverse();
              animation.play()
            }

            const el = document.querySelector('.row.details');
            const bg = document.querySelector('.content .background')
            
            const width = el.clientWidth;
            const height = el.clientHeight;

            el.style.position = 'fixed'
            el.style.zIndex = 10
            el.style.width = `${width}px`
            el.style.top = `${20}px`

            bg.style.position = 'fixed'
            bg.style.top = '-190px'

            document.querySelector('.row.table').style.marginTop = `${height}px`
          } else {
            if ( setAnims ) {
              setAnims = false

              animation.reverse();
              animation.play();
            }

            const el = document.querySelector('.row.details');
            const bg = document.querySelector('.content .background')

            el.style.position = 'relative'
            bg.style.position = 'absolute'
            bg.style.top = '0px'
            document.querySelector('.row.table').style.marginTop = '0px'
          }

          // console.log( e.srcElement.offsetHeight )
          // console.log( Math.abs( e.srcElement.scrollHeight - e.srcElement.scrollTop ) / e.srcElement.offsetHeight )
          // console.log( ( e.srcElement.scrollHeight - e.srcElement.offsetHeight ) - e.srcElement.scrollTop )
        })
      }, 500)

      window.addEventListener('scroll', function(e){
        // var scrollPos = window.scrollY
        // var winHeight = window.innerHeight
        // var docHeight = document.documentElement.scrollHeight
        // var perc = 100 * scrollPos / (docHeight - winHeight)
        // vm.$el.style.width = perc + '%'
      })
    
      setTimeout(() => {
          // anime({
          //   targets: '.animation-circle',
          //   top() {
          //     return anime.random(0, 50)
          //   },
          //   left() {
          //     return anime.random(0, 50)
          //   },
          //   loop: true,
          //   duration: 5000,
          //   direction: 'alternate'
          // })
      }, 1000);


      require('owl.carousel/dist/owl.carousel.js')
    
      setTimeout( () => $('.owl-carousel').owlCarousel({
          rtl:true,
          margin:10,
          nav:false,
          responsive:{
              0:{
                  items:1
              },
              600:{
                  items:2
              },
              1000:{
                  items:3
              }
          }
      }), 200);
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

      changeTableData()
      {
        axios.get(`/api/v1/${this.type}`, {
          params: this.attr('filters')
        }).then(({data}) => {
          setTimeout( () => {
            this.setData( data.data )
            
            setTimeout( () => $('.tilt').tilt({scale: 1.1}), 300)
          }, 500);
        })
      },
      search(event) {
          this.setAttr('filters', { query: event.target.value })

          this.changeTableData();
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
    box-shadow: 0px 6px 35px -20px #19375a, 0px 5px 30px -25px #0076ff !important;
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

  /* .data-table-row::before {
    z-index: -1;
    content: '';
    position: absolute;
    bottom: -339px;
    right: -254px;
    width: 600px;
    height: 400px;
    background: linear-gradient(to left, #fd5d9330, transparent);
    border-radius: 50%;
  }
  .data-table-row::after {
    z-index: -1;
    content: '';
    position: absolute;
    bottom: -372px;
    right: -96px;
    width: 600px;
    height: 400px;
    background: linear-gradient(to left, #f56c6c59, transparent);
    border-radius: 50%;
  } */
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

  .data-table-row ul .animation-circle {
    content: '';
    background: #fdb7ce30;
    position: absolute;
    top: 100px;
    left: 150px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    z-index: -1;
    box-shadow: 0px 10px 50px -15px rgb(231, 109, 215);
  }

  .data-table-row ul .animation-circle.small {
    width: 30px;
    height: 30px;
    background: #e782a430;
    box-shadow: 0px 10px 50px -15px rgb(238, 88, 218);
  }

  .data-table-row ul li:first-of-type {
    text-shadow: 0px 10px 37px #440139;
  }
  
  .data-table-row:hover {
    transform: scale(1.003) !important;
    box-shadow: 0px 6px 32px -15px #19375a, 0px 5px 35px -25px #0076ff;
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
  
  .data-table img {
    max-height: 50px;
    box-shadow: 0px 12px 40px -15px #000000a6;
  }

  .md-dialog {
    background: #fff;
    overflow: hidden;
    max-height: 90%;
  }
  .md-dialog-content {
    max-height: 78%;
    overflow: auto;
  }

  .md-dialog.md-dialog-fullscreen {
    box-shadow: 0 15px 150px -50px #fd5d93, 0 5px 15px rgba(0, 0, 0, 0.17) !important;
  }

  .modal.show .modal-dialog {
    -webkit-transform: translate(0, 0%) !important;
    transform: translate(0, 0%) !important;
  }

  .modal-content .modal-header button {
    left: 10px !important;
  }

  .md-dialog-title {
    /* background: url('/images/modal-header.png') center bottom; */
    /* height: 130px; */
    background-size: cover;
    display: block !important;
    text-align: center;
    position: relative;
  }
  .md-dialog-title::after {
    content: '';
    width: 100%;
    height: 70px;
    position: absolute;
    top: 0px;
    left: 0px;
    background: url('/images/modal_footer.svg') no-repeat;
    background-size: cover;
    transform: rotate(180deg) scaleY(1.5);
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
    color: #fff !important;
    text-shadow: 0px 0px 10px #000;
    font-size: 35px;
    margin-top: -5px;
    font-weight: bold;
  }
  .md-dialog-title p {
    position: relative;
    display: block;
    text-shadow: 0px 0px 10px #000;
    color: #f3f3f3 !important;
    font-size: 14px;
    font-weight: bold;
    z-index: 1;
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
</style>