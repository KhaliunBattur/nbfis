<template>
    <div class="modal fade" id="breakdownModal" tabindex="-1" role="dialog" aria-labelledby="myModabreakdownModallLabel" v-if="account" v-modal v-on:showModal="init()">
        <div class="modal-dialog" role="document" v-if="account">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="breakdownModalLabel">Балансын задаргаа оруулах</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div style="max-height: 250px; float: left; width: 100%">
                            <table class="table table-bordered" style="max-height: 200px;">
                                <thead>
                                <tr>
                                    <th>Гүйлгээний утга</th>
                                    <th>Мөнгөн дүн</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(t, index) in transaction">
                                    <td><input type="text" class="form-control input-sm" v-model="t.description" /></td>
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

    import {Money} from 'v-money'

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
                transaction: [
                    {
                        id: 0,
                        description: null,
                        amount: 0
                    }
                ],
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
        },

        methods: {
            addRow()
            {
                this.transaction.push({
                    id: 0,
                    description: null,
                    amount: 0
                });
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
                    transaction: this.transaction
                }
                this.transaction = [
                    {
                        description: null,
                        amount: 0
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
            init()
            {
                if(this.account['breakdown'] !== undefined)
                {
                    this.transaction = this.account['breakdown'];
                }
            }
        }

    }

</script>