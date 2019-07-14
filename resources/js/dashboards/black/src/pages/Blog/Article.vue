<template>
  <datatable
    :type="type"
    :group="group"
    :label="label"
    :fields="getFields"

    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">
    
    <template v-slot:image-body="slotProps">
      <img class="tilt" :src="slotProps.row.image ? slotProps.row.image.thumb : '/images/placeholder.png'" />
    </template>
    
    <template v-slot:reading_time-body="slotProps">
      <span v-if="slotProps.row.reading_time">{{ slotProps.row.reading_time }} دقیقه</span>
      <span v-else class="badge badge-warning">
        <i class="tim-icons icon-watch-time"></i>
        نا مشخص
      </span>
    </template>

    <template v-slot:subjects-body="slotProps">
      <transition-group name="list">
        <el-popover
          v-for="item in slotProps.row.subjects.filter( (i, index) => index < 3)"
          :key="item.id"
          placement="top-end"
          width="300"
          trigger="hover"
          :disabled="typeof item.title === 'string' ? item.title.length <= 20 : false"
          :content="item.title"
        >
          <span
            slot="reference"
            class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
            <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
            {{ item.title | truncate(20) }}
          </span>
        </el-popover>

        <el-dropdown v-if="slotProps.row.subjects.length > 3" :key="slotProps.row.subjects.map((c) => c.id).join(',')">
          <span class="el-dropdown-link badge badge-default">
            باقی گروه ها <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item
              v-for="item in slotProps.row.subjects.filter( (category, index) => index < 3)"
              :key="item.id">
              {{ item.title }}
            </el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </transition-group>
    </template>

    <template slot="modal">
      <div class="row">
        <div class="col-md-6">
          <md-field :class="getValidationClass('title')">
            <label>عنوان مقاله</label>
            <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
            <i class="md-icon tim-icons icon-caps-small"></i>
            <span class="md-helper-text">عنوان مقاله را وارد کنید ...</span>
            <span class="md-error" v-show="!$v.title.required">لطفا عنوان مقاله را وارد کنید</span>
          </md-field>
        </div>

        <div class="col-md-6">
          <md-field :class="getValidationClass('reading_time')">
            <label>زمان مطالعه</label>
            <md-input v-model="reading_time" type="number" />
            <span class="md-suffix ml-2">دقیقه</span>
            <i class="md-icon tim-icons icon-watch-time"></i>
            <span class="md-helper-text">زمان مورد نیاز برای مطالعه مقاله</span>
            <span class="md-error" v-show="!$v.reading_time.required">لطفا عنوان مقاله را وارد کنید</span>
          </md-field>
        </div>
      </div>


      <md-field :class="getValidationClass('description')">
        <label>توضیحات مقاله</label>
        <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
        <i class="md-icon tim-icons icon-paper"></i>
        <span class="md-helper-text">توضیحی مختصر درباره مقاله</span>
      </md-field>
      <br/>
      
      <div class="row">
        <div class="col-5">
          <base-input label="موضوعات مقاله">
            <el-tree
              dir="ltr"
              class="rtl"
              :data="$store.state.group.subject"
              :props="defaultProps"
              :accordion="true"
              ref="subjects"
              show-checkbox
              node-key="id"
              @check-change="changeSelectedSubjects"
              :default-checked-keys="selected('subjects')"
              :default-expanded-keys="selected('subjects')"
              empty-text="هیچ موضوعی یافت نشد :("
            >
            </el-tree>
          </base-input>
          <small slot="helperText" id="emailHelp" class="form-text text-muted">برای انتخاب هر موضوع تیک قبل آن را انتخاب کنید</small>
        </div>
        <div class="col-7">
          <base-input label="تصویر">
            <el-upload
              class="avatar-uploader"
              action="/"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="addImage">
              <img
                v-if="$store.state[group].form[type].image.url"
                :src="$store.state[group].form[type].image.url"
                class="avatar"
              />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <small slot="helperText" id="emailHelp" class="form-text text-muted">تصویر مورد نظر خود را انتخاب کنید</small>
          </base-input>
        </div>
      </div>

      <br/>
      <base-input label="متن">
        <ckeditor :editor="editor" v-model="body" ></ckeditor>
        <small slot="helperText" id="emailHelp" class="form-text text-muted">متن کامل مقاله ، قابل نمایش در ادامه مطلب سایت</small>
      </base-input>

      <br/>
      <md-chips v-model="tags" md-placeholder="افزودن کلمه کلیدی ...">
        <label>کلمات کلیدی مقاله</label>
        <span class="md-helper-text">کلمات کلیدی مرتبط با مقاله خود را وارد کنید</span>
      </md-chips>
    </template>
  </datatable>
</template>

<script>
import Datatable from '../../components/BaseDatatable.vue'

import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
import Binding, { bind } from '../../mixins/binding'

import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
  components: {
    Datatable,
  },
  metaInfo: {
    title: 'مقالات',
  },
  mixins: [
    initDatatable,
    createMixin,
    validationMixin,
    Binding
  ],
  data() {
    return {
      plural: 'articles',
      type: 'article',
      group: 'blog',
      label: 'مقاله',

      defaultProps: {
        children: 'childs',
        label: 'title',
      },

      editor: ClassicEditor,
    }
  },
  mounted() {
    this.$store.dispatch('getData', {
      group: 'group',
      type: 'subject',
    })
  },
  methods: {
    changeSelectedSubjects() {
      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: 'subjects',
        value: this.$refs.subjects.getCheckedKeys()
      })
    },
    getRowData(row)
    {
      this.setAttr('is_query_loading', true)

      return axios.post('/graphql/auth', {
        query: `{
          singleData: ${this.type} (id: "${row.id}") {
            id
            ${this.allQuery}
            body
            tags { name }
            created_at
            updated_at
          }
        }`
      })
    },
    afterEdit(row)
    {
      this.setAttr('is_query_loading', false)

      setTimeout(() => this.$refs.subjects.setCheckedKeys( row.subjects.map(i => i.id) ), 100)
    },
  },
  validations: {
    title: {
      required,
      maxLength: maxLength(100)
    },
    description: {
      maxLength: maxLength(255)
    },
    reading_time: {
      // maxLength: maxLength(255)
    },
  },
  computed: {
    title: bind('title'),
    body: bind('body'),
    description: bind('description'),
    reading_time: bind('reading_time'),
    tags: {
      get() {
        return this.$store.state.blog.form.article.tags.value.map( item => item.name )
      },
      set(value) {
        this.$store.commit('setFormData', {
          group: this.group,
          type: this.type,
          field: 'tags',
          value: value.map(item => { return { name: item } }) 
        })
      }
    },

    getFields() {
      return [
        {
          field: 'image',
          label: 'تصویر مقاله',
          icon: 'icon-image-02'
        }, {
          field: 'title',
          label: 'عنوان مقاله',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات مقاله',
          icon: 'icon-paper'
        }, {
          field: 'reading_time',
          label: 'زمان مطالعه',
          icon: 'icon-watch-time'
        }, {
          field: 'subjects',
          label: 'دسته بندی ها',
          icon: 'icon-tag'
        }
      ]
    },

    allQuery() {
      return `
        title
        description
        image {
          id
          file_name
          thumb
          medium
        }
        reading_time
        subjects {
          id
          title
        }`
    },
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700)
  },
}
</script>

<style>
.ck.ck-content.ck-editor__editable img {
  max-height: unset;
}
.el-icon-plus.avatar-uploader-icon, .el-upload, .avatar {
  width: 100%;
}
.ck-blurred.ck-content {
  min-height: 200px;
}

.md-chip {
  color: #fff;
  background: #fd5d93;
  margin: 4px 5px;
}
</style>
