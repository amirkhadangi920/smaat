<template>
  <base-opinion
    :type="type"
    :label="label"
    ref="base"
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
