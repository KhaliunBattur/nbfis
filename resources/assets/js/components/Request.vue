
<template>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Зээлийн хүсэлтүүд
            </div>
            <div class="box-tools">
                <router-link to="/new/customer" class="btn btn-sm btn-default">Шинээр нэмэх</router-link>
            </div>
        </div>
        <!--<family-create v-if="view == 'family-create'" :user="user" :relations="relations" v-on:closed="closeForm"></family-create>-->
        <!--<family-edit v-if="view == 'family-edit'" :member="member" :user="user" :relations="relations" v-on:closed="closeForm"></family-edit>-->
        <div class="box-body" v-if="view =='list'">
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
                        <sort :column="'name'" :query="query" :text="'Нэр'" v-on:sorted="sort"></sort>
                        <sort :column="'register'"   :query="query" :text="'Регистер'" v-on:sorted="sort"></sort>
                        <sort :column="'user_type'"   :query="query" :text="'Харилцагч'" v-on:sorted="sort"></sort>
                        <sort :column="'pledge_type'" :query="query" :text="'Барьцаа'" v-on:sorted="sort"></sort>
                        <sort :column="'loan_term'"   :query="query" :text="'Зээлийн хэмжээ'" v-on:sorted="sort"></sort>
                        <sort :column="'period_time'" :query="query" :text="'Төлөх хугацаа'" v-on:sorted="sort"></sort>
                        <sort :column="'payment_day'" :query="query" :text="'Төлөлт хийх өдөр'" v-on:sorted="sort"></sort>
                        <sort :column="'expire_date'" :query="query" :text="'Зээлийн хугацаа дуусах'" v-on:sorted="sort"></sort>
                        <sort :column="'description'" :query="query" :text="'Нэмэлт тайлбар, тэмдэглэгээ'" v-on:sorted="sort"></sort>
                        <th class="action-controls-sm" v-if="!advancedSearch">
                            <button class="btn btn-info btn-sm" @click="toggleAdvancedSearch">Дэлгэрэнгүй хайлт</button>
                        </th>
                    </tr>
                    <tr v-if="advancedSearch">
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.name" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.register" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.user_type" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.pledge_type" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.loan_term" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.period_time" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.payment_day" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.expire_date" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.description" @keyup.enter="search()"/>
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
                    <tr v-for="request in requests.data">
                        <td>{{request.name}}</td>
                        <td>{{request.register}}</td>
                        <td v-if="request.user_type == 'customer'">Хувь хүн</td>
                        <td v-else-if="request.user_type == 'organization'">Байгууллага</td>
                        <td v-else="request.user_type == 'staff'">Ажилтан</td>
                        <td>{{ request.pledge_type }}</td>
                        <td>{{ request.loan_term}}</td>
                        <td>{{ request.period_time }}</td>
                        <td>{{ request.payment_day }}</td>
                        <td>{{ request.expire_date }}</td>
                        <td>{{ request.description }}</td>
                        <td>
                            <router-link v-bind:to="'new/customer/' + request.register " class="btn btn-xs btn-warning"><i class="fa fa-pencil-square"></i></router-link>
                            <delete-confirm :item="user" :url="'/api/request/' + request.id + '/request/' + request.id + '/destroy'" v-on:destroyed="destroy(request)"></delete-confirm>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="pull-left">
                                <span>Нийт: {{ requests.total }} мөр бичлэгийн {{ requests.from }} -с {{ requests.to }} харуулж байна</span>
                            </div>
                            <div class="pull-right">
                                <a @click="prev()" v-if="requests.prev_page_url" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Өмнөх</a>
                                <a @click="next()" v-if="requests.next_page_url" class="btn btn-default btn-xs">Дараах <i class="fa fa-arrow-right"></i></a>
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

    import Sort from '../components/Helper/Sort.vue';
    import DeleteConfirm from '../components/Helper/DeleteConfirm.vue';
//    import FamilyCreate from './Create.vue'
//    import FamilyEdit from './Edit.vue'

    export default {

        props: ['user'],

        data() {
            return {
                view: 'list',
                loading: true,
                advancedSearch: false,
                requests:{},
                request:null,
                query: {
                    page: 1,
                    column: 'user_type',
                    direction: 'asc',
                    per_page: 10,
                    search: {

                    }
                },
            }
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,

        },

        mounted()
        {
            this.fetchRequests();
        },

        methods: {
            editRequest(request)
            {
                console.log(request);
            },
            createRequest()
            {

            },
            fetchRequests()
            {
              axios.get('/api/request' ,{
                  params: {
                      search: JSON.stringify(this.query.search),
                      per_page: this.query.per_page,
                      column: this.query.column,
                      direction: this.query.direction,
                      page: this.query.page
                  }
              }).then(response => {
                  this.requests = response.data.requests;
                  this.loading = false;
              }).catch(error =>{
                  console.log(error);
                  this.loading = false;
              })
            },
            closeForm()
            {
                this.view = 'list';
                this.fetchRequests();
            },

            changePerPage()
            {
                this.fetchRequests();
            },
            search()
            {
                this.fetchRequests();
            },
            toggleAdvancedSearch()
            {
                if(this.advancedSearch)
                {
                    this.advancedSearch = false;
                    this.query.search = {
                        pledge_type:null,
                        loan_term:null,
                        period_time:null,
                        payment_day:null,
                        expire_date:null,
                        description:null,
                    };
                    this.fetchRequests();
                }
                else
                {
                    this.advancedSearch = true
                }
            },
            sort(query)
            {
                this.query = query;
                this.fetchRequests();
            },
            next()
            {
                if(this.requests.next_page_url) {
                    this.query.page++;
                    this.fetchRequests()
                }
            },
            prev()
            {

            },
            destroy(request)
            {
                this.requests.data.splice(this.requests.data.indexOf(request), 1);
                this.requests.total = this.requests.total - 1;
                this.fetchRequests();
            }
        }
    }
</script>
