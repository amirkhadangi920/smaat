<template>
  <base-feature
    type="warranty"
    ref="base"
    :has_logo="true"
    label="گارانتی"
    :validate="validate"
    plural="warranties"
    :fields="[
    {
      field: 'title',
      label: 'نام گارانتی',
      icon: 'icon-caps-small'
    }, {
      field: 'expire',
      label: 'مدت اعتبار',
      icon: 'icon-time-alarm'
    }, {
      field: 'description',
      label: 'توضیحات گارانتی',
      icon: 'icon-paper'
    },
  ]">
  
    <md-field :class="getValidationClass('title')">
      <label for="email">نام گارانتی</label>
      <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
      <i class="md-icon tim-icons icon-caps-small"></i>
      <span class="md-helper-text">برای مثال : مدیران</span>
      <span class="md-error" v-show="!$v.title.required">لطفا نام گارانتی را وارد کنید</span>
    </md-field>
    <br/>
    <md-field :class="getValidationClass('expire')">
      <label for="email">مدت اعتبار گارانتی</label>
      <md-input v-model="expire" :maxlength="$v.expire.$params.maxLength.max" />
      <i class="md-icon tim-icons icon-time-alarm"></i>
      <span class="md-helper-text">برای مثال : ۳ سال</span>
      <span class="md-error" v-show="!$v.expire.required">لطفا مدت اعتبار گارانتی را وارد کنید</span>
    </md-field>
    <br/>
    <md-field :class="getValidationClass('description')">
      <label for="email">توضیحات گارانتی</label>
      <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
      <i class="md-icon tim-icons icon-paper"></i>
      <span class="md-helper-text">توضیحی مختصر درباره گارانتی</span>
    </md-field>
  </base-feature>
</template>

<script>
import BaseFeature from './Base.vue'

import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  mixins: [
    validationMixin,
    Binding
  ],
  components: {
    BaseFeature
  },
  metaInfo: {
    title: 'گارانتی ها',
  },
  data() {
    return {
      group: 'feature',
      type: 'warranty'
    }
  },
  validations: {
    title: {
      required,
      maxLength: maxLength(50)
    },
    expire: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(255)
    },
  },
  computed: {
    title: bind('title'),
    expire: bind('expire'),
    description: bind('description')
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>