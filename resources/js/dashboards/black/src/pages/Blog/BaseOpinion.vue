<template>
  <div>
    <datatable
      :type="type"
      :group="group"
      :label="label"
      :fields="getFields"
      :canCreate="false"
      :canEdit="false"
      :canSearch="false"
      
      :methods="{}"
      ref="datatable"
    >
      <template v-slot:writer-body="slotProps">
        <div class="info-cell">
          <div class="mb-2" v-if="rel === 'article'">
            <img class="tilt" :src="slotProps.row.article.image ? slotProps.row.article.image.thumb : '/images/placeholder.png'" />
            <span>{{ slotProps.row.article.title }}</span>
          </div>
          <div class="mb-2" v-if="rel === 'product'">
            <img class="tilt" :src="slotProps.row.product.photos ? slotProps.row.product.photos.thumb : '/images/placeholder.png'" />
            <span>{{ slotProps.row.product.name }}</span>
          </div>

          <div>
            <img class="tilt" :src="slotProps.row.writer.avatar ? slotProps.row.writer.avatar.thumb : '/images/placeholder-user.png'" />
            <span>{{ slotProps.row.writer.full_name }}</span>
          </div>
        </div>
      </template>

      <template v-slot:votes-body="slotProps">
        <div :style="{ fontSize: '12px' }">
          <el-tooltip :content="slotProps.row.votes.dislikes + ' بار پسندیده شده'" placement="left">
            <p class="text-muted hvr-icon-bob" :style="{display: 'block'}"><i class="tim-icons icon-heart-2 text-default hvr-icon"></i> {{ slotProps.row.votes.dislikes }}</p>
          </el-tooltip>

          <el-tooltip :content="slotProps.row.votes.dislikes + ' بار نسپندیده شده'" placement="left">
            <p class="text-muted hvr-icon-hang"><i class="tim-icons icon-heart-2 text-danger hvr-icon"></i> {{ slotProps.row.votes.likes }}</p>
          </el-tooltip>
        </div>
      </template>

      <template #status-body="slotProps">
        <i class="tim-icons icon-check-2 text-success ml-2"></i>  
        <el-switch
          :disabled="can(`accept-${type}`)"
          @change="accept(slotProps.index, $event)"
          v-model="slotProps.row.is_accept"
          active-color="#13ce66"
          inactive-color="#ff4949"
        ></el-switch>
        <i class="tim-icons icon-simple-remove text-danger mr-2"></i>
      </template>

      <template #custom-operations="slotProps">
        <el-tooltip content="مشاهده اطلاعات">
          <base-button class="ml-2" @click="info(slotProps.index, slotProps.row)" type="success" size="sm" icon>
            <i class="tim-icons icon-chat-33"></i>
          </base-button>
        </el-tooltip>
      </template>

      <template #custom-buttons>
        <transition name="fade">
          <base-button
            @click="accept_multiple"
            v-show="attr('selected_items').length >= 1"
            :disabled="can(`accept-${type}`)"
            size="sm"
            :type="acceptType ? 'success' : 'warning'"
            class="pull-left mr-2"
          >
            {{ acceptType ? 'تایید' : 'رد' }}
            <ICountUp
              :style="{display: 'inline'}"
              :endVal="attr('selected_items').length"
              :options="{
                useEasing: true,
                useGrouping: true,
              }"
            />
            مورد انتخاب شده
            <i class="tim-icons" :class="acceptType ? 'icon-check-2' : 'icon-refresh-01'"></i>
          </base-button>
        </transition>
      </template>
    </datatable>

    <md-dialog :md-active.sync="is_info_dialog_open" class="text-right" dir="rtl">
      <md-dialog-title>
        <h2>اطلاعات تکمیلی {{label}}</h2>
      </md-dialog-title>

      <div class="md-dialog-content">
        <div class="p-2">
          <div class="row" :style="{ position: 'relative', zIndex: 1}">
            <div class="col-6" v-if="rel === 'article'">
              <img class="header-image tilt" :src="showing_info.article.image ? showing_info.article.image.medium : '/images/placeholder.png'" />
              <p class="header-paragraph">
                <i class="tim-icons icon-single-copy-04"></i>
                {{ showing_info.article.title }}
              </p>
            </div>
            <div class="col-6" v-if="rel === 'product'">
              <img class="header-image tilt" :src="showing_info.product.photos && showing_info.product.photos.length ? showing_info.product.photos[0].medium : '/images/placeholder.png'" />
              <p class="header-paragraph">
                <i class="tim-icons icon-basket-simple"></i>
                {{ showing_info.product.name }}
              </p>
            </div>
            <div class="col-6">
              <img class="header-image tilt" :src="showing_info.writer.avatar ? showing_info.writer.avatar.thumb : '/images/placeholder-user.png'" />
              <p class="header-paragraph">
                <i class="tim-icons icon-user-run"></i>
                {{ showing_info.writer.full_name }}
              </p>
            </div>
          </div>
          <hr/>
          <div class="row">
            <div class="col-12">
              <div class="text-right pull-right">
                <h3 class="animated bounceInRight delay-first mb-0">
                  <i class="tim-icons icon-align-center" :style="{fontSize: '20px'}"></i>
                  متن {{ label }}
                </h3>
              </div>
            </div>
            <div class="col-12">
              <p class="animated bounceInDown delay-first" :style="{
                padding: '15px',
                borderRight: '4px solid #960577'
              }">
                {{ showing_info.message }}
              </p>
            </div>
          </div>
          <hr/>

          <div v-if="type === 'review' && false">
            <div class="row">
              <div class="col-12">
                <h3 class="animated bounceInRight delay-first mb-0">
                  <i class="tim-icons icon-chart-bar-32" :style="{fontSize: '20px'}"></i>
                  امتیازات
                </h3>

                <div v-if="showing_info.ranks">
                  <div
                    class="col-12 pull-right mb-2"
                    v-for="(item, index) of showing_info.ranks"
                    :key="index">
                    <p class="pull-right">{{ item.title }}</p>

                    <el-rate
                      class="pull-left"
                      v-model="item.value"
                      disabled
                      show-score
                      text-color="#ff9900"
                      score-template=" {value} امتیاز">
                    </el-rate>
                  </div>
                </div>
                <span
                  class="col-12 badge badge-warning data-badge mb-2"
                  v-if="!showing_info.ranks">
                  هیچ امتیازی ثبت نشده است :(
                </span>
              </div>                        
            </div>
            <hr/>

            <div class="row mt-3">
              <div class="col-6">
                <h3 class="animated bounceInRight delay-first mb-0">
                  <i class="tim-icons icon-simple-add" :style="{fontSize: '20px'}"></i>
                  نکات مثبت
                </h3>

                <div v-if="showing_info.advantages">
                  <span
                    :style="{ animationDelay: `${500 + index * 100}ms` }"
                    class="col-12 badge badge-success data-badge mb-2  animated bounceLeftUp"
                    v-for="(item, index) of showing_info.advantages"
                    :key="index">
                    {{ item }}
                  </span>
                </div>
                <span
                  class="col-12 badge badge-warning data-badge mb-2"
                  v-if="!showing_info.advantages">
                  هیچ نکته مثبتی ثبت نشده است :(
                </span>
              </div>

              <div class="col-6">
                <h3 class="animated bounceInRight delay-first mb-0">
                  <i class="tim-icons icon-simple-delete" :style="{fontSize: '20px'}"></i>
                  نکات منفی
                </h3>

                <div v-if="showing_info.disadvantages">
                  <span
                    :style="{ animationDelay: `${500 + index * 100}ms` }"
                    class="col-12 badge badge-danger data-badge mb-2 animated bounceRightUp"
                    v-for="(item, index) of showing_info.disadvantages"
                    :key="index">
                    {{ item }}
                  </span>
                </div>
                <span
                  class="col-12 badge badge-primary data-badge mb-2"
                  v-if="!showing_info.disadvantages">
                  هیچ نکته منفی ثبت نشده است :)
                </span>
              </div>
            </div>
          </div>

          <div class="row" v-if="showing_info.answers">
            <div class="col-12 mt-4">
              <div class="text-right pull-right">
                <h3 class="animated bounceInRight delay-second mb-0">
                  <i class="tim-icons icon-bullet-list-67" :style="{fontSize: '20px'}"></i>
                  لیست پاسخ ها
                </h3>
              </div>
            </div>

            <base-table
              :tableData="showing_info.answers"
              :has_animation="false"
              :type="type"
              :group="group"
              :label="label"
              :fields="[
                {
                  field: 'writer',
                  label: 'نویسنده',
                  icon: 'icon-badge',
                }, {
                  field: 'message',
                  label: 'پاسخ',
                  icon: 'icon-paper',
                }, {
                  field: 'status',
                  label: 'وضعیت',
                  icon: 'icon-refresh-02',
                }
              ]"
              :methods="{ deleteSingle: deleteAnswer }"
              :canDelete="true"
              :canEdit="false"
              :has_loaded="true"
              :has_times="true"
              :has_operation="true"
            >
              <template #writer-body="props">
                <img class="tilt" :src="props.row.writer.avatar ? props.row.writer.avatar.thumb : '/images/placeholder-user.png'" />
                {{ props.row.writer.full_name }}
              </template>

              <template #status-body="props">
                <i class="tim-icons icon-check-2 text-success ml-2"></i>  
                <el-switch
                  :disabled="can(`accept-${type}`)"
                  @change="accept(props.index, $event, true)"
                  v-model="props.row.is_accept"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                ></el-switch>
                <i class="tim-icons icon-simple-remove text-danger mr-2"></i>
              </template>
            </base-table>
          </div>
        </div>
      </div>

      <md-dialog-actions>
        <base-button
          size="sm"
          type="danger"
          @click="is_info_dialog_open = false"
        >
          <i class="tim-icons icon-simple-remove"></i>
          بستن
        </base-button>
        
        <base-button
          class="mr-2"
          v-if="type !== 'review'"
          size="sm"
          type="success"
          @click="createAnswer"
        >
          <i class="tim-icons icon-simple-add"></i>
          افزودن پاسخ جدید
        </base-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
</template>

<script>
import {Tooltip} from 'element-ui'
import BaseTable from '../../components/BaseTable'
import {BaseDropdown} from '../../components'
import Datatable from '../../components/BaseDatatable.vue'
import ICountUp from 'vue-countup-v2';
import {mapActions, mapMutations} from 'vuex'
import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'
import tilt from 'tilt.js'
import {ElTree} from 'element-ui'
import filtersHelper from '../../mixins/filtersHelper';
import voca from 'voca'
import deleteMixin from '../../mixins/deleteMixin';

export default {
  props: {
    type: String,
    plural: {
      type: String,
      required: true
    },
    queryFields: {
      type: String,
      required: true
    },
    fullInfoQuery: {
      type: String,
      required: true
    },
    group: {
      type: String,
      default: 'product'
    },
    label: String,
    rel: {
      type: String,
      default: 'product'
    }
  },
  components: {
    Datatable,
    BaseDropdown,
    ICountUp,
    BaseTable
  },
  mixins: [
    filtersHelper,
    initDatatable,
    createMixin,
    deleteMixin
  ],
  data() {
    return {
      selected_count: 0,
      delete_from_answers: false,

      showing_info: {
        index: null,
        answers: [],
        advantages: null,
        disadvantages: null,
        ranks: null,
        article: {
          image: null,
          title: '',
        },
        product: {
          photos: null,
          name: '',
        },
        writer: {
          avatar: null,
          full_name: '',
        },
        votes: {
          likes: 0,
          dislikes: 0,
        },
        message: ''
      },
      is_info_dialog_open: false
    }
  },
  methods: {
    closePanel() {
      this.$refs.datatable.closePanel();
    },
    accept(index, status, parent = false) {
      var id = parent ? this.showing_info.answers[index].id : this.data()[index].id;

      axios.post(`/graphql/auth`, {
        query: `
          mutation {
            ${ voca.camelCase(`accept ${this.type}`) } (id: ${id}, status: ${status}) {
              status
              message
            }
          }
        `
      })
      .then(({data}) => {
        if ( parent ) {
          // this.data()[index].answers[index].is_accept = status
        } else {
          this.data()[index].is_accept = status
        }
        this.setData( this.data() )
        
        this.$notify({
          title: status ? 'تایید شد' : 'رد شد',
          message: `${this.label} مورد نظر با موفقیت ${ status ? 'تایید شد' : 'رد شد' } :)`,
          timeout: 1500,
          type: status ? 'success' : 'danger',
          verticalAlign: 'top',
          horizontalAlign: 'left',
        })
      })
      .catch( error => console.log(error) );
    },
    deleteAnswer(index, row)
    {
      this.delete_from_answers = true
      this.handleDelete(index, row)
    },
    createAnswer()
    {
      this.$swal.fire({
        input: 'textarea',
        inputPlaceholder: 'متن پیام خود را بنویسید',
        showCancelButton: true,
        title: `متن پیام خود را وارد کنید`,
        type: 'warning',
        confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
        confirmButtonColor: '#0098f0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ثبت پاسخ',
        cancelButtonText: 'منصرف شدم'
      })
      .then(({value}) => {
        if (value) {
          axios.post(`/graphql/auth`, {
            query: `mutation {
              create: ${ voca.camelCase(`create ${this.type}`) } (
                ${this.type === 'comment' ? 'parent_id' : 'question_id'}: ${this.showing_info.id}, 
                message: "${value}"
              ) {
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
            }`
          })
          .then(({data})=> {
            this.showing_info.answers.unshift(data.data.create)

            this.$swal.fire({
              title: `ثبت شد`,
              text: `پاسخ شما با موفقیت ثبت شد`,
              type: 'success',
              timer: 1000,
              showConfirmButton: false,
            })
          })
          .catch(error => {
            if (error.response) {
              this.$swal.fire({
                title: 'خطایی رخ داد !',
                text: error.response.data.message,
                type: 'error',
                timer: 5000,
                confirmButtonText: 'بسیار خب :('
              })
            } else {
              console.log(error)
            }
          });
        }
      })
    },
    afterDelete(index, row)
    {
      if ( this.delete_from_answers )
      {
        this.showing_info.answers.splice(index, 1)
        this.delete_from_answers = false
      }
      else
      {
        this.data().splice(index, 1)
        this.setData( this.data() )
        
        this.setAttr('counts', {
          total: this.attr('counts').total - 1,
          trash: this.attr('counts').trash + 1,
        })
      }
    },
    accept_multiple() {
      this.$swal.fire({
        title: `برای ${this.acceptType ? 'تایید' : 'رد'} ${this.label} های انتخاب شده مطمئن هستید ؟`,
        text: `در صورت ${this.acceptType ? 'تایید' : 'رد'} کردن ، تمامی ${this.label} های انتخاب شده به حالت ${this.acceptType ? 'تایید' : 'رد'} شده درخواهند آمد !`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
        confirmButtonColor: '#0098f0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله ، مطمئنم !',
        cancelButtonText: 'نه ، اشتباه شده'
      }).then((result) => {
        if (result.value) {
          var ids = [];
          this.attr('selected_items').forEach( item => {
            ids = [...ids, this.data()[item].id]
          })

          axios.post(`/graphql/auth`, {
            query: `
              mutation {
                ${ voca.camelCase(`active ${this.type}`) } (ids: [${ids.join(',')}], status: ${this.acceptType}) {
                  status
                  message
                }
              }
            `
          })
          .then(({data})=> {
            let used_status = this.acceptType;
            this.attr('selected_items').forEach(index => {
              this.data()[index].is_accept = used_status
            });

            this.setAttr('selected_items', [], true)
            this.$refs.datatable.selected_items = [];

            this.$swal.fire({
              title: `${this.acceptType ? 'تایید' : 'رد'} شدند`,
              text: `${this.label} هایی که انتخاب کردید با موفقیت ${this.acceptType ? 'تایید' : 'رد'} شدند :)`,
              type: 'success',
              timer: 1000,
              showConfirmButton: false,
            })

          })
          .catch(error => {
            if (error.response) {
              this.$swal.fire({
                title: 'خطایی رخ داد !',
                text: error.response.data.message,
                type: 'error',
                timer: 5000,
                confirmButtonText: 'بسیار خب :('
              })
            } else {
              console.log(error)
            }
          });
        }
      })
    },
    info(index, row)
    {
      axios.get('/graphql/auth', {
        params: {
          query: `{ singleData: ${this.type} (id: ${row.id}) { ${this.fullInfoQuery} } }`
        }
      }).then(({data}) => {
        this.showing_info = { ...row, ...data.data.singleData };
        this.showing_info.index = index;

        this.is_info_dialog_open = true;
      })
    },
  },
  computed: {
    acceptType() {
      var accept_count = 0, rejact_count = 0;

      this.attr('selected_items').forEach(index => {
        if ( this.data()[index].is_accept )
          ++accept_count
        else
          ++rejact_count
      });

      return accept_count <= rejact_count;
    },

    getFields() {
      if ( this.type === 'question_and_answer' ) {
        return [
          {
            field: 'writer',
            label: 'مقاله / محصول',
            icon: 'icon-badge'
          }, {
            field: 'title',
            label: 'عنوان',
            icon: 'icon-caps-small'
          }, {
            field: 'status',
            label: 'وضعیت',
            icon: 'icon-refresh-02'
          }
        ]
      }

      return [        
        {
          field: 'writer',
          label: 'مقاله / کاربر',
          icon: 'icon-badge'
        }, {
          field: 'title',
          label: 'عنوان',
          icon: 'icon-caps-small'
        }, {
          field: 'votes',
          label: 'رای ها',
          icon: 'icon-heart-2'
        }, {
          field: 'status',
          label: 'وضعیت',
          icon: 'icon-refresh-02'
        }
      ]
    },


    allQuery() {
      return `
        is_accept
        title
        ${this.queryFields}
        votes {
          likes
          dislikes
        }
        writer {
          id
          first_name
          last_name
          full_name
          avatar {
            id
            file_name
            thumb
          }
        }`
    },
  },
}
</script>

<style>
.data-badge {
  font-size: 12px !important;
  white-space: unset !important;
  text-align: right !important;
  line-height: 16px !important;
}
.info-cell img {
  width: 30px;
  max-height: 30px;
  float: right;
}
.info-cell div {
  width: 100%;
  float: right;
}
.info-cell a, .info-cell p {
  float: right;
}

.header-image {
  max-height: 120px;
  min-height: 120px;
  max-width: 100%;
  width: auto;
  display: block;
  margin: auto;
}

.header-paragraph {
  text-align: center;
  margin-top: 15px;
  font-size: 18px;
}
</style>
