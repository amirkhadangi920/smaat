<template>
  <div class="content">
    <!-- <fade-transition :duration="100" mode="out-in"> -->
      <!-- your content here -->
       <transition name="fade">
        <router-view :key="$route.fullPath"></router-view>
      </transition>
    <!-- </fade-transition> -->
  </div>
</template>

<script>
  // import {FadeTransition} from 'vue2-transitions';
  export default {
    // components: {
      // FadeTransition
    // }
  };
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
