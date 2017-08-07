<template>
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Засварлах
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Зураг</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" @change="onFileChange" />
                                </div>
                                <div class="col-sm-2 col-sm-offset-2" v-if="profile_picture !== null && profile_picture !== ''">
                                    <img :src="profile_picture" class="profile-user-img img-responsive img-circle" style="margin: 10px 0px" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Овог <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.first_name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нэр <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.name" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Утас</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.phone_number" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Хаяг</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="2" v-model="user.address"></textarea>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Email <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.email" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-sm-offset-2">
                                    <div class="radio-inline">
                                        <input type="radio" v-model="user.user_type" value="staff" /> Ажилтан
                                    </div>
                                    <div class="radio-inline">
                                        <input type="radio" v-model="user.user_type" value="customer" /> Харилцагч
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-if="user.user_type === 'staff'">
                                <label class="col-sm-2 control-label">Албан тушаал</label>
                                <div class="col-sm-10">
                                    <select v-model="user.roles" multiple="multiple" class="form-control">
                                        <option v-for="role in roles" :value="role.id" :selected="isSelected(role)">{{ role.display_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group">
                            <router-link to="/users" class="btn btn-sm btn-danger">Буцах</router-link>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-sm btn-success" @click="save()">Хадгалах</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Нууц үг солих
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нууц үг <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" v-model="password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нууц үг батлах <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" v-model="confirm_password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group pull-right"><button type="button" class="btn btn-sm btn-success" @click="changePassword">Хадгалах</button></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    export default {

        props: ['roles'],

        data()
        {
            return {
                user: {
                    image: '',
                    first_name: '',
                    name: '',
                    phone_number: '',
                    address: '',
                    email: '',
                    user_type: '',
                    roles: []
                },
                profile_picture: '',
                password: '',
                confirm_password: '',
            }
        },

        created()
        {
            this.getUser();
        },

        methods: {

            getUser()
            {
                axios.get('api/users/' + this.$route.params.id + '/edit').then(response => {
                    this.user = response.data.user;
                    this.user.roles = response.data.roles
                    this.profile_picture = this.user.image;
                    this.user.image = null;
                    Vue.delete(this.user, 'created_at');
                    Vue.delete(this.user, 'updated_at');
                }).catch(function (response) {
                    swal('Уучлаарай!', 'Хэрэглэгчийн мэдээлэл татаж чадсангүй', 'error')
                })
            },

            changePassword(user)
            {
                axios.patch('api/user/' + this.$route.params.id + '/changePassword', {password: this.password, confirm_password: this.confirm_password}).then(response => {
                    if(response.data.result)
                    {
                        var self = this;
                        swal({
                            title: 'Ажилттай!',
                            text: 'Хэрэглэгч мэдээлэл засварлагдлаа',
                            type: 'success'
                        }, function(){

                        })
                    }
                }).catch(function(response) {
                    swal('Уучлаарай!', 'Нууц үг солих амжилтгүй', 'error')
                })
            },

            save()
            {
                axios.patch('/api/users/' + this.$route.params.id, this.user).then(response => {
                    if(response.data.result)
                    {
                        var self = this;
                        swal({
                            title: 'Ажилттай!',
                            text: 'Хэрэглэгч мэдээлэл засварлагдлаа',
                            type: 'success'
                        }, function(){

                        })
                    }
                }).catch(function(response){
                    swal('Уучлаарай!', 'Амжилтгүй боллоо', 'error')
                })
            },

            back()
            {
                this.$router.push('/users')
            },

            reset()
            {
                this.user = {
                    image: '',
                    first_name: '',
                    name: '',
                    phone_number: '',
                    address: '',
                    email: '',
                    password: '',
                    confirm_password: '',
                }
            },

            onFileChange(e)
            {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.user.image = e.target.result;
                    vm.profile_picture = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage: function (e) {
                this.user.image = '';
            },

            isSelected(role)
            {
                return this.user.roles.indexOf(role.id) === -1 ? false : true
            }
        }

    }
</script>
