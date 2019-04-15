<template>
  <base-feature type="unit" ref="base" label="واحد" :validate="validate" :fields="[
    {
      field: 'title',
      label: 'عنوان واحد',
      icon: 'icon-caps-small'
    }, {
      field: 'description',
      label: 'توضیحات واحد',
      icon: 'icon-single-copy-04'
    },
  ]">
    <md-field :class="getValidationClass('title')">
      <label for="email">عنوان واحد</label>
      <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
      <i class="md-icon tim-icons icon-tag"></i>
      <span class="md-helper-text">برای مثال : عدد</span>
      <span class="md-error" v-show="!$v.title.required">لطفا نام واحد را وارد کنید</span>
    </md-field>
    <br/>
    <md-field :class="getValidationClass('description')">
      <label for="email">توضیحات واحد</label>
      <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
      <i class="md-icon tim-icons icon-paper"></i>
      <span class="md-helper-text">توضیحی مختصر درباره واحد</span>
    </md-field>
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
      type: 'unit'
    }
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
    title: bind('title'),
    description: bind('description')
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>