<template>
    <div class="modal fade" id="breakdownModal" tabindex="-1" role="dialog" aria-labelledby="myModabreakdownModallLabel" v-if="account" v-modal v-on:showModal="init()">
        <div class="modal-dialog modal-lg" role="document" v-if="account">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="breakdownModalLabel">Балансын задаргаа оруулах (Өглөг авлага)</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div style="max-height: 250px; float: left; width: 100%">
                            <table class="table table-bordered" style="max-height: 200px;">
                                <thead>
                                <tr>
                                    <th>Гүйлгээний утга</th>
                                    <th>Харилцагч</th>
                                    <th>Тооцоо хаагдах огноо</th>
                                    <th>Мөнгөн дүн</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(t, index) in transaction">
                                    <td><input type="text" class="form-control input-sm" v-model="t.description" /></td>
                                    <td style="min-width: 150px">
                                        <select2 :options="options" :value="t.transaction_able.customer_id" :selected="t" v-on:input="selectCustomer"></select2>
                                    </td>
                                    <td><input type="text" class="form-control input-sm" v-pick="t.transaction_able.closing_date" v-model="t.transaction_able.closing_date" /> </td>
                                    <td><money v-model="t.amount" v-bind="money" class="input-sm form-control" @input="selectInput(t.amount)"></money></td>
                                    <td>
                                        <button class="btn btn-xs btn-danger" v-if="index > 0" @click="destroy(t)"><i class="fa fa-trash-o"></i></button>
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

    import {Money} from 'v-money';
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
                class_name: "Receivable",
                transaction: [
                    {
                        id: 0,
                        description: 'Эхний үлдэгдэл',
                        amount: 0,
                        transaction_able: {
                            id: 0,
                            customer_id: null,
                            closing_date: null
                        }
                    }
                ],
                money:{
                    decimal:'.',
                    thousands:',',
                    precision:2,
                    masked:false
                },
                options: []
            }
        },
        components:  {
            'money': Money,
            'select2': Select2
        },

        methods: {
            addRow()
            {
                this.transaction.push({
                    id: 0,
                    description: 'Эхний үлдэгдэл',
                    amount: 0,
                    transaction_able: {
                        id: 0,
                        customer_id: null,
                        closing_date: null
                    }
                });
            },
            selectCustomer(data)
            {
                this.transaction[this.transaction.indexOf(data.selected)].transaction_able.customer_id = data.value
            },
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
                    class_name: this.class_name
                }

                this.transaction = [
                    {
                        id: 0,
                        description: 'Эхний үлдэгдэл',
                        amount: 0,
                        transaction_able: {
                            id: 0,
                            customer_id: null,
                            closing_date: null
                        }
                    }
                ]
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
            fetchCustomer()
            {
                axios.get('/api/customer/list').then(response => {
                    this.options = response.data.customers
                }).catch(errors => {
                })
            },
            init()
            {
                this.fetchCustomer();
                if(this.account['breakdown'] !== undefined)
                {
                    this.transaction = this.account['breakdown'];
                }
            }
        }

    }

</script>