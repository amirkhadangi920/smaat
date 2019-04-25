<template>
  <transition name="fade">
    <div v-show="attr('has_loaded')">
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
            <base-button @click="methods.create" v-if="canCreate" :disabled="can(`create-${type}`)" size="sm" :type="can(`create-${type}`) ? 'default' : 'info'" class="pull-left">
              <i class="tim-icons icon-pencil"></i>
              افزودن {{ label }} جدید
            </base-button>
            
            <transition name="fade">
              <base-button @click="handleDeleteMultiple" v-if="canDelete" v-show="attr('selected_items').length >= 1" size="sm" type="danger"
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
            </transition>

            <slot name="custom-buttons"></slot>
          </div>
        </div>
      </div>

      <transition name="fade">
        <slot name="charts">
          <div class="row" dir="rtl">
          
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
        </slot>
      </transition>

      <div class="row mt-3">
        <div class="col-12">
          <div class="text-right pull-right">
            <h1 class="animated bounceInRight delay-secound">
              مدیریت {{ label }} ها
              <i class="tim-icons icon-puzzle-10" :style="{fontSize: '25px'}"></i>
            </h1>
            <h6 class="text-muted animated bounceInRight delay-last">با استفاده از جدول زیر ، امکان مدیریت کامل {{ label }} های وبسایت برای شما ممکن خواهد شد</h6>
          </div>

          <div class="animated bounceInLeft delay-secound mt-2">
            <input type="text" v-if="canSearch" :value="filter('query')" @keyup.enter="search" dir="rtl" class="form-control col-3 mr-2 d-inline-block" placeholder="جستجو کنید ...">
            
            <el-tooltip content="نمای جدول">
              <i class="tim-icons icon-bullet-list-67 mr-1"></i>
            </el-tooltip>
            <el-switch 
              v-model="layout"
              @change="changeLayout"
              active-color="#4c065b"
              inactive-color="#4c065b">
            </el-switch>
            <el-tooltip content="نمای کارد">
              <i class="tim-icons icon-components"></i>
            </el-tooltip>
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

      <transition name="fade">
        <div class="row">
          <div class="col-12 data-table animated bounceInUp delay-last" dir="rtl" v-show="!attr('is_grid_view')">
            <ul class="data-table-header p-2 d-flex justify-content-center">
              <li 
                class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted"
                :style="{width: '40px'}"
              >
              <transition name="fade" mode="out-in">
                <span v-if="attr('selected_items').length === 0">#</span>
                <ICountUp
                  v-if="attr('selected_items').length !== 0"
                  :endVal="attr('selected_items').length"
                  :options="{
                    useEasing: true,
                    useGrouping: true,
                  }"
                />
              </transition>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
                <checkbox>
                  <input type="checkbox" v-model="all_items_selected" @change="handleSelectAll" />
                </checkbox>
              </li>
              <li v-for="(field, index) in fields" :key="index" class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
                <slot :name="field.field + '-header'">
                  <i v-if="field.icon !== undefined" :class="['tim-icons', field.icon,  'hvr-icon']"></i>
                  {{ field.label }}
                </slot>
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
                <i class="tim-icons icon-time-alarm hvr-icon"></i>
                ثبت / ویرایش
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-spin">
                <i class="tim-icons icon-settings hvr-icon"></i>
                عملیات ها
              </li>
            </ul>

            <transition name="fade">
              <transition-group
                name="flip-list"
                v-show="data().length !== 0"
                @enter="enter"
                @after-enter="afterEnter"
                @before-leave="beforeLeave"
                enter-active-class="animated zoomIn"
                leave-active-class="animated zoomOut" 
                tag="ul"
              >
                <li
                  v-for="(item, index) in $store.state[group][type]"
                  :key="item.id"
                  class="data-table-row"
                  :style="{animationDelay: is_finished ? '0ms' : `${1000 + index * 50}ms`}"
                >
                  <ul class="p-2 d-flex justify-content-center">
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
                      {{ index + 1 }}
                    </li>
                    <li :style="{width: '40px'}" class="data-table-cell d-flex align-items-center justify-content-center">
                      <checkbox>
                        <input type="checkbox" :value="index" v-model="selected_items" @change="handleSelectedChange(index)" />
                      </checkbox>
                    </li>
                    <li v-for="(field, childIndex) in fields" :key="childIndex" class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                      <slot :name="field.field + '-body'" :row="item" :index="index">
                        {{ item[ field.field ] }}
                      </slot>
                    </li>
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center">
                      <div :style="{ fontSize: '12px' }">
                        <el-tooltip :content="item.create_time | created" placement="left">
                          <p class="text-muted hvr-icon-bob"><i class="tim-icons icon-check-2 text-info hvr-icon"></i> {{ item.create_time | ago }}</p>
                        </el-tooltip>

                        <el-tooltip
                          :content="item.last_update_time | edited" placement="left"
                          v-if="item.last_update_time !== item.create_time">
                          <p class="text-muted hvr-icon-hang"><i class="tim-icons icon-pencil text-warning hvr-icon"></i> {{ item.last_update_time | ago }}</p>
                        </el-tooltip>
                      </div>
                    </li>
                    <li class="data-table-cell operation-cell p-2 d-flex align-items-center justify-content-center">
                      <el-tooltip :content="'ویرایش ' + label">
                        <base-button v-if="canEdit" @click="methods.edit(index, item)" simple class="hvr-icon-spin ml-2" :disabled="can(`update-${type}`)" :type="can(`create-${type}`) ? 'default' : 'success'" size="sm" icon>
                          <i class="tim-icons icon-pencil hvr-icon"></i>
                        </base-button>
                      </el-tooltip>

                      <el-tooltip :content="'حذف ' + label">
                        <base-button v-if="canDelete" @click="handleDelete(index, item)" simple class="ml-2" :disabled="can(`delete-${type}`)" :type="can(`create-${type}`) ? 'default' : 'danger'" size="sm" icon>
                          <i class="tim-icons icon-simple-remove"></i>
                        </base-button>
                      </el-tooltip>

                      <slot name="custom-operations" :row="item" :index="index"></slot>

                      <base-button @click="moreInfo" simple v-if="item.description != null" type="default" size="sm" icon>
                        !
                      </base-button>
                    </li>

                    <span class="animation-circle" :class="`type${(index % 3) + 1}`"></span>
                    <span class="animation-circle small" v-if="index % 3 !== 1" :class="`type${3 - (index % 3)}`"></span>
                  </ul>
                  <span class="data-table-hidden-cell" @click="lessInfo">
                    {{ item.description }}
                  </span>
                </li>
              </transition-group>
            </transition>
              
            <transition name="fade">
              <md-empty-state
                v-show="data().length === 0"
                md-icon="search"
                md-label="متاسفانه هیچ داده ای یافت نشد :("
                md-description="اگر در حالت جستجو نیستید و هیچ فیلتری نیز اعمال نکرده اید ، میتوانید با کلیک بر روی دکمه زیر یک داده جدید ثبت کنید">
                <base-button @click="methods.create" :disabled="can(`create-${type}`)" size="sm" :type="can(`create-${type}`) ? 'default' : 'info'" class="pull-left">
                  <i class="tim-icons icon-pencil"></i>
                  افزودن {{ label }} جدید
                </base-button>
              </md-empty-state>
            </transition>
          </div>

          <transition-group 
            class="col-12 data-grid"
            tag="div"
            v-show="attr('is_grid_view')"
            v-if="false"
          >
            <div
              class="col-md-4 pull-right"
              v-for="(item, index) in data()"
              :key="item.id"
            >
              <card
                class="col-md-12 data-grid-item animated bounceInUp"
                :class="!item.description ? 'card-empty' : ''"
                :showFooterLine="true"
                :title="item.name"
                :subTitle="item.description ? item.description : `متاسفانه توضیحی برای این ${label} ثبت نشده است :(`"
              >
                <img  slot="image"
                      class="card-img-top tilt"
                      :src="item.logo ? item.logo.tiny : '/images/placeholder.png'"
                      alt="Card image cap" />
                
                <div class="operation-cell">
                  <slot name="edit-button" :row="item" :index="index"></slot>
                
                  <el-tooltip :content="'حذف ' + label">
                    <base-button v-if="canDelete" @click="handleDelete(index, item)" type="danger" size="sm" icon>
                      <i class="tim-icons icon-simple-remove"></i>
                    </base-button>
                  </el-tooltip>
                </div>

                <span
                  v-if="item.categories.length === 0"
                  class="badge badge-danger hvr-grow-shadow hvr-icon-grow">
                  <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
                  بدون دسته بندی !
                </span>
                <slot name="categories-body" :row="item"></slot>
                
                <template slot="footer">
                  <hr/>
                  <slot name="time-body" :row="item"></slot>
                </template>
              </card>
            </div>
          </transition-group>

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
                type="secondary"
                @click="setAttr('is_open', false)">
                لغو
              </base-button>
              
              <base-button 
                :type="attr('is_creating') ? 'primary' : 'danger'"
                @click="attr('is_creating') ? methods.store() : methods.update()">
                {{ attr('is_creating') ? 'ذخیره' : 'بروز رسانی' }} {{ label }}
              </base-button>
            </md-dialog-actions>
          </md-dialog>
        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
  import deleteMixin from '../mixins/deleteMixin'
  import createMixin from '../mixins/createMixin'
  import FiltersHelper from '../mixins/filtersHelper'

  import {Tooltip} from 'element-ui'
  import {Modal} from '../components'
  import ICountUp from 'vue-countup-v2';
  import {BaseAlert} from '../../src/components'
  import Checkbox from './Checkbox.vue'
  import LineChart from '../components/Charts/LineChart';
  
  import * as chartConfigs from '../components/Charts/config';
  import config from '../config';
  import 'owl.carousel/dist/assets/owl.carousel.css';

  import { mapMutations } from 'vuex';
  import 'hover.css'
  import 'animate.css'

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
    },
    components: {
      LineChart,
      Modal,
      Tooltip,
      BaseAlert,
      ICountUp,
      Checkbox
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
        is_finished: false
      }
    },
    created() {
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

      enter(el) {
        el.style.marginBottom = `-${el.offsetHeight + 15}px`
        $(el).animate({marginBottom: 15})
      },
      afterEnter(el) {
        el.style.animationDelay = 'unset'

        if ( ++this.entered_count === this.tableData().length )
          this.is_finished = true
      },
      beforeLeave(el) {
        el.style.marginTop = `-${el.offsetHeight + 15}px`
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
        $('#particles-js').removeClass('show')
        $('footer.footer').fadeOut(500)
        $('#granim-canvas').fadeOut(500)
        $('.navbar-brand').removeClass(['animated', 'fadeIn', 'delay-1s']).addClass(['animated', 'fadeOut'])
        $('.delay-first').removeClass('delay-first').addClass('delay-last-out');
        $('.delay-first').removeClass('delay-secound').addClass('delay-secound-out');
        $('.delay-last').removeClass('delay-last').addClass('delay-first-out');
        $('.bounceInUp').removeClass(['animated', 'bounceInUp']).addClass(['animated', 'bounceOutDown']);
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
    background: #92006f;
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
  .card .card-image {
    position: relative;
    bottom: 30px;
    box-shadow: 0px 0px 20px -4px #000000b3;
    transition: transform 300ms;
    background: #fff;
  }
  .card .card-image img {
    max-height: 100px;
  }

  @media only screen and (max-width: 770px) {
    .card.responsive {
      margin-bottom: 30px !important;
    }
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
  .card .card-image, .card .card-image img {
    border-radius: 50%;
    width: 100px;
    height: 100px;
  }

  .card:hover .card-image {
    transform: rotate(30deg)
  }

  .white-content .card:not(.card-white) {
    box-shadow: 0px 0px 60px -30px rgb(255, 0, 214) !important;
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
  
  .data-table-cell {
    float: right;
    width: 25%;
    padding: 10px;
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

  .data-table-row {
    background: #fff;
    box-shadow: 0px 0px 60px -30px #ff00d3;
    position: relative;
    border-radius: 10px 10px 10px 60px;
    transform: scale(1);
    transition: transform 200ms, margin-top 500ms, box-shadow 250ms;
  }
  .data-table-row::before {
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
  }
  .data-table-row ul::before {
    z-index: -1;
    content: '';
    position: absolute;
    top: -280px;
    left: -110px;
    width: 300px;
    height: 300px;
    background: linear-gradient(to left, #fd5d9330, transparent);
    border-radius: 50%;
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

  .data-table-row ul li {
    text-shadow: 0px 10px 37px #440139;
  }

  .animation-circle.type1 {
    animation: moveCircle1 30s infinite;
  }

  .animation-circle.type2 {
    animation: moveCircle2 20s infinite;
  }
  .animation-circle.type3 {
    animation: moveCircle3 25s infinite;
  }

  @keyframes moveCircle1 {
    0% {
      top: 0px;
      left: 50px;
    }
    30% {
      top: 10px;
      left: 300px;
    }
    60% {
      top: 60px;
      left: 30px;
    }
    80% {
      top: 40px;
      left: 200px;
    }
    100% {
      top: 0px;
      left: 50px;
    }
  }
  @keyframes moveCircle2 {
    0% {
      top: 40px;
      left: 30px;
    }
    30% {
      top: 20px;
      left: 200px;
    }
    60% {
      top: 50px;
      left: 100px;
    }
    80% {
      top: 60px;
      left: 500px;
    }
    100% {
      top: 40px;
      left: 30px;
    }
  }
  @keyframes moveCircle3 {
    0% {
      top: 70px;
      left: 400px;
    }
    30% {
      top: 20px;
      left: 200px;
    }
    60% {
      top: 10px;
      left: 250px;
    }
    80% {
      top: 60px;
      left: 300px;
    }
    100% {
      top: 70px;
      left: 400px;
    }
  }
  
  .data-table-row:hover {
    transform: scale(1.01);
    box-shadow: 0px 0px 70px -30px #ff00d3;
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
    max-height: 70%;
    overflow: auto;
  }
  .md-overlay.md-fixed.md-dialog-overlay {
    background-color: #fdfdfdd9;
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
    background: url('/images/modal-header.png') center bottom;
    height: 130px;
    background-size: cover;
    display: block !important;
    text-align: center;
    position: relative;
  }
  .md-dialog-title::after {
    content: '';
    width: 100%;
    height: 115%;
    position: absolute;
    top: 0px;
    left: 0px;
    background: linear-gradient(#fd5d93d4, #650a3900);
  }

  .md-dialog-title h2 {
    position: relative;
    z-index: 3;
    color: #fff !important;
    text-shadow: 0px 0px 10px #000;
    font-size: 35px;
    margin-top: 10px;
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