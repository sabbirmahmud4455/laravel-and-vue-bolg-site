require('./bootstrap');
import Vue from 'vue'
import router from './router'
import store from './store'

// toastr notification
import CxltToastr from 'cxlt-vue2-toastr'
var toastrConfigs = {
    position: 'top right',
    showDuration: 500,
    progressBar: true,
    closeButton: true,
    showMethod: 'bounceIn',
    hideMethod: 'bounceOut',
    showDuration: 500,
    hideDuration: 1000,
    timeOut: 5000,
}
Vue.use(CxltToastr, toastrConfigs)
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'


// vform
import { Form, HasError, AlertError } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)




//Vue.component('app-main', require('./component/main.vue').default);

//backend main component
Vue.component('backend-main', require('./component/backend/main.vue').default);


import Common from './common'
Vue.mixin(Common)

const app = new Vue({
    el: '#backend-content',
    router,
    store
});
