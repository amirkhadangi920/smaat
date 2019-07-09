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
    :canCreate="false" 
    ref="datatable"
  >

    <template #filter-labels></template>
    
    <template #avatar-body="slotProps">
      <img class="tilt" :src="slotProps.row.avatar ? slotProps.row.avatar.thumb : '/images/placeholder-user.png'" />
    </template>

    <template #email-body="slotProps">
      <a :href="`mailto:${slotProps.row.email}`">{{ slotProps.row.email }}</a>
    </template>

    <template #full_name-body="slotProps">
      <span v-if="slotProps.row.full_name.trim()">{{ slotProps.row.full_name }}</span>
      <span v-else class="badge badge-warning">بی نام</span>
    </template>

    <template #roles-body="slotProps">
      <transition-group name="list">
        <span
          v-for="item in slotProps.row.roles.filter( (role, index) => index < 3)"
          :key="item.id"
          class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
          <i class="tim-icons icon-single-02 hvr-icon"></i>
          {{ item.display_name }}
        </span>

        <el-dropdown v-if="slotProps.row.roles.length > 3" :key="slotProps.row.roles.map((c) => c.id).join(',')">
          <span class="el-dropdown-link badge badge-default">
            باقی نقش ها <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item
              v-for="item in slotProps.row.roles.filter( (role, index) => index < 3)"
              :key="item.id">
              {{ item.display_name }}
            </el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </transition-group>
    </template>

    <template #modal>
      <div class="row d-flex justify-content-center">
        <div class="col-md-6">
          <base-input label="تصویر پروفایل کاربر">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="addImage">
              <div v-if="$store.state[group].form[type].avatar.url">
                <img :src="$store.state[group].form[type].avatar.url" class="avatar" />
                <i @click.prevent="deleteImage" class="el-icon-delete avatar-uploader-icon"></i>
              </div>
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">تصویر مورد نظر خود را انتخاب کنید</small>
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <md-field :class="getValidationClass('first_name')">
            <label>نام</label>
            <md-input v-model="first_name" :maxlength="$v.first_name.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-badge"></i>
            <span class="md-helper-text">برای مثال : امیر</span>
            <span class="md-error" v-show="!$v.first_name.required">لطفا نام نقش را وارد کنید</span>
          </md-field>
        </div>
        <div class="col-6">
          <md-field :class="getValidationClass('last_name')">
            <label>نام خانوادگی</label>
            <md-input v-model="last_name" :maxlength="$v.last_name.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-badge"></i>
            <span class="md-helper-text">برای مثال : امیری نژاد</span>
            <span class="md-error" v-show="!$v.last_name.required">لطفا نام نقش را وارد کنید</span>
          </md-field>
        </div>
      </div>

      <md-field :class="getValidationClass('email')">
        <label>آدرس ایمیل</label>
        <md-input v-model="email" :maxlength="$v.email.$params.maxLength.max" />
        <i class="md-icon tim-icons icon-email-85"></i>
        <span class="md-helper-text">برای مثال : test@example.com</span>
        <span class="md-error" v-show="!$v.email.required">لطفا نام نقش را وارد کنید</span>
      </md-field>

      <div class="row">
        <div class="col-md-6">
          <md-field :class="getValidationClass('national_code')">
            <label>کد ملی</label>
            <md-input v-model="national_code" :maxlength="$v.national_code.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-tag"></i>
            <span class="md-helper-text">برای مثال : ۰۹۲۱۰۲۰۳۴۵</span>
            <span class="md-error" v-show="!$v.national_code.required">لطفا آدرس کاربر را وارد کنید</span>
          </md-field>
        </div>

        <div class="col-md-6">
          <md-field :class="getValidationClass('gender')">
            <label>جنسیت</label>
            <md-select v-model="gender" >
              <md-option value="false">مونث</md-option>
              <md-option value="true">مذکر</md-option>
              <md-option value="null">نا مشخص</md-option>
            </md-select>
            <i class="md-icon tim-icons icon-satisfied"></i>
            <span class="md-helper-text">جنسیت خود را مشخص کنید</span>
          </md-field>
        </div>
      </div>


      <base-input label="نقش ها" :style="{ marginTop: '25px' }">
        <el-transfer
          v-model="roles"
          filterable
          :filter-method="filterMethod"
          filter-placeholder="جستجو نقش ..."
          :titles="['موجود', 'اعطا شده']"
          :button-texts="['گرفتن نقش', 'اعطاء نقش']"
          @change="handleRolePermissions"
          :format="{
            noChecked: '${total}',
            hasChecked: '${checked}/${total}'
          }"
          :data="$store.state.user.role.map(value => { return { key: value.id, label: value.display_name, description: value.description } } )">

          <template #default="props">
            <span>
              <p>{{ props.option.label }}</p>
              <span class="text-muted">{{ props.option.description }}</span>
            </span>
          </template>

        </el-transfer>
        <span class="text-muted">نقش های مورد نظر خود انتخاب و آن ها را اعطاء کنید</span>
      </base-input>

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
          :data="$store.state.permissions_list.map(value => { return { key: value.id, label: value.display_name, description: value.description, disabled: value.disabled } } )">

          <template #default="props">
            <span>
              <p>{{ props.option.label }}</p>
              <span class="text-muted">{{ props.option.description }}</span>
            </span>
          </template>

        </el-transfer>
        <span class="text-muted">سطح دسترسی های مورد نظر خود انتخاب و آن ها را اعطاء کنید</span>
      </base-input>
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
import _ from 'lodash'

export default {
  components: {
    Datatable
  },
  mixins: [
    initDatatable,
    createMixin,
    Binding,
    validationMixin
  ],
  metaInfo: {
    title: 'کاربران',
  },
  validations: {
    first_name : {
      maxLength: maxLength(20)
    },
    last_name : {
      maxLength: maxLength(30)
    },
    address : {
      maxLength: maxLength(250)
    },
    email : {
      required,
      maxLength: maxLength(100)
    },
    national_code : {
      maxLength: maxLength(10)
    },
  },
  data() {
    return {
        plural: 'users',
        type: 'user',
        group: 'user',
        label: 'کاربر'
    }
  },
  mounted() {
    this.$store.dispatch('getData', {
      group: 'user',
      type: 'role',
      query: `roles {
        data {
          id name display_name permissions { id } created_at updated_at
        }
        total trash chart { month count }
      }`
    })
  },
  methods: {
    filterMethod(query, item) {
      return item.label.toLowerCase().indexOf(query.toLowerCase()) > -1;
    },
    handleRolePermissions(value, direction, movedKeys)
    {
      let allPermissions = this.$store.state.user.form.user.permissions.value

      movedKeys.forEach(value => {
        _.find(this.$store.state.user.role, ['id', value]).permissions.forEach(value => {
          
          _.find(this.$store.state.permissions_list, ['id', value.id]).disabled = direction === 'right' ? true : false

          if ( direction === 'right' )
            allPermissions = [...allPermissions, value.id]
            
          else
            allPermissions = allPermissions.filter(item => item !== value.id)
        })
      })

      if ( direction === 'left' )
      {
        value.forEach(value => {
          _.find(this.$store.state.user.role, ['id', value]).permissions.forEach(value => {
            
            _.find(this.$store.state.permissions_list, ['id', value.id]).disabled = true

            allPermissions = [...allPermissions, value.id]
          })
        })
      }

      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: 'permissions',
        value: allPermissions
      })
    },
    getRowData(row)
    {
      this.setAttr('is_query_loading', true)

      return axios.get('/graphql/auth', {
        params: {
          query: `{
            singleData: ${this.type} (id: "${row.id}") {
              national_code gender
              permissions { id }
              roles { id }
            }
          }`
        }
      })
    },
    afterEdit(row)
    {
      this.setAttr('is_query_loading', false)

      this.$store.state.permissions_list.forEach(p => p.disabled = false)

      let allPermissions = []

      row.roles.forEach(value => {
        _.find(this.$store.state.user.role, ['id', value.id]).permissions.forEach(value => {

          allPermissions.push(value.id)
          _.find(this.$store.state.permissions_list, ['id', value.id]).disabled = true
        })
      })

      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: 'permissions',
        value: [...allPermissions, ...row.permissions.map(i => i.id)]
      })
    },
    validate() {
      return true
    },
  },
  computed: {
    first_name: bind('first_name'),
    last_name: bind('last_name'),
    avatar: bind('avatar'),
    address: bind('address'),
    email: bind('email'),
    national_code: bind('national_code'),
    gender: bind('gender'),
    roles: bind('roles'),
    permissions: bind('permissions'),

    getFields() {
      return [
        {
          field: 'avatar',
          label: 'آواتار',
          icon: 'icon-image-02'
        }, {
          field: 'full_name',
          label: 'نام و نام خانوادگی',
          icon: 'icon-badge'
        }, {
          field: 'email',
          label: 'آدرس ایمیل',
          icon: 'icon-email-85'
        }, {
          field: 'roles',
          label: 'نقش ها',
          icon: 'icon-tap-02'
        }
      ]
    },
    
    allQuery() {
      return `
        avatar { id file_name thumb medium }
        first_name
        last_name
        full_name
        email
        roles {
          id
          display_name
        }
      `
    },
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>

<style>
.el-button.el-transfer__button:not(.is-disabled) {
  background-color: #ff8d72;
  border-color: #f56c6c;
}
.el-transfer-panel__list .el-checkbox__label {
  height: 100%;
}
</style>