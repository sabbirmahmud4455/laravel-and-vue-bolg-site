import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import BackHome from './pages/backend/home.vue'

//tags
import tagIndex from './pages/backend/tags/index.vue'
//tags
import categoryIndex from './pages/backend/category/index.vue'

//users
import userIndex from './pages/backend/users/index.vue'

//role manage
import roleIndex from './pages/backend/role/index.vue'
import rolePermissions from './pages/backend/role/rolepermissions.vue'



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
        {
            path: '/dashboard/users',
            component: userIndex,
            name: 'users',
        },
        {
            path: '/dashboard/role',
            component: roleIndex,
            name: 'roles',
        },
        {
            path: '/dashboard/role-permissions',
            component: rolePermissions,
            name: 'rolesPermissions',
        },
        
    ]
});

export default routes;