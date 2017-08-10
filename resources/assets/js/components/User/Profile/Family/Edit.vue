<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Овог нэр <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="member.name" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Таны хэн болох <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <select v-model="member.relation" class="form-control">
                                <option v-for="(relation, index) in relations" :value="index">{{ relation }}</option>
                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ажил/Сургууль/<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="member.job" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Регистер<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <masked-input v-model="member.register" mask="AA11111111" placeholder="АА00000000" class="form-control" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Сарын орлого <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="member.budged" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Утас</label>
                        <div class="col-sm-10">
                            <masked-input v-model="member.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111" class="form-control" />
                        </div>
                    </div>

                    <hr />

                    <div class="box-footer">
                        <div class="btn-group">
                            <a @click="back()" class="btn btn-sm btn-danger">Буцах</a>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-sm btn-success" @click="save()">Хадгалах</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import MaskedInput from 'vue-masked-input'

    export default {

        props: ['user', 'member', 'relations'],

        components: {
            'masked-input': MaskedInput
        },

        methods: {

            back()
            {
                this.$emit('closed');
            },

            save()
            {
                var self = this;

                axios.patch('/api/user/' + this.user.id + '/family/' + this.member.id, this.member).then(response => {
                    if(response.data.result)
                    {
                        swal({
                            title: 'Ажилттай',
                            text: 'Бүртгэгдлээ',
                            type: 'success'
                        }, function(){

                        });
                    }
                }).catch(errors=>{
                    swal('Уучлаарай', 'Амжилтгүй боллоо', 'error');
                })
            }
        }

    }
</script>
