<template>
    <div class="modal fade" id="form_00003" tabindex="-1" role="dialog" aria-labelledby="form_00003ModalLabel" v-modal v-on:showModal="init()" v-on:hideModal="hiddenModal()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="general_transactionModalLabel">Ажил гүйлгээ шинээр бүртгэх (Үндсэн хөрөнгө)</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive with-chosen">
                        <table class="table table-bordered property-table table-sm-text">
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
                                        <label class="control-label">Харилцагч</label>
                                        <select2 v-if="customers.length > 0" :options="customers" :value="transaction.customer_id" :selected="transaction" v-on:input="selectCustomer"></select2>
                                        <div class="text-danger" v-if="errorMessages.transaction_date">
                                            {{ errorMessages.transaction_date[0] }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Харьцсан данс</label>
                                        <select2-group v-if="to_accounts.length > 0" :options="to_accounts" :value="transaction.to_account_id" :selected="transaction" v-on:input="selectToAccount"></select2-group>
                                        <div class="text-danger" v-if="errorMessages.to_account_id">
                                            {{ errorMessages.to_account_id[0] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group">
                                        <label class="control-label">Гүйлгээний утга</label>
                                        <input type="text" class="form-control input-sm" v-model="transaction.description" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Огноо</label>
                                        <input type="text" class="form-control input-sm" v-model="transaction.transaction_date" v-pick="transaction.transaction_date" v-on:input="setStartDate" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Хөрөнгийн данс</label>
                                        <select2-group v-if="accounts.length > 0" :options="accounts" :value="transaction.account_id" :selected="transaction" v-on:input="selectAccount"></select2-group>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Байрлал</label>
                                        <select2 v-if="branches.length > 0" :options="branches" :value="transaction.branch_id" :selected="transaction" v-on:input="selectBranch"></select2>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Код</label>
                                        <input type="text" class="form-control input-sm" v-model="transaction.code" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Нэр</label>
                                        <input type="text" class="form-control input-sm" v-model="transaction.name" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Эд хариуцагч</label>
                                        <select2 v-if="users.length > 0" :options="users" :value="transaction.owner_id" :selected="transaction" v-on:input="selectOwner"></select2>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Нэгж өртөг</label>
                                        <money v-model="transaction.unit_amount" v-bind="money" class="input-sm form-control"></money>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Тоо ширхэг</label>
                                        <money v-model="transaction.count" v-bind="money" class="input-sm form-control"></money>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Нийт үнэ</label>
                                        <money :value="transaction.count * transaction.unit_amount" v-bind="money" readonly="readonly" class="input-sm form-control" @input="calculateProperty"></money>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Ашиглаж эхэлсэн огноо</label>
                                        <input type="text" v-pick="transaction.start_date" class="form-control input-sm" v-model="transaction.start_date" v-on:changeDate="calculateProperty" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Ашиглах хугацаа (жилээр)</label>
                                        <money v-model="transaction.use_time_count" v-bind="money" class="input-sm form-control" @input="calculateProperty"></money>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Элэгдэх дүн (жилээр)</label>
                                        <input type="text" readonly="readonly" class="form-control input-sm" :value="formatPrice(Math.round(expiration_amount * 100) / 100)" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Хуримтлагдсан элэгдэл</label>
                                        <input type="text" readonly="readonly" class="form-control input-sm" :value="formatPrice(Math.round(deprecation * 100) / 100)" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Дуусах хугацаа</label>
                                        <input type="text" readonly="readonly" class="form-control input-sm" v-model="remaining_time_count" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label">Үлдэх өртөг</label>
                                        <money v-model="transaction.amount" readonly="readonly" v-bind="money" class="input-sm form-control"></money>
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

        },

        data()
        {
            return {
                accounts: [],
                customers: [],
                to_accounts: [],
                total: 0,
                receivables: [],
                branches: [],
                users: [],
                expiration_amount: 0,
                remaining_time_count: '',
                deprecation: 0,
                transaction: {
                    receipt_number: null,
                    transaction_date: null,
                    customer_id: null,
                    account_id: null,
                    description: null,
                    type: 'debit',
                    exchange: 1,
                    marker: '₮',
                    currency_id: null,
                    to_account_id: null,
                    to_exchange: 0,
                    to_currency_id: null,
                    //property
                    code: null,
                    name: null,
                    branch_id: null,
                    owner_id: null,
                    unit_amount: 0,
                    count: 1,
                    use_time_count: 0,
                    start_date: null,
                    amount: 0
                },
                errorMessages: {
                    account_id: null,
                    customer_id: null,
                    description: null,
                    receipt_number: null,
                    to_account_id: null,
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
            selectBranch(data)
            {
                this.transaction.branch_id = data.value;
            },
            setStartDate()
            {
                if(this.transaction.start_date === null)
                {
                    this.transaction.start_date = this.transaction.transaction_date
                }
            },
            selectOwner(data)
            {
                this.transaction.owner_id = data.value;
            },
            calculateProperty()
            {
                const dateformat = require('dateformat');
                var date1 = new Date(this.transaction.start_date);
                var date2 = new Date(this.transaction.start_date);
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if(this.transaction.use_time_count > 0)
                {
                    var day_expiration = (this.transaction.count * this.transaction.unit_amount) / (365 * this.transaction.use_time_count);
                    this.expiration_amount = day_expiration * 365;
                    this.deprecation = diffDays * day_expiration;
                    var remain_percent = (diffDays * 100) / (365 * this.transaction.use_time_count);

                    this.remaining_time_count = dateformat(new Date(date2.getFullYear() + this.transaction.use_time_count, date2.getMonth(), date2.getDate()), 'yyyy-mm-dd');
                    this.transaction.amount = (this.transaction.count * this.transaction.unit_amount) - this.deprecation;
                }
                else
                {
                    this.remaining_time_count = '';
                }

            },
            selectToAccount(data)
            {
                this.transaction.to_account_id = data.value;
                var account = null;
                this.to_accounts.forEach(entry => {
                    entry.accounts.forEach(acc => {
                        if(acc.id == data.value)
                        {
                            account = acc
                        }
                    })
                });
                this.transaction.to_exchange = parseFloat(account.currency.exchange);
                this.transaction.to_currency_id = account.currency_id;
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
            },
            selectCustomer(data)
            {
                this.transaction.customer_id = data.value;
            },
            saveTransaction()
            {
                var self = this;
                axios.post('/api/transaction?journal=0&property=true', this.transaction).then(response => {
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
                            type: 'debit',
                            exchange: 1,
                            marker: '₮',
                            currency_id: null,
                            to_account_id: null,
                            to_exchange: 0,
                            to_currency_id: null,
                            //property
                            code: null,
                            name: null,
                            branch_id: null,
                            owner_id: null,
                            unit_amount: 0,
                            count: 1,
                            use_time_count: 0,
                            start_date: null,
                            amount: 0
                        };
                        self.errorMessages = {
                            account_id: null,
                            customer_id: null,
                            description: null,
                            receipt_number: null,
                            to_account_id: null,
                            closing_date: null
                        };
                        $('#form_00003').modal('hide');
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

                axios.get('/api/account/list?code=00003').then(response => {
                    this.accounts = response.data.model
                }).catch(errors => {})

                axios.get('/api/account/list').then(response => {
                    this.to_accounts = response.data.model
                }).catch(errors => {})

                axios.get('/api/list/branches').then(response => {
                    this.branches = response.data.branches;
                })

                axios.get('/api/user/list').then(response => {
                    this.users = response.data.users
                }).catch(errors => {
                })

                this.fetchReceivable();
            },
            fetchReceivable()
            {
                axios.get('/api/receivable/list/open').then(response => {
                    this.receivables = response.data.list
                }).catch(errors => {})
            },
            hiddenModal()
            {
                this.$emit('modalHided');
            },
            formatPrice(amount) {
                let val = (amount/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }

    }

</script>