
<template>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Жагсаалт
            </div>
            <div class="box-tools">
                <!--<router-link v-bind:to="'/users/' + user.id + '/family/create'" class="btn btn-sm btn-default">Шинээр нэмэх</router-link>-->
                <!--<a href="#family-create" class="btn btn-sm btn-default">Шинээр нэмэх</a>-->
                <button @click="toggleFamilyCreate" class="btn btn-sm btn-default">
                    Шинээр нэмэх</button>
            </div>
        </div>
        <div class="box-body">
            <div v-if="familyCreate" >
                <family-create></family-create>
            </div>
            <div v-if="familyList">
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
                        <sort :column="'last_name'" :query="query" :text="'Нэр'" v-on:sorted="sort"></sort>
                        <sort :column="'relation'" :query="query" :text="'Хэн болох'" v-on:sorted="sort"></sort>
                        <sort :column="'phone'" :query="query" :text="'Утас'" v-on:sorted="sort"></sort>
                      <th class="action-controls-sm" v-if="!advancedSearch">
                            <button class="btn btn-info btn-sm" @click="toggleAdvancedSearch">Дэлгэрэнгүй хайлт</button>
                        </th>
                    </tr>
                    <tr v-if="advancedSearch">
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.first_name" />
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.last_name" />
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.relation" />
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.phone" />
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
                    <tr v-for="family in members.data">
                        <td>{{ family.first_name }}</td>
                        <td>{{ family.last_name }}</td>
                        <td>{{ family.relation }}</td>
                        <td>{{ family.phone }}</td>
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
                                <span>Нийт: {{ members.total }} мөр бичлэгийн {{ members.from }} -с {{ members.to }} харуулж байна</span>
                            </div>
                            <div class="pull-right">
                                <a @click="prev()" v-if="members.prev_page_url" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Өмнөх</a>
                                <a @click="next()" v-if="members.next_page_url" class="btn btn-default btn-xs">Дараах <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Sort from '../../../Helper/Sort.vue';
    import DeleteConfirm from '../../../Helper/DeleteConfirm.vue';
    import FamilyCreate from './Create.vue'
    export default {

        props: ['user'],

        data() {
            return {
                loading: true,
                familyCreate:false,
                advancedSearch: false,
                familyList:true,
                members: {},
                query: {
                    page: 1,
                    column: 'first_name',
                    direction: 'asc',
                    per_page: 10,
                    search: {
                        first_name: null,
                        last_name: null,
                        relation: null,
                        job: null,
                        register: null,
                        monthBudged: null,
                        phone: null,
                    }
                }
            }
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,
            'family-create': FamilyCreate,
        },

        mounted()
        {
            this.fetchFamily();
        },

        methods: {
             fetchFamily()
            {
                axios.get('api/user/' + this.$route.params.id + '/family').then(response => {
                    this.members = response.data.members;
                    this.loading = false;
                }).catch(function (error) {
                    console.log(error);
                    this.loading = false;
                })
            },
            changePerPage()
            {
                this.fetchFamily();
            },
            search()
            {
                this.fetchFamily();
            },
            toggleAdvancedSearch()
            {
                if(this.advancedSearch)
                {
                    this.advancedSearch = false;
                    this.query.search = {
                        first_name: null,
                        last_name: null,
                        relation: null,
                        job: null,
                        register: null,
                        monthBudged: null,
                        phone: null,
                    };
                    this.fetchFamily();
                }else
                {
                    this.advancedSearch = true
                }
            },
            toggleFamilyCreate()
            {
                if(this.familyCreate)
                {
                    this.familyList=true;
                    this.familyCreate=false;
                }
                else
                    this.familyList=false;
                    this.familyCreate=true;
            },
            sort(query)
            {
                this.query = query;

                this.fetchFamily();
            },
            next()
            {
                if(this.members.next_page_url) {
                    this.query.page++;
                    this.fetchFamily()
                }
            },
            prev()
            {
                if(this.members.prev_page_url) {
                    this.query.page--;
                    this.fetchFamily()
                }
            },
            destroy(user)
            {
                this.members.data.splice(this.members.data.indexOf(user), 1);
                this.members.total = this.members.total - 1;
            }
        }
    }
</script>
