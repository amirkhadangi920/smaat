<template>
  <base-feature
    type="size"
    ref="base"
    label="سایز"
    :validate="validate"
    plural="sizes"
    :fields="[
    {
      field: 'name',
      label: 'نام سایز',
      icon: 'icon-caps-small'
    }, {
      field: 'description',
      label: 'توضیحات سایز',
      icon: 'icon-paper'
    },
  ]">
    <md-field :class="getValidationClass('name')">
      <label for="email">نام سایز</label>
      <md-input v-model="name" :maxlength="$v.name.$params.maxLength.max" />
      <i class="md-icon tim-icons icon-caps-small"></i>
      <span class="md-helper-text">برای مثال : xxl</span>
      <span class="md-error" v-show="!$v.name.required">لطفا نام سایز را وارد کنید</span>
    </md-field>
    <br/>
    <md-field :class="getValidationClass('description')">
      <label for="email">توضیحات سایز</label>
      <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
      <i class="md-icon tim-icons icon-paper"></i>
      <span class="md-helper-text">توضیحی مختصر درباره سایز</span>
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
  data() {
    return {
      group: 'feature',
      type: 'size'
    }
  },
  metaInfo: {
    title: 'سایز و اندازه ها',
  },
  validations: {
    name: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(255)
    },
  },
  computed: {
    name: bind('name'),
    description: bind('description')
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>