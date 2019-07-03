<template>
  <base-opinion
    :type="type"
    :label="label"
    ref="base"
    plural="reviews"
    queryFields="
      product {
        id
        name
        photos {
          id
          file_name
          thumb
        }
      }
    "
    fullInfoQuery="
      message
      ranks { title value }
      advantages
      disadvantages
      is_accept
    "
  ></base-opinion>
</template>

<script>
import BaseOpinion from '../Blog/BaseOpinion'

export default {
  components: {
    BaseOpinion
  },
  data() {
    return {
      type: 'review',
      label: 'نقد و بررسی',
    }
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>
