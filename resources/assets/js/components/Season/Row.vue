<template>
    <div class="list-tree-view-parent">
        <div class="list-group-item list-group-tree">
            <div class="col-lg-2 col-md-2 col-sm-3" v-bind:style="'padding-left: ' + number + 'px'">
                <b>{{ account.code }}</b>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-3">
                <b>{{ account.name }}</b>
            </div>
            <div class="col-lg-1 hidden-md hidden-sm">

            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6"><b v-if="account.active > 0">{{ formatPrice(account.active) }}</b></div>
                    <div class="col-lg-6 col-md-6 col-sm-6"><b v-if="account.passive > 0">{{ formatPrice(account.passive) }}</b></div>
                </div>
            </div>
        </div>
        <div class="list-group-item list-group-tree" v-if="account.accounts" v-for="acc in account.accounts">
            <div class="col-lg-2 col-md-2 col-sm-3" v-bind:style="'padding-left: ' + (number + 20) + 'px'">
                {{ acc.account_number }}
            </div>
            <div class="col-lg-3 col-md-4 col-sm-3">
                {{ acc.name }}
            </div>
            <div class="col-lg-1 hidden-md hidden-sm">
                {{ acc.currency.name }}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="input-group" v-if="acc.type == 'active'">
                            <money v-model="acc.balance" v-bind="money" class="input-sm form-control" @input="selectInput(acc.balance)"></money>
                            <div class="input-group-addon">
                                {{ acc.currency.marker }}
                            </div>
                            <div v-if="!acc.currency.is_current">
                                <money :value="parseFloat(acc.balance) * acc.exchange" v-bind="money" readonly="readonly" class="input-sm form-control" @input="selectInput(acc.balance)"></money>
                            </div>
                            <div class="input-group-addon" v-if="!acc.currency.is_current">
                                ₮
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="input-group" v-if="acc.type == 'passive'">
                            <div>
                                <money v-model="acc.balance" v-bind="money" class="input-sm form-control" @input="selectInput(acc.balance)"></money>
                            </div>
                            <div class="input-group-addon">
                                {{ acc.currency.marker }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <account-row v-for="child in account.children" v-bind:key="child.id" v-bind:account="child" :number="number + 10" v-on:setBalance="setBalance"></account-row>
    </div>
</template>

<script>

    import Row from './Row.vue';
    import DeleteConfirm from './../Helper/DeleteConfirm.vue';
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
            'delete-confirm': DeleteConfirm,
            'money': Money,
        },

        methods: {
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
                this.selectedValue = null;
                this.$emit('setBalance', account);
            },
            balance()
            {
                if(this.account.accounts)
                {
                    this.account['active'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (account.type == 'active' ? parseFloat(account.balance) * account.exchange : 0);
                    }, 0);

                    this.account['passive'] = this.account.accounts.reduce(function(prev, account){
                        return parseFloat(prev) + (account.type == 'passive' ? parseFloat(account.balance) * account.exchange : 0);
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