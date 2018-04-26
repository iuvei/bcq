import "es6-promise/auto";
import Vue from 'vue';
import router from './router';
import App from './App.vue';
import axios from 'axios';
import iView from 'iview';
import store from './store';
import 'iview/dist/styles/iview.css';
import 'normalize.css/normalize.css';
import '../../css/reset.css';
import '../../css/reset_alex.scss';
import '../../css/icons.css';
import '../../css/style.less';
Vue.use(iView)
Vue.prototype.https = axios
const app = new Vue({
    router,
    store,
    el : '#app',
    template : '<App/>',
    components : {
        App
    }
});