<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Овог нэр <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="emergency.name" name="name" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('name') }" placeholder="Ихдээ 255 тэмдэгт"/>
                            <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
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
                            <input type="text" class="form-control" v-model="emergency.job" name="job" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('job') }" placeholder="Ихдээ 255 тэмдэгт"/>
                            <div v-show="errors.has('job')" class="help is-danger">{{ errors.first('job') }}</div>
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
                            <input class="form-control" type="number" v-model="emergency.budged" name="budged" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('budged') }" placeholder="Зөвхөн тоон утга оруулна уу"/>
                            <div v-show="errors.has('budged')" class="help is-danger">{{ errors.first('budged') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Утас<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <masked-input name="phone" v-validate="'required'" v-model="emergency.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111" class="form-control" @keyup.enter="save()"/>
                            <div v-show="errors.has('phone')" class="help is-danger">{{ errors.first('phone') }}</div>
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

        props: ['user', 'relations', 'emergency'],

        components: {
            'masked-input': MaskedInput
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
                axios.patch('/api/user/' + this.user.id + '/emergency/' + this.emergency.id, this.emergency).then(response => {
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