<template>
  <div>
    <div :style="{ position: 'relative', zIndex: 1000 }">
      <div class="row col-12 m-0 p-0">
        <div class="col-12 text-right m-0 p-0">
          <div class="pull-right">
            <h1 class="animated bounceInRight delay-first" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
              مدیریت <span :style="{ color: '#ff3d3d' }">جدول مشخصات</span> فنی
              <i class="tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
            </h1>
            <h6 class="text-muted animated bounceInRight delay-secound">با استفاده از جداول زیر ، امکان مدیریت کامل جدول مشخصات فنی مورد نظر برای شما ممکن خواهد شد</h6>
          </div>
          <div class="pull-left animated bounceInDown delay-last">
            <flip-clock :options="{
              label: false,
              clockFace: 'TwentyFourHourClock'
            }" />
          </div>
        </div>
      </div>

      <card :style="{ height: '300px' }" class="operation-cell">
        <h4 class="card-title">{{ table_title }}</h4>
        <h6 class="card-subtitle mb-2 text-muted">{{ table_description }}</h6>
        <a class="card-link">{{ table_category ? table_category.title : '' }}</a>

        <hr />

        <base-button @click="createMethod(null, 'header')" type="success" size="sm" class="ml-2">
          <i class="tim-icons icon-simple-add"></i>
          ثبت عنوان جدید
        </base-button>

        <base-button @click="$router.push('/panel/specification')" size="sm" type="warning" class="pull-left">
            <i class="tim-icons icon-double-left"></i>
            بازگشت
          </base-button>
      </card>

      <md-dialog :md-active.sync="$store.state.spec.is_open.spec_header" class="text-right" dir="rtl">
        <md-dialog-title>
          <h2 class="modal-title">
            {{ $store.state.spec.is_creating.spec_header ? 'ثبت عنوان جدول' : 'ویرایش عنوان جدول' }}
          </h2>
          <p>از طریق فرم زیر میتوانید عنوان جدول {{ $store.state.spec.is_creating.spec_header ? 'جدید ثبت کنید' : 'مورد نظر خود را ویرایش کنید' }}</p>
        </md-dialog-title>

        <div class="md-dialog-content">
          <div class="p-2">
            <form @submit.prevent>
              <md-field>
                <label>عنوان</label>
                <md-input v-model="header_form.title.value" :maxlength="50" />
                <i class="md-icon tim-icons icon-tag"></i>
                <span class="md-helper-text">برای مثال : مشخصات پردازنده</span>
                <!-- <span class="md-error" v-show="!$v.title.required">لطفا عنوان را وارد کنید</span> -->
              </md-field>
              <br/>
              <md-field>
                <label>توضیحات</label>
                <md-textarea v-model="header_form.description.value" md-autogrow :maxlength="250"></md-textarea>
                <i class="md-icon tim-icons icon-paper"></i>
                <span class="md-helper-text">توضیحی مختصر درباره این عنوان</span>
              </md-field>
            </form>
          </div>
        </div>

        <md-dialog-actions>
          <base-button
            simple
            type="secondary"
            @click="$store.state.spec.is_open.spec_header = false">
            لغو
          </base-button>
          
          <base-button 
            simple
            :type="$store.state.spec.is_creating.spec_header ? 'primary' : 'danger'"
            @click="$store.state.spec.is_creating.spec_header ? store() : update()">
            {{ $store.state.spec.is_creating.spec_header ? 'ذخیره' : 'بروز رسانی' }} عنوان جدول مشخصات
          </base-button>
        </md-dialog-actions>
      </md-dialog>

      <md-dialog :md-active.sync="$store.state.spec.is_open.spec_row" class="text-right" dir="rtl">
        <md-dialog-title>
          <h2 class="modal-title">
            {{ $store.state.spec.is_creating.spec_row ? 'ثبت ردیف جدول' : 'ویرایش ردیف جدول' }}
          </h2>
          <p>از طریق فرم زیر میتوانید ردیف جدول {{ $store.state.spec.is_creating.spec_row ? 'جدید ثبت کنید' : 'مورد نظر خود را ویرایش کنید' }}</p>
        </md-dialog-title>

        <div class="md-dialog-content">
          <div class="p-2">
            <form @submit.prevent>
              <md-field>
                <label>عنوان</label>
                <md-input v-model="row_form.title.value" :maxlength="50" />
                <i class="md-icon tim-icons icon-paper"></i>
                <!-- <span class="md-error" v-show="!$v.title.required">لطفا عنوان ردیف را وارد کنید</span> -->
              </md-field>

              <div class="row">
                <div class="col-6">
                  <md-field>
                    <label>پیشوند</label>
                    <md-input v-model="row_form.prefix.value" :maxlength="20" />
                    <i class="md-icon tim-icons icon-tag"></i>
                    <span class="md-helper-text">پیشوند مقادیر جدول</span>
                  </md-field>
                </div>
                <div class="col-6">
                  <md-field>
                    <label>پسوند</label>
                    <md-input v-model="row_form.postfix.value" :maxlength="20" />
                    <i class="md-icon tim-icons icon-puzzle-10"></i>
                    <span class="md-helper-text">پسوند مقادیر جدول</span>
                  </md-field>
                </div>
              </div>
              <br/>

              <md-field>
                <label>توضیحات</label>
                <md-textarea v-model="row_form.description.value" md-autogrow :maxlength="250"></md-textarea>
                <i class="md-icon tim-icons icon-paper"></i>
                <span class="md-helper-text">توضیحی مختصر درباره این ردیف</span>
              </md-field>
              <br/>

              <md-field>
                <label>راهنما</label>
                <md-textarea v-model="row_form.help.value" md-autogrow :maxlength="250"></md-textarea>
                <i class="md-icon tim-icons icon-alert-circle-exc"></i>
                <span class="md-helper-text">راهنمایی کوتاه جهت نمایش به کاربران درباره این ردیف</span>
              </md-field>
              <br/>

              <div class="row" dir="ltr">
                <el-switch
                  class="col-4 d-flex justify-content-center"
                  v-model="row_form.is_filterable.value"
                  active-text="قابلیت فیتلر"
                  inactive-text="غیرقابل فیلتر">
                </el-switch>
                <el-switch
                  class="col-4 d-flex justify-content-center"
                  v-model="row_form.is_multiple.value"
                  active-text="چند مقداری"
                  inactive-text="تک مقداری">
                </el-switch>
                <el-switch
                  class="col-4 d-flex justify-content-center"
                  v-model="row_form.is_required.value"
                  active-text="اجباری"
                  inactive-text="اختیاری">
                </el-switch>
              </div>
              <br/>
            </form>
          </div>
        </div>

        <md-dialog-actions>
          <base-button
            type="secondary"
            @click="$store.state.spec.is_open.spec_row = false">
            لغو
          </base-button>
          
          <base-button
            :type="$store.state.spec.is_creating.spec_row ? 'primary' : 'danger'"
            @click="$store.state.spec.is_creating.spec_row ? store() : update()">
            {{ $store.state.spec.is_creating.spec_row ? 'ذخیره' : 'بروز رسانی' }} ردیف جدول مشخصات
          </base-button>
        </md-dialog-actions>
      </md-dialog>

      <md-dialog :md-active.sync="$store.state.spec.is_open.spec_default" class="text-right" dir="rtl">
        <md-dialog-title>
          <h2 class="modal-title">مدیریت مقادیر سطر</h2>
          <p>از طریق فرم زیر میتوانید کلیه مقادیر جدول را مدیریت کنید</p>
        </md-dialog-title>

        <div class="md-dialog-content">
          <div class="p-2">
            <div>
              <base-button @click="createDefault(null, null, true)" type="success" size="sm">
                <i class="tim-icons icon-simple-add"></i>
                ثبت مقدار جدید
              </base-button>
            </div>

            <base-table
              :style="{ width: '100%' }"
              :tableData="row_defaults"
              :has_animation="false"
              type="brand"
              group="feature"
              label="مقدار"
              :fields="[
                {
                  field: 'value',
                  label: 'مقدار',
                  icon: 'icon-caps-small'
                }
              ]"
              :has_loaded="true"
              :methods="{ deleteSingle: deleteDefault, edit: createDefault }"
              :has_operation="true"
              :has_times="false"
            >
            </base-table>
          </div>
        </div>

        <md-dialog-actions>
          <base-button
            type="secondary"
            @click="$store.state.spec.is_open.spec_default = false">
            لغو
          </base-button>
        </md-dialog-actions>
      </md-dialog>

      <div v-for="(header, index) of headers" :key="header.id" class="row mb-3 w-100 m-0">
        <div class="col-12">
          <div class="text-right pull-right">
            <h2 class="animated bounceInRight delay-first mb-0">
              {{ header.title }}
              <i class="tim-icons icon-bullet-list-67" :style="{fontSize: '20px'}"></i>
            </h2>
            <h6 class="text-muted animated bounceInRight delay-secound">{{ header.description }}</h6>
          </div>

          <div class="animated bounceInLeft delay-secound operation-cell" dir="rtl">
            <el-tooltip content="ثبت ردیف برای این عنوان">
              <base-button @click="createMethod(header.id, 'row')" type="success" size="sm" icon>
                <i class="tim-icons icon-simple-add"></i>
              </base-button>
            </el-tooltip>

            <el-tooltip content="ویرایش عنوان">
              <base-button @click="editMethod(index, header, 'header')" type="warning" size="sm" icon>
                <i class="tim-icons icon-pencil"></i>
              </base-button>
            </el-tooltip>

            <el-tooltip content="حذف عنوان">
              <base-button @click="deleteSingle(index, header, 'header')" type="danger" size="sm" icon>
                <i class="tim-icons icon-trash-simple"></i>
              </base-button>
            </el-tooltip>
          </div>
        </div>

        <base-table
          :style="{ width: '100%' }"
          :tableData="header.rows"
          :has_animation="false"
          type="brand"
          group="feature"
          label="سطر جدول"
          :fields="[
            {
              field: 'title',
              label: 'عنوان جدول',
              icon: 'icon-caps-small'
            }, {
              field: 'defaults',
              label: 'مقادیر پیشفرض',
              icon: 'icon-single-copy-04'
            }, {
              field: 'texts',
              label: 'پیشوند/پسوند',
              icon: 'icon-single-copy-04'
            }, {
              field: 'features',
              label: 'ویژگی ها',
              icon: 'icon-single-copy-04'
            }
          ]"
          :methods="{ edit: editMethod, deleteSingle }"
          :has_loaded="has_loaded"
          :has_times="true"
          :has_operation="true"
        >
          <template #title-body="slotProps">
            <el-tooltip :content="slotProps.row.help">
              <p>{{ slotProps.row.title }}</p>
            </el-tooltip>
          </template>

          <template #defaults-body="slotProps">
            <transition-group name="list">
              <span
                v-for="item in slotProps.row.defaults.filter( (i, index) => index < 3)"
                :key="item.id"
                class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
                <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
                {{ item.value }}
              </span>

              <el-dropdown v-if="slotProps.row.defaults.length > 3" :key="slotProps.row.defaults.map((c) => c.id).join(',')">
                <span class="el-dropdown-link badge badge-default">
                  باقی مقادیر ها <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item
                    v-for="item in slotProps.row.defaults.filter( (i, index) => index < 3)"
                    :key="item.id">
                    {{ item.value }}
                  </el-dropdown-item>
                </el-dropdown-menu>
              </el-dropdown>
            </transition-group>
          </template>

          <template #features-body="slotProps">
            <div>
              <el-tooltip content="ایجاد شده در" placement="left">
                <p :class="slotProps.row.is_required ? 'text-success' : 'text-danger'">
                  <i class="tim-icons icon-lock-circle"></i>
                  {{ slotProps.row.is_required ? 'اجباری' : 'اختیاری' }}
                </p>
              </el-tooltip>

              <el-tooltip content="ایجاد شده در" placement="left">
                <p :class="slotProps.row.is_multiple ? 'text-success' : 'text-danger'">
                  <i class="tim-icons icon-bullet-list-67"></i>
                  {{ slotProps.row.is_multiple ? 'چند مقداری' : 'تک مقداری' }}
                </p>
              </el-tooltip>
              
              <el-tooltip content="ایجاد شده در" placement="left">
                <p :class="slotProps.row.is_filterable ? 'text-success' : 'text-danger'">
                  <i class="tim-icons icon-pin"></i>
                  {{ slotProps.row.is_filterable ? 'قابلیت فیلتر' : 'غیرقابل فیلتر' }}
                </p>
              </el-tooltip>
            </div>

          </template>

          <template #texts-body="slotProps">
            <div>
              <p v-if="slotProps.row.postfix">
                <i class="tim-icons icon-double-right"></i>
                {{ slotProps.row.postfix }}
              </p>
              <p v-if="slotProps.row.prefix">
                <i class="tim-icons icon-double-left"></i>
                {{ slotProps.row.prefix }}
              </p>
            </div>
          </template>

          <template #custom-operations="slotProps">
            <el-tooltip content="مدیریت مقادیر">
              <base-button class="m-0" @click="manageValues(slotProps.index, slotProps.row)" type="success" size="sm" icon>
                <i class="tim-icons icon-bullet-list-67"></i>
              </base-button>
            </el-tooltip>
          </template>
        </base-table>
      </div>

      <transition name="fade">
        <md-empty-state
          v-show="headers.length === 0"
          md-icon="search"
          md-label="متاسفانه هیچ داده ای یافت نشد :("
          md-description="اگر در حالت جستجو نیستید و هیچ فیلتری نیز اعمال نکرده اید ، میتوانید با کلیک بر روی دکمه زیر یک داده جدید ثبت کنید">
          <base-button @click="createMethod(null, 'header')" type="success" size="sm" class="ml-2">
            <i class="tim-icons icon-simple-add"></i>
            ثبت عنوان جدید
          </base-button>
        </md-empty-state>
      </transition>
    </div>
  </div>
</template>

<script>
import BaseTable from '../../components/BaseTable.vue'
import { FlipClock } from '@mvpleung/flipclock';
import deleteMixin from '../../mixins/deleteMixin';
import createMixin from '../../mixins/createMixin';

export default {
  mixins: [ createMixin, deleteMixin ],
  components: { BaseTable, FlipClock },
  data() {
    return {
      headers: [],
      row_defaults: [],
      table_title: '',
      table_description: '',
      table_category: null,

      type: null,
      group: 'spec',
      has_loaded: false,
      is_modal_open: false,
      is_open_value_prompt: false,
      selected_type: false
    }
  },
  methods: {
    createMethod(id = null, type = 'row')
    {
      this.label = type === 'row' ? 'سطر جدول' : 'عنوان جدول'
      this.type = type === 'row' ? 'spec_row' : 'spec_header'
      this.selected_type = type
      this.selected_header_id = id
      
      this.create()
    },
    createDefault(index = null, row = null, is_creating = false)
    {
      this.label = 'مقدار پیشفرض'
      this.type = 'spec_default'
      this.selected_type = 'default'

      this.setAttr('is_creating', is_creating)

      if ( !is_creating )
      {
        this.setAttr('selected', {
          index,
          id: row.id
        })
      }
     
      this.$swal.fire({
        title: 'مقدار مورد نظر خود را وارد کنید :',
        input: 'text',
        inputValue: is_creating ? '' : row.value,
        showCancelButton: true,
        confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
        confirmButtonColor: '#0098f0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ذخیره',
        cancelButtonText: 'لغو',
        inputValidator: (value) => {
          if (!value) {
            return 'فیلد مقدار نمیتواند خالی باشد :('
          }
        }
      }).then(({value}) => {
        
        this.$store.commit('setFormData', {
          group: this.group,
          type: this.type,
          field: 'value',
          value: value
        })

        this.storeInServer({
          callback: ({data}) => {

            if ( is_creating ) {
              this.row_defaults.unshift(data)
            } else {
              this.row_defaults[ this.attr('selected').index ].value = data.value
            }
          }
        })
      })
    },
    afterCreate()
    {
      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: this.selected_type === 'row' ? 'spec_header_id' : 'spec_id',
        value: this.selected_type === 'row' ? this.selected_header_id : this.$route.params.id
      })
    },
    editMethod(index, row, type = 'row')
    {
      this.label = type === 'row' ? 'سطر جدول' : 'عنوان جدول'
      this.type = type === 'row' ? 'spec_row' : 'spec_header'
      this.selected_type = type
      
      this.edit(index, row)
    },
    afterEdit(row)
    {
      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: this.selected_type === 'row' ? 'spec_header_id' : 'spec_id',
        value: this.selected_type === 'row' 
          ? this.headers.filter( header => header.rows.filter(i => i.id === row.id).length !== 0 )[0].id
          : this.$route.params.id
      })
    },
    store()
    {
      this.storeInServer({
        callback: ({data}) => {

          if ( this.selected_type === 'row' )
          {
            this.headers.filter(i => i.id === this.selected_header_id)[0].rows.unshift(data)
          }
          else
          {
            data.rows = []
            this.headers.unshift(data)
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
          let index = this.attr('selected').index;

          if ( this.selected_type === 'row' )
          {
            let item = this.headers.filter( header => header.rows.filter(i => i.id === data.id).length !== 0 )
            item[0].rows[index] = data
          }
          else
          {
            data.rows = this.headers[index].rows
            this.headers[index] = data
          }

          this.setAttr('is_open', false)
        }
      })
    },
    deleteSingle(index, row, type = 'row')
    {
      this.label = type === 'row' ? 'سطر جدول' : 'عنوان جدول'
      this.type = type === 'row' ? 'spec_row' : 'spec_header'
      this.selected_type = type

      this.handleDelete(index, row)
    },
    deleteDefault(index, row)
    {
      this.label = 'مقدار سطر'
      this.type = 'spec_default'
      this.selected_type = 'default'

      this.handleDelete(index, row)
    },
    afterDelete(index, row)
    {
      if ( this.selected_type === 'row' )
      {
        let item = this.headers.filter( header => header.rows.filter(i => i.id === row.id).length !== 0 )
        item[0].rows.splice(index, 1)
      }
      else if ( this.selected_type === 'default' )
      {
        this.row_defaults.splice(index, 1)   
      }
      else
        this.headers.splice(index, 1)
    },
    manageValues(index, row)
    {
      this.row_defaults = row.defaults
      this.type = 'spec_default'

      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: 'spec_row_id',
        value: row.id
      })

      this.setAttr('is_open', true)
    },
    validate() {
      return true;
    }
  },
  computed: {
    row_form() {
      return this.$store.state.spec.form.spec_row
    },
    header_form() {
      return this.$store.state.spec.form.spec_header
    },
    allQuery()
    {
      if ( this.selected_type === 'row' )
      {
        return `
          title
          description
          help
          postfix
          prefix
          is_required
          is_multiple
          is_filterable
          created_at
          updated_at

          defaults {
            id
            value
          }
        `
      }
      else if ( this.selected_type === 'header' )
      {
        return `
          title
          description
          rows {
            id
          }
        `
      }

      return `value`
    }
  },
  mounted()
  {
    axios.get('/graphql/auth', {
      params: {
        query: `{
          spec(id: ${this.$route.params.id}) {
            id
            title
            description
            category {
              id
              title
            }
            headers {
              id
              title
              description

              rows {
                id
                title
                description
                help
                postfix
                prefix
                is_required
                is_multiple
                is_filterable
                created_at
                updated_at

                defaults {
                  id
                  value
                }
              }
            }
          }
        }`
      }
    })
    .then(({data}) => {
      this.table_title = data.data.spec.title
      this.table_description = data.data.spec.description
      this.table_category = data.data.spec.category
      this.headers = data.data.spec.headers
    })
    .then( () => this.has_loaded = true)
  },
}
</script>