<template>
    <section class="content">
        <div class="row" v-if="user">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img v-if="user.image" class="profile-user-img img-responsive img-circle" :src="user.image" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ user.first_name }} {{ user.name }}</h3>

                        <p class="text-muted text-center" v-if="user.roles"><span class="text" v-for="role in user.roles">{{ role.display_name + ', ' }}</span></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Регистр</b> <a class="pull-right">{{ user.register }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Төрсөн он сар өдөр</b> <a class="pull-right">{{ user.birth_day }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Нас</b> <a class="pull-right">{{ user.age }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="pull-right">{{ user.email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Утаc</b> <span class="pull-right">{{ user.phone_number }}</span>
                            </li>
                        </ul>

                        <router-link v-bind:to="'/users/' + user.id + '/edit'" class="btn btn-primary btn-block"><b>Мэдээлэл засварлах</b></router-link>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary" v-if="user.user_type == 'customer'">
                    <div class="box-header with-border">
                        <h3 class="box-title">Тухай</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Одоо амьдарч буй хаяг</strong>

                        <p class="text-muted">
                            <textarea class="form-control" v-model="user.address"></textarea>
                            <button class="btn btn-success btn-sm" style="margin-top: 5px" @click="saveAddress">
                                <i class="fa fa-check"></i> Хадгалах
                            </button>
                        </p>

                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" v-model="user.live_year" v-if="show_live" />
                            <input type="text" class="form-control" v-model="user.live_year" readonly="readonly" v-if="!show_live" />
                            <div class="input-group-btn">
                                <button class="btn btn-xs btn-success" v-if="show_live" @click="saveLiveYear"><i class="fa fa-check"></i></button>
                                <button class="btn btn-xs btn-danger" v-if="show_live" @click="changeLiveYear"><i class="fa fa-close"></i></button>
                                <button class="btn btn-xs btn-warning" v-if="!show_live" @click="changeLiveYear"><i class="fa fa-pencil"></i></button>
                            </div>
                        </div>
                        <br />
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" v-model="user.owner_type" v-if="show_owner" />
                            <input type="text" class="form-control" v-model="user.owner_type" readonly="readonly" v-if="!show_owner" />
                            <div class="input-group-btn">
                                <button class="btn btn-xs btn-success" v-if="show_owner" @click="saveOwnerType"><i class="fa fa-check"></i></button>
                                <button class="btn btn-xs btn-danger" v-if="show_owner" @click="changeOwnerType"><i class="fa fa-close"></i></button>
                                <button class="btn btn-xs btn-warning" v-if="!show_owner" @click="changeOwnerType"><i class="fa fa-pencil"></i></button>
                            </div>
                        </div>

                        <hr>

                        <strong><i class="fa fa-suitcase margin-r-5"></i> Ажлын газрын мэдээлэл</strong>

                        <p class="text-muted">Woovoo tech, Programmer</p>
                        <p class="text-muted">UB chingeltei, 2-r street 307-1</p>

                        <hr>

                        <strong><i class="fa fa-pencil margin-r-5"></i> Зэрэглэл</strong>

                        <p>
                            <span class="label label-danger">Найдваргүй зээлдэгч</span>
                            <span class="label label-warning">Хугацаа хороодог</span>
                        </p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Тэмдэглэл</strong>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#timeline" data-toggle="tab">Timeline</a></li>
                        <li><a href="#family" data-toggle="tab">Гэр бүлийн мэдээлэл</a></li>
                        <li><a href="#contact" data-toggle="tab">Холбоо барих</a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="active tab-pane" id="timeline">
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">
                                <!-- timeline time label -->
                                <li class="time-label">
                            <span class="bg-red">
                              10 Feb. 2014
                            </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-envelope bg-blue"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-xs">Read more</a>
                                            <a class="btn btn-danger btn-xs">Delete</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-user bg-aqua"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                                        <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                                        </h3>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-comments bg-yellow"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                        <div class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <li class="time-label">
                            <span class="bg-green">
                              3 Jan. 2014
                            </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-camera bg-purple"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                        <div class="timeline-body">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-pane" id="family">
                            <familyList :user="user"></familyList>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="contact">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        <!-- /.col -->
        </div>
    </section>
</template>

<script>

    import FamilyList from './Family/List.vue'

    export default {
        data()
        {
            return{
                user: null,
                show_live: false,
                show_owner: false
            }
        },

        components: {
            'familyList' : FamilyList
        },

        created()
        {
            this.fetchUser();
        },

        methods: {

            saveOwnerType()
            {
                axios.patch('api/user/' + this.$route.params.id + '/saveOwnerType', {_owner_type: this.user.owner_type}).then(response => {
                    if(response.data.result)
                    {
                        this.show_owner = false;
                    }
                }).catch(function(responce) {

                })
            },

            saveLiveYear()
            {
                axios.patch('api/user/' + this.$route.params.id + '/saveLiveYear', {_year: this.user.live_year}).then(response => {
                    if(response.data.result)
                    {
                        this.show_live = false;
                    }
                }).catch(function(responce) {

                })
            },

            saveAddress()
            {
                axios.patch('api/user/' + this.$route.params.id + '/saveAddress', {_address: this.user.address}).then(response => {

                }).catch(function(responce) {

                })
            },

            changeOwnerType()
            {
                this.show_owner = this.show_owner == false ? true : false;
            },

            changeLiveYear()
            {
                this.show_live = this.show_live == false ? true: false;
            },
            fetchUser()
            {
                axios.get('api/users/' + this.$route.params.id).then(response => {
                    this.user = response.data.user;
                    this.user.roles = response.data.roles
                    this.user.birth_day = null
                    this.user.age = null
                    this.setRegister();
                }).catch(function (response) {
                    swal('Уучлаарай!', 'Хэрэглэгчийн мэдээлэл татаж чадсангүй', 'error')
                })
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
        }
    }

</script>