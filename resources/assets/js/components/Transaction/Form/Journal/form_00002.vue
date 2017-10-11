<template>
    <div class="modal fade" id="form_00002" tabindex="-1" role="dialog" aria-labelledby="form_00002ModalLabel" v-modal v-on:showModal="init()" v-on:hideModal="hiddenModal()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="general_transactionModalLabel">Ажил гүйлгээ шинээр бүртгэх (Авлага өглөг)</h4>
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
                                    <div class="form-group pull-left">
                                        <label class="control-label">Тооцоо</label>
                                        <br />
                                        <div class="radio-inline">
                                            <input name="type" type="radio" v-model="transaction.type" value="credit" checked="checked"> {{ label_credit }}
                                        </div>
                                        <div class="radio-inline">
                                            <input name="type" type="radio" v-model="transaction.type" value="debit"> {{ label_debit }}
                                        </div>
                                    </div>
                                    <div class="form-group pull-left" style="margin-left: 30px" v-if="(transaction.type === 'credit' && account_type == 'passive') || (transaction.type === 'debit' && account_type == 'active')">
                                        <label class="control-label">Тооцоо хаах огноо</label>
                                        <input type="text" class="form-control input-sm" v-model="transaction.closing_date" v-pick />
                                        <div class="text-danger" v-if="errorMessages.closing_date">
                                            {{ errorMessages.closing_date[0] }}
                                        </div>
                                    </div>
                                    <div class="form-group pull-left" style="margin-left: 30px" v-if="(transaction.type === 'credit' && account_type == 'active') || (transaction.type === 'debit' && account_type == 'passive')">
                                        <label class="control-label">Өглөг авлага сонгох</label>
                                        <select2 v-if="receivables.length > 0" :options="receivables" :value="transaction.receivable_id" :selected="transaction" v-on:input="selectReceivable"></select2>
                                        <div class="text-danger" v-if="errorMessages.receivable_id">
                                            {{ errorMessages.receivable_id[0] }}
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
                                                    <label class="control-label">Харьцсан данс</label>
                                                    <select2-group v-if="to_accounts.length > 0" :options="to_accounts" :value="tran.to_account_id" :selected="tran" v-on:input="selectToAccount"></select2-group>
                                                </td>
                                                <td class="form-group" v-if="(transaction.currency_id != tran.currency_id && tran.is_current === 0) || (transaction.is_current === 0 && tran.is_current === 0)">
                                                    <label class="control-label">Ханш</label>
                                                    <money type="text" class="form-control input-sm" v-model="tran.to_exchange" v-bind="money" @input="calculate"></money>
                                                </td>
                                                <td class="form-group" v-if="(transaction.currency_id != tran.currency_id && tran.is_current === 1) || (transaction.is_current === 0 && tran.is_current === 0)">
                                                    <label class="control-label">Ханш ({{ transaction.marker }})</label>
                                                    <money type="text" class="form-control input-sm" v-model="transaction.exchange" v-bind="money" @input="calculate"></money>
                                                </td>
                                                <td class="form-group" :colspan="transaction.currency_id == tran.currency_id ? '2' : '1'">
                                                    <label class="control-label">Нэгж дүн</label>
                                                    <money type="text" class="form-control input-sm" v-model="tran.amount" v-bind="money" @input="inputSubTotal(tran)"></money>
                                                </td>
                                                <td class="form-group" :colspan="transaction.currency_id == tran.currency_id ? '2' : '1'" v-show="transaction.is_current === 0 || tran.is_current === 0">
                                                    <label class="control-label">Дүн</label>
                                                    <money type="text" class="form-control input-sm" v-model="tran.subTotal" v-bind="money" @input="calculate"></money>
                                                </td>
                                                <td>
                                                    <button class="btn btn-xs btn-danger" style="margin-top: 24px" v-if="index > 0" @click="deleteTransaction(tran)"><i class="fa fa-trash-o"></i></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="pull-right" v-if="transaction">
                                            Нийт дүн: {{ formatPrice(total) }}
                                        </div>
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
                    <button type="button" class="btn btn-primary btn-sm" @click="saveTransaction">Гүйлгээ хийх</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {Money} from 'v-money';
    import Select2 from './../../../Helper/Select2.vue';
    import Select2Group from './../../../Helper/Select2Group.vue';

    export default {

        watch: {
            'transaction.to_transaction': function() {
                this.calculate();
            },
            'transaction.account_id': function() {
                this.fetchReceivable();
            },
            'transaction.to_transaction.to_exchange': function() {
                this.calculate();
            },
            'transaction.to_transaction.amount': function() {
                this.calculate();
            },
            'transaction.to_transaction.to_account_id': function() {
                this.calculate();
            },
            'transaction.type': function()
            {
                if(this.transaction.account_id !== null)
                {
                    this.fetchReceivable();
                }
                this.calculate();
            }
        },

        data()
        {
            return {
                accounts: [],
                customers: [],
                to_accounts: [],
                total: 0,
                receivables: [],
                label_credit: 'Үүсгэх',
                label_debit: 'Хаах',
                account_type: 'passive',
                transaction: {
                    receipt_number: null,
                    transaction_date: null,
                    customer_id: null,
                    account_id: null,
                    description: null,
                    receivable_id: null,
                    closing_date: null,
                    type: 'credit',
                    exchange: 1,
                    marker: '₮',
                    currency_id: null,
                    is_current: 0,
                    to_transaction: [
                        {
                            to_account_id: null,
                            to_exchange: 0,
                            amount: 0,
                            currency_id: null,
                            is_current: 0
                        }
                    ]
                },
                errorMessages: {
                    account_id: null,
                    customer_id: null,
                    description: null,
                    receipt_number: null,
                    to_account_id: null,
                    receivable_id: null,
                    transaction_date: null,
                    closing_date: null
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
            inputSubTotal(tran)
            {
                if(tran.is_current === 1)
                {
                    tran.subTotal = (tran.amount * this.transaction.exchange) / tran.to_exchange;
                }
                else
                {
                    tran.subTotal = (tran.amount * tran.to_exchange) / this.transaction.exchange;
                }
            },
            addToTransaction()
            {
                this.transaction.to_transaction.push({
                    to_account_id: null,
                    to_exchange: 0,
                    amount: 0,
                    currency_id: null
                })
            },
            deleteTransaction(tran)
            {
                this.transaction.to_transaction.splice(this.transaction.to_transaction.indexOf(tran), 1);
                this.calculate();
            },
            selectReceivable(data)
            {
                this.transaction.receivable_id = data.value;

                var receivable = null;

                this.receivables.forEach(entry => {
                    if(entry.id == data.value)
                    {
                        receivable = entry;
                    }
                });
            },
            selectToAccount(data)
            {
                let index = this.transaction.to_transaction.indexOf(data.selected);
                this.transaction.to_transaction[index].to_account_id = data.value;
                this.setCurrency(data, index);
                this.calculate();
            },
            setCurrency(data, index)
            {
                var account = null;
                this.to_accounts.forEach(entry => {
                    entry.accounts.forEach(acc => {
                        if(acc.id == data.value)
                        {
                            account = acc
                        }
                    })
                });

                this.transaction.to_transaction[index].currency_id = account.currency_id;
                this.transaction.to_transaction[index].to_exchange = parseFloat(account.currency.exchange);
                this.transaction.to_transaction[index].is_current = account.currency.is_current;
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
                this.transaction.marker = account.currency.marker;
                this.transaction.is_current = account.currency.is_current;
                this.account_type = account.type
                if(this.account_type === 'active')
                {
                    this.label_credit = 'Хаах';
                    this.label_debit = 'Үүсгэх';
                }
                else
                {
                    this.label_credit = 'Үүсгэх';
                    this.label_debit = 'Хаах';
                }
            },
            selectCustomer(data)
            {
                this.transaction.customer_id = data.value;
            },
            saveTransaction()
            {
                var self = this;
                axios.post('/api/transaction?journal=0&multiple=true&receivable=true', this.transaction).then(response => {
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
                            receivable_id: null,
                            closing_date: null,
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
                            receivable_id: null,
                            transaction_date: null,
                            closing_date: null
                        };
                        $('#form_00002').modal('hide');
                    });
                }).catch(errors => {
                    this.errorMessages = errors.response.data;
                });
            },
            init()
            {
                axios.get('/api/customer/list').then(response => {
                    this.customers = response.data.customers
                }).catch(errors => {})

                axios.get('/api/account/list?code=00002').then(response => {
                    this.accounts = response.data.model
                }).catch(errors => {})

                axios.get('/api/account/list').then(response => {
                    this.to_accounts = response.data.model
                }).catch(errors => {})
            },
            fetchReceivable()
            {
                axios.get('/api/receivable/list/open', {
                    params: {
                        type: this.account_type
                    }
                }).then(response => {
                    this.receivables = response.data.list
                }).catch(errors => {})
            },
            calculate()
            {
                var sum = 0;
                this.transaction.to_transaction.forEach(entry => {
                    sum += parseFloat(entry.subTotal)
                });
                this.total = sum;
            },
            hiddenModal()
            {
                Object.assign(this.$data, {
                    accounts: [],
                    customers: [],
                    to_accounts: [],
                    total: 0,
                    receivables: [],
                    label_credit: 'Үүсгэх',
                    label_debit: 'Хаах',
                    account_type: 'passive',
                    transaction: {
                        receipt_number: null,
                        transaction_date: null,
                        customer_id: null,
                        account_id: null,
                        description: null,
                        receivable_id: null,
                        closing_date: null,
                        type: 'credit',
                        exchange: 1,
                        marker: '₮',
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
                        receivable_id: null,
                        transaction_date: null,
                        closing_date: null
                    },
                    money:{
                        decimal:'.',
                        thousands:',',
                        precision:2,
                        masked:false
                    },
                });
                this.$emit('modalHided');
            },
            formatPrice(amount) {
                let val = (amount/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }

    }

</script>