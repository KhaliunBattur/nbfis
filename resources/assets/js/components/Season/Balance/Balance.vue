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
                            <li><b>Улирал нээгдэх үед </b></li>
                            <li v-for="currency in season.currencies">{{ currency.name + ': ' + currency.pivot.exchange + '₮' }}</li>
                        </ul>
                        <ul class="list-inline">
                            <li><b>Одоогийн ханш </b></li>
                            <li v-for="currency in currencies">{{ currency.name + ': ' + currency.exchange + '₮' }}</li>
                        </ul>
                        <div class="list-tree-view" v-if="accounts">
                            <div class="list-group-item list-group-header">
                                <div class="col-lg-5 col-md-2 col-sm-2"></div>
                                <div class="col-lg-7 col-md-10 col-sm-10">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">Эхлэл баланс</div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">Ерөнхий журнал</div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">Эцсийн үлдэгдэл</div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item list-group-header">
                                <div class="col-lg-2 hidden-md hidden-sm">Дугаар</div>
                                <div class="col-lg-2 col-md-2 col-sm-2">Нэр</div>
                                <div class="col-lg-1 hidden-md hidden-sm">Валют</div>
                                <div class="col-lg-7 col-md-10 col-sm-10">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-2">Актив</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">Пассив</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">Дебит</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">Кредит</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">Актив</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">Пассив</div>
                                    </div>
                                </div>
                            </div>
                            <account-row v-for="account in accounts" v-bind:key="account.id" :season="season" v-bind:account="account" :number="15"></account-row>
                            <div class="list-group-item list-group-footer">
                                <div class="col-lg-5 col-md-2 col-sm-2"></div>
                                <div class="col-lg-7 col-md-10 col-sm-10">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8"></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">Актив = {{ getActive() }}</div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">Пассив = {{ getPassive() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-inline">
                            <div class="pull-right">
                                <span class="text-danger"><i v-if="(active > 0 || passive > 0) && active != passive" class="fa fa-warning"> Баланс тэнцээгүй байна</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    import Row from './Row.vue';

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
                currencies: null,
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
            'account-row': Row
        },

        created()
        {
            this.fetchRoles();
            this.fetchSeason();
            this.fetchAccounts();
            this.fetchCurrency();
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
            getActive()
            {
                let active = this.accounts.reduce(function(prev, account){
                    return parseFloat(prev) + parseFloat(account.active_total);
                }, 0);

                this.active = active;

                return this.formatPrice(active);
            },
            getPassive()
            {
                let passive = this.accounts.reduce(function(prev, account){
                    return parseFloat(prev) + parseFloat(account.passive_total);
                }, 0);

                this.passive = passive;

                return this.formatPrice(passive);
            },
            fetchSeason()
            {
                axios.get('/api/season/' + this.$route.params.id + '/edit').then(response => {
                    this.season = response.data.season;
                });
            },
            fetchAccounts()
            {
                axios.get('/api/season/' + this.$route.params.id + '/balance').then(response => {
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
            fetchCurrency()
            {
                axios.get('api/currency/lists').then(response => {
                    this.currencies = response.data.lists
                });
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
        }

    }
</script>
