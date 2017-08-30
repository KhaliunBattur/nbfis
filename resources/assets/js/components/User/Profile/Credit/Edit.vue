<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээл авсан банк /санхүүгийн байгууллагын/ нэр<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="credit.organization" name="org" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('org') }" placeholder="Ихдээ 255 тэмдэгт"/>
                            <div v-show="errors.has('org')" class="help is-danger">{{ errors.first('org') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээлийн хэмжээ<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" v-model="credit.loan_amount" name="amount" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('amount') }" />
                            <div v-show="errors.has('amount')" class="help is-danger">{{ errors.first('amount') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээлийн зориулалт<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input maxlength="255" type="text" class="form-control" v-model="credit.loan_usage" name="usage" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('usage') }"/>
                            <div v-show="errors.has('usage')" class="help is-danger">{{ errors.first('usage') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Хугацаа<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="credit.loan_date" name="date" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('date') }" placeholder="2000-01-01"/>
                            <div v-show="errors.has('date')" class="help is-danger">{{ errors.first('date') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээлийн хүү<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="credit.loan_interest" name="interest" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('interest') }" />
                            <div v-show="errors.has('interest')" class="help is-danger">{{ errors.first('interest') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Одоогийн үлдэгдэл<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="credit.loan_balance" name="balance" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('balance') }"/>
                            <div v-show="errors.has('balance')" class="help is-danger">{{ errors.first('balance') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Сард төлөгдөх төлбөр<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="credit.monthly_pay" name="pay" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('pay') }" @keyup.enter="save()"/>
                            <div v-show="errors.has('pay')" class="help is-danger">{{ errors.first('pay') }}</div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-sm btn-danger" @click="back()">Буцах</a>
                    </div>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-sm btn-success" @click="save()">Хадгалах</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>

    import MaskedInput from 'vue-masked-input'

    export default {

        props: ['user', 'credit'],

        components: {
            'masked-input': MaskedInput
        },

        methods: {

            reset()
            {
                this.emergency = {
                    organization: null,
                    loan_amount: null,
                    loan_usage: null,
                    loan_date: null,
                    loan_interest: null,
                    loan_balance: null,
                    monthly_pay: null
                }
            },

            back()
            {
                this.$emit('closed');
            },

            save()
            {
                var self = this;
                axios.patch('/api/user/' + this.user.id + '/credit/' + this.credit.id, this.credit).then(response => {
                    if(response.data.result)
                    {
                        swal({
                            title: 'Ажилттай',
                            text: 'Засварлагдлаа',
                            type: 'success'
                        }, function(){

                        });
                    }
                }).catch(errors => {
                    swal('Уучлаарай', 'Амжилтгүй боллоо', 'error');
                })
            }
        }

    }

</script>