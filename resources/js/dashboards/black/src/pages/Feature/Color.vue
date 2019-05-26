<template>
  <base-feature
    type="color"
    ref="base"
    label="رنگ"
    :validate="validate"
    plural="colors"
    :fields="[
    {
      field: 'name',
      label: 'نام رنگ',
      icon: 'icon-caps-small'
    }, {
      field: 'code',
      label: 'کد رنگ',
      icon: 'icon-single-copy-04'
    }
  ]">

    <div class="row">
      <div class="col-md-8">
        <md-field :class="getValidationClass('name')">
          <label>نام رنگ</label>
          <md-input v-model="name" :maxlength="$v.name.$params.maxLength.max" />
          <i class="md-icon tim-icons icon-tag"></i>
          <span class="md-helper-text">برای مثال : نارنجی</span>
          <span class="md-error" v-show="!$v.name.required">لطفا نام رنگ را وارد کنید</span>
        </md-field>
      </div>

      <div class="col-md-4">
        <md-field :class="getValidationClass('code')">
          <el-color-picker v-model="code"></el-color-picker>
          <span class="md-helper-text">رنگ را انتخاب کنید</span>
          <span class="md-error" v-show="!$v.code.required">لطفا کد رنگ را وارد کنید</span>
        </md-field>
      </div>
    </div>

  </base-feature>
</template>

<script>
import BaseFeature from './Base.vue'
import Binding, { bind } from '../../mixins/binding'

import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  mixins: [ validationMixin, Binding ],
  components: {
    BaseFeature
  },
  data() {
    return {
      group: 'feature',
      type: 'color'
    }
  },
  validations: {
    name: {
      required,
      maxLength: maxLength(50)
    },
    code: {
      required,
    },
  },
  methods: {
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
    name: bind('name'),
    code: bind('code')
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>

<style>
.el-color-picker, .el-color-picker__trigger {
  width: 100%;
}
.el-color-picker__color-inner {
  border-radius: 10px 10px 0px 0px;
  margin-bottom: -1px;
}
.el-color-picker__color {
  border: none;
}
.el-color-picker__trigger {
  padding: 0px;
  height: 39px;
  border: none;
}
</style>
