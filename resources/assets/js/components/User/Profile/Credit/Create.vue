<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээл авсан банк /санхүүгийн байгууллагын/ нэр<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="credit.organization" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээлийн хэмжээ<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="credit.loan_amount"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээлийн зориулалт<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="credit.loan_usage" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Хугацаа<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="credit.loan_date" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Зээлийн хүү<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="credit.loan_interest" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Одоогийн үлдэгдэл<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="credit.loan_balance"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Сард төлөгдөх төлбөр<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="credit.monthly_pay"/>
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

        props: ['user'],

        components: {
            'masked-input': MaskedInput
        },

        data() {
            return {
                credit: {
                    organization: null,
                    loan_amount: null,
                    loan_usage: null,
                    loan_date: null,
                    loan_interest: null,
                    loan_balance: null,
                    monthly_pay: null
                }
            }
        },

        methods: {

            reset()
            {
                this.credit = {
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
                axios.post('/api/user/' + this.user.id + '/credit', this.credit).then(response => {
                    if(response.data.result)
                    {
                        swal({
                            title: 'Ажилттай',
                            text: 'Бүртгэгдлээ',
                            type: 'success'
                        }, function(){
                            self.reset();
                        });
                    }
                }).catch(errors => {
                    swal('Уучлаарай', 'Амжилтгүй боллоо', 'error');
                })
            }
        }

    }

</script>