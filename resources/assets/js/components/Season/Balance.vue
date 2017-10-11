<template>
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row" v-if="season">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">
                            {{ season.name }}
                        </div>
                        <div class="box-tools">
                            Нээсэн огноо: {{ season.open_date }}
                        </div>
                    </div>
                    <div class="box-body">
                        <ul class="list-inline">
                            <li><b>Валютын ханш </b></li>
                            <li v-for="currency in season.currencies">
                                <div>{{ currency.name}} : <input type="text" class="form-control input-sm" v-model="currency.pivot.exchange" /> </div>
                            </li>
                            <li><button class="btn btn-warning btn-xs" data-placement="top" title="Валют засварлах" v-tip @click="saveCurrency()"><i class="fa fa-save"></i></button></li>
                        </ul>
                        <div class="list-tree-view" v-if="accounts">
                            <div class="list-group-item list-group-header">
                                <div class="col-lg-2 col-md-2 col-sm-3">Дугаар</div>
                                <div class="col-lg-3 col-md-4 col-sm-3">Нэр</div>
                                <div class="col-lg-1 hidden-md hidden-sm">Валют</div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">Актив</div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">Пассив</div>
                                    </div>
                                </div>
                            </div>
                            <account-row v-for="account in accounts" v-bind:key="account.id" :season="season" v-bind:account="account" :number="15" v-on:destroyedGroup="deleteGroup" v-on:saveGroup="saveGroup" v-on:saveAccount="saveAccount"></account-row>
                            <div class="list-group-item list-group-footer">
                                <div class="col-lg-2 col-md-2 col-sm-3"></div>
                                <div class="col-lg-3 col-md-4 col-sm-3"></div>
                                <div class="col-lg-1 hidden-md hidden-sm"></div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">Актив = {{ getActive() }}</div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">Пассив = {{ getPassive() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div class="pull-right">
                                <span class="text-danger"><i v-if="(active > 0 || passive > 0) && active != passive" class="fa fa-warning"> Баланс тэнцээгүй байна</i></span>
                            </div>
                            <div class="btn-group pull-right" v-if="(active > 0 || passive > 0) && active == passive">
                                <button class="btn btn-success btn-sm" @click="saveBalance">Хадгалах</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <group-form-editor :group="group" :title="title" v-modal v-on:saved="saveGroup" v-on:saveGroup="saveGroup" :id="'groupForm' + group.id"></group-form-editor>
        <account-form-editor :account="account" :title="title" v-modal v-on:saved="saveAccount" :id="'accountForm' + account.id"></account-form-editor>
    </section>
</template>

<script>

    import Row from './Row.vue';
    import GroupForm from './../Account/Group/Form.vue';
    import AccountForm from './../Account/Form.vue';

    export default {

        computed: {
            filteredAccounts() {
                return this.filter();
            }
        },

        data()
        {
            return {
                active: 0,
                passive: 0,
                roles: null,
                accounts: null,
                season: null,
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
            this.fetchSeason();
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
            saveBalance()
            {
                var self = this;

                swal({
                    title: "Та итгэлтэй байна уу?",
                    text: "Эхлэл балансын дүнг хадгалах гэж байна!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Тийм",
                    cancelButtonText: "Үгүй",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    axios.patch('/api/season/' + self.$route.params.id + '/balance', self.accounts).then(response => {
                        if(response.data.result)
                        {
                            swal({
                                title: 'Амжилттай!',
                                text: 'Aмжилттай хадгалагдлаа',
                                type: 'success'
                            }, function(){

                            })
                        }
                    }).catch(function(error) {
                        swal(
                            'Уучлаарай',
                            'Хүсэлт амжилтгүй боллоо! Та дахин оролдоно уу.',
                            'error'
                        );
                    });
                });
            },
            getActive()
            {
                let active = this.accounts.reduce(function(prev, account){
                    return parseFloat(prev) + parseFloat(account.active);
                }, 0);

                this.active = active;

                return this.formatPrice(active);
            },
            getPassive()
            {
                let passive = this.accounts.reduce(function(prev, account){
                    return parseFloat(prev) + parseFloat(account.passive);
                }, 0);

                this.passive = passive;

                return this.formatPrice(passive);
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
            },
            saveCurrency()
            {
                axios.patch('/api/season/' + this.$route.params.id + '/currency', this.season.currencies).then(response => {
                    swal('Амжилттай', 'Валют амжилттай солигдлоо', 'success');
                }).catch(errors => {

                });
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
            fetchSeason()
            {
                axios.get('/api/season/' + this.$route.params.id + '/edit').then(response => {
                    this.season = response.data.season;
                });
            },
            fetchAccounts()
            {
                axios.get('/api/season/' + this.$route.params.id).then(response => {
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
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
        }

    }
</script>
