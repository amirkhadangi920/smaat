<template>
  <div :style="{ position: 'relative', zIndex: 10 }">
    <div class="row mt-3 mb-3">
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

    <div class="row mb-4">
      <div class="pull-left animated bounceInDown delay-last">
        <base-button @click="createMethod(null)" :disabled="can(`create-${type}`)" size="sm" :type="can(`create-${type}`) ? 'info' : 'success'">
          افزودن {{ label }} جدید
          <i class="tim-icons icon-simple-add"></i>
        </base-button>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <el-tree
          class="rtl group-tree"
          :data="$store.state.group[type]"
          node-key="id"
          empty-text="هیچ گونه اطلاعاتی یافت نشد :("
          :props="defaultProps">
          <div class="custom-tree-node data-table-row col-12 pr-3" slot-scope="{ node, data }">
            <div class="pull-left d-flex align-items-center">
              <img :src="data.logo ? data.logo.thumb : '/images/placeholder.png'" />
              <div class="pull-right group-info">
                <h4 class="mb-0">{{ node.label }}</h4>
                <p class="text-muted">{{ data.description }}</p>
              </div>
            </div>
            
            <div class="operation-cell pull-right">
              <el-tooltip content="حذف">
                <base-button type="danger" @click="handleDelete(node, data)" size="sm" icon>
                  <i class="tim-icons icon-simple-remove"></i>
                </base-button>
              </el-tooltip>

              <el-tooltip content="ویرایش">
                <base-button class="ml-2" @click="edit(node, data)" type="warning" size="sm" icon>
                  <i class="tim-icons icon-pencil"></i>
                </base-button>
              </el-tooltip>

              <el-tooltip content="ثبت گروه فرزند">
                <base-button class="ml-2" @click="createMethod(node)" type="success" size="sm" icon>
                  <i class="tim-icons icon-simple-add"></i>
                </base-button>
              </el-tooltip>
            </div>
          </div>
        </el-tree>
      </div>
    </div>
    
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
            <base-input :label="'لوگوی ' + label">
              <el-upload
                class="avatar-uploader"
                action="/"
                :auto-upload="false"
                :show-file-list="false"
                :on-change="addImage">
                <img
                  v-if="$store.state[group].form[type].logo.url"
                  :src="$store.state[group].form[type].logo.url"
                  class="avatar"
                />
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
              </el-upload>
              <small slot="helperText" id="emailHelp" class="form-text text-muted">لوگوی مورد نظر خود را انتخاب کنید</small>
            </base-input>

            <md-field :class="getValidationClass('title')">
              <label for="email">عنوان</label>
              <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
              <i class="md-icon tim-icons icon-caps-small"></i>
              <span class="md-helper-text">برای مثال : کالای دیجیتال</span>
              <span class="md-error" v-show="!$v.title.required">لطفا نام سایز را وارد کنید</span>
            </md-field>
            <br/>

            <md-field :class="getValidationClass('description')">
              <label for="email">توضیحات واحد</label>
              <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
              <i class="md-icon tim-icons icon-paper"></i>
              <span class="md-helper-text">توضیحی مختصر درباره واحد</span>
            </md-field>
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
          @click="attr('is_creating') ? store() : update()"
        >
          <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
          <i v-else class="tim-icons icon-pencil"></i>
          {{ attr('is_creating') ? 'ذخیره' : 'بروز رسانی' }} {{ label }}
        </base-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
</template>

<script>
import LineChart from './Charts/LineChart';
import ICountUp from 'vue-countup-v2';
import initMixin from '../mixins/initDatatree'
import deleteMixin from '../mixins/deleteMixin';
import createMixin from '../mixins/createMixin';
import Binding, { bind } from '../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
import initDatatable from '../mixins/initDatatable';
import { FlipClock } from '@mvpleung/flipclock';


export default {
  props: {
    label: {
      type: String,
      required: true
    },
    type: {
      type: String,
      required: true
    },
    plural: String,
    required: true
  },
  mixins: [
    initDatatable,
    deleteMixin,
    createMixin,
    validationMixin,
    Binding
  ],
  components: {
    LineChart,
    ICountUp,
    FlipClock
  },
  data() {
    return {
        value: [],
        selected_node: null,
        group: 'group',

        defaultProps: {
          children: 'childs',
          label: 'title',
        },
    }
  },
  methods: {
    createMethod(node = null)
    {
      this.selected_node = node
      
      this.create()
    },
    afterCreate()
    {
      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: 'parent_id',
        value: this.selected_node ? this.selected_node.data.id : null
      })
    },
    store()
    {
      this.storeInServer({
        callback: ({data}) => {
  
          if ( this.selected_node )
          {
            data.childs = []
            this.selected_node.data.childs.push(data)
          }
          else
          {
            let arr = this.data()
            arr.push(data)

            this.setData( arr )
          }

          this.setAttr('is_open', false)
          this.setAttr('is_creating', false)
        }
      })
    },
    update()
    {
      this.storeInServer({
        callback: ({data}) => {
          const parent = this.attr('selected').index.parent;
          const children = parent.data.childs || parent.data;
          const index = children.findIndex(d => d.id === data.id);

          children[index].logo = data.logo;
          children[index].title = data.title;
          children[index].description = data.description;

          this.setAttr('is_open', false)
        }
      })
    },
    afterDelete(node, data) 
    {
      const parent = node.parent;
      const children = parent.data.childs || parent.data;
      const index = children.findIndex(d => d.id === data.id);
      children.splice(index, 1);
    },
  },
  validations: {
    title: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(255)
    },
  },
  computed: {
    title: bind('title'),
    description: bind('description'),

    allQuery()
    {
      if ( this.data().length === 0 )
      {
        return `
          title logo { id file_name thumb } childs {
            id title logo { id file_name thumb } childs {
              id title logo { id file_name thumb } childs {
                id title logo { id file_name thumb } childs { id title }
              }
            }
          }
        `
      }

      return `title description logo { id file_name thumb }`
    }
  },
}
</script>

<style>

.el-tree.group-tree .el-tree-node__children .el-tree-node__expand-icon {
  background: #878787;
  margin-right: 7px;
  margin-left: 5px;
  padding: 0px;
  border-radius: 40%;
  color: #eaf1fa;
  font-size: 12px;
}

.el-tree.group-tree .el-tree-node__children .el-tree-node__expand-icon.is-leaf {
  background: unset !important;
  color: transparent !important;
}

.el-tree {
  background: transparent;
}
.el-tree .operation-cell {
  height: 70px;
  display: flex;
  align-items: center;
}

.el-tree.rtl,
.el-tree.rtl .custom-tree-node img,
.el-tree.rtl .custom-tree-node .pull-left .pull-right,
.el-tree.rtl .custom-tree-node .operation-cell,
.el-tree.rtl .el-checkbox__input,
.el-tree.rtl .el-tree__empty-text,
.el-tree-node__label {
  transform: scaleX(-1)
}
.el-tree.rtl .el-tree__empty-text {
  width: 100%;
  text-align: center;
  left: 0px;
  direction: rtl;
}

.el-tree.rtl .custom-tree-node {
  max-width: 100%;
  padding: 0px;
  background: #fff;
  border-radius: 10px;
}
.el-tree.group-tree .el-tree-node {
  padding: 15px 0px;
}
.el-tree.group-tree .el-tree-node__expand-icon {
  font-size: 18px;
  margin-top: -15px;
}
.el-tree.group-tree .el-tree-node__children {
  margin-top: 20px;
  padding-top: 10px;
  position: relative;
}
.el-tree.group-tree .el-tree-node__children::before {
  content: '';
  background: #888;
  width: 2px;
  height: calc(100% - 50px);
  position: absolute;
  border-radius: 3px;
  left: 13px;
  top: 0px;
}
.el-tree.group-tree .el-tree-node__children .el-tree-node__content {
  position: relative;
}
.el-tree.group-tree .el-tree-node__children .el-tree-node__content:hover {
  transform: scale(1);
}
.el-tree.group-tree .el-tree-node__children .el-tree-node__content::before {
  content: '';
  width: 100px;
  height: 2px;
  border-radius: 3px;
  background: #888;
  display: inline-block;
  position: absolute;
  left: 14px;
  top: 4px;
}

.el-tree.group-tree .group-info {
  direction: rtl;
  text-align: right;
  max-width: calc(100% - 80px);
  width: 400px;
}
.el-tree.group-tree .group-info p {
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}

.el-tree.group-tree .el-tree-node__content {
  /* height: 70px;
  margin-bottom: 15px;
  background: #fff !important;
  border-radius: 10px; */
  width: calc(100% - 40px);
  margin-bottom: 15px;
  background: transparent !important;
  transition: transform 200ms;
}

.el-tree-node__content:hover {
  transform: scale(1.01);
}
.el-tree.group-tree .operation-cell {
  height: 50px;
}

.custom-tree-node img {
  max-height: 50px;
  width: 50px;
  margin-right: 10px;
}
</style>