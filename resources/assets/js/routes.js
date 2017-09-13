import Vue from 'vue';
import VueRouter from 'vue-router'

// Удирдлагын routes
import Dashboard from './components/Dashboard.vue'

// Хэрэглэгчийн routes
import Users from './components/User/Users.vue'
import UserLists from './components/User/Lists.vue'
import UserCreate from './components/User/Create.vue'
import UserEdit from './components/User/Edit.vue'
import CV from './components/User/CV.vue'
import UserCv from './components/User/Profile/CV.vue'
import UserProfile from './components/User/Profile/Profile.vue'

// Данс
import Account from './components/Account/Account.vue'

// Журнал
import Journal from './components/Journal/Journal.vue'

// Банк
import Bank from './components/Bank/Bank.vue'

// Вальют
import Currency from './components/Currency/Currency.vue'

//Хэрэглэгчийн эрхийн routes
import Roles from './components/Role/Roles.vue'

//Эхлэл баланс буюу улирал
import Season from './components/Season/Season.vue'
import BalanceList from './components/Season/List.vue'
import Balance from './components/Season/Balance.vue'

//Гүйлгээ
import Transaction from './components/Transaction/Transaction.vue';
import General from './components/Transaction/General.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Dashboard
        },
        {
            path: '/new/customer',
            component: CV
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
                },
                {
                    path: ':id/profile', component: UserProfile
                },
                {
                    path: ':id/cv', component: UserCv
                }
            ]
        },
        {
            path: '/account', component: Account
        },
        {
            path: '/journal', component: Journal
        },
        {
            path: '/bank', component: Bank
        },
        {
          path: '/currency', component: Currency
        },
        {
            path: '/season', component: Season,
            children: [
                {
                    path: '', component: BalanceList
                },
                {
                    path: ':id/balance', component: Balance
                }
            ]
        },
        {
            path: '/transaction', component: Transaction,
            children: [
                {
                    path: '', component: General
                }
            ]
        },
        {
            path: '/roles',
            component: Roles
        },
    ]
})

export default router