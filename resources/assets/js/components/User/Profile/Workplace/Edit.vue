<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Байгууллага <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="255" class="form-control" v-model="workplace.organization" name="org" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('org') }"/>
                            <div v-show="errors.has('org')" class="help is-danger">{{ errors.first('org') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ажилд орсон огноо <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="workplace.date_employment" v-pick="workplace.date_employment" name="date" v-validate="'required|date'" :class="{'form-control': true, 'is-danger': errors.has('date') }" placeholder="2000-01-01"/>
                            <div v-show="errors.has('date')" class="help is-danger">{{ errors.first('date') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Албан тушаал <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="255" class="form-control" v-model="workplace.position" name="pos" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('pas') }"/>
                            <div v-show="errors.has('pos')" class="help is-danger">{{ errors.first('pos') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Үйл ажиллагааны чиглэл <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="255" class="form-control" v-model="workplace.activity" name="act" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('act') }"/>
                            <div v-show="errors.has('act')" class="help is-danger">{{ errors.first('act') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Хаяг <label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="2" v-model="workplace.address" name="add" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('add') }"></textarea>
                            <div v-show="errors.has('add')" class="help is-danger">{{ errors.first('add') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ажилчдын тоо<label class="text-danger">*</label></label>
                        <div class="col-sm-10">
                            <input type="number" @keyup.enter="save()" class="form-control" v-model="workplace.worker_count" name="count" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('count') }"/>
                            <div v-show="errors.has('count')" class="help is-danger">{{ errors.first('count') }}</div>
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