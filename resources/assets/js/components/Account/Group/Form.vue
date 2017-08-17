<template>
    <div class="modal fade" id="groupForm" tabindex="-1" role="dialog" aria-labelledby="groupFormLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="groupFormLabel">{{ title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Харья бүлэг</label>
                            <div class="col-sm-10">
                                <v-select v-model="group.root" :debounce="250" :on-search="fetchGroup" :options="groups" label="name" placeholder="Харьяа бүлэг"></v-select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Нэр</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="group.name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Код</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="group.code" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" @click="save()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import vSelect from 'vue-select'

    export default {

        props: ['title', 'group'],

        data()
        {
            return {
                groups: [],
                selected: null
            }
        },

        components: {
            'v-select': vSelect
        },

        methods: {
            fetchGroup(search, loading) {
                loading(true);
                axios.get('/api/account/group/' + this.group.id + '/others?q=' + search).then(response => {
                    this.groups = response.data.lists
                    loading(false)
                }).catch(errors => {
                    loading(false)
                })
            },
            save()
            {
                var self = this;
                axios.post('api/account/group', this.group).then(response => {
                    swal({
                        title: 'Амжилттай',
                        text: 'Бүртгэгдлээ',
                        type: 'success',
                        timer: 3000
                    }, function(){
                        $('#groupForm').modal('hide');
                        self.$emit('saved');
                    })
                }).catch(errors => {
                    swal('Уучлаарай', 'Амжилтгүй боллоо! Та дахин оролдоно уу', 'error')
                })
            }
        }

    }

</script>