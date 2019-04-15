<template>
  <datatree :label="label" :type="type"></datatree>
</template>

<script>
import Datatree from '../../components/BaseDatatree'

export default {
  components: { Datatree },
  data() {
    return {
      type: 'category',
      label: 'دسته بندی',
    }
  },
}
</script>