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
                                    <dropzone
                                            ref="profUpload"
                                            id="profile"
                                            class="margin-bottom-10"
                                            :headers='csrfHeaders'
                                            :url="profileUpload"
                                            :thumbnail-height="100"
                                            :thumbnail-width="100"
                                            v-on:vdropzone-success="ProfSuccess"
                                            v-on:vdropzone-error="onError">
                                    </dropzone>
                                </div>
                            </div>
                            <div class="form-group">
                                <label v-if="user.user_type=='customer'" class="col-sm-2 control-label">Овог <label class="text-danger">*</label></label>
                                <label v-else-if="user.user_type=='organization'" class="col-sm-2 control-label">Байгууллагын нэр <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="255" class="form-control" v-model="user.first_name" name="fname" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('fname') }"/>
                                    <div v-show="errors.has('fname')" class="help is-danger">{{ errors.first('fname') }}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label v-if="user.user_type == 'customer'" class="col-sm-2 control-label">Нэр <label class="text-danger">*</label></label>
                                <label v-else-if="user.user_type=='organization'" class="col-sm-2 control-label">Товч нэр <label class="text-danger">*</label></label>
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
                            <div class="form-group" v-else-if="user.user_type === 'organization'">
                                <label class="col-sm-2 control-label">Байгууллагын Регистр</label>
                                <div class="col-sm-10">
                                    <masked-input v-model="user.org_register" mask="AA11111111" placeholder="АА00000000"  class="form-control" />
                                </div>
                            </div>

                            <div class="form-group" v-if="user.user_type === 'customer'">
                                <label class="col-sm-2 control-label">Төрсөн огноо</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.birth_day" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group" v-else-if="user.user_type === 'organization'">
                                <label class="col-sm-2 control-label">Байгуулагдсан огноо</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.founding_date" v-pick="user.founding_date" />
                                </div>
                            </div>

                            <div class="form-group" v-if="user.user_type === 'customer'">
                                <label class="col-sm-2 control-label">Нас</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.age" readonly="readonly" />
                                </div>
                            </div>
                            <div class="form-group" v-else-if="user.user_type === 'organization'">
                                <label class="col-sm-2 control-label">У/Б дугаар</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="user.state_num"  />
                                </div>
                            </div>
                            <hr v-if="user.user_type === 'customer'" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Утас</label>
                                <div class="col-sm-10">
                                    <masked-input v-model="user.phone_number" mask="\+ (976) 1111-1111" class="form-control"  />
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
                                    <input  type="text" class="form-control" v-model="user.email" name="email" v-validate="'required|email'" :class="{'form-control': true, 'is-danger': errors.has('email') }"/>
                                    <div v-show="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-sm-offset-2">
                                    <div class="radio-inline">
                                        <input name="type" type="radio" v-model="user.user_type" value="organization" /> Байгууллага
                                    </div>
                                    <div class="radio-inline">
                                        <input name="type" type="radio" v-model="user.user_type" value="customer" /> Хувь хүн
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-if="user.user_type === 'organization'">
                                <label class="col-sm-2 control-label">Байгууллагын төрөл</label>
                                <div class="col-sm-10">
                                    <select v-model="user.org_types"  class="form-control">
                                        <option v-for="(org_type,index) in org_types" :value="index">{{org_type}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нууц үг <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" v-model="user.password" name="pass" v-validate="'required|min:6'" :class="{'form-control': true, 'is-danger': errors.has('pass') }"/>
                                    <div v-show="errors.has('pass')" class="help is-danger">{{ errors.first('pass') }}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нууц үг батлах <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" v-model="user.confirm_password" @keyup.enter="save()" name="confpass" v-validate="'required|min:6'" :class="{'form-control': true, 'is-danger': errors.has('confpass') }"/>
                                    <div v-show="errors.has('confpass')" class="help is-danger">{{ errors.first('confpass') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group">
                            <router-link to="/users" class="btn btn-sm btn-danger">Буцах</router-link>
                        </div>
                        <div class="btn-group pull-right" >
                            <button type="button" class="btn btn-sm btn-success" @click="save()" onautocomplete="off" >Хадгалах</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    import MaskedInput from 'vue-masked-input'
    import Dropzone from 'vue2-dropzone'
    export default {

        props: ['roles'],

        components: {
            'masked-input': MaskedInput,
            Dropzone,

        },

        data()
        {
            return {
                profileUpload:'/api/cv/profileUpload',
                user: {
                    image: '',
                    first_name: '',
                    name: '',
                    phone_number: '',
                    address: '',
                    email: '',
                    user_type: 'customer',
                    roles: [],
                    password: '',
                    register: null,
                    birth_day: null,
                    age: null,
                    confirm_password: '',
                    profilePath:'',
                    founding_date:'',
                    org_types:[],
                    org_type:'',
                    org_register:'',
                    state_num:'',
                }
            }
        },
        created()
        {
            this.csrfHeaders = {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
            this.fetchOrgType();
        },
        methods: {
            fetchOrgType()
            {
                axios.get('/api/org_types' ).then(response=>{
                    this.org_types = response.data.org_types;
                    this.loading=false;
                }).catch(errors=>{
                    this.loading = false;
                })
            },
            ProfSuccess(file,response)
            {
                this.user.profilePath = response.tempProfPath;
                this.user.image = response.profPic;
            },
            onError (file, error)
            {
                swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
            },
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

            save()
            {
                this.$validator.validateAll();
                if(!this.errors.any()){
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
                }
                else
                {
                    console.log(this.errors.any());
                }

            },
            back()
            {
                this.$router.push('/customers')
            },
            reset()
            {
                this.$refs.profUpload.removeAllFiles();
                this.user = {
                    image: '',
                    first_name: '',
                    name: '',
                    phone_number: '',
                    address: '',
                    email: '',
                    profilePath:'',
                    password: '',
                    confirm_password: '',
                    founding_date:'',
                    org_type:'',
                    org_register:'',
                    state_num:'',
                }
            },
        }

    }
</script>
<style>
    .vue-dropzone {
        min-height:20px;
        padding: 0;
    }
</style>