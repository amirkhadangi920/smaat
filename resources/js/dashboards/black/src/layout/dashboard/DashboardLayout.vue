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
    <div class="main-panel">
      <vue-particles color="#f1f1f1" :moveSpeed="1" shapeType="triangle" :particlesNumber="120"></vue-particles>
      <top-navbar></top-navbar>
      <dashboard-content @click.native="toggleSidebar">

      </dashboard-content>

      <content-footer></content-footer>
    </div>
  </div>
</template>

<style>

#particles-js {
  position: fixed;
  width: 100%;
  height: 100%;
  opacity: 0;
  transition: opacity 400ms;
}

.show {
  opacity: 1 !important;
}

.el-menu {
  background: transparent !important;
  padding: 0px !important;
  text-align: right;
}
.el-menu-item {
  padding-right: 0px !important;
}
.el-submenu__icon-arrow {
  float: left !important;
  margin-top: -15px !important;
}

.el-submenu__title i {
  margin: 0px;
  margin-top: 10px;
}

.el-submenu__title:hover, .el-menu-item:focus, .el-menu-item:hover {
  background: transparent;
}
.el-menu-item, .el-submenu__title {
  color: #fff !important;
}

#granim-canvas {
  position: absolute;
  top: 0px;
  left: 0px;
  height: 100%;
  width: 100%;
  border-radius: 4px;
}

.alert.open.top.left {
  text-align: right;
}

*::-webkit-scrollbar-track
{
	background-color: transparent;
	border-radius: 5px;
}

*::-webkit-scrollbar
{
	width: 5px;
	background-color: transparent;
}

*::-webkit-scrollbar-thumb
{
	border-radius: 3px;
	background-color: #FFF;
	background-image: -webkit-gradient(linear,
									   40% 0%,
									   75% 84%,
									   from(#ef5690),
									   to(#c717a1),
									   color-stop(.6,#eb4584))
}
</style>

<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "./MobileMenu";

import Granim from 'granim'

export default {
  components: {
    TopNavbar,
    ContentFooter,
    DashboardContent,
    MobileMenu
  },
  data() {
    return {
      opened_index: this.$route.meta.index
    }
  },
  mounted() {
    this.$store.dispatch('getPermissions')
  },
  created() {    
    setTimeout( () => {
      var granimInstance = new Granim({
        element: '#granim-canvas',
        name: 'granim',
        opacity: [1, 1],
        direction: 'diagonal',
        stateTransitionSpeed: 20000,
        states : {
            "default-state": {
                gradients: [
                    ['#8b387d', '#33002a'],
                    ['#fd5d93', '#910e7d'],
                    ['#574ee1', '#a804f2'],
                    ['#68002c', '#310129']
                ]
            }
        }
      });

      $('#particles-js').addClass('show')
    }, 100)
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
