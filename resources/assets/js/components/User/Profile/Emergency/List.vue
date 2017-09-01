<template>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Холбоо барих хүний мэдээлэл
            </div>
            <div class="box-tools">
                <a class="btn btn-sm btn-default" @click="createEmergency()" v-if="view == 'list'">Шинээр нэмэх</a>
            </div>
        </div>
        <create v-if="view == 'create'" :user="user" :relations="relations" v-on:closed="closeForm"></create>
        <edit v-if="view == 'edit' && emergency !== null" :emergency="emergency" :relations="relations" :user="user" v-on:closed="closeForm"></edit>
        <div class="box-body" v-if="view == 'list'">
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
                        <sort :column="'name'" :query="query" :text="'Нэр'" v-on:sorted="sort"></sort>
                        <sort :column="'relation'" :query="query" :text="'Хэн болох'" v-on:sorted="sort"></sort>
                        <sort :column="'job'" :query="query" :text="'Ажил мэргэжил'" v-on:sorted="sort"></sort>
                        <sort :column="'register'" :query="query" :text="'Регистр'" v-on:sorted="sort"></sort>
                        <sort :column="'budged'" :query="query" :text="'Сарын орлого'" v-on:sorted="sort"></sort>
                        <sort :column="'phone_number'" :query="query" :text="'Утас'" v-on:sorted="sort"></sort>
                        <th class="action-controls-sm" v-if="!advancedSearch">
                            <button class="btn btn-info btn-sm" @click="toggleAdvancedSearch">Дэлгэрэнгүй хайлт</button>
                        </th>
                    </tr>
                    <tr v-if="advancedSearch">
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.name" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.relation" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.job" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.register" @keyup.enter="search()"/>
                        </th>
                        <th>

                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.phone_number" @keyup.enter="search()"/>
                        </th>
                        <th>
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
                    <tr v-for="emergency in emergencies.data">
                        <td>{{ emergency.name }}</td>
                        <td><span v-if="relations">{{ relations[emergency.relation] }}</span></td>
                        <td>{{ emergency.job }}</td>
                        <td>{{ emergency.register }}</td>
                        <td>{{ emergency.budged }}</td>
                        <td>{{ emergency.phone_number }}</td>
                        <td>
                            <a class="btn btn-xs btn-warning" @click="editEmergency(emergency)"><i class="fa fa-pencil-square"></i></a>
                            <delete-confirm :item="user" :url="'/api/user/' + user.id + '/emergency/' + emergency.id + '/destroy'" v-on:destroyed="destroy(emergency)"></delete-confirm>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="pull-left">
                                <span>Нийт: {{ emergencies.total }} мөр бичлэгийн {{ emergencies.from }} -с {{ emergencies.to }} харуулж байна</span>
                            </div>
                            <div class="pull-right">
                                <a @click="prev()" v-if="emergencies.prev_page_url" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Өмнөх</a>
                                <a @click="next()" v-if="emergencies.next_page_url" class="btn btn-default btn-xs">Дараах <i class="fa fa-arrow-right"></i></a>
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
                emergencies: {},
                emergency: null,
                query: {
                    page: 1,
                    column: 'name',
                    direction: 'asc',
                    per_page: 10,
                    search: {
                        name: null,
                        relation: null,
                        job: null,
                        register: null,
                        phone_number: null
                    }
                },
                relations: null
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
            this.fetchRelation();
            this.fetchEmergency();
        },

        methods: {

            closeForm()
            {
                this.view = 'list';
                this.fetchEmergency();
            },

            editEmergency(emergency)
            {
                this.emergency = emergency
                this.view = 'edit';
            },

            createEmergency()
            {
                this.view = 'create';
            },

            fetchRelation()
            {
                axios.get('/api/relations').then(response => {
                    this.relations = response.data.relations;
                })
            },

            fetchEmergency()
            {
                axios.get('api/user/' + this.$route.params.id + '/emergency', {
                    params: {
                        search: JSON.stringify(this.query.search),
                        per_page: this.query.per_page,
                        column: this.query.column,
                        direction: this.query.direction,
                        page: this.query.page
                    }
                }).then(response => {
                    this.emergencies = response.data.model;
                    this.loading = false;
                }).catch(errors => {
                    this.loading = false;
                })
            },
            changePerPage()
            {
                this.fetchEmergency();
            },
            search()
            {
                this.fetchEmergency();
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
                    this.fetchEmergency();
                }else
                {
                    this.advancedSearch = true
                }
            },
            sort(query)
            {
                this.query = query;

                this.fetchEmergency();
            },
            next()
            {
                if(this.emergencies.next_page_url) {
                    this.query.page++
                    this.fetchEmergency()
                }
            },
            prev()
            {
                if(this.emergencies.prev_page_url) {
                    this.query.page--
                    this.fetchEmergency()
                }
            },
            destroy(emergency)
            {
                this.emergencies.data.splice(this.emergencies.data.indexOf(emergency), 1);
                this.emergencies.total = this.emergencies.total - 1;
            }
        }
    }
</script>
