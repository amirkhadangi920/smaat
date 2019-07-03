<template>
  <datatable
    :type="type"
    :group="group"
    :label="label"
    :fields="getFields"
    
    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"  
    ref="datatable"
  > 
    <template #permissions_count-body="slotProps">
      <span v-if="slotProps.row.permissions.length" class="badge badge-default">دارای <strong>{{ slotProps.row.permissions.length }}</strong> دسترسی</span>
      <span v-else class="badge badge-danger">بدون دسترسی دسترسی</span>
    </template>

    <template slot="modal">
      <div class="row">
        <md-field :class="getValidationClass('display_name')">
          <label>نام نقش</label>
          <md-input v-model="display_name" :maxlength="$v.display_name.$params.maxLength.max" />
          <i class="md-icon tim-icons icon-caps-small"></i>
          <span class="md-helper-text">برای مثال : مدیر فروش</span>
          <span class="md-error" v-show="!$v.display_name.required">لطفا نام نقش را وارد کنید</span>
        </md-field>

        <md-field :class="getValidationClass('description')">
          <label>توضیحات نقش</label>
          <md-textarea v-model="description" :maxlength="$v.description.$params.maxLength.max"></md-textarea>
          <i class="md-icon tim-icons icon-paper"></i>
          <span class="md-helper-text">توضیحی مختصر درباره نقش و دسترسی های آن</span>
        </md-field>

        <base-input label="سطح دسترسی ها" :style="{ marginTop: '25px' }">
          <el-transfer
            v-model="permissions"
            filterable
            :filter-method="filterMethod"
            filter-placeholder="جستجو دسترسی ..."
            :titles="['موجود', 'اعطا شده']"
            :button-texts="['گرفتن دسترسی', 'اعطاء دسترسی']"
            :format="{
              noChecked: '${total}',
              hasChecked: '${checked}/${total}'
            }"
            :data="$store.state.permissions_list.map(value => { return { key: value.id, label: value.display_name, description: value.description } } )">

            <template #default="props">
              <span>
                <p>{{ props.option.label }}</p>
                <span class="text-muted">{{ props.option.description }}</span>
              </span>
            </template>

          </el-transfer>
          <span class="text-muted">سطح دسترسی های مورد نظر خود انتخاب و آن ها را اعطاء کنید</span>
        </base-input>
      </div>
    </template>
  </datatable>
</template>

<script>
import Datatable from '../../components/BaseDatatable.vue'
import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'

import Binding, { bind } from '../../mixins/binding'

import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {
    Datatable,
  },
  mixins: [
    initDatatable,
    createMixin,
    Binding,
    validationMixin
  ],
  data() {
    
    return {
      plural: 'roles',
      type: 'role',
      group: 'user',
      label: 'نقش',
    }
  },
  validations: {
    display_name: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(255)
    },
  },
  methods: {
    filterMethod(query, item) {
      return item.label.toLowerCase().indexOf(query.toLowerCase()) > -1;
    },

  },
  computed: {
    display_name: bind('display_name'),
    description: bind('description'),
    permissions: bind('permissions'),

    getFields() {
      return [
        {
          field: 'display_name',
          label: 'نام',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات',
          icon: 'icon-paper'
        }, {
          field: 'permissions_count',
          label: 'میزان دسترسی',
          icon: 'icon-key-25'
        },
      ]
    },

    allQuery() {
      return `
        display_name
        description
        permissions { id }
      `
    }
  },
  watch: {
    permissions(newValue, oldValue) {
      // console.log( newValue, oldValue )
    }
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>

<style>
.el-transfer {
  margin-top: 20px;
  text-align: right;
  display: inline-block;
  min-width: 585px;
}
.el-transfer .el-button i {
  transform: rotate(180deg);
}
.el-transfer .el-transfer-panel__header .el-checkbox__label {
  position: relative;
  width: 100%;
  left: 15px;
}
.el-transfer .el-checkbox__label span {
  left: 0px;
  right: auto !important;
}
.el-transfer .el-checkbox__label p {
  margin-top: -5px !important;
}
.el-transfer .el-checkbox__label .text-muted {
  display: block;
  margin-top: -20px;
  font-size: 10px;
}
.el-transfer .el-checkbox__inner {
  margin-top: 0px;
  left: 20px;
}
.el-transfer .el-checkbox:last-child {
  margin-right: 30px;
}
</style>
