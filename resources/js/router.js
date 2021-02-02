import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import BackHome from './pages/backend/home.vue'

//tags
import tagIndex from './pages/backend/tags/index.vue'
//tags
import categoryIndex from './pages/backend/category/index.vue'



const routes = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard/home',
            component: BackHome,
            name: 'dashboard',
        },
        {
            path: '/dashboard/tags',
            component: tagIndex,
            name: 'tags',
        },
        {
            path: '/dashboard/category',
            component: categoryIndex,
            name: 'category',
        },
        
    ]
});

export default routes;