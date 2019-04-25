import VueRouter from "vue-router";
import routes from "./routes";

// configure router
const router = new VueRouter({
  mode: 'history',
  base: '/',
  fallback: true,
  routes,
  linkExactActiveClass: "active",
  scrollBehavior: (to) => {
    if (to.hash) {
      return {selector: to.hash}
    } else {
      return { x: 0, y: 0 }
    }
  }
});


router.beforeEach((to, from, next) => {
  if ( to.meta.auth && !localStorage.getItem('JWT') ) {
      window.location = "/login"
      return;
  }
  
  next();
})

export default router;
