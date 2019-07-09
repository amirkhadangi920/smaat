<template>
  <base-opinion
    :type="type"
    :label="label"
    ref="base"
    plural="question_and_answers"
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
import BaseOpinion from '../Blog/BaseOpinion'

export default {
  components: {
    BaseOpinion
  },
  metaInfo: {
    title: 'پرسش و پاسخ کاربران',
  },
  data() {
    return {
      type: 'question_and_answer',
      label: 'پرسش و پاسخ',
    }
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.base.closePanel()

    setTimeout( () => next(), 700);
  }
}
</script>