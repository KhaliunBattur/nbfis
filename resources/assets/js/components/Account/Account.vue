<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Данс
            </h1>
            <ol class="breadcrumb">
                <li><router-link to="/"><i class="fa fa-dashboard"></i> Удирдлага</router-link></li>
                <li class="active">Данс</li>
            </ol>
        </section>

        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Жагсаалт
                            </div>
                            <div class="box-tools">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Шинээр нэмэх
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a @click="createGroup" class="links">Бүлэг</a></li>
                                        <li><a @click="createAccount" class="links">Данс</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="list-tree-view" v-if="accounts">
                                <div class="list-group-item list-group-header">
                                    <div class="col-lg-2 col-md-2 col-sm-3">Дугаар</div>
                                    <div class="col-lg-4 col-md-4 col-sm-3">Нэр</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1">Төлөв</div>
                                    <div class="col-lg-1 col-md-1 col-sm-2">Валют</div>
                                    <div class="col-lg-3 col-md-3 col-sm-2">Журнал</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1"></div>
                                </div>
                                <!--<div class="list-group-item list-group-tree">-->
                                    <!--<div class="col-lg-2 col-md-2 col-sm-3">-->
                                        <!--<input type="text" class="form-control input-sm" v-model="search.code" />-->
                                        <!--<button class="btn btn-sm" @click="filter"></button>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <account-row v-for="account in accounts" v-bind:key="account.id" v-bind:account="account" :number="15" v-on:destroyedGroup="deleteGroup" v-on:saveGroup="saveGroup" v-on:saveAccount="saveAccount"></account-row>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <group-form-editor :group="group" :title="title" v-modal v-on:saved="saveGroup" v-on:saveGroup="saveGroup" :id="'groupForm' + group.id"></group-form-editor>
        <account-form-editor :account="account" :title="title" v-modal v-on:saved="saveAccount" :id="'accountForm' + account.id"></account-form-editor>
    </div>
</template>

<script>

    import Row from './Row.vue';
    import GroupForm from './Group/Form.vue';
    import AccountForm from './Form.vue';

    export default {

        computed: {
            filteredAccounts() {
                return this.filter();
            }
        },

        data()
        {
            return {
                roles: null,
                accounts: null,
                search: {
                    code: ''
                },
                account: {
                    id: 0,
                    name: null,
                    code: null,
                    group: null,
                    journal: null,
                    currency: null,
                    bank: null,
                    bank_account_number: null,
                    is_temporary: false,
                    type: 'active'
                },
                group: {
                    id: 0,
                    code: null,
                    name: null,
                    root_id: null,
                    root: null
                },
                title: 'Шинээр нэмэх'
            }
        },

        components: {
            'account-row': Row,
            'group-form-editor': GroupForm,
            'account-form-editor': AccountForm
        },

        created()
        {
            this.fetchRoles();
            this.fetchAccounts();
        },

        methods: {
            filter()
            {
                var self = this;
                var exp = new RegExp(self.search.code, 'i');

                function deepFilter(accounts) {
                    return accounts.filter(item => {
                        return item.children ? deepFilter(item.children) : accountFilter(item)
                    })
                }

                function accountFilter(item) {
                    if(item.accounts)
                    {
                        return item.accounts.filter(account => {
                            return exp.test(account.account_number)
                        })
                    }
                    else
                    {
                        return false;
                    }
                }

                var filtering = deepFilter(this.accounts);

                return filtering;
            },
            createGroup()
            {
                $('#groupForm' + this.group.id).modal('show');
            },
            createAccount()
            {
                $('#accountForm' + this.account.id).modal('show');
            },
            saveGroup()
            {
                this.group = {
                    id: 0,
                    code: null,
                    name: null,
                    root_id: null,
                    root: null
                };
                this.fetchAccounts();
            },
            saveAccount()
            {
                this.account = {
                    id: 0,
                    name: null,
                    code: null,
                    group: null,
                    journal: null,
                    currency: null,
                    bank: null,
                    bank_account_number: null,
                    is_temporary: false,
                    type: 'active'
                };
                this.fetchAccounts();
            },
            deleteGroup(group)
            {
                this.accounts.splice(this.accounts.indexOf(group), 1);
            },
            fetchAccounts()
            {
                axios.get('/api/account').then(response => {
                    this.accounts = response.data.model;
                }).catch(errors => {
                    this.$router.push('/')
                })
            },
            fetchRoles()
            {
                var self = this;
                axios.get('/api/roles').then(response => {
                    this.roles = response.data.model
                }).catch(function (errors) {
                    self.$router.push('/')
                })
            }
        }

    }
</script>
