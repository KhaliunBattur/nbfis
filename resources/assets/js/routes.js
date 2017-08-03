import Vue from 'vue';
import VueRouter from 'vue-router'

// Удирдлагын routes
import Dashboard from './components/Dashboard.vue'

// Хэрэглэгчийн routes
import Users from './components/User/Users.vue'
import UserLists from './components/User/Lists.vue'
import UserCreate from './components/User/Create.vue'
import UserEdit from './components/User/Edit.vue'

//Хэрэглэгчийн эрхийн routes
import Roles from './components/Roles.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Dashboard
        },
        {
            path: '/users', component: Users,
            children: [
                {
                    path: '', component: UserLists
                },
                {
                    path: 'create', component: UserCreate
                },
                {
                    path: ':id/edit', component: UserEdit
                }
            ]
        },
        {
            path: '/roles',
            component: Roles
        }
    ]
})

export default router