<template>
    <div class="modal fade" id="breakdownModal" tabindex="-1" role="dialog" aria-labelledby="myModabreakdownModallLabel" v-if="account" v-modal v-on:showModal="init()">
        <div class="modal-dialog modal-lg" role="document" v-if="account">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="breakdownModalLabel">Балансын задаргаа оруулах (Үндсэн хөрөнгө)</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div style="float: left; width: 100%">
                            <table class="table table-bordered property-table">
                                <tbody v-if="tran">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Гүйлгээний утга</label>
                                                <input type="text" class="form-control input-sm" v-model="tran.description" v-validate="'required|max:255'"
                                                       maxlength="255" name="description" />
                                                <span v-if="errors.has('description')" class="help is-danger">{{ errors.first('description') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Хөрөнгийн ангилал</label>
                                                <select2 :options="groups" :value="tran.transaction_able.group_id" :selected="tran" v-on:input="selectGroup"></select2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Байрлал</label>
                                                <select2 :options="branches" :value="tran.transaction_able.branch_id" :selected="tran" v-on:input="selectBranch"></select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Код</label>
                                                <input v-validate="'required|max:255|'" name="code" maxlength="255" :class="{'form-control input-sm': true, 'is-danger': errors.has('code') }" type="text" class="form-control input-sm" v-model="tran.transaction_able.code" />
                                                <span v-if="errors.has('code')" class="help is-danger">{{ errors.first('code') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Нэр</label>
                                                <input v-validate="'required|max:255'" name="name" :class="{'form-control input-sm': true, 'is-danger': errors.has('name') }" maxlength="255" type="text" class="form-control input-sm" v-model="tran.transaction_able.name" />
                                                <span v-if="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Эд хариуцагч</label>
                                                <select2 :options="users" :value="tran.transaction_able.owner_id" :selected="tran" v-on:input="selectOwner"></select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Нэгж өртөг</label>
                                                <money v-validate="'required|min_value:0.001'" :class="{'form-control input-sm': true, 'is-danger': errors.has('uamount') }" name="uamount" v-model="tran.transaction_able.unit_amount" v-bind="money" class="input-sm form-control"></money>
                                                <span v-if="errors.has('uamount')" class="help is-danger">{{ errors.first('uamount') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Тоо ширхэг</label>
                                                <money v-validate="'required|min_value:0.001'" :class="{'form-control input-sm': true, 'is-danger': errors.has('count') }" name="count" v-model="tran.transaction_able.count" v-bind="money" class="input-sm form-control"></money>
                                                <span v-if="errors.has('count')" class="help is-danger">{{ errors.first('count') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Нийт үнэ</label>
                                                <money :value="tran.transaction_able.count * tran.transaction_able.unit_amount" v-bind="money" readonly="readonly" class="input-sm form-control" @input="calculate"></money>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Ашиглаж эхэлсэн огноо</label>
                                                <input type="text" v-pick="tran.transaction_able.start_date" class="form-control input-sm" v-model="tran.transaction_able.start_date" v-on:changeDate="calculate" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Ашиглах хугацаа (жилээр)</label>
                                                <money v-validate="'required|min_value:1.00'" :class="{'form-control input-sm': true, 'is-danger': errors.has('timeCount') }" name="timeCount"  v-model="tran.transaction_able.use_time_count" v-bind="money" class="input-sm form-control" @input="calculate"></money>
                                                <span v-if="errors.has('timeCount')" class="help is-danger">{{ errors.first('timeCount') }}</span>
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
                                                <money v-model="tran.amount" readonly="readonly" v-bind="money" class="input-sm form-control"></money>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Код</th>
                                    <th>Нэр</th>
                                    <th>Нэгж үнэ</th>
                                    <th>Тоо ширхэг</th>
                                    <th>Нийт үнэ</th>
                                    <th>Үлдэх өртөг</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(tran, index) in transaction">
                                    <td>{{ tran.transaction_able.code }}</td>
                                    <td>{{ tran.transaction_able.name }}</td>
                                    <td>{{ tran.transaction_able.unit_amount }}</td>
                                    <td>{{ tran.transaction_able.count }}</td>
                                    <td>{{ tran.transaction_able.unit_amount * tran.transaction_able.count }}</td>
                                    <td>{{ Math.round(tran.amount * 100) / 100 }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-warning" @click="edit(tran)"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-xs btn-danger" @click="destroy(tran)"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        Нийт: {{ formatPrice(total) }}
                    </div>
                    <button type="button" class="btn btn-default btn-sm" @click="saveRow()">{{ mode ? 'Засах' : 'Нэмэх' }}</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="saveBreakDown">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {Money} from 'v-money'
    import Select2 from './../../Helper/Select2.vue';

    export default {

        props: ['account', 'season'],

        watch: {
            transaction: function() {
                let total = this.transaction.reduce(function(prev, t){
                    return parseFloat(prev) + parseFloat(t.amount);
                }, 0);
                this.total = total;
            }
        },

        data()
        {
            return {
                selectedValue: 0,
                expiration_amount: 0,
                remaining_time_count: '',
                deprecation: 0,
                total: 0,
                class_name: "Property",
                branches: [],
                groups: [],
                users: [],
                mode: false,
                tran: {
                    id: 0,
                    description: 'Эхний үлдэгдэл',
                    amount: 0,
                    transaction_able: {
                        branch_id: null,
                        group_id: null,
                        code: null,
                        name: null,
                        owner_id: null,
                        unit_amount: 0,
                        count: 1,
                        use_time_count: 0,
                        start_date: this.season.open_date
                    }
                },
                transaction: [],
                money:{
                    decimal:'.',
                    thousands:',',
                    precision:2,
                    masked:false
                },
            }
        },
        components:  {
            'money': Money,
            'select2': Select2
        },
//        created(){s
//          Validator.extend('passphrase',{
//              getMessage:field=>'0-с их'
//          })
//        },
        methods: {
            selectGroup(data)
            {
                this.tran.transaction_able.group_id = data.value;
            },
            selectBranch(data)
            {
                this.tran.transaction_able.branch_id = data.value;
            },
            selectOwner(data)
            {
                this.tran.transaction_able.owner_id = data.value;
            },
            saveRow()
            {
                if(!this.mode)
                {
                    this.transaction.push(this.tran);
                }
                this.resetForm();
            },
            calculate()
            {
                var date1 = new Date(this.season.open_date);
                var date2 = new Date(this.tran.transaction_able.start_date);
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if(this.tran.transaction_able.use_time_count > 0)
                {
                    var day_expiration = (this.tran.transaction_able.count * this.tran.transaction_able.unit_amount) / (365 * this.tran.transaction_able.use_time_count);
                    this.expiration_amount = day_expiration * 365;
                    this.deprecation = diffDays * day_expiration;
                    var remain_percent = (diffDays * 100) / (365 * this.tran.transaction_able.use_time_count);

                    const dateformat = require('dateformat');

                    this.remaining_time_count = dateformat(new Date(date2.getFullYear() + this.tran.transaction_able.use_time_count, date2.getMonth(), date2.getDate()), 'yyyy-mm-dd');
                    this.tran.amount = (this.tran.transaction_able.count * this.tran.transaction_able.unit_amount) - this.deprecation;
                }
                else
                {
                    this.remaining_time_count = '';
                }

            },
            resetForm()
            {
                this.tran = {
                    id: 0,
                    description: 'Эхний үлдэгдэл',
                    amount: 0,
                    transaction_able: {
                        branch_id: null,
                        group_id: null,
                        code: null,
                        name: null,
                        owner_id: null,
                        unit_amount: 0,
                        count: 1,
                        use_time_count: 0,
                        start_date: this.season.open_date
                    }
                };
                this.mode = false;
                this.expiration_amount = 0;
                this.remaining_time_count = '';
                this.deprecation = 0;
            },
            saveBreakDown()
            {
                this.$validator.validateAll();
                if(!this.errors.any())
                {
                    if(this.total == 0)
                    {
                        return;
                    }
                    let data = {
                        total: this.total,
                        transaction: this.transaction,
                        class_name: this.class_name
                    }
                    this.transaction = [];
                    this.total = 0;
                    this.selectedValue = 0;
                    this.$emit('saved', data);
                }
                else
                {
                    console.log(this.errors.any())
                }

            },
            edit(t)
            {
                this.mode = true;
                this.tran = t;
            },
            destroy(t)
            {
                this.transaction.splice(this.transaction.indexOf(t), 1)
            },
            formatPrice(amount) {
                let val = (amount/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            init()
            {
                this.fetchBranch();
                this.fetchGroups();
                this.fetchUsers();
                if(this.account['breakdown'] !== undefined)
                {
                    this.transaction = this.account['breakdown'];
                }
            },
            fetchBranch()
            {
                axios.get('/api/list/branches').then(response => {
                    this.branches = response.data.branches;
                })
            },
            fetchGroups()
            {
                axios.get('/api/journal/' + this.account.journal.id + '/group').then(response => {
                    this.groups = response.data.groups;
                })
            },
            fetchUsers()
            {
                axios.get('/api/user/list').then(response => {
                    this.users = response.data.users
                }).catch(errors => {
                })
            },
            formatPrice(amount) {
                let val = (amount/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }

    }

</script>