<template>
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img v-if="user.image !== null" class="profile-user-img img-responsive img-circle" :src="user.image" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ user.first_name }} {{ user.name }}</h3>

                        <p class="text-muted text-center" v-if="user.roles > 0"><span class="text" v-for="role in user.roles">{{ role.display_name + ', ' }}</span></p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Регистр</b> <a class="pull-right">УУ87021501</a>
                            </li>
                            <li class="list-group-item">
                                <b>Төрсөн он сар өдөр</b> <a class="pull-right">1987-02-15</a>
                            </li>
                            <li class="list-group-item">
                                <b>Нас</b> <a class="pull-right">30</a>
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
                <div class="box box-primary" v-if="user.user_type == 'staff'">
                    <div class="box-header with-border">
                        <h3 class="box-title">Тухай</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Одоо амьдарч буй хаяг</strong>

                        <p class="text-muted">{{ user.address }}</p>
                        <p class="text-muted">5 жил амьдарч байгаа</p>
                        <p class="text-muted">Түрээсийн</p>

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
                    <li><a href="#Family" data-toggle="tab">Гэр бүлийн мэдээлэл</a></li>
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

                    <family></family>
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

    import Family from './Family.vue'

    export default {
        data()
        {
            return{
                user: [],
            }
        },

        components: {
            'family' : Family
        },

        created()
        {
            this.fetchUser();
        },

        methods: {
            fetchUser()
            {
                axios.get('api/users/' + this.$route.params.id).then(response => {
                    this.user = response.data.user;
                    this.user.roles = response.data.roles
                }).catch(function (response) {
                    swal('Уучлаарай!', 'Хэрэглэгчийн мэдээлэл татаж чадсангүй', 'error')
                })
            }
        }
    }

</script>