<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Байгууллага <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="workplace.organization" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ажилд орсон огноо <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="workplace.date_employment" v-pick="workplace.date_employment" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Албан тушаал <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="workplace.position" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Үйл ажиллагааны чиглэл <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="workplace.activity" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Хаяг <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="2" v-model="workplace.address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ажилчдын тоо<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="workplace.worker_count" />
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

    export default {

        props: ['user', 'workplace'],

        methods: {

            back()
            {
                this.$emit('closed');
            },

            save()
            {
                var self = this;
                axios.patch('/api/user/' + this.user.id + '/workplace/' + this.workplace.id, this.workplace).then(response => {
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