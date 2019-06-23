<template>
  <datatree :label="label" :type="type" :plural="plural"></datatree>
</template>

<script>
import Datatree from '../../components/BaseDatatree'

export default {
  components: { Datatree },
  data() {
    return {
      plural: 'subjects',
      type: 'subject',
      label: 'موضوع',
      group: 'group',
    }
  },
}
</script>