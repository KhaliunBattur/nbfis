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
import Customer from './components/User/Customer.vue';
import CustomerList from './components/User/CustomerList.vue';
import CustomerEdit from './components/User/Customer/Edit.vue';
import CustomerCreate from './components/User/Customer/Create.vue';
import CustomerProfile from  './components/User/Customer/Profile.vue';
import CvRequest from './components/User/CV.vue';
//Зээл
import Request from './components/Request.vue';

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
import General from './components/Transaction/General.vue';
import JournalTransaction from './components/Transaction/Journal.vue';

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Dashboard
        },
        {
            path: '/new/customer',
            component: CV,
            children: [
                {
                    path:':register' ,component: CvRequest
                }
            ]
        },
        {
            path: '/customers', component: Customer,
            children: [
                {
                    path: '', component: CustomerList
                },
                {
                    path: 'create', component: CustomerCreate
                },
                {
                    path: ':id/edit', component: CustomerEdit
                },
                {
                    path: ':id/profile', component: CustomerProfile
                }
            ]
        },
        {
            path: '/request', component: Request
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
                },
                {
                    path: ':id', component: JournalTransaction
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