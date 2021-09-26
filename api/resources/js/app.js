require('./bootstrap');
window.Vue = require('vue').default;
import axios from "axios";
import VueAxios from "vue-axios";
import Toasted from "vue-toasted";
import VueScrollTo from "vue-scrollto";
import Loading from "vue-loading-overlay";
import VueSweetalert2 from 'vue-sweetalert2';
import "vue-loading-overlay/dist/vue-loading.css";
import 'sweetalert2/dist/sweetalert2.min.css';
import router from "./router";
import commonHelper from "./helpers/common";
import App from "./App.vue";

Vue.use(VueAxios, axios);
Vue.use(Toasted, {
    position: "top-center",
    duration: 2000,
});
Vue.use(VueScrollTo);
Vue.use(Loading, {
    loader: "dots",
    width: 150,
    height: 150,
    color: '#1F2937',
});
let loaderIndicator = null;

Vue.use(VueSweetalert2);

axios.defaults.baseURL = commonHelper.apiUrl + "/";
axios.interceptors.request.use((config) => {
    showLoaderIndicator();
    return config;
});


axios.interceptors.response.use(
    (response) => {
        hideLoaderIndicator();
        return response;
    },
    (error) => {
        loaderIndicator.hide();
        return Promise.reject(error);
    }
);


router.beforeResolve((to, from, next) => {
    if (to.name) {
        showLoaderIndicator();
    }
    next();
});


router.afterEach((to, from) => {
    VueScrollTo.scrollTo('#app');
    hideLoaderIndicator();
});

const helpers = {
    install(Vue, options) {
        Vue.prototype.$help = commonHelper; // we use $ because it's the Vue convention
    }
};
Vue.use(helpers);

const app = new Vue({
    router,
    render: (h) => h(App),
}).$mount("#app");

function showLoaderIndicator() {
    loaderIndicator = Vue.$loading.show();
}
function hideLoaderIndicator() {
    if (loaderIndicator) {
        loaderIndicator.hide();
    }
}