import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "home",
    component: () =>
      import(
        /* webpackChunkName: "home" */ /* webpackPrefetch: true */ "@/views/Home.vue"
      ),
    meta: {
        title: "All Resources",
    },
  },
  {
    path: "/create",
    name: "create",
    component: () =>
      import(
        /* webpackChunkName: "create" */ /* webpackPrefetch: true */ "@/views/resource/Create.vue"
      ),
    meta: {
        title: "Create New Resource",
    },
  },
  {
    path: "/:id/edit",
    name: "edit",
    component: () =>
      import(
        /* webpackChunkName: "edit" */ /* webpackPrefetch: true */ "@/views/resource/Edit.vue"
      ),
    meta: {
        title: "Edit Resource",
    },
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
