<template>
  <base-feature
    ref="base"
    type="brand"
    :has_logo="true"
    label="برند"
    :validate="validate"
    plural="brands"
    :fields="[
    {
      field: 'name',
      label: 'نام برند',
      icon: 'icon-caps-small'
    }, {
      field: 'description',
      label: 'توضیحات برند',
      icon: 'icon-paper'
    },
  ]">

    <base-form :validation="$v">

      <smart-input
        v-model="name"
        label="نام برند"
        icon="icon-caps-small"
        description="برای مثال : سامسونگ"
        :validation="$v.name"
      />

      <smart-input
        v-model="description"
        type="textarea"
        label="توضیحات برند"
        icon="icon-paper"
        description="توضیحی مختصر درباره برند"
        :validation="$v.description"
      />
    </base-form>

  </base-feature>
</template>

<script>
import BaseFeature from './Base.vue'
import SmartInput from '../../components/BaseInput'
import BaseForm from '../../components/BaseForm'

import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  mixins: [
    validationMixin,
    Binding
  ],
  components: {
    SmartInput,
    BaseFeature,
    BaseForm
  },
  metaInfo: {
    title: 'برندها',
  },
  data() {
    return {
      group: 'feature',
      type: 'brand',
    }
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