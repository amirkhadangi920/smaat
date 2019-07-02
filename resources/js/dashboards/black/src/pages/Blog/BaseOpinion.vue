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
      
      :methods="{
        create: create,
        edit: edit,
        store: store,
        update: update
      }"
      ref="datatable"
    >
      <template slot="filter-labels"></template>
      
      <template v-slot:writer-body="slotProps">
        <div class="info-cell">
          <div class="mb-2" v-if="rel === 'article'">
            <img class="tilt" :src="slotProps.row.article.image ? slotProps.row.article.image.thumb : '/images/placeholder.png'" />
            <a href="#" :style="{display: 'block'}">{{ slotProps.row.article.title }}</a>
          </div>
          <div class="mb-2" v-if="rel === 'product'">
            <img class="tilt" :src="slotProps.row.product.photos ? slotProps.row.product.photos.thumb : '/images/placeholder.png'" />
            <a href="#" :style="{display: 'block'}">{{ slotProps.row.product.name }}</a>
          </div>

          <div>
            <img class="tilt" :src="slotProps.row.writer.avatar ? slotProps.row.writer.avatar.thumb : '/images/placeholder-user.png'" />
            <a href="#">{{ slotProps.row.writer.full_name }}</a>
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
          <base-button @click="accept_multiple" v-show="attr('selected_items').length >= 1" :disabled="can(`accept-${type}`)" size="sm" :type="acceptType ? 'success' : 'warning'"
            class="pull-left">
            <i class="tim-icons" :class="acceptType ? 'icon-check-2' : 'icon-simple-remove'"></i>
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
              <img class="header-image tilt" :src="showing_info.product.photos ? showing_info.product.photos.medium : '/images/placeholder.png'" />
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

          <div v-if="type === 'review'">
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
            <div class="col-12">
              <ul class="data-table-header p-2 d-flex justify-content-center animated bounceInUp delay-second">
                <li 
                  class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted"
                  :style="{width: '40px'}"
                >#
                </li>
                <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
                  <i class="tim-icons icon-badge hvr-icon"></i>
                  نویسنده
                </li>
                <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
                  <i class="tim-icons icon-caps-small hvr-icon"></i>
                  پاسخ
                </li>
                <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
                  <i class="tim-icons icon-refresh-02 hvr-icon"></i>
                  وضعیت
                </li>
                <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up">
                  <i class="tim-icons icon-time-alarm hvr-icon"></i>
                  ثبت / تایید
                </li>
                <li class="data-table-cell p-2 d-flex align-items-center justify-content-center text-muted hvr-icon-up" :style="{width: '40px'}">
                  <i class="tim-icons icon-settings hvr-icon"></i>
                  حذف
                </li>
              </ul>
              <md-empty-state
                v-show="showing_info.answers.length === 0"
                md-icon="search"
                md-label="هیچ پاسخی یافت نشد"
                :md-description="`تا کنون هیچ پاسخی برای این ${label} ثبت نشده است :(`">
              </md-empty-state>
              <ul class="animated bounceInUp delay-last" v-if="showing_info.answers.length !== 0">
                <li
                  v-for="(row, index) of showing_info.answers" :key="index"
                  class="data-table-row animated bounceInUp"
                  :style="{ background: '#f9f9f9', animationDelay: `${500 + index * 100}ms` }"
                >
                  <ul class="p-2 d-flex justify-content-center">
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
                      {{ index + 1 }}
                    </li>
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                      <img class="tilt" :src="row.writer.avatar ? row.writer.avatar.thumb : '/images/placeholder-user.png'" />
                      {{ row.writer.full_name }}
                    </li>
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                      {{ row.message }}
                    </li>
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                      <i class="tim-icons icon-check-2 text-success ml-2"></i>  
                      <el-switch
                        :disabled="can(`accept-${type}`)"
                        @change="accept(index, $event, true)"
                        v-model="row.is_accept"
                        active-color="#13ce66"
                        inactive-color="#ff4949"
                      ></el-switch>
                      <i class="tim-icons icon-simple-remove text-danger mr-2"></i>
                    </li>
                    <li class="data-table-cell p-2 d-flex align-items-center justify-content-center" >
                      <div :style="{ fontSize: '12px' }">
                        <el-tooltip :content="row.created_at | created" placement="left">
                          <p class="text-muted hvr-icon-bob"><i class="tim-icons icon-check-2 text-info hvr-icon"></i> {{ row.created_at | ago }}</p>
                        </el-tooltip>

                        <el-tooltip
                          :content="row.updated_at | edited" placement="left"
                          v-if="row.updated_at !== row.created_at">
                          <p class="text-muted hvr-icon-hang"><i class="tim-icons icon-pencil text-warning hvr-icon"></i> {{ row.updated_at | ago }}</p>
                        </el-tooltip>
                      </div>
                    </li>
                    <li class="data-table-cell operation-cell p-2 d-flex align-items-center justify-content-center" :style="{width: '40px'}">
                      <el-tooltip content="حذف">
                        <base-button @click="deleteAnswer(index, row)" type="danger" size="sm" icon>
                          <i class="tim-icons icon-simple-remove"></i>
                        </base-button>
                      </el-tooltip>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <md-dialog-actions>
        <base-button
          type="secondary"
          @click="is_info_dialog_open = false">
          بستن
        </base-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
</template>

<script>
import {Tooltip} from 'element-ui'
import {BaseDropdown} from '../../components'
import Datatable from '../../components/BaseDatatable.vue'
import ICountUp from 'vue-countup-v2';
import {mapActions, mapMutations} from 'vuex'
import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'
import tilt from 'tilt.js'
import {ElTree} from 'element-ui'
import filtersHelper from '../../mixins/filtersHelper';

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
    ICountUp
  },
  mixins: [
    filtersHelper,
    initDatatable,
    createMixin,
  ],
  data() {
    return {
      selected_count: 0,

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
    create() {},
    edit() {},
    closePanel() {
      this.$refs.datatable.closePanel()
    },
    
    accept(index, status, parent = false) {
      var id = parent ? this.data()[ this.showing_info.index ].answers[index].id : this.data()[index].id;

      axios.put(`/api/v1/${this.type}/accept/${id}`, { accept: status })
        .then(({data}) => {
          if ( parent ) {
            this.data()[index].answers[index].is_accept = status
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
        }).catch( error => console.log(error) );
    },
    deleteAnswer(index, row) {
      this.$swal.fire({
        title: `برای پاک کردن ${this.label} مطمئن هستید ؟`,
        text: "در صورت پاک کردن امکان بازگشت اطلاعات نیست !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'linear-gradient(to bottom left, #00f2c3, #0098f0)',
        confirmButtonColor: '#0098f0',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله ، مطمئنم !',
        cancelButtonText: 'نه ، اشتباه شده'
      }).then((result) => {
        if (result.value) {
          axios({
            method: 'delete',
            url: row.link
          }).then(response => {
            this.data()[this.showing_info.index].answers.splice(index, 1)
            this.setData( this.data() )
            
            this.$swal.fire({
              title: 'حذف شد',
              text: `${this.label} با موفقیت حذف شد :)`,
              type: 'success',
              showConfirmButton: false,
              timer: 1000,
            })
          }).catch(error => console.log(error));
        }
      })
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

          axios({
            method: 'put',
            url: `/api/v1/${this.type}/accept/${ids.join(',')}`,
            data: { accept: this.acceptType }
          }).then(response => {
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

          }).catch(error => {
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
