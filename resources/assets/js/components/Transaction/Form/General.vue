<template>
    <div class="modal fade" id="general_transactionModal" tabindex="-1" role="dialog" aria-labelledby="general_transactionModalLabel" v-modal v-on:showModal="init()" v-on:hideModal="hiddenModal()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="general_transactionModalLabel">Ажил гүйлгээ шинээр бүртгэх</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
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
                                        <label class="control-label">Огноо</label>
                                        <input type="text" class="form-control input-sm" v-model="transaction.transaction_date" v-pick />
                                        <div class="text-danger" v-if="errorMessages.transaction_date">
                                            {{ errorMessages.transaction_date[0] }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Харилцагч</label>
                                        <select2 :options="customers" :value="transaction.customer_id" :selected="transaction" v-on:input="selectCustomer"></select2>
                                        <div class="text-danger" v-if="errorMessages.customer_id">
                                            {{ errorMessages.customer_id[0] }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Харицах данс</label>
                                        <select2 :options="accounts" :value="transaction.account_id" :selected="transaction" v-on:input="selectToAccount"></select2>
                                        <div class="text-danger" v-if="errorMessages.to_account_id">
                                            {{ errorMessages.to_account_id[0] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="3" colspan="2">
                                    <div class="form-group">
                                        <label class="control-label">Гүйлгээний утга</label>
                                        <textarea class="form-control" v-bind:rows="currency_current ? 4 : 6" style="resize:none" v-model="transaction.description"></textarea>
                                        <div class="text-danger" v-if="errorMessages.description">
                                            {{ errorMessages.description[0] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <label class="control-label">Данс</label>
                                        <select2 :options="accounts" :value="transaction.account_id" :selected="transaction" v-on:input="selectAccount"></select2>
                                        <div class="text-danger" v-if="errorMessages.account_id">
                                            {{ errorMessages.account_id[0] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
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
                                <td>
                                    <div class="form-group" v-if="currency_current">
                                        <label class="control-label">Мөнгөн дүн</label>
                                        <div class="input-group input-group-sm">
                                            <money v-model="transaction.amount" v-bind="money" class="form-control"></money>
                                            <div class="input-group-addon">
                                                <span>{{ transaction.marker }}</span>
                                            </div>
                                        </div>
                                        <div class="text-danger" v-if="errorMessages.amount">
                                            {{ errorMessages.amount[0] }}
                                        </div>
                                    </div>
                                    <div v-if="!currency_current">
                                        <div class="form-group">
                                            <label class="control-label">Ханш</label>
                                            <money v-model="transaction.exchange" v-bind="money" class="form-control input-sm"></money>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Мөнгөн дүн</label>
                                            <div class="input-group input-group-sm">
                                                <money v-model="transaction.amount" v-bind="money" class="form-control"></money>
                                                <div class="input-group-addon">
                                                    <span>{{ transaction.marker }}</span>
                                                </div>
                                                <input :value="formatPrice(transaction.amount * transaction.exchange)" class="form-control" />
                                                <div class="input-group-addon">
                                                    <span>{{ transaction.to_marker }}</span>
                                                </div>
                                            </div>
                                            <div class="text-danger" v-if="errorMessages.amount">
                                                {{ errorMessages.amount[0] }}
                                            </div>
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
                    <button type="button" class="btn btn-primary btn-sm" @click="saveTransaction">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {Money} from 'v-money';
    import Select2 from './../../Helper/Select2.vue';

    export default {

        data()
        {
            return {
                customers: [],
                accounts: [],
                to_accounts: [],
                currency_current: true,
                errorMessages: {
                    account_id: null,
                    customer_id: null,
                    description: null,
                    receipt_number: null,
                    to_account_id: null,
                    transaction_date: null,
                },
                transaction: {
                    receipt_number: null,
                    transaction_date: null,
                    customer_id: null,
                    account_id: null,
                    to_account_id: null,
                    description: null,
                    type: 'credit',
                    amount: 0,
                    exchange: 0,
                    to_exchange: 0,
                    marker: '₮',
                    to_marker: '$'
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
            'select2': Select2
        },

        methods: {
            selectCustomer(data)
            {
                this.transaction.customer_id = data.value;
            },

            selectAccount(data)
            {
                this.transaction.account_id = data.value;
                this.checkExchange()
            },

            selectToAccount(data)
            {
                this.transaction.to_account_id = data.value;
                this.checkExchange()
            },

            saveTransaction()
            {
                var self = this;
                axios.post('/api/transaction?journal=0', this.transaction).then(response => {
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
                            to_account_id: null,
                            description: null,
                            type: 'credit',
                            amount: 0,
                            exchange: 0,
                            to_exchange: 0,
                            marker: '₮',
                            to_marker: '$'
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
                })
            },

            formatPrice(amount) {
                let val = (amount/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

            checkExchange()
            {
                var account = this.accounts.filter(account => {
                    return account.id == this.transaction.account_id;
                });

                var to_account = this.accounts.filter(account => {
                    return account.id == this.transaction.to_account_id;
                });

                if(account.length > 0)
                {
                    this.transaction.marker = account[0].marker;
                    if(to_account.length > 0)
                    {
                        this.transaction.to_marker = to_account[0].marker;
                        this.currency_current = (account[0].currency_id === to_account[0].currency_id);
                        if(account[0].currency_id !== to_account[0].currency_id)
                        {

                            if(account[0].is_current === 0)
                            {
                                this.transaction.exchange = parseFloat(account[0].exchange)
                                this.transaction.to_exchange = parseFloat(to_account[0].exchange)
                            }
                            else
                            {
                                this.transaction.exchange = parseFloat(to_account[0].exchange)
                                this.transaction.to_exchange = parseFloat(account[0].exchange)
                            }
                        }
                        else
                        {
                            this.transaction.exchange = parseFloat(account[0].exchange);
                            this.transaction.to_exchange = parseFloat(account[0].exchange)
                        }
                    }
                }
            },

            init()
            {
                axios.get('/api/customer/list').then(response => {
                    this.customers = response.data.customers
                }).catch(errors => {})

                axios.get('/api/account/list').then(response => {
                    this.accounts = response.data.model
                }).catch(errors => {})
            },

            hiddenModal()
            {
                this.$emit('modalHided');
            }
        }

    }

</script>