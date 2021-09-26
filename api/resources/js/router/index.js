import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    {
      path: "/",
      name: "home",
      component: () =>
        import(
          /* webpackChunkName: "home" */ /* webpackPrefetch: true */ "../components/Home.vue"
        ),
      meta: {
          title: "All Resources",
      },
    },
]

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
  });
  
  export default router;