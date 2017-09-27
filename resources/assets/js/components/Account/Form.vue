<template>
    <div class="modal fade" id="accountForm" tabindex="-1" role="dialog" aria-labelledby="accountFormLabel" v-if="account" v-bind:clear="checkError"  @click.self="checkError">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="checkError" ><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="accountFormLabel">{{ title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Харья бүлэг <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <v-select  v-model="account.group" :debounce="250" :on-search="fetchGroup" :on-change="setAccountNumber()" :options="groups" label="name" placeholder="Харьяа бүлэг"></v-select>
                                <!--<span v-if="errors.has('group')" class="help is-danger">{{ errors.first('group') }}</span>-->
                                <div class="text-danger" v-if="errorMessages.group">
                                    {{ errorMessages.group[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Нэр <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input v-validate="'required'" name="name" type="text" class="form-control" v-model="account.name"  />
                                <span v-if="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
                                <div class="text-danger" v-if="errorMessages.name">
                                    {{ errorMessages.name[0] }}
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                            <!--<label class="col-sm-3 control-label">Код <span class="text-danger">*</span></label>-->
                            <!--<div class="col-sm-9">-->
                                <!--<input type="text" class="form-control" v-model="account.code" @input="setAccountNumber()" />-->
                                <!--<div class="text-danger" v-if="errorMessages.code">-->
                                    <!--{{ errorMessages.code[0] }}-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Дансны дугаар <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input v-validate="'required'" name="number" type="text" class="form-control" v-model="account.account_number" />
                                <span v-if="errors.has('number')" class="help is-danger">{{ errors.first('number') }}</span>
                                <div class="text-danger" v-if="errorMessages.account_number">
                                    {{ errorMessages.account_number[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Төрөл <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="radio-inline">
                                    <input type="radio" v-model="account.type" value="active" /> Актив
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" v-model="account.type" value="passive" /> Пассив
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Журнал <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <v-select  v-model="account.journal" :debounce="250" :on-search="fetchJournal" :options="journals" label="name" placeholder="Журнал..." ></v-select>
                                <!--<span v-if="errors.has('journal')" class="help is-danger">{{ errors.first('journal') }}</span>-->
                                <div class="text-danger" v-if="errorMessages.journal">
                                    {{ errorMessages.journal[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Валют <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <v-select  v-model="account.currency" :debounce="250" :on-search="fetchCurrency" :options="currencies" label="name" placeholder="Валют..."></v-select>
                                <!--<span v-if="errors.has('currency')" class="help is-danger">{{ errors.first('currency') }}</span>-->
                                <div class="text-danger" v-if="errorMessages.currency">
                                    {{ errorMessages.currency[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Банк</label>
                            <div class="col-sm-9">
                                <v-select  v-model="account.bank" :debounce="250" :on-search="fetchBank" :options="banks" label="name" placeholder="Банк..."></v-select>
                            </div>
                        </div>
                        <div class="form-group" v-if="account.bank">
                            <label class="col-sm-3 control-label">Банкны дансны дугаар <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input v-validate="'required'" name="bank" type="text" class="form-control" v-model="account.bank_account_number" />
                                <span v-if="errors.has('bank')" class="help is-danger">{{ errors.first('bank') }}</span>
                                <div class="text-danger" v-if="errorMessages.bank_account_number">
                                    {{ errorMessages.bank_account_number[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <div class="checkbox">
                                    <input  type="checkbox" v-model="account.is_temporary" /> Түр данс эсэх
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" @click="checkError()">Хаах</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="save()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import vSelect from 'vue-select'

    export default {

        props: ['title', 'account'],

        data()
        {
            return {
                groups: [],
                currencies: [],
                journals: [],
                banks: [],
                selected: null,
                errorMessages: {
                    account_number: null,
                    code: null,
                    group: null,
                    journal: null,
                    name: null,
                    currency: null,
                },
                loading:false
            }
        },

        components: {
            'v-select': vSelect
        },
        methods: {
            setAccountNumber()
            {
                if(this.account.group)
                {
                    if(this.account.account_number === null)
                    {
                        this.account.account_number = this.account.group.code;
                    }
                }
            },
            fetchGroup(search, loading) {
                loading(true);
                axios.get('/api/account/group/0/others?q=' + search).then(response => {
                    this.groups = response.data.lists
                    loading(false)
                }).catch(errors => {
                    loading(false)
                })
            },
            fetchBank(search, loading) {
                loading(true);
                axios.get('/api/bank/lists?q=' + search).then(response => {
                    this.banks = response.data.lists
                    loading(false)
                }).catch(errors => {
                    loading(false)
                })
            },
            fetchJournal(search, loading)
            {
                loading(true);
                axios.get('/api/journal/lists?q=' + search).then(response => {
                    this.journals = response.data.lists
                    loading(false)
                }).catch(errors => {
                    loading(false)
                })
            },
            fetchCurrency(search, loading) {
                loading(true);
                axios.get('/api/currency/lists?q=' + search).then(response => {
                    this.currencies = response.data.lists
                    loading(false)
                }).catch(errors => {
                    loading(false)
                })
            },
            reset()
            {
                    this.groups = [];
                    this.currencies = [];
                    this.journals = [];
                    this.banks = [];
                    this.selected = [];
                    this.errorMessages = {
                        account_number: null,
                        code: null,
                        group: null,
                        journal: null,
                        name: null,
                        currency: null,
                    };
                console.log(this.groups);
            },
            checkError()
            {
                if(this.errors.any()){
                    this.errors.clear();
                    this.reset();
                    this.$emit('reset');
                }
            },
            save()
            {
                this.$validator.validateAll();
                if(!this.errors.any()){
                    var self = this;
                    axios.post('/api/account', this.account).then(response => {
                        if(response.data.result)
                        {
                            swal({
                                title: 'Амжилттай',
                                text: 'Данс бүртгэгдлээ',
                                type: 'success',
                                timer: 3000
                            }, function(){
                                $('#accountForm' + self.account.id).modal('hide');
                                self.$emit('saved');
                            });
                        }
                    }).catch(error => {
                        this.errorMessages = error.response.data;
                        swal('Уучлаарай', 'Бүртгэл амжилтгүй! Та дахин оролдоно уу', 'error');
                    })
                }
                else {
                    console.log(this.errors.any());
                }

            }
        }

    }

</script>