<template>
  <datatable
    class="spec-datatable"
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
    
    <template v-slot:categories-body="slotProps">
      <transition-group name="list">
        <span
          v-for="item in slotProps.row.categories.filter( (category, index) => index < 3)"
          :key="item.id"
          class="badge badge-default ml-1 hvr-grow-shadow hvr-icon-grow">
          <i class="tim-icons icon-bullet-list-67 hvr-icon"></i>
          {{ item.title }}
        </span>

        <el-dropdown v-if="slotProps.row.categories.length > 3" :key="slotProps.row.categories.map((c) => c.id).join(',')">
          <span class="el-dropdown-link badge badge-default">
            باقی گروه ها <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item
              v-for="item in slotProps.row.categories.filter( (category, index) => index < 3)"
              :key="item.id">
              {{ item.title }}
            </el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </transition-group>
    </template>

    <template slot="modal">
      <md-field :class="getValidationClass('title')">
        <label>عنوان جدول</label>
        <md-input v-model="title" :maxlength="$v.title.$params.maxLength.max" />
        <i class="md-icon tim-icons icon-caps-small"></i>
        <span class="md-helper-text">میتوانید از نام خود گروه استفاده کنید</span>
        <span class="md-error" v-show="!$v.title.required">لطفا عنوان جدول را وارد کنید</span>
      </md-field>
      <br/>
      <md-field :class="getValidationClass('description')">
        <label>توضیحات جدول</label>
        <md-textarea v-model="description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
        <i class="md-icon tim-icons icon-paper"></i>
        <span class="md-helper-text">توضیحی مختصر درباره جدول</span>
      </md-field>
      <br/>

      <base-input label="دسته بندی های جدول مشخصات">
        <el-tree
          class="rtl"
          dir="ltr"
          :data="$store.state.group.category"
          :props="defaultProps"
          :accordion="true"
          ref="categories"
          show-checkbox
          node-key="id"
          @check-change="changeSelectedCategories"
          :default-checked-keys="selected('categories')"
          :default-expanded-keys="selected('categories')"
          empty-text="هیچ دسته بندی ای یافت نشد :("
        >
        </el-tree>
      <small slot="helperText" id="emailHelp" class="form-text text-muted">برای انتخاب هر دسته بندی تیک قبل آن را انتخاب کنید</small>
      </base-input>
    </template>

    <template #custom-operations="slotProps">
      <el-tooltip content="مدیریت جدول">
        <base-button class="m-0" @click.once="manageTable(slotProps.index, slotProps.row)" type="success" size="sm" icon>
          <i class="tim-icons icon-bullet-list-67"></i>
        </base-button>
      </el-tooltip>
    </template>

  </datatable>
</template>

<script>
import Datatable from '../../components/BaseDatatable.vue'

import createMixin from '../../mixins/createMixin'
import initDatatable from '../../mixins/initDatatable'
import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import { required, maxLength } from 'vuelidate/lib/validators'

export default {
  components: {
    Datatable
  },
  mixins: [
    initDatatable,
    createMixin,
    validationMixin,
    Binding
  ],
  metaInfo: {
    title: 'جداول مشخصات',
  },
  data() {
    return {
      plural: 'specs',
      type: 'spec',
      group: 'feature',
      label: 'جدول مشخصات',

      defaultProps: {
        children: 'childs',
        label: 'title',
      },
    }
  },
  validations: {
    title: {
      required,
      maxLength: maxLength(50)
    },
    description: {
      maxLength: maxLength(255)
    },
  },
  mounted() {
    this.$store.dispatch('getData', {
      group: 'group',
      type: 'category',
    })
  },
  methods: {
    manageTable(index, row)
    {
      this.setAttr('is_creating', false)

      this.$router.push(`/panel/specification/${row.id}`)
    },
    changeSelectedCategories() {
      this.$store.commit('setFormData', {
        group: this.group,
        type: this.type,
        field: 'categories',
        value: this.$refs.categories.getCheckedKeys()
      })
    },
    afterCreate()
    {
      setTimeout(() => this.$refs.categories.setCheckedKeys([]) , 100);
    },
    afterEdit(row)
    {
      setTimeout(() => this.$refs.categories.setCheckedKeys(
        row.categories.map(i => i.id)
      ), 100);
    },
  },
  computed: {
    title: bind('title'),
    description: bind('description'),

    getFields() {
      return [
        {
          field: 'title',
          label: 'عنوان جدول',
          icon: 'icon-caps-small'
        }, {
          field: 'description',
          label: 'توضیحات',
          icon: 'icon-paper'
        }, {
          field: 'categories',
          label: 'دسته بندی ها',
          icon: 'icon-bullet-list-67'
        }
      ]
    },
    allQuery() {
      return `
        title
        description
        categories {
          id
          title
        }
      `
    }
  },
  beforeRouteLeave (to, from, next) {
    this.$refs.datatable.closePanel()

    setTimeout( () => next(), 700);
  },
}
</script>

<style>

.spec-datatable .data-table-row ul {
  min-height: 120px;
}

</style>
