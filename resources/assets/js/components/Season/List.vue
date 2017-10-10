<template>
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Жагсаалт
                        </div>
                    </div>
                    <div class="box-body">
                        <div v-bind:class="loading ? 'table-responsive table-sm loading' : 'table-responsive table-sm'">
                            <div class="input-group input-group-sm input-small with-margin-bottom pull-left">
                                <input type="text" v-model="query.per_page" class="form-control" />
                                <div class="input-group-btn">
                                    <button class="btn" @click="changePerPage()">-р хуудаслах</button>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <sort :column="'name'" :query="query" :text="'Нэр'" v-on:sorted="sort"></sort>
                                        <th>Нээсэн хүн</th>
                                        <th>Нээсэн огноо</th>
                                        <th>Хаасан хүн</th>
                                        <th>Хаасан огноо</th>
                                        <th></th>
                                    </tr>
                                    <tr v-if="closed">
                                        <td>
                                            <div class="input-group-sm input-group">
                                                <input type="text" v-model="season.name" class="form-control" />
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-success" @click="create">Нээх</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr v-for="season in model.data">
                                    <td>{{ season.name }}</td>
                                    <td>{{ season.open_user.name }}</td>
                                    <td>{{ season.open_date }}</td>
                                    <td><span v-if="season.close_user">{{ season.close_user.name }}</span></td>
                                    <td>{{ season.close_date }}</td>
                                    <td v-if="!season.close_user">
                                        <router-link v-bind:to="'/season/' + season.id + '/balance'" class="btn btn-xs btn-warning">
                                            <i class="fa fa-pencil-square"></i> Эхлэл баланс
                                        </router-link>
                                        <delete-confirm :item="season" :url="'/api/season/' + season.id" v-on:destroyed="destroy(season)"></delete-confirm>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <div class="pull-left">
                                            <span>Нийт: {{ model.total }} мөр бичлэгийн {{ model.from }} -с {{ model.to }} харуулж байна</span>
                                        </div>
                                        <div class="pull-right">
                                            <a @click="prev()" v-if="model.prev_page_url" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Өмнөх</a>
                                            <a @click="next()" v-if="model.next_page_url" class="btn btn-default btn-xs">Дараах <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    import Sort from './../Helper/Sort.vue';
    import DeleteConfirm from './../Helper/DeleteConfirm.vue';

    export default {

        data() {
            return {
                closed: true,
                loading: true,
                advancedSearch: false,
                season: {
                    id: null,
                    name: null,
                    open_user: null,
                    open_date: null,
                    close_user: null,
                    close_date: null
                },
                model: {},
                query: {
                    page: 1,
                    column: 'name',
                    direction: 'asc',
                    per_page: 10,
                    user_type: 'all',
                    search: {
                        name: null
                    }
                }
            }
        },

        created()
        {
            this.fetchSeason();
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm
        },

        methods: {
            create()
            {
                var self = this;
                swal({
                    title: "Анхаар",
                    text: "Улирал нээх гэж байна",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Тийм",
                    cancelButtonText: "Үгүй",
                }, function(){
                    axios.post('/api/season', self.season).then(response => {
                        swal({
                            title: 'Амжилттай',
                            text: 'Улирал нээгдлээ',
                            type: 'success',
                            timer: 300,
                            confirmButtonText: "Хаах",
                        }, function(){
                            self.fetchSeason();
                            self.season = {
                                id: null,
                                name: null,
                                open_user: null,
                                open_date: null,
                                close_user: null,
                                close_date: null
                            };
                        })
                    }).catch(error => {
                        swal('Уучлаарай', error.response.data.name[0], 'error');
                    });
                })
            },
            changePerPage()
            {
                this.fetchSeason();
            },
            sort(query)
            {
                this.query = query;

                this.fetchSeason();
            },
            next()
            {
                if(this.model.next_page_url) {
                    this.query.page++
                    this.fetchSeason()
                }
            },
            prev()
            {
                if(this.model.prev_page_url) {
                    this.query.page--
                    this.fetchSeason()
                }
            },
            fetchSeason()
            {
                axios.get('/api/season', {
                    params: {
                        per_page: this.query.per_page,
                        column: this.query.column,
                        direction: this.query.direction,
                        page: this.query.page
                    }
                }).then(response => {
                    this.model = response.data.model
                    this.closed = response.data.closed
                    this.loading = false;
                }).catch(errors => {
                    this.$router.push('/')
                })
            },
            destroy(season)
            {
                this.fetchSeason();
            }
        }

    }

</script>