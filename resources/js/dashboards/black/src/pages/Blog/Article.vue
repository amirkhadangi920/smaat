<template>
  <datatable
    :type="type"
    :group="group"
    label="مقاله"
    :fields="getFields"

    :methods="{
      create: create,
      edit: edit,
      store: store,
      update: update
    }"
    
    ref="datatable">

    <template slot="filter-labels" v-if="false">
      <span class="pull-right text-muted ml-2" v-show="hasFilter">فیتلر های اعمال شده :</span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterLogo(null)"
        v-show="filter('hasLogo') == 1">
        فقط عکس دار ها
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>
      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterLogo(null)"
        v-show="filter('hasLogo') == 0">
        فقط بدون عکس
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterCategory(null)"
        v-show="filter('hasCategories') == 1">
        فقط با دسته بندی ها
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>
      <span 
        class="badge badge-default p-2 ml-2 pull-right"
        @click="filterCategory(null)"
        v-show="filter('hasCategories') == 0">
        فقط بدون دسته بندی ها
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="$refs.filter_categories.setCheckedNodes([]); filterCategory( filter('hasCategories') )"
        v-show="filter('categories') && filter('categories_string')">
        فقط برای گروه {{ filter('categories').length !== 1 ? 'های' : '' }} : <b>{{ filter('categories_string') }}</b>
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>

      <span
        class="badge badge-default p-2 ml-2 pull-right"
        @click="$store.state[group].filters[type].query = null; filterSearch()"
        v-show="filter('query')">
        جستجو برای : {{ filter('query') }}
        <i class="tim-icons icon-simple-remove remove-button"></i>
      </span>
    </template>
    
    <template v-slot:image-body="slotProps">
      <img class="tilt" :src="slotProps.row.image ? slotProps.row.image.tiny : '/images/placeholder.png'" />
    </template>

    <template slot="categories-header" v-if="false">
      <el-popover placement="top-start" width="200" trigger="hover"
        content="this is content, this is content, this is content">

        <el-dropdown @command="filterCategory">
          <span class="el-dropdown-link">
            با / بدون دسته بندی <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown" dir="rtl">
            <el-dropdown-item icon="el-icon-tickets" :command="null">همه</el-dropdown-item>
            <el-dropdown-item icon="el-icon-check" :command="1">با دسته بندی</el-dropdown-item>
            <el-dropdown-item icon="el-icon-error" :command="0">بدون دسته بندی</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>

        <hr />

        <el-tree
          dir="ltr"
          :data="$store.state.group.categories"
          :props="defaultProps"
          :accordion="true"
          ref="filter_categories"
          empty-text="هیچ دسته بندی ای یافت نشد :("
          show-checkbox
          node-key="id"
        >
          <span class="custom-tree-node" slot-scope="{ node }">
            <span>{{ node.label }}</span>
          </span>
        </el-tree>
        <hr />
        <base-button @click="filterCategory($store.state[group].filters[type].hasCategories)" size="sm">اعمال</base-button>

        <p class="text-muted hvr-icon-up" slot="reference">
          <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
          دسته بندی ها
          <i class="el-icon-arrow-down el-icon--right"></i>
        </p>
      </el-popover>
    </template>

    <template v-slot:subjects-body="slotProps">
      <transition-group name="list">
        <span
          v-for="item in slotProps.row.subjects.filter( (category, index) => index < 3)"
          :key="item.id"
          class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
          <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
          {{ item.title }}
        </span>

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
            <i class="md-icon tim-icons icon-tag"></i>
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
        <div class="col-5">
          <base-input label="موضوعات مقاله">
            <el-tree
              dir="ltr"
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
import {Tooltip} from 'element-ui'
import {BaseDropdown} from '../../components'
import Datatable from '../../components/BaseDatatable.vue'
import ICountUp from 'vue-countup-v2';
import {mapActions, mapMutations} from 'vuex'
import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'
import tilt from 'tilt.js'
import {ElTree} from 'element-ui'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'
import Binding, { bind } from '../../mixins/binding'

export default {
  components: {
    Datatable,
    BaseDropdown,
    ICountUp,
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
  created() {
    setTimeout( () => $('.tilt').tilt({scale: 1.1}) ,300)
    setTimeout( () => $('.tilt-fixed').tilt() ,300)
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
      return axios.get('/graphql/auth', {
        params: {
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
        }
      })
    },
    afterEdit(row)
    {
      setTimeout(() => {
        this.$refs.subjects.setCheckedKeys( row.subjects.map(i => i.id) )
      }, 100);
    },
  },
  validations: {
    title: {
      required,
      maxLength: maxLength(50)
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
          icon: 'icon-caps-small'
        }, {
          field: 'title',
          label: 'عنوان مقاله',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات مقاله',
          icon: 'icon-single-copy-04'
        }, {
          field: 'reading_time',
          label: 'زمان مطالعه',
          icon: 'icon-time-alarm'
        }, {
          field: 'subjects',
          label: 'دسته بندی ها',
          icon: 'icon-time-alarm'
        }
      ]
    },

    allQuery() {
      return `
        title
        description
        image {
          tiny
          big
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

    setTimeout( () => next(), 700);
  },
}
</script>

<style>
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
