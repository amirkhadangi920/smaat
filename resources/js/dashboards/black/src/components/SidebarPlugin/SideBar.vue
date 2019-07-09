<template>
  <div 
    class="sidebar animated bounceInRight"
    :style="{ borderRadius: `${$parent.is_collapsed ? 10 : 90}px 10px 10px 10px`, animationDelay: '3300ms' }"
    :data="backgroundColor">
    <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black | darkblue"
            Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        -->
    <!-- -->
    <div class="user-profile">
      <div class="logo" :style="{
        backgroundImage: `url('${ $store.state.me.avatar ? $store.state.me.avatar.thumb : '/images/placeholder-user.png'}') !important`,
        backgroundSize: 'cover !important'
      }"></div>
      <div class="info">
        <span class="name">
          <i class="tim-icons icon-caps-small"></i>
          {{ $store.state.me.full_name }}
          <span class="d-inline" v-if="!$store.state.me.full_name.trim()">بدون نام</span>
        </span>
        <span class="email">
          <i class="tim-icons icon-single-02"></i>
          {{ $store.state.me.email }}
        </span>
      </div>
    </div>

    <div class="sidebar-wrapper" id="style-3">
      <!-- <div class="logo" @click="toggleSidebar">
        <a
          :style="{ marginRight: $parent.is_collapsed ? '5px' : '20px' }"
          aria-label="sidebar mini logo"
          class="simple-text logo-mini">
          <div class="logo-img"
               :class="{'logo-img-rtl': $rtl.isRTL}">
            <img
              :style="{margin: '0px'}"
              src="/images/user-test.jpg"
              alt="">
          </div>
        </a>
        <a class="simple-text logo-normal">
          {{title}}
        </a>
      </div> -->
      <slot>

      </slot>
      <ul class="nav">
        <!--By default vue-router adds an active class to each route link. This way the links are colored when clicked-->
        <slot name="links">
          <sidebar-link v-for="(link,index) in sidebarLinks"
                        :key="index"
                        :to="link.path"
                        :name="link.name"
                        :icon="link.icon">
          </sidebar-link>
        </slot>
      </ul>
    </div>

    <div class="logout-btn" @click="logout">
      خروج از حساب
      <i class="tim-icons icon-button-power"></i>
    </div>
  </div>
</template>

<script>
  import SidebarLink from "./SidebarLink";

  export default {
    props: {
      title: {
        type: String,
        default: "Creative Tim"
      },
      backgroundColor: {
        type: String,
        default: "vue"
      },
      activeColor: {
        type: String,
        default: "success",
        validator: value => {
          let acceptedValues = [
            "primary",
            "info",
            "success",
            "warning",
            "danger"
          ];
          return acceptedValues.indexOf(value) !== -1;
        }
      },
      sidebarLinks: {
        type: Array,
        default: () => []
      },
      autoClose: {
        type: Boolean,
        default: true
      }
    },
    provide() {
      return {
        autoClose: this.autoClose,
        addLink: this.addLink,
        removeLink: this.removeLink
      };
    },
    components: {
      SidebarLink
    },
    computed: {
      /**
       * Styles to animate the arrow near the current active sidebar link
       * @returns {{transform: string}}
       */
      arrowMovePx() {
        return this.linkHeight * this.activeLinkIndex;
      },
      shortTitle() {
        return this.title.split(' ')
          .map(word => word.charAt(0))
          .join('').toUpperCase();
      }
    },
    data() {
      return {
        linkHeight: 65,
        activeLinkIndex: 0,
        windowWidth: 0,
        isWindows: false,
        hasAutoHeight: false,
        links: []
      };
    },
    methods: {
      findActiveLink() {
        this.links.forEach((link, index) => {
          if (link.isActive()) {
            this.activeLinkIndex = index;
          }
        });
      },
      addLink(link) {
        const index = this.$slots.links.indexOf(link.$vnode);
        this.links.splice(index, 0, link);
      },
      removeLink(link) {
        const index = this.links.indexOf(link);
        if (index > -1) {
          this.links.splice(index, 1);
        }
      },
      toggleSidebar() {
        this.$parent.is_collapsed = !this.$parent.is_collapsed 
      },
      logout()
      {
        localStorage.removeItem('JWT');
        window.location.replace('/login')
      }
    },
    mounted() {
      this.$watch("$route", this.findActiveLink, {
        immediate: true
      });

      setTimeout(() => {
        $('.sidebar').removeClass(['animated', 'bounceInRight'])
      }, 4200);
    }
  };
</script>

<style>
.user-profile .info {
  position: absolute;
  right: 10px;
  left: 10px;
  top: -30px;
  background: #fd7e14;
  padding: 3px 10px;
  border-radius: 5px;
  color: #fff;
  direction: rtl;
  text-align: right;
  z-index: 100 !important;
  box-shadow: 0px 5px 10px -4px #fd7e14, 0px 4px 6px -5px #000;
}
.user-profile .info span {
  display: block;
}
.user-profile .info .email {
  font-size: 10px;
}
.user-profile .logo {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  position: absolute !important;
  left: 18px;
  top: -57px;
  z-index: 110 !important;
  box-shadow: 0px 5px 10px -4px #19375a, 0px 4px 6px -5px #0076ff;
}
.logout-btn {
  position: absolute;
  bottom: -20px;
  width: 70%;
  left: 15%;
  cursor: pointer;
  background: #ff3d3d;
  padding: 6px;
  color: #fff;
  text-align: center;
  border-radius: 10px;
  font-weight: bold;
  z-index: 10000;
  box-shadow: 0px 5px 10px -4px #ff3d3d, 0px 4px 6px -5px #000;
}
.logout-btn i {
  font-size: 16px;
  font-weight: bold;
}
</style>
