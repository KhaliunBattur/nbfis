<template>
    <div class="modal fade" id="breakdownModal" tabindex="-1" role="dialog" aria-labelledby="myModabreakdownModallLabel" v-if="account" v-modal v-on:showModal="init()">
        <div class="modal-dialog modal-lg" role="document" v-if="account">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="breakdownModalLabel">Балансын задаргаа оруулах</h4>
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
                                                <input type="text" class="form-control input-sm" v-model="tran.description" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Хөрөнгийн ангилал</label>
                                                <select2 :options="groups" :value="tran.property.group_id" :selected="tran"></select2>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Байрлал</label>
                                                <select2 :options="branches" :value="tran.property.branch_id" :selected="tran"></select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Код</label>
                                                <input type="text" class="form-control input-sm" v-model="tran.property.code" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Нэр</label>
                                                <input type="text" class="form-control input-sm" v-model="tran.property.name" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Эд хариуцагч</label>
                                                <select2 :options="users" :value="tran.property.owner_id" :selected="tran"></select2>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Нэгж өртөг</label>
                                                <input type="text" class="form-control input-sm" v-model="tran.property.unit_amount" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Тоо ширхэг</label>
                                                <input type="text" class="form-control input-sm" v-model="tran.property.count" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Нийт үнэ</label>
                                                <input type="text" class="form-control input-sm" v-model="tran.amount" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Хуримтлагдсан элэгдэл</label>
                                                <input type="text" class="form-control input-sm" v-model="tran.property.deprecation" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Ашиглаж эхэлсэн огноо</label>
                                                <input type="text" v-pick="tran.property.start_date" class="form-control input-sm" v-model="tran.property.start_date" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="control-label">Үлдэх өртөг</label>
                                                <input type="text" class="form-control input-sm" />
                                            </div>
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
                    <button type="button" class="btn btn-default btn-sm" @click="addRow()">Нэмэх</button>
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

        props: ['account'],

        watch: {
            selectedValue: function() {
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
                total: 0,
                branches: [],
                groups: [],
                users: [],
                tran: {
                    id: 0,
                    description: 'Эхний үлдэгдэл',
                    amount: 0,
                    property: {
                        branch_id: null,
                        group_id: 0,
                        code: null,
                        name: null,
                        owner_id: null,
                        unit_amount: null,
                        count: null,
                        deprecation: null,
                        start_date: null
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

        methods: {
            selectInput(amount)
            {
                this.selectedValue = amount;
            },
            saveBreakDown()
            {
                if(this.total == 0)
                {
                    return;
                }
                let data = {
                    total: this.total,
                    transaction: this.transaction,
                    class_name: null
                }
                this.transaction = [];
                this.total = 0;
                this.selectedValue = 0;
                this.$emit('saved', data);
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
            }
        }

    }

</script>