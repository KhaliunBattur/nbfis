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
                                    <td><input type="text" class="form-control input-sm" maxlength="255" v-model="t.description"  /></td>
                                    <span v-show="errors.has('description')" class="help is-danger">{{ errors.first('description') }}</span>
                                    <td><money class="form-control input-sm" v-model="t.amount" v-bind="money"  @input="selectInput(t.amount)" name="amount"></money></td>
                                    <span v-show="errors.has('amount')" class="help is-danger">{{ errors.first('amount') }}</span>
                                    <td>
                                        <button class="btn btn-xs btn-danger" @click="destroy(t)"><i class="fa fa-trash-o"></i></button>
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
    import { Validator } from 'vee-validate'
    const dict = {
        en: {
            custom: {
                amount: {
                    required: 'Нэр талбарыг заавал бөглөнө үү.',
                }
            }
        }
    };
    export default {

        props: ['account'],
        validator:null,
        watch: {
            selectedValue: function() {
                let total = this.transaction.reduce(function(prev, t){
                    return parseFloat(prev) + parseFloat(t.amount);
                }, 0);
                this.total = total;
            },
            transAmount(val){
                console.log(val);
                this.validator.validate('amount',val);
            }
        },
        computed:{
          transAmount(){
              return this.transaction.amount;
          }
        },
        data()
        {
            return {
                selectedValue: 0,
                total: 0,
                amount:'',
                transaction: [
                    {
                        id: 0,
                        description: 'Эхний үлдэгдэл',
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
            addRow() {
                this.transaction.push({
                    id: 0,
                    description: 'Эхний үлдэгдэл',
                    amount: 0
                });
            },
            selectInput(amount) {
                this.selectedValue = amount;
            },
            saveBreakDown() {

                try {
                this.validator.validateAll({
                    amount: this.transaction
                }).then((result) => {
                    console.log(this.validator.errors);
                    console.log(this.validator.errors.first('amount'));
                    if (result) {

                            if (this.total === 0) {
                                return;
                            }
                            let data = {
                                total: this.total,
                                transaction: this.transaction,
                                class_name: null
                            }
                            this.transaction = [
                                {
                                    id: 0,
                                    description: 'Эхний үлдэгдэл',
                                    amount: 0
                                }
                            ]
                            this.total = 0;
                            this.selectedValue = 0;
                            this.$emit('saved', data);

                    }
                });
                }
                catch (error) {
                    console.log(error);
                    swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
                }
            },
            close(){
              this.error.clear();
            },
            created() {
                this.$validator.updateDictionary(dict);
                this.validator = new Validator({
                    amount: 'required|min_value:1',
                });
                this.$set(this, 'errors', this.validator.errors);
//                $(window).click(function(event) {
//                    if ( $(".hello").has(event.target).length == 0 ){
//                        console.log("Clear");
//                    }
//                });
            },
            beforeMount(){
                this.errors.clear();
            },
            destroy(t) {
                this.transaction.splice(this.transaction.indexOf(t), 1)
            },
            formatPrice(amount) {
                let val = (amount / 1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            init() {
                if (this.account['breakdown'] !== undefined) {
                    this.transaction = this.account['breakdown'];
                }
            }

        }

    }

</script>