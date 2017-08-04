<template>
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Шинээр нэмэх
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Зураг</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" @change="onFileChange" />
                                </div>
                                <div class="col-sm-2 col-sm-offset-2" v-if="user.image != ''">
                                    <img :src="user.image" class="profile-user-img img-responsive img-circle" style="margin: 10px 0px" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Овог</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.first_name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нэр</label>
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
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.email" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нууц үг</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" v-model="user.password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нууц үг батлах</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" v-model="user.confirm_password" />
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
        </div>
    </section>
</template>

<script>

    export default {

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
                    password: '',
                    confirm_password: '',
                }
            }
        },

        methods: {

            save()
            {
                axios.post('/api/users', this.user).then(response => {
                    if(response.data.result)
                    {
                        var self = this;
                        swal({
                            title: 'Ажилттай!',
                            text: 'Хэрэглэгч бүртгэгдлээ',
                            type: 'success'
                        }, function(){
                            self.reset();
                        })
                    }
                }).catch(function(response){
                    swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
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
                };
                reader.readAsDataURL(file);
            },

            removeImage: function (e) {
                this.user.image = '';
            }
        }

    }
</script>
