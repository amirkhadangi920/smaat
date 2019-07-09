<template>
  <datatree :label="label" :type="type" :plural="plural"></datatree>
</template>

<script>
import Datatree from '../../components/BaseDatatree'

export default {
  components: { Datatree },
  metaInfo: {
    title: 'گروه بندی محصولات',
  },
  data() {
    return {
      plural: 'categories',
      type: 'category',
      group: 'group',
      label: 'دسته بندی',
    }
  },
}
</script>