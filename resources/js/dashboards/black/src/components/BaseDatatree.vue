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
      <div class="row" v-if="attr('has_loaded') && false" dir="rtl">
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

      <card :style="{ height: '300px', position: 'relative', zIndex: 100 }"></card>
    </div>

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
          <base-button @click="createMethod(null)" :disabled="can(`create-${type}`)" size="sm" :type="can(`create-${type}`) ? 'info' : 'success'">
            افزودن {{ label }} جدید
            <i class="tim-icons icon-simple-add"></i>
          </base-button>
        </div>
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
          <div class="custom-tree-node col-11" slot-scope="{ node, data }">
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
              <i class="md-icon tim-icons icon-tag"></i>
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
          type="secondary"
          simple
          size="sm"
          @click="setAttr('is_open', false)">
          لغو
        </base-button>
        
        <base-button
          simple
          size="sm" 
          :type="attr('is_creating') ? 'danger' : 'warning'"
          @click="attr('is_creating') ? store() : update()">
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
    initMixin,
    deleteMixin,
    createMixin,
    validationMixin,
    Binding
  ],
  components: {
    LineChart,
    ICountUp
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

    allQuery() {
      return `title description logo { id file_name thumb }`
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
}
.el-tree.group-tree .el-tree-node {
  padding: 15px 0px;
}
.el-tree.group-tree .el-tree-node__expand-icon {
  font-size: 18px;
}
.el-tree.group-tree .el-tree-node__children {
  margin-top: 20px;
  margin-bottom: 30px;
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

.custom-tree-node img {
  max-height: 50px;
  width: 50px;
  margin-right: 10px;
}
</style>