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
                                <div class="col-sm-2 col-sm-offset-2" v-if="user.image != ''">
                                    <img :src=" user.image " class="profile-user-img img-responsive img-circle" style="margin: 10px 0px" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Овог <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="255" class="form-control" v-model="user.first_name" name="fname" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('fname') }"/>
                                    <div v-show="errors.has('fname')" class="help is-danger">{{ errors.first('fname') }}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нэр <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="255"  class="form-control" v-model="user.name"  name="oname" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('oname') }"/>
                                    <div v-show="errors.has('oname')" class="help is-danger">{{ errors.first('oname') }}</div>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group" v-if="user.user_type === 'customer'">
                                <label class="col-sm-2 control-label">Регистр</label>
                                <div class="col-sm-10">
                                    <masked-input v-model="user.register" mask="AA11111111" placeholder="АА00000000" @input="setRegister" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group" v-if="user.user_type === 'customer'">
                                <label class="col-sm-2 control-label">Төрсөн огноо</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.birth_day" readonly="readonly" />
                                </div>
                            </div>
                            <div class="form-group" v-if="user.user_type === 'customer'">
                                <label class="col-sm-2 control-label">Нас</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.age" readonly="readonly" />
                                </div>
                            </div>
                            <hr v-if="user.user_type === 'customer'" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Утас</label>
                                <div class="col-sm-10">
                                    <masked-input v-model="user.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111" class="form-control"  />
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
                                    <input  type="text" class="form-control" v-model="user.email" name="email" v-validate="'required|email'" :class="{'form-control': true, 'is-danger': errors.has('email') }" placeholder="Email" />
                                    <div v-show="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-sm-offset-2">
                                    <div class="radio-inline">
                                        <input name="type" type="radio" v-model="user.user_type" value="staff" /> Ажилтан
                                    </div>
                                    <div class="radio-inline">
                                        <input name="type" type="radio" v-model="user.user_type" value="customer" /> Харилцагч
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-if="user.user_type === 'staff'">
                                <label class="col-sm-2 control-label">Албан тушаал</label>
                                <div class="col-sm-10">
                                    <select v-model="user.roles" multiple="multiple" class="form-control">
                                        <option v-for="role in roles" :value="role.id">{{ role.display_name }}</option>
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

    import MaskedInput from 'vue-masked-input'

    export default {

        props: ['roles'],

        components: {
            'masked-input': MaskedInput
        },

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
                    register: null,
                    birth_day: null,
                    age: null,
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

            setRegister()
            {
                try {
                    var splits = this.user.register.match(/.{1,2}/g);
                    if(parseInt(splits[2]) > 12)
                    {
                        var year = 2000 + parseInt(splits[1]);
                        var month = parseInt(splits[2]) - 20;
                        var birthDay = new Date(year, month - 1, parseInt(splits[3]) + 1);
                    }
                    else
                    {
                        var year = 1900 + parseInt(splits[1]);
                        var birthDay = new Date(year, parseInt(splits[2]) - 1 , parseInt(splits[3]) + 1);
                    }
                    this.user.birth_day = birthDay.toISOString().substring(0, 10);
                    this.user.age = this.getAge(birthDay);
                }
                catch(error)
                {

                }
            },

            getAge(d1){
                var d2 = new Date();
                var diff = d2.getTime() - d1.getTime();
                return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
            },

            getUser()
            {
                axios.get('/api/users/' + this.$route.params.id + '/edit').then(response => {
                    this.user = response.data.user;
                    this.user.roles = response.data.roles;
                    this.profile_picture = '/images/profile/' + this.user.image;
                    this.user.image = null;
                    Vue.delete(this.user, 'created_at');
                    Vue.delete(this.user, 'updated_at');
                    this.setRegister();
                }).catch(function (response) {
                    swal('Уучлаарай!', 'Хэрэглэгчийн мэдээлэл татаж чадсангүй', 'error')
                })
            },

            changePassword(user)
            {
                axios.patch('/api/user/' + this.$route.params.id + '/changePassword', {password: this.password, confirm_password: this.confirm_password}).then(response => {
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
