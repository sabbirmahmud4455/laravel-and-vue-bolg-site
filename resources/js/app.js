import Vue from 'vue'
import routers from './router'

require('./bootstrap');


//Vue.component('app-main', require('./component/main.vue').default);

//backend main component
Vue.component('backend-main', require('./component/backend/main.vue').default);





const app = new Vue({
    el: '#backend-content',
    router: routers,
});
