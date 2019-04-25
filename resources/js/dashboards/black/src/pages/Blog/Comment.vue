<template>
  <base-opinion
    :type="type"
    :group="group"
    rel="article"
    :label="label"
    ref="base"
  ></base-opinion>
</template>

<script>
import BaseOpinion from './BaseOpinion'

export default {
  components: {
    BaseOpinion
  },
  data() {
    return {
      type: 'comment',
      group: 'blog',
      label: 'نظر'
    }
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>
