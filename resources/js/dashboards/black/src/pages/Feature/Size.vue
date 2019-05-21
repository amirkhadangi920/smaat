<template>
  <base-feature type="size" ref="base" label="سایز" :validate="validate" :fields="[
    {
      field: 'name',
      label: 'عنوان سایز',
      icon: 'icon-caps-small'
    }, {
      field: 'description',
      label: 'توضیحات سایز',
      icon: 'icon-single-copy-04'
    },
  ]">
    <md-field :class="getValidationClass('name')">
      <label for="email">نام سایز</label>
      <md-input v-model="name" :maxlength="$v.name.$params.maxLength.max" />
      <i class="md-icon tim-icons icon-tag"></i>
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
  mixins: [ validationMixin, Binding ],
  components: {
    BaseFeature
  },
  data() {
    return {
      group: 'feature',
      type: 'size'
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
    description: bind('description')
  },
  mounted() {

    const data = {
      query: `
        mutation {
          createBrand(name: "برند تصادفی") {
            id
            name
            description
            categories {
              title
            }
          }
        }
      `,
      variables: {
        id: 12
      }
    }

    axios({
      method: 'GET',
      url: '/graphql/auth',
      params: {
        query: data.query
      }
    }).then(response => {
      return console.log( response.data );
      console.log( response.data.data )
    }).catch(error => console.log( error ))

  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>