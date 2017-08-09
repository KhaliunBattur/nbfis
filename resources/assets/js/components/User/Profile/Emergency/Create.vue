<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Овог нэр <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="emergency.name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Хэн болох <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <select v-model="emergency.relation" class="form-control">
                                <option v-for="(relation, index) in relations" :value="index">{{ relation }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ажил мэргэжил <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="emergency.job" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Регистр <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <masked-input v-model="emergency.register" mask="AA11111111" placeholder="АА00000000" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Сарын орлого <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input class="form-control" v-model="emergency.budged" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Утас<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <masked-input v-model="emergency.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111" class="form-control" />
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

        props: ['user', 'relations'],

        components: {
            'masked-input': MaskedInput
        },

        data() {
            return {
                emergency: {
                    name: null,
                    relation: null,
                    job: null,
                    register: null,
                    budged: null,
                    phone_number: null
                }
            }
        },

        methods: {

            reset()
            {
                this.emergency = {
                    name: null,
                    relation: null,
                    job: null,
                    register: null,
                    budged: null,
                    phone_number: null
                }
            },

            back()
            {
                this.$emit('closed');
            },

            save()
            {
                var self = this;
                axios.post('/api/user/' + this.user.id + '/emergency', this.emergency).then(response => {
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