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
import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
import SmartInput from '../../components/BaseInput'
import BaseForm from '../../components/BaseForm'

export default {
  mixins: [validationMixin, Binding],
  components: {
    SmartInput,
    BaseFeature,
    BaseForm
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
  mounted() {
    
  },
  methods: {
    validate() {
      this.$v.$touch()

      return !this.$v.$invalid;
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