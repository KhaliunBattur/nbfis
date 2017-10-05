<template>
    <div class="list-tree-view-parent">
        <div class="list-group-item list-group-tree">
            <div class="col-lg-2 hidden-md hidden-sm" v-bind:style="'padding-left: ' + number + 'px'">
                <b>{{ account.code }}</b>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
                <b>{{ account.name }}</b>
            </div>
            <div class="col-lg-1 hidden-md hidden-sm">

            </div>
            <div class="col-lg-7 col-md-10 col-sm-10">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2"><b v-if="account.active > 0">{{ formatPrice(account.active) }}</b></div>
                    <div class="col-lg-2 col-md-2 col-sm-2"><b v-if="account.passive > 0">{{ formatPrice(account.passive) }}</b></div>
                    <div class="col-lg-2 col-md-2 col-sm-2"><b v-if="account.debit > 0">{{ formatPrice(account.debit) }}</b></div>
                    <div class="col-lg-2 col-md-2 col-sm-2"><b v-if="account.credit > 0">{{ formatPrice(account.credit) }}</b></div>
                    <div class="col-lg-2 col-md-2 col-sm-2"><b v-if="account.active_total > 0">{{ formatPrice(account.active_total) }}</b></div>
                    <div class="col-lg-2 col-md-2 col-sm-2"><b v-if="account.passive_total > 0">{{ formatPrice(account.passive_total) }}</b></div>
                </div>
            </div>
        </div>
        <div class="list-group-item list-group-tree account-row" v-if="account.accounts" v-for="acc in account.accounts">
            <div class="col-lg-2 hidden-md hidden-sm" v-bind:style="'padding-left: ' + (number + 20) + 'px'">
                {{ acc.account_number }}
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
                {{ acc.name }}
            </div>
            <div class="col-lg-1 hidden-md hidden-sm">
                {{ acc.currency.name }}
            </div>
            <div class="col-lg-7 col-md-10 col-sm-10">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="input-group" v-if="acc.type == 'active'">
                            <div v-if="acc.currency.is_current">
                                {{ formatPrice(acc.balance) }}
                            </div>
                            <div v-if="!acc.currency.is_current">
                                {{ formatPrice(acc.balance) + acc.currency.marker + ' = ' + formatPrice(parseFloat(acc.balance) * parseFloat(acc.final_exchange)) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="input-group" v-if="acc.type == 'passive'">
                            <div v-if="acc.currency.is_current">
                                {{ formatPrice(acc.balance) }}
                            </div>
                            <div v-if="!acc.currency.is_current">
                                {{ formatPrice(acc.balance) + acc.currency.marker + ' = ' + formatPrice(parseFloat(acc.balance) * parseFloat(acc.final_exchange)) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="input-group">
                            <div v-if="acc.currency.is_current">
                                {{ formatPrice(acc.general_debit) }}
                            </div>
                            <div v-if="!acc.currency.is_current">
                                {{ acc.general_debit > 0 ? formatPrice(acc.general_debit) + acc.currency.marker + ' = ' + formatPrice(parseFloat(acc.general_debit) * parseFloat(acc.final_exchange)) : formatPrice(0) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="input-group">
                            <div v-if="acc.currency.is_current">
                                {{ formatPrice(acc.general_credit) }}
                            </div>
                            <div v-if="!acc.currency.is_current">
                                {{ acc.general_credit > 0 ? formatPrice(acc.general_credit) + acc.currency.marker + ' = ' + formatPrice(parseFloat(acc.general_credit) * parseFloat(acc.final_exchange)) : formatPrice(0) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="input-group" v-if="acc.type == 'active'">
                            <div v-if="acc.currency.is_current">
                                {{ formatPrice(acc.total) }}
                            </div>
                            <div v-if="!acc.currency.is_current">
                                {{ formatPrice(acc.total) + acc.currency.marker + ' = ' + formatPrice(parseFloat(acc.total) * parseFloat(acc.final_exchange)) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="input-group" v-if="acc.type == 'passive'">
                            <div v-if="acc.currency.is_current">
                                {{ formatPrice(acc.total) }}
                            </div>
                            <div v-if="!acc.currency.is_current">
                                {{ formatPrice(acc.total) + acc.currency.marker + ' = ' + formatPrice(parseFloat(acc.total) * parseFloat(acc.final_exchange)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <account-row v-for="child in account.children" v-bind:key="child.id" v-bind:account="child" :number="number + 10" :season="season" v-on:setBalance="setBalance"></account-row>
    </div>
</template>

<script>

    import Row from './Row.vue';
    import {Money} from 'v-money'

    export default {

        name: 'account-row',

        props: ['account', 'number', 'season'],

        watch: {
            selectedValue: function(){
                this.changeBalance();
            }
        },

        data()
        {
            return {
                acc: null,
                selectedValue: null,
                money:{
                    decimal:'.',
                    thousands:',',
                    precision:2,
                    masked:false
                },
                group: {
                    id: 0,
                    code: null,
                    name: null,
                    root_id: null,
                    root: null
                },
                selectedAccount: {
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
                title: 'Засварлах'
            }
        },

        mounted()
        {
            this.balance();
        },

        components: {
            'account-row': Row,
            'money': Money,
        },

        methods: {
            breakdown(account)
            {
                this.acc = account;
                $('#breakDown' + account.id).modal('show');
            },
            saveBreakDown(data)
            {
                this.account.accounts[this.account.accounts.indexOf(this.acc)]['breakdown'] = data.transaction;
                this.account.accounts[this.account.accounts.indexOf(this.acc)]['balance'] = data.total;
                this.account.accounts[this.account.accounts.indexOf(this.acc)]['class_name'] = data.class_name;
                $('#breakDown' + this.acc.id).modal('hide');
            },
            selectInput(value)
            {
                this.selectedValue = value;
            },
            changeBalance()
            {
                this.balance();
            },
            setBalance(account)
            {
                this.account['active'] = this.account.children.reduce(function(prev, children){
                    return parseFloat(prev) + parseFloat(children.active);
                }, 0);

                this.account['passive'] = this.account.children.reduce(function(prev, children){
                    return parseFloat(prev) + parseFloat(children.passive);
                }, 0);

                this.account['balance'] = this.account.children.reduce(function(prev, children){
                    return parseFloat(prev) + parseFloat(children.balance);
                }, 0);

                this.account['credit'] = this.account.children.reduce(function(prev, children){
                    return parseFloat(prev) + parseFloat(children.credit);
                }, 0);

                this.account['debit'] = this.account.children.reduce(function(prev, children){
                    return parseFloat(prev) + parseFloat(children.debit);
                }, 0);

                this.account['active_total'] = this.account.children.reduce(function(prev, children){
                    return parseFloat(prev) + parseFloat(children.active_total);
                }, 0);

                this.account['passive_total'] = this.account.children.reduce(function(prev, children){
                    return parseFloat(prev) + parseFloat(children.passive_total);
                }, 0);

                this.selectedValue = null;
                this.$emit('setBalance', account);
            },
            balance()
            {
                if(this.account.accounts)
                {
                    this.account['active'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (account.type == 'active' ? parseFloat(account.balance) * parseFloat(account.final_exchange) : 0);
                    }, 0);

                    this.account['passive'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (account.type == 'passive' ? parseFloat(account.balance) * parseFloat(account.final_exchange) : 0);
                    }, 0);

                    this.account['credit'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (parseFloat(account.general_credit) * parseFloat(account.final_exchange));
                    }, 0);

                    this.account['debit'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (parseFloat(account.general_debit) * parseFloat(account.final_exchange));
                    }, 0);

                    this.account['active_total'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (account.type == 'active' ? parseFloat(account.total) * parseFloat(account.final_exchange) : 0);
                    }, 0);

                    this.account['passive_total'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (account.type == 'passive' ? parseFloat(account.total) * parseFloat(account.final_exchange) : 0);
                    }, 0);
                }
                this.selectedValue = null;
                this.$emit('setBalance', this.account);
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
        }

    }

</script>