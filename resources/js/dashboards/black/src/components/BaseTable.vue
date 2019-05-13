<template>
  <transition name="fade">
    <div v-show="attr('has_loaded')">

      <div class="row" v-if="false">
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
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up" v-if="has_times">
                <i class="tim-icons icon-time-alarm hvr-icon"></i>
                ثبت / ویرایش
              </li>
              <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-spin" v-if="has_operation">
                <i class="tim-icons icon-settings hvr-icon"></i>
                عملیات ها
              </li>
            </ul>

            <transition name="fade">
              <transition-group
                name="flip-list"
                v-show="tableData.length !== 0"
                @enter="enter"
                @leave="leave"
                @after-enter="afterEnter"
                tag="ul"
              >
                <li
                  v-for="(item, index) in tableData"
                  :key="item.id"
                  class="data-table-row"
                  :style="{ transform: 'scale(0)', animationDelay: is_finished ? '0ms' : `${1000 + index * 50}ms`}"
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
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" v-if="has_times">
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
                    <li class="data-table-cell operation-cell p-2 d-flex align-items-center justify-content-center" v-if="has_operation">
                      <el-tooltip :content="'ویرایش ' + label">
                        <base-button v-if="canEdit" @click="methods.edit(index, item)" link class="hvr-icon-spin ml-2" :disabled="can(`update-${type}`)" :type="can(`create-${type}`) ? 'success' : 'default'" size="sm" icon>
                          <i class="tim-icons icon-pencil hvr-icon" :style="{ fontSize: '18px !important' }"></i>
                        </base-button>
                      </el-tooltip>

                      <el-tooltip :content="'حذف ' + label">
                        <base-button v-if="canDelete" @click="handleDelete(index, item)" link class="ml-2" :disabled="can(`delete-${type}`)" :type="can(`create-${type}`) ? 'danger' : 'default'" size="lg" icon>
                          <i class="tim-icons icon-trash-simple" :style="{ fontSize: '18px !important' }"></i>
                        </base-button>
                      </el-tooltip>
                    </li>
                  </ul>
                </li>
              </transition-group>
            </transition>
              
            <transition name="fade">
              <md-empty-state
                v-if="false"
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
              v-for="(item, index) in tableData"
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
  import { FlipClock } from '@mvpleung/flipclock';
  
  import * as chartConfigs from '../components/Charts/config';
  import config from '../config';
  import 'owl.carousel/dist/assets/owl.carousel.css';

  import { mapMutations } from 'vuex';
  import 'hover.css'
  import 'animate.css'
  import anime from 'animejs'

  export default {
    props: {
      tableData: {
        type: Array,
        required: true
      },
      type: {
        type: String,
        required: true
      },
      group: {
        type: String,
        required: true
      },
      fields: {
        type: Array,
        required: true
      },
      has_times: {
        type: Boolean,
        default: false
      },
      has_operation: {
        type: Boolean,
        default: false
      },
      methods: {
        type: Object,
        required: true
      },
      label: {
        type: String,
        required: true
      },
      canEdit: {
        type: Boolean,
        default: true
      },
      canDelete: {
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
          return this.tableData.length === this.attr('selected_items').length
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

        if ( ++this.entered_count === this.tableData.length )
          this.is_finished = true
      },

      handleSelectAll(event) {
        let temp = event.target.checked ? Array.apply(null, {length: this.tableData.length }).map( (v, i) => i) : []

        this.selected_items = temp;
        this.setAttr('selected_items', temp, true)
      },
      handleSelectedChange(value) {
        this.setAttr('selected_items', this.selected_items, true)
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

  .tim-icons {
    margin-left: 5px;
  }

  .badge-default {
    color: #344675 !important;
    background: transparent !important;
    border: 1px solid #344675 !important;
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
    transition: transform 200ms, box-shadow 250ms;
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

  .data-table-row ul li:first-of-type {
    text-shadow: 0px 10px 37px #440139;
  }
  
  .data-table-row:hover {
    transform: scale(1.01);
    box-shadow: 0px 0px 70px -30px #ff00d3;
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

  button.swal2-confirm {
    background: linear-gradient(to bottom left, #00f2c3, #0098f0) !important;
  }

  button.swal2-cancel {
    background: linear-gradient(to bottom left, #fd5d93, #ec250d) !important;
  }

  .el-checkbox__inner {
    margin-top: 10px;
  }
</style>