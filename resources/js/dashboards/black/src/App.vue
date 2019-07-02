<template>
  <div>
    <notifications></notifications>
    <div class="wrapper">
      <side-bar
        title="SmaaT"
        logo="/images/logo.jpg"
        :style="{background: 'linear-gradient(0deg, #f4ecff, #fff)', width: is_collapsed ? '64px' : '230px' }"
      >
        <!-- :style="{background: 'linear-gradient(0deg, #7F7FD5, #86A8E7, #91EAE4)', width: is_collapsed ? '64px' : '230px' }" -->
        <template slot="links">
          <!-- <canvas id="granim-canvas"></canvas> -->

          <el-menu
            :collapse="is_collapsed"
            dir="rtl"
            default-active="2"
            :default-openeds="[opened_index]"
            unique-opened
            class="el-menu-vertical-demo"
            >
            <el-menu-item class="main" index="0">
              <sidebar-link to="/panel" name="داشبورد" icon="tim-icons icon-tv-2 dashboard-icon"/>
            </el-menu-item>
            <el-submenu index="1" v-if="canSeeMenu(['brand', 'unit', 'size', 'warranty', 'color', 'spec'])">
              <template slot="title">
                <i class="tim-icons icon-single-copy-04 feature-icon"></i>
                <span>ویژگی ها</span>
              </template>
              <el-menu-item v-if="hasPermissions('brand')">
                <sidebar-link to="/panel/brand" :name="$t('sidebar.list') + ' ' + $t('sidebar.brand')" icon="tim-icons icon-atom"/>
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('unit')">
                <sidebar-link to="/panel/unit" :name="$t('sidebar.list') + ' ' + $t('sidebar.unit')" icon="tim-icons icon-app"/>
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('size')">
                <sidebar-link to="/panel/size" :name="$t('sidebar.list') + ' ' + $t('sidebar.size')" icon="tim-icons icon-chart-bar-32"/>
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('warranty')">
                <sidebar-link to="/panel/warranty" :name="$t('sidebar.list') + ' ' + $t('sidebar.warranty')" icon="tim-icons icon-bank"/>
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('color')">
                <sidebar-link to="/panel/color" :name="$t('sidebar.list') + ' ' + $t('sidebar.color')" icon="tim-icons icon-palette"/>
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('spec')">
                <sidebar-link to="/panel/specification" :name="$t('sidebar.list') + ' ' + $t('sidebar.spec')" icon="tim-icons icon-palette"/>
              </el-menu-item>
            </el-submenu>
            <el-submenu index="2" v-if="canSeeMenu(['article', 'comment', 'subject'])">
              <template slot="title">
                <i class="tim-icons icon-book-bookmark blog-icon"></i>
                <span>وبلاگ</span>
              </template>
              <el-menu-item v-if="hasPermissions('article')">
                <sidebar-link to="/panel/article" :name="$t('sidebar.list') + ' ' + $t('sidebar.article')" icon="tim-icons icon-paper"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('comment')">
                <sidebar-link to="/panel/comment" :name="$t('sidebar.list') + ' ' + $t('sidebar.comment')" icon="tim-icons icon-notes"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('subject')">
                <sidebar-link to="/panel/subject" :name="$t('sidebar.list') + ' ' + $t('sidebar.subject')" icon="tim-icons icon-notes"/>      
              </el-menu-item>
            </el-submenu>
            <el-submenu index="3" v-if="canSeeMenu(['product', 'label', 'category', 'review', 'question_and_answer'])">
              <template slot="title">
                <i class="tim-icons icon-bag-16 product-icon"></i>
                <span>محصول</span>
              </template>
              <el-menu-item v-if="hasPermissions('product')">
                <sidebar-link to="/panel/product" :name="$t('sidebar.list') + ' ' + $t('sidebar.product')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('label')">
                <sidebar-link to="/panel/label" :name="$t('sidebar.list') + ' ' + $t('sidebar.label')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('category')">
                <sidebar-link to="/panel/category" :name="$t('sidebar.list') + ' ' + $t('sidebar.category')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('review')">
                <sidebar-link to="/panel/review" :name="$t('sidebar.list') + ' ' + $t('sidebar.review')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('question_and_answer')">
                <sidebar-link to="/panel/question_and_answer" :name="$t('sidebar.list') + ' ' + $t('sidebar.question_and_answer')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
            </el-submenu>
            <el-submenu index="4" v-if="canSeeMenu(['shipping_method', 'order_stauts']) || this.$store.state.permissions.includes('read-order')">
              <template slot="title">
                <i class="tim-icons icon-money-coins shop-icon"></i>
                <span>فروشگاه</span>
              </template>
              <el-menu-item v-if="this.$store.state.permissions.includes('read-order')">
                <sidebar-link to="/panel/order" :name="$t('sidebar.list') + ' ' + $t('sidebar.order')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('shipping_method')">
                <sidebar-link to="/panel/shipping_method" :name="$t('sidebar.list') + ' ' + $t('sidebar.shipping_method')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('order_status')">
                <sidebar-link to="/panel/order_status" :name="$t('sidebar.list') + ' ' + $t('sidebar.order_status')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('discount')">
                <sidebar-link to="/panel/discount" :name="$t('sidebar.list') + ' ' + $t('sidebar.discount')" icon="tim-icons icon-bag-16"/>      
              </el-menu-item>
            </el-submenu>
            <el-submenu index="5" v-if="this.$store.state.permissions.includes('read-user') || this.$store.state.permissions.includes('read-role')">
              <template slot="title">
                <i class="tim-icons icon-single-02 user-icon"></i>
                <span>کاربران</span>
              </template>
              <el-menu-item v-if="this.$store.state.permissions.includes('read-user')">
                <sidebar-link to="/panel/user" :name="$t('sidebar.list') + ' ' + $t('sidebar.user')" icon="tim-icons icon-paper"/>      
              </el-menu-item>
              <el-menu-item v-if="this.$store.state.permissions.includes('read-role')">
                <sidebar-link to="/panel/role" :name="$t('sidebar.list') + ' ' + $t('sidebar.role')" icon="tim-icons icon-notes"/>      
              </el-menu-item>
            </el-submenu>
            <el-submenu index="6">
              <template slot="title">
                <i class="tim-icons icon-settings-gear-63 setting-icon"></i>
                <span>تنظیمات</span>
              </template>
              <el-menu-item>
                <sidebar-link to="/panel/setting/user" name="تنظیمات کاربر" icon="tim-icons icon-paper"/>      
              </el-menu-item>
              <el-menu-item v-if="hasPermissions('setting')">
                <sidebar-link to="/panel/setting/site" name="تنظیمات سایت" icon="tim-icons icon-notes"/>      
              </el-menu-item>
            </el-submenu>
          </el-menu>
        </template>
      </side-bar>
      <div class="main-panel">
        <!-- <vue-particles color="#f0f0f0" :moveSpeed="1" shapeType="circle" :particlesNumber="180"></vue-particles> -->
        <top-navbar></top-navbar>

        <!-- <router-view :key="$route.fullPath"></router-view> -->
        <dashboard-content @click.native="toggleSidebar" :style="{ padding: `40px ${is_collapsed ? 110 : 280}px 30px 30px` }">

        </dashboard-content>

        <content-footer></content-footer>
      </div>
    </div>
  </div>
</template>

<script>
import TopNavbar from "./layout/dashboard/TopNavbar.vue";
import ContentFooter from "./layout/dashboard/ContentFooter.vue";
import DashboardContent from "./layout/dashboard/Content.vue";
import MobileMenu from "./layout/dashboard/MobileMenu";
import Granim from 'granim'
import anime from 'animejs'
import _ from 'lodash'

export default {
  components: {
    TopNavbar,
    ContentFooter,
    DashboardContent,
    MobileMenu
  },
  data() {
    return {
      opened_index: this.$route.meta.index,
      is_collapsed: false,
    }
  },
  methods: {
    toggleNavOpen() {
      let root = document.getElementsByTagName('html')[0];
      root.classList.toggle('nav-open');
    },
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false);
      }
    },

    hasPermissions(permission_name) {

      return _.filter(this.$store.state.permissions, function(p) {

        return p.indexOf( permission_name ) > -1
      }).length > 0
    },
    canSeeMenu(menu) {
      let status = false

      menu.forEach(item => {
        if ( this.hasPermissions(item) )
          status = true
      })

      return status
    }
  },
  mounted() {
    setTimeout(() => {
      
      anime({
        targets: '.content .background',
        height: 200,
        zIndex:1,
        delay: 3000,
        top: [
          { value: -260 },
          { value: 0, delay: 200 }
        ],
        scale: {
          value: 1.5,
          delay: 3000
        },
        rotate: {
          value: -2,
          delay: 3000
        },
        duration: 300,
        easing: 'easeInOutSine',
        complete() {
          document.querySelector('.main-panel').style.overflowY = 'auto'
        }
      })
      
    }, 200);

    this.$store.dispatch('getPermissions')

    this.$rtl.enableRTL();
    document.body.classList.toggle('white-content');
    
    // this.$watch('$route', this.disableRTL, { immediate: true });
    this.$watch('$sidebar.showSidebar', this.toggleNavOpen)
  },
  created() {
    setTimeout( () => {
      // var granimInstance = new Granim({
      //   element: '#granim-canvas',
      //   name: 'granim',
      //   opacity: [1, 1],
      //   direction: 'diagonal',
      //   stateTransitionSpeed: 20000,
      //   states : {
      //       "default-state": {
      //           gradients: [
      //               ['#8b387d', '#33002a'],
      //               ['#fd5d93', '#910e7d'],
      //               ['#574ee1', '#a804f2'],
      //               ['#68002c', '#310129']
      //           ]
      //       }
      //   }
      // });

      $('#particles-js').addClass('show')
    }, 100)
  }
};
</script>

<style>
.content {
  transition: padding 300ms;
}
.sidebar {
  margin-top: 70px !important;
  height: calc(100vh - 110px) !important;
  /* box-shadow: 0px 15px 60px -30px !important; */
  /* border-radius 300ms */
}
.main-panel {
  border-top: none !important;
}

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
.el-menu-item.main p {
  font-size: 14px;
}
.el-menu-item.main a {
  padding-right: 4px !important;
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
.el-menu * {
  color: #626262 !important;
  font-weight: bold;
}

.sidebar .nav li.active > a:not([data-toggle=collapse]):before, .off-canvas-sidebar .nav li.active > a:not([data-toggle=collapse]):before {
  background: #212529 !important;
}

#granim-canvas {
  position: absolute;
  top: 0px;
  left: 0px;
  height: 100%;
  width: 100%;
  border-radius: 4px;
}

.sidebar {
  border-radius: 10px !important;
  background: #fbfbfb !important;
  /* box-shadow: 0px 10px 60px -22px !important; */
  box-shadow: none !important;
  filter: drop-shadow(0px 5px 25px #00000017);
}

i.dashboard-icon, i.feature-icon, i.blog-icon, i.product-icon, i.shop-icon, i.user-icon, i.setting-icon {
  font-size: 16px !important;
  padding: 0px;
  width: 30px !important;
  height: 30px !important;
  border-radius: 10px;
  color: #fff !important;
}
.el-menu-item i.dashboard-icon {
  background: #cc04c1;
  box-shadow: 0px 4px 20px -3px #cc04c1, 0px 4px 18px -8px #000;
}
.el-submenu__title i.feature-icon {
  background: #ff3d3d;
  box-shadow: 0px 4px 20px -3px #ff3d3d, 0px 4px 18px -8px #000;
}
.el-submenu__title i.blog-icon {
  background: #fd7e14;
  box-shadow: 0px 4px 20px -3px #fd7e14, 0px 4px 18px -8px #000;
}
.el-submenu__title i.product-icon {
  background: #ffc107;
  box-shadow: 0px 4px 20px -3px #ffc107, 0px 4px 18px -8px #000;
}
.el-submenu__title i.shop-icon {
  background: #20c997;
  box-shadow: 0px 4px 20px -3px #20c997, 0px 4px 18px -8px #000;
}
.el-submenu__title i.user-icon {
  background: #007bff;
  box-shadow: 0px 4px 20px -3px #007bff, 0px 4px 18px -8px #000;
}
.el-submenu__title i.setting-icon {
  background: #6c757d;
  box-shadow: 0px 4px 20px -3px #6c757d, 0px 4px 18px -8px #000;
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
	width: 2px;
	background-color: transparent;
}

#style-3 {
  /* box-shadow: 0px 0px 45px -20px inset; */
  border-radius: 10px;
}

.sidebar *::-webkit-scrollbar
{
	width: 0px;
	background-color: transparent;
}

*::-webkit-scrollbar-thumb
{
	border-radius: 3px;
	background-color: #FFF;
	background-image: -webkit-gradient(linear,
									   40% 0%,
									   75% 84%,
									   from(#303030),
									   to(#2b2b2b),
									   color-stop(.6,#6b6b6b))
}

@media screen and (max-width: 992px) {
  
  .main-panel .content {
     padding: 40px 30px 30px 30px !important;
  }

  .sidebar {
    width: 260px !important;
    margin: 0px !important;
    height: 100% !important;
    border-radius: 0px !important;
  }

  #style-3 {
    padding: 57px 0px 50px !important;
    border-radius: unset !important;
  }

  .logout-btn {
    bottom: 15px !important;
  }
  
  .user-profile .info {
    top: 25px !important;
  }
  .user-profile .logo {
    top: 10px !important;
  }
}

.md-field .md-icon.tim-icons {
  background: linear-gradient(to bottom right, #ff8d72, #f56c6c);
  padding: 5.5px 6px;
  width: 30px;
  height: 30px;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0px 4px 25px -6px #f70000, 0px 3px 10px -8px #000;
  text-shadow: 1px 2px 7px #0000005c;
}
.md-field .md-button.md-toggle-password {
  right: auto;
  left: 0px;
}
</style>
