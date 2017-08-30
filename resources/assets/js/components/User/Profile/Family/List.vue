
<template>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Гэр бүлийн мэдээлэл
            </div>
            <div class="box-tools">
                <button @click="createFamily" class="btn btn-sm btn-default" v-if="view == 'list'">Шинээр нэмэх</button>
            </div>
        </div>
        <family-create v-if="view == 'family-create'" :user="user" :relations="relations" v-on:closed="closeForm"></family-create>
        <family-edit v-if="view == 'family-edit'" :member="member" :user="user" :relations="relations" v-on:closed="closeForm"></family-edit>
        <div class="box-body" v-if="view =='list'">
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
                        <sort :column="'phone'" :query="query" :text="'Утас'" v-on:sorted="sort"></sort>
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
                            <input type="text" class="form-control input-sm" v-model="query.search.phone" @keyup.enter="search()"/>
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
                        <td>{{ family.name }}</td>
                        <td><span v-if="relations">{{ relations[family.relation] }}</span></td>
                        <td>{{ family.job }}</td>
                        <td>{{ family.register }}</td>
                        <td>{{ family.phone_number }}</td>
                        <td>
                            <a class="btn btn-xs btn-warning" @click="editFamily(family)"><i class="fa fa-pencil-square"></i></a>
                            <delete-confirm :item="user" :url="'/api/user/' + user.id + '/family/' + family.id + '/destroy'" v-on:destroyed="destroy(family)"></delete-confirm>
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
</template>

<script>

    import Sort from '../../../Helper/Sort.vue';
    import DeleteConfirm from '../../../Helper/DeleteConfirm.vue';
    import FamilyCreate from './Create.vue'
    import FamilyEdit from './Edit.vue'

    export default {

        props: ['user'],

        data() {
            return {
                view: 'list',
                loading: true,
                advancedSearch: false,
                members: {},
                member: null,
                query: {
                    page: 1,
                    column: 'name',
                    direction: 'asc',
                    per_page: 10,
                    search: {
                        name: null,
                        register: null,
                        relation: null,
                        job: null,
                        phone: null
                    }
                },
                relations: null
            }
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,
            'family-create': FamilyCreate,
            'family-edit':FamilyEdit
        },

        mounted()
        {
            this.fetchRelation();
            this.fetchFamily();
        },

        methods: {
            closeForm()
            {
              this.view = 'list';
              this.fetchFamily();
            },
            createFamily()
            {
               this.view = 'family-create';
            },
            editFamily(member)
            {
                this.member = member;

                this.view='family-edit';
            },
            fetchRelation()
            {
                axios.get('/api/relations').then(response => {
                    this.relations = response.data.relations;
                })
            },
            fetchFamily()
            {
                axios.get('api/user/' + this.$route.params.id + '/family', {
                    params: {
                        search: JSON.stringify(this.query.search),
                        per_page: this.query.per_page,
                        column: this.query.column,
                        direction: this.query.direction,
                        page: this.query.page
                    }
                }).then(response => {
                    this.members = response.data.members;
                    this.loading = false;
                }).catch(error => {
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
            destroy(family)
            {
                this.members.data.splice(this.members.data.indexOf(family), 1);
                this.members.total = this.members.total - 1;
            }
        }
    }
</script>
