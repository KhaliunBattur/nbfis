<template>
    <div>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="general_transactionModalLabel">Ажил гүйлгээ шинээр бүртгэх</h4>
        </div>
        <div class="modal-body">
            <div class="table-responsive with-chosen">

                <table class="table table-bordered property-table" style="font-size: 12px !important">
                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label">Баримтын дугаар</label>
                                <input type="text" class="form-control input-sm" v-model="transaction.receipt_number"  />
                                <div class="text-danger" v-if="errorMessages.receipt_number">
                                    {{ errorMessages.receipt_number[0] }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label class="control-label">Данс</label>
                                <select2-group v-if="accounts.length > 0" :options="accounts" :value="transaction.account_id" :selected="transaction" v-on:input="selectAccount"></select2-group>
                                <div class="text-danger" v-if="errorMessages.transaction_date">
                                    {{ errorMessages.transaction_date[0] }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label">Огноо</label>
                                <input type="text" class="form-control input-sm" v-model="transaction.transaction_date" v-pick />
                                <div class="text-danger" v-if="errorMessages.transaction_date">
                                    {{ errorMessages.transaction_date[0] }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label class="control-label">Гүйлгээний төрөл</label>
                                <br />
                                <div class="radio-inline">
                                    <input name="type" type="radio" v-model="transaction.type" value="credit" checked="checked"> Кредит
                                </div>
                                <div class="radio-inline">
                                    <input name="type" type="radio" v-model="transaction.type" value="debit"> Дебит
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">
                            <div class="form-group">
                                <label class="control-label">Гүйлгээний утга</label>
                                <textarea class="form-control" style="resize:none" :rows="2 + (transaction.to_transaction.length * 3)" v-model="transaction.description"></textarea>
                                <div class="text-danger" v-if="errorMessages.description">
                                    {{ errorMessages.description[0] }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label">Харилцагч</label>
                                <select2 v-if="customers.length > 0" :options="customers" :value="transaction.customer_id" :selected="transaction" v-on:input="selectCustomer"></select2>
                                <div class="text-danger" v-if="errorMessages.transaction_date">
                                    {{ errorMessages.transaction_date[0] }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="float: left; width: 100%">
                                <table class="table">
                                    <tbody>
                                    <tr v-for="(tran, index) in transaction.to_transaction">
                                        <td class="form-group">
                                            <label class="control-label">Харицах данс</label>
                                            <select2-group v-if="accounts.length > 0" :options="accounts" :value="tran.to_account_id" :selected="tran" v-on:input="selectToAccount"></select2-group>
                                        </td>
                                        <td class="form-group" v-if="transaction.currency_id != tran.currency_id">
                                            <label class="control-label">Ханш</label>
                                            <money type="text" class="form-control input-sm" v-model="tran.to_exchange" v-bind="money"></money>
                                        </td>
                                        <td class="form-group" :colspan="transaction.currency_id == tran.currency_id ? '2' : '1'">
                                            <label class="control-label">Нэгж дүн</label>
                                            <money type="text" class="form-control input-sm" v-model="tran.amount" v-bind="money"></money>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-danger" style="margin-top: 24px" v-if="index > 0" @click="deleteTransaction(tran)"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <div class="pull-left text-danger">
                {{ errorMessages.message }}
            </div>
            <button type="button" class="btn btn-default btn-sm" @click="addToTransaction">Харицах данс нэмэх</button>
            <button type="button" class="btn btn-primary btn-sm" @click="saveTransaction">Хадгалах</button>
        </div>
    </div>
</template>

<script>

    import {Money} from 'v-money';
    import Select2 from './../../Helper/Select2.vue';
    import Select2Group from './../../Helper/Select2Group.vue';

    export default {

        props: ['accounts', 'customers', 'to_accounts'],

        data()
        {
            return {
                transaction: {
                    receipt_number: null,
                    transaction_date: null,
                    customer_id: null,
                    account_id: null,
                    description: null,
                    type: 'credit',
                    exchange: 0,
                    currency_id: null,
                    to_transaction: [
                        {
                            to_account_id: null,
                            to_exchange: 0,
                            amount: 0,
                            currency_id: null
                        }
                    ]
                },
                errorMessages: {
                    account_id: null,
                    customer_id: null,
                    description: null,
                    receipt_number: null,
                    to_account_id: null,
                    transaction_date: null,
                },
                money:{
                    decimal:'.',
                    thousands:',',
                    precision:2,
                    masked:false
                },
            }
        },

        components: {
            'money': Money,
            'select2': Select2,
            'select2-group': Select2Group
        },

        methods: {
            addToTransaction()
            {
                this.transaction.to_transaction.push({
                    to_account_id: null,
                    to_exchange: 0,
                    amount: 0
                })
            },
            deleteTransaction(tran)
            {
                this.transaction.to_transaction.splice(this.transaction.to_transaction.indexOf(tran), 1);
            },
            selectToAccount(data)
            {
                let index = this.transaction.to_transaction.indexOf(data.selected);
                this.transaction.to_transaction[index].to_account_id = data.value;
                this.setCurrency(data, index);
            },
            setCurrency(data, index)
            {
                var account = null;
                this.accounts.forEach(entry => {
                    entry.accounts.forEach(acc => {
                        if(acc.id == data.value)
                        {
                            account = acc
                        }
                    })
                });

                this.transaction.to_transaction[index].currency_id = account.currency_id;
                this.transaction.to_transaction[index].to_exchange = parseFloat(account.currency.exchange);
            },
            selectAccount(data)
            {
                this.transaction.account_id = data.value;
                var account = null;
                this.accounts.forEach(entry => {
                    entry.accounts.forEach(acc => {
                        if(acc.id == data.value)
                        {
                            account = acc
                        }
                    })
                });
                this.transaction.exchange = parseFloat(account.currency.exchange);
                this.transaction.currency_id = account.currency_id;
            },
            selectCustomer(data)
            {
                this.transaction.customer_id = data.value;
            },
            saveTransaction()
            {
                var self = this;
                axios.post('/api/transaction?journal=0&multiple=true', this.transaction).then(response => {
                    swal({
                        title : 'Амжилттай',
                        text: 'Гүйлгээ хийгдлээ',
                        type: 'success',
                        timer: 3000
                    }, function(){
                        self.transaction = {
                            receipt_number: null,
                            transaction_date: null,
                            customer_id: null,
                            account_id: null,
                            description: null,
                            type: 'credit',
                            exchange: 0,
                            currency_id: null,
                            to_transaction: [
                                {
                                    to_account_id: null,
                                    to_exchange: 0,
                                    amount: 0,
                                    currency_id: null
                                }
                            ]
                        };
                        self.errorMessages = {
                            account_id: null,
                            customer_id: null,
                            description: null,
                            receipt_number: null,
                            to_account_id: null,
                            transaction_date: null,
                        };
                        $('#general_transactionModal').modal('hide');
                    });
                }).catch(errors => {
                    this.errorMessages = errors.response.data;
                });
            }
        }

    }

</script>