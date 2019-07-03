<template>
  <base-opinion
    :type="type"
    :group="group"
    rel="article"
    plural="comments"
    :label="label"
    ref="base"
    queryFields="
      article {
        id
        title
        image {
          id
          file_name
          thumb
        }
      }
    "
    fullInfoQuery="
      message
      answers {
        id
        writer {
          id
          first_name
          last_name
          full_name
          avatar { id file_name thumb }
        }
        message
        is_accept
        created_at
        updated_at
      }
    "
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
