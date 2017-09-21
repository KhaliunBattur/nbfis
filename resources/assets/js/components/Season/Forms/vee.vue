<template>
    <div class="modal fade hello" id="accountForm" tabindex="-1" role="dialog" aria-labelledby="accountFormLabel" v-if="account">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close()"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="accountFormLabel">{{ title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Харья бүлэг <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <v-select v-model="account.group" :debounce="250" :on-search="fetchGroup" :on-change="setAccountNumber()" :options="groups" label="name" placeholder="Харьяа бүлэг"></v-select>
                                <div class="text-danger" v-if="errorMessages.group">
                                    {{ errorMessages.group[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Нэр <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="account.name" name="name"/>
                                <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
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
                                <input type="text" class="form-control" v-model="account.account_number" />
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
                                <v-select v-model="account.journal" :debounce="250" :on-search="fetchJournal" :options="journals" label="name" placeholder="Журнал..."></v-select>
                                <div class="text-danger" v-if="errorMessages.journal">
                                    {{ errorMessages.journal[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Валют <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <v-select v-model="account.currency" :debounce="250" :on-search="fetchCurrency" :options="currencies" label="name" placeholder="Валют..."></v-select>
                                <div class="text-danger" v-if="errorMessages.currency">
                                    {{ errorMessages.currency[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Банк</label>
                            <div class="col-sm-9">
                                <v-select v-model="account.bank" :debounce="250" :on-search="fetchBank" :options="banks" label="name" placeholder="Банк..."></v-select>
                            </div>
                        </div>
                        <div class="form-group" v-if="account.bank">
                            <label class="col-sm-3 control-label">Банкны дансны дугаар <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="account.bank_account_number" />
                                <div class="text-danger" v-if="errorMessages.bank_account_number">
                                    {{ errorMessages.bank_account_number[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <div class="checkbox">
                                    <input type="checkbox" v-model="account.is_temporary" /> Түр данс эсэх
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="save()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import vSelect from 'vue-select'
    import { Validator } from 'vee-validate'
    const dict = {
        en: {
            custom: {
                name: {
                    required: 'Нэр талбарыг заавал бөглөнө үү.',
                }
            }
        }
    };
    export default {

        props: ['title', 'account'],
        validator: null,
        components: {
            'v-select': vSelect
        },
        computed: {
            first_name() {
                return this.account.name;
            }
        },
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
                name: '',
                errors: null,
            }
        },
        watch: {
            first_name(val) {
                console.log(val);
                this.validator.validate('name', val);
            },
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
            save()
            {
                var self = this;
                this.validator.validateAll({
                    name: this.account.name,
                }).then((result) => {
                    console.log(this.validator.errors);
                    console.log( this.validator.errors.first('name'));
                    if (result) {
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
                        return;
                    }
                });

            },
            close(){
                this.errors.clear();
            },
        },
        created() {
            this.$validator.updateDictionary(dict);
            this.validator = new Validator({
                name: 'required',
            });
            this.$set(this, 'errors', this.validator.errors);
            $(window).click(function(event) {
                if ( $(".hello").has(event.target).length == 0 ){
                    console.log("Clear");
                }
            });
        },
        beforeMount(){
            this.errors.clear();
        },

    }
</script>