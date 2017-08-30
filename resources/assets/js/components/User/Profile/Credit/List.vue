
<template>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                Идэвхтэй зээлийн мэдээлэл
            </div>
            <div class="box-tools">
                <button @click="createCredit" class="btn btn-sm btn-default" v-if="view == 'list'">Шинээр нэмэх</button>
            </div>
        </div>
        <credit-create v-if="view == 'credit-create'" :user="user"  v-on:closed="closeForm"></credit-create>
        <credit-edit v-if="view == 'credit-edit'" :credit="credit" :user="user"  v-on:closed="closeForm"></credit-edit>
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
                        <sort :column="'organization'" :query="query" :text="'Зээл авсан байгууллага'" v-on:sorted="sort"></sort>
                        <sort :column="'loan_amount'" :query="query" :text="'Зээлийн хэмжээ'" v-on:sorted="sort"></sort>
                        <sort :column="'loan_usage'" :query="query" :text="'Зээлийн зориулалт'" v-on:sorted="sort"></sort>
                        <sort :column="'loan_date'" :query="query" :text="'Хугацаа'" v-on:sorted="sort"></sort>
                        <sort :column="'loan_interest'" :query="query" :text="'Зээлийн хүү'" v-on:sorted="sort"></sort>
                        <sort :column="'loan_balance'" :query="query" :text="'Одоогийн үлдэгдэл'" v-on:sorted="sort"></sort>
                        <sort :column="'monthly_pay'" :query="query" :text="'Сарын төлбөр'" v-on:sorted="sort"></sort>
                        <th class="action-controls-sm" v-if="!advancedSearch">
                            <button class="btn btn-info btn-sm" @click="toggleAdvancedSearch">Дэлгэрэнгүй хайлт</button>
                        </th>
                    </tr>
                    <tr v-if="advancedSearch">
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.organization" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.loan_amount" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.loan_usage" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.loan_date" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.loan_interest" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.loan_balance" @keyup.enter="search()"/>
                        </th>
                        <th>
                            <input type="text" class="form-control input-sm" v-model="query.search.monthly_pay" @keyup.enter="search()"/>
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
                    <tr v-for="credit in credits.data">
                        <td>{{ credit.organization }}</td>
                        <td>{{ credit.loan_amount }}</td>
                        <td>{{ credit.loan_usage }}</td>
                        <td>{{ credit.loan_date }}</td>
                        <td>{{ credit.loan_interest }}</td>
                        <td>{{ credit.loan_balance }}</td>
                        <td>{{ credit.monthly_pay }}</td>
                        <td>
                            <a class="btn btn-xs btn-warning" @click="editCredit(credit)"><i class="fa fa-pencil-square"></i></a>
                            <delete-confirm :item="user" :url="'/api/user/' + user.id + '/credit/' + credit.id + '/destroy'" v-on:destroyed="destroy(credit)"></delete-confirm>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="8">
                            <div class="pull-left">
                                <span>Нийт: {{ credits.total }} мөр бичлэгийн {{ credits.from }} -с {{ credits.to }} харуулж байна</span>
                            </div>
                            <div class="pull-right">
                                <a @click="prev()" v-if="credits.prev_page_url" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Өмнөх</a>
                                <a @click="next()" v-if="credits.next_page_url" class="btn btn-default btn-xs">Дараах <i class="fa fa-arrow-right"></i></a>
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
    import CreditCreate from './Create.vue'
    import CreditEdit from './Edit.vue'

    export default {

        props: ['user'],

        data() {
            return {
                view: 'list',
                loading: true,
                advancedSearch: false,
                credits: {},
                credit: null,
                query: {
                    page: 1,
                    column: 'organization',
                    direction: 'asc',
                    per_page: 10,
                    search: {
                        organization: null,
                        loan_amount: null,
                        loan_usage: null,
                        loan_date: null,
                        loan_interest: null,
                        loan_balance: null,
                        monthly_pay: null
                    }
                },
                relations: null
            }
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,
            'credit-create': CreditCreate,
            'credit-edit':CreditEdit
        },

        mounted()
        {

            this.fetchCredit();
        },

        methods: {
            closeForm()
            {
                this.view = 'list';
                this.fetchCredit();
            },
            createCredit()
            {
                this.view = 'credit-create';
            },
            editCredit(credit)
            {
                this.credit = credit;

                this.view='credit-edit';
            },

            fetchCredit()
            {
                axios.get('api/user/' + this.$route.params.id + '/credit', {
                    params: {
                        search: JSON.stringify(this.query.search),
                        per_page: this.query.per_page,
                        column: this.query.column,
                        direction: this.query.direction,
                        page: this.query.page
                    }
                }).then(response => {
                    this.credits = response.data.credits;
                    this.loading = false;
                }).catch(error => {
                    console.log(error);
                    this.loading = false;
                })
            },
            changePerPage()
            {
                this.fetchCredit();
            },
            search()
            {
                this.fetchCredit();
            },
            toggleAdvancedSearch()
            {
                if(this.advancedSearch)
                {
                    this.advancedSearch = false;
                    this.query.search = {
                        organization: null,
                        loan_amount: null,
                        loan_usage: null,
                        loan_date: null,
                        loan_interest: null,
                        loan_balance: null,
                        monthly_balance: null,
                    };
                    this.fetchCredit();
                }else
                {
                    this.advancedSearch = true
                }
            },
            sort(query)
            {
                this.query = query;

                this.fetchCredit();
            },
            next()
            {
                if(this.credits.next_page_url) {
                    this.query.page++;
                    this.fetchCredit()
                }
            },
            prev()
            {
                if(this.credits.prev_page_url) {
                    this.query.page--;
                    this.fetchCredit()
                }
            },
            destroy(credit)
            {
                this.credits.data.splice(this.credits.data.indexOf(credit), 1);
                this.credits.total = this.credits.total - 1;
            }
        }
    }
</script>
