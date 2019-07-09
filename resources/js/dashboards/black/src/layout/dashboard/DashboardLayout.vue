<template>
  <div class="wrapper">
    <side-bar 
      title="SmaaT"
      logo="/images/logo.jpg"
      :style="{background: 'linear-gradient(0deg, #33002a 0%, #8b387d 100%)'}">
      <template slot="links">
        <canvas id="granim-canvas"></canvas>

        <el-menu
          dir="rtl"
          default-active="2"
          :default-openeds="[opened_index]"
          unique-opened
          class="el-menu-vertical-demo"
          >
          <el-submenu index="1">
            <template slot="title">
              <i class="tim-icons icon-badge"></i>
              <span>ویژگی ها</span>
            </template>
            <el-menu-item>
              <sidebar-link to="/panel/brand" :name="$t('sidebar.list') + ' ' + $t('sidebar.brand')" icon="tim-icons icon-atom"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/unit" :name="$t('sidebar.list') + ' ' + $t('sidebar.unit')" icon="tim-icons icon-app"/>
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/size" :name="$t('sidebar.list') + ' ' + $t('sidebar.size')" icon="tim-icons icon-chart-bar-32"/>
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/warranty" :name="$t('sidebar.list') + ' ' + $t('sidebar.warranty')" icon="tim-icons icon-bank"/>
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/color" :name="$t('sidebar.list') + ' ' + $t('sidebar.color')" icon="tim-icons icon-palette"/>
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/specification" :name="$t('sidebar.list') + ' ' + $t('sidebar.spec')" icon="tim-icons icon-palette"/>
            </el-menu-item>
          </el-submenu>
          <el-submenu index="2">
            <template slot="title">
              <i class="tim-icons icon-book-bookmark"></i>
              <span>وبلاگ</span>
            </template>
            <el-menu-item>
              <sidebar-link to="/panel/article" :name="$t('sidebar.list') + ' ' + $t('sidebar.article')" icon="tim-icons icon-paper"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/comment" :name="$t('sidebar.list') + ' ' + $t('sidebar.comment')" icon="tim-icons icon-notes"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/subject" :name="$t('sidebar.list') + ' ' + $t('sidebar.subject')" icon="tim-icons icon-notes"/>      
            </el-menu-item>
          </el-submenu>
          <el-submenu index="3">
            <template slot="title">
              <i class="tim-icons icon-book-bookmark"></i>
              <span>محصول</span>
            </template>
            <el-menu-item>
              <sidebar-link to="/panel/product" :name="$t('sidebar.list') + ' ' + $t('sidebar.product')" icon="tim-icons icon-bag-16"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/category" :name="$t('sidebar.list') + ' ' + $t('sidebar.category')" icon="tim-icons icon-bag-16"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/review" :name="$t('sidebar.list') + ' ' + $t('sidebar.review')" icon="tim-icons icon-bag-16"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/question_and_answer" :name="$t('sidebar.list') + ' ' + $t('sidebar.question_and_answer')" icon="tim-icons icon-bag-16"/>      
            </el-menu-item>
          </el-submenu>
          <el-submenu index="4">
            <template slot="title">
              <i class="tim-icons icon-book-bookmark"></i>
              <span>فروشگاه</span>
            </template>
            <el-menu-item v-if="this.$store.state.permissions.includes('read-order')">
              <sidebar-link to="/panel/order" :name="$t('sidebar.list') + ' ' + $t('sidebar.order')" icon="tim-icons icon-bag-16"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/shipping_method" :name="$t('sidebar.list') + ' ' + $t('sidebar.shipping_method')" icon="tim-icons icon-bag-16"/>      
            </el-menu-item>
            <el-menu-item>
              <sidebar-link to="/panel/order_status" :name="$t('sidebar.list') + ' ' + $t('sidebar.order_status')" icon="tim-icons icon-bag-16"/>      
            </el-menu-item>
          </el-submenu>
        </el-menu>
      </template>
    </side-bar>
  </div>
</template>

<script>

export default {
  data() {
    return {
      opened_index: this.$route.meta.index
    }
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    }
  }
};
</script>
