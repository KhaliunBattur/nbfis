<template>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Ажлын газрын мэдээлэл
            </div>
            <div class="box-tools">
                <a class="btn btn-sm btn-default" @click="createWorkList()" v-if="view == 'list'">Шинээр нэмэх</a>
            </div>
        </div>
        <create v-if="view == 'create'" :user="user" v-on:closed="closeForm"></create>
        <edit v-if="view == 'edit'" :workplace="workplace" :user="user" v-on:closed="closeForm"></edit>
        <div class="box-body" v-if="view == 'list'">
            <div v-bind:class="loading ? 'table-responsive table-sm loading' : 'table-responsive table-sm'">
                <div class="input-group input-group-sm input-small with-margin-bottom">
                    <input type="text" v-model="query.per_page" class="form-control" @keyup.enter="changePerPage()" />
                    <div class="input-group-btn">
                        <button class="btn" @click="changePerPage()">-р хуудаслах</button>
                    </div>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <sort :column="'organization'" :query="query" :text="'Байгууллага'" v-on:sorted="sort"></sort>
                        <sort :column="'date_employment'" :query="query" :text="'Ажилд орсон огноо'" v-on:sorted="sort"></sort>
                        <sort :column="'position'" :query="query" :text="'Албан тушаал'" v-on:sorted="sort"></sort>
                        <sort :column="'activity'" :query="query" :text="'Үйл ажиллагааны чиглэл'" v-on:sorted="sort"></sort>
                        <sort :column="'address'" :query="query" :text="'Хаяг'" v-on:sorted="sort"></sort>
                        <sort :column="'worker_count'" :query="query" :text="'Ажилчдын тоо'" v-on:sorted="sort"></sort>
                        <th class="action-controls-sm" v-if="!advancedSearch">
                            <button class="btn btn-info btn-sm" @click="toggleAdvancedSearch">Дэлгэрэнгүй хайлт</button>
                        </th>
                    </tr>
                    <tr v-if="advancedSearch">
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.organization" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.date_employment" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.position" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.activity" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.address" @keyup.enter="search()"/>
                        </th>
                        <th colspan="3">
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
                    <tr v-for="workplace in workplaces.data">
                        <td>{{ workplace.organization }}</td>
                        <td>{{ workplace.date_employment }}</td>
                        <td>{{ workplace.position }}</td>
                        <td>{{ workplace.activity }}</td>
                        <td>{{ workplace.address }}</td>
                        <td>{{ workplace.worker_count }}</td>
                        <td>
                            <a class="btn btn-xs btn-warning" @click="editWorkplace(workplace)"><i class="fa fa-pencil-square"></i></a>
                            <delete-confirm :item="user" :url="'/api/user/' + user.id + '/workplace/' + workplace.id + '/destroy'" v-on:destroyed="destroy(workplace)"></delete-confirm>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="pull-left">
                                <span>Нийт: {{ workplaces.total }} мөр бичлэгийн {{ workplaces.from }} -с {{ workplaces.to }} харуулж байна</span>
                            </div>
                            <div class="pull-right">
                                <a @click="prev()" v-if="workplaces.prev_page_url" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Өмнөх</a>
                                <a @click="next()" v-if="workplaces.next_page_url" class="btn btn-default btn-xs">Дараах <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

    import Sort from '../../../Helper/Sort.vue';
    import DeleteConfirm from '../../../Helper/DeleteConfirm.vue';
    import Create from './Create.vue';
    import Edit from './Edit.vue';

    export default {

        props: ['user'],

        data() {
            return {
                view: 'list',
                loading: true,
                advancedSearch: false,
                workplaces: {},
                workplace: null,
                query: {
                    page: 1,
                    column: 'organization',
                    direction: 'asc',
                    per_page: 10,
                    search: {
                        organization: null,
                        date_employment: null,
                        position: null,
                        activity: null,
                        address: null,
                        worker_count: null
                    }
                }
            }
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,
            'create': Create,
            'edit': Edit
        },

        mounted()
        {
            this.fetchWorkplace();
        },

        methods: {

            closeForm()
            {
                this.view = 'list';
                this.fetchWorkplace();
            },

            editWorkplace(workplace)
            {
                this.workplace = workplace
                this.view = 'edit';
            },

            createWorkList()
            {
                this.view = 'create';
            },

            fetchWorkplace()
            {
                axios.get('api/user/' + this.$route.params.id + '/workplace', {
                    params: {
                        search: JSON.stringify(this.query.search),
                        per_page: this.query.per_page,
                        column: this.query.column,
                        direction: this.query.direction,
                        page: this.query.page
                    }
                }).then(response => {
                    this.workplaces = response.data.model;
                    this.loading = false;
                }).catch(errors => {
                    this.loading = false;
                })
            },
            changePerPage()
            {
                this.fetchWorkplace();
            },
            search()
            {
                this.fetchWorkplace();
            },
            toggleAdvancedSearch()
            {
                if(this.advancedSearch)
                {
                    this.advancedSearch = false
                    this.query.search = {
                        first_name: null,
                        last_name: null,
                        relation: null,
                        job: null,
                        register: null,
                        monthBudged: null,
                        phone: null,
                    }
                    this.fetchWorkplace();
                }else
                {
                    this.advancedSearch = true
                }
            },
            sort(query)
            {
                this.query = query;

                this.fetchWorkplace();
            },
            next()
            {
                if(this.workplaces.next_page_url) {
                    this.query.page++
                    this.fetchWorkplace()
                }
            },
            prev()
            {
                if(this.workplaces.prev_page_url) {
                    this.query.page--
                    this.fetchWorkplace()
                }
            },
            destroy(workplace)
            {
                this.workplaces.data.splice(this.workplaces.data.indexOf(workplace), 1);
                this.workplaces.total = this.workplaces.total - 1;
                this.fetchWorkplace();
            }
        }
    }
</script>
