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
                        <div class="box-tools">
                            <router-link to="/users/create" class="btn btn-sm btn-default">Шинээр нэмэх</router-link>
                        </div>
                    </div>
                    <div class="box-body">
                        <div v-bind:class="loading ? 'table-responsive table-sm loading' : 'table-responsive table-sm'">
                            <div class="input-group input-group-sm input-small with-margin-bottom">
                                <input type="text" v-model="query.per_page" class="form-control" />
                                <div class="input-group-btn">
                                    <button class="btn" @click="changePerPage()">-р хуудаслах</button>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <sort :column="'first_name'" :query="query" :text="'Овог'" v-on:sorted="sort"></sort>
                                    <sort :column="'name'" :query="query" :text="'Нэр'" v-on:sorted="sort"></sort>
                                    <sort :column="'email'" :query="query" :text="'Email'" v-on:sorted="sort"></sort>
                                    <sort :column="'phone_number'" :query="query" :text="'Утас'" v-on:sorted="sort"></sort>
                                    <th>Албан тушаал</th>
                                    <th class="action-controls-sm" v-if="!advancedSearch">
                                        <button class="btn btn-info btn-sm" @click="toggleAdvancedSearch">Дэлгэрэнгүй хайлт</button>
                                    </th>
                                </tr>
                                <tr v-if="advancedSearch">
                                    <th>
                                        <input type="text" class="form-control input-sm" v-model="query.search.first_name" />
                                    </th>
                                    <th>
                                        <input type="text" class="form-control input-sm" v-model="query.search.name" />
                                    </th>
                                    <th>
                                        <input type="text" class="form-control input-sm" v-model="query.search.email" />
                                    </th>
                                    <th>
                                        <input type="text" class="form-control input-sm" v-model="query.search.phone_number" />
                                    </th>
                                    <th colspan="2">
                                        <button class="btn btn-sm btn-info" @click="search()">
                                            <i class="fa fa-search"></i> Хайх
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-close" @click="toggleAdvancedSearch"></i>
                                        </button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in model.data">
                                    <td>{{ user.first_name }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.phone_number }}</td>
                                    <td>
                                        <label class="text" v-for="role in user.roles">{{ role.display_name + ', ' }}</label>
                                    </td>
                                    <td>
                                        <router-link v-bind:to="'/users/' + user.id + '/profile'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></router-link>
                                        <router-link v-bind:to="'/users/' + user.id + '/edit'" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square"></i></router-link>
                                        <delete-confirm :item="user" :url="'/api/users/' + user.id" v-on:destroyed="destroy(user)"></delete-confirm>
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
                loading: true,
                advancedSearch: false,
                model: {},
                query: {
                    page: 1,
                    column: 'first_name',
                    direction: 'asc',
                    per_page: 10,
                    search: {
                        first_name: null,
                        name: null,
                        email: null,
                        phone_number: null,
                    }
                }
            }
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm
        },

        created()
        {
            this.fetchUser();
        },

        methods: {
            changePerPage()
            {
                this.fetchUser();
            },
            search()
            {
                this.fetchUser();
            },
            toggleAdvancedSearch()
            {
                if(this.advancedSearch)
                {
                    this.advancedSearch = false
                    this.query.search = {
                        first_name: null,
                        name: null,
                        email: null,
                        phone_number: null,
                    }
                    this.fetchUser();
                }else
                {
                    this.advancedSearch = true
                }
            },
            sort(query)
            {
                this.query = query;

                this.fetchUser();
            },
            next()
            {
                if(this.model.next_page_url) {
                    this.query.page++
                    this.fetchUser()
                }
            },
            prev()
            {
                if(this.model.prev_page_url) {
                    this.query.page--
                    this.fetchUser()
                }
            },
            fetchUser()
            {
                this.loading = true;
                axios.get('/api/users?search='+ JSON.stringify(this.query.search) +'&per_page=' + this.query.per_page + '&column='+this.query.column+'&direction='+this.query.direction+'&page='+this.query.page).then(response => {
                    this.model = response.data.model;
                    this.loading = false;
                }).catch(errors => {
                    this.$router.push('/')
                })
            },
            destroy(user)
            {
                this.model.data.splice(this.model.data.indexOf(user), 1);
                this.model.total = this.model.total - 1;
            }
        }
    }
</script>
