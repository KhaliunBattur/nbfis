<template>
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Ерөнхий журнал
                        </div>
                    </div>
                    <div class="box-body">
                        <div>
                            <div class="container-fluid" style="padding: 0px">
                                <div class="btn-group pull-left" role="group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Шинээр гүйлгээ
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="links" @click="showModal(null)">Ерөнхий журнал</a></li>
                                        <li v-for="(journal, index) in journals"><a class="links" @click="showModal(index)">{{ journal }}</a></li>
                                    </ul>
                                </div>
                                <div class="input-group input-group-sm input-small with-margin-bottom pull-right">
                                    <input type="text" v-model="query.per_page" class="form-control" />
                                    <div class="input-group-btn">
                                        <button class="btn" @click="changePerPage()">-р хуудаслах</button>
                                    </div>
                                </div>
                            </div>
                            <div v-bind:class="loading ? 'table-responsive table-sm loading' : 'table-responsive table-sm'">
                                <table class="table table-bordered table-hover" style="font-size: 12px">
                                    <thead>
                                    <tr>
                                        <sort :column="'transaction_number'" :query="query" :text="'Гүйлгээний дугаар'" v-on:sorted="sort"></sort>
                                        <sort :column="'account_number'"   :query="query" :text="'Данс'" v-on:sorted="sort"></sort>
                                        <sort :column="'transaction_date'"   :query="query" :text="'Огноо'" v-on:sorted="sort"></sort>
                                        <sort :column="'transaction_value'" :query="query" :text="'Гүйлгээний утга'" v-on:sorted="sort"></sort>
                                        <sort :column="'type'"  :query="query" :text="'Дебет'" v-on:sorted="sort"></sort>
                                        <sort :column="'type'" :query="query" :text="'Кредит'" v-on:sorted="sort"></sort>
                                        <sort :column="'name'" :query="query" :text="'Харилцагч'" v-on:sorted="sort"></sort>
                                        <sort :column="'created_at'" :query="query" :text="'Үүсгэсэн'" v-on:sorted="sort"></sort>
                                        <th class="action-controls-sm"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="tran in model.data">
                                        <td>{{ tran.transaction_number }}</td>
                                        <td>
                                            {{ tran.account.name }}
                                            <div class="text-block">{{ tran.account.account_number }}</div>
                                        </td>
                                        <td>{{ tran.transaction_date }}</td>
                                        <td>{{ tran.description }}</td>
                                        <td>
                                            <div v-if="tran.type == 'debit'">
                                                {{ formatPrice(tran.amount * tran.exchange) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div v-if="tran.type == 'credit'">
                                                {{ formatPrice(tran.amount * tran.exchange) }}
                                            </div>
                                        </td>
                                        <td>{{ tran.customer.first_name + ' ' + tran.customer.name }}</td>
                                        <td>
                                            {{ tran.user.name }}
                                            <div class="text-block">{{ tran.created_at }}</div>
                                        </td>
                                        <td>
                                            <delete-confirm :item="tran" :url="'/api/transaction/' + tran.transaction_number" v-on:destroyed="destroy(tran)"></delete-confirm>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>Пассив: {{ formatPrice(sumOfDebit) }}</b></td>
                                        <td><b>Актив: {{ formatPrice(sumOfCredit) }}</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="9">
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
        </div>
        <general v-on:modalHided="fetchTransaction"></general>
        <form-00001 v-on:modalHided="fetchTransaction"></form-00001>
        <form-00011 v-on:modalHided="fetchTransaction"></form-00011>
        <form-00012 v-on:modalHided="fetchTransaction"></form-00012>
        <form-00002 v-on:modalHided="fetchTransaction"></form-00002>
        <form-00003 v-on:modalHided="fetchTransaction"></form-00003>
    </section>
</template>

<script>

    import Sort from './../Helper/Sort.vue';
    import DeleteConfirm from './../Helper/DeleteConfirm.vue';
    import General from './Form/General.vue';
    import Form_00001 from './Form/Journal/form_00001.vue';
    import Form_00011 from './Form/Journal/form_00011.vue';
    import Form_00012 from './Form/Journal/form_00012.vue';
    import Form_00002 from './Form/Journal/form_00002.vue';
    import Form_00003 from './Form/Journal/form_00003.vue';

    export default {

        data() {
            return {
                closed: true,
                loading: true,
                advancedSearch: false,
                journals: {},
                model: {},
                query: {
                    page: 1,
                    column: 'transaction_number',
                    direction: 'asc',
                    per_page: 10,
                    user_type: 'all',
                    search: {
                        name: null
                    }
                }
            }
        },

        computed: {
            sumOfCredit() {
                if(this.model.data)
                {
                    let credits = this.model.data.filter(function(transaction){
                        return transaction.type == 'credit'
                    });

                    return credits.reduce(function(prev, transaction) {
                        return parseFloat(prev) + parseFloat(transaction.amount * transaction.exchange)
                    }, 0)
                }
                else
                {
                    return 0;
                }
            },
            sumOfDebit()
            {
                if(this.model.data)
                {
                    let credits = this.model.data.filter(function(transaction){
                        return transaction.type == 'debit'
                    });

                    return credits.reduce(function(prev, transaction) {
                        return parseFloat(prev) + parseFloat(transaction.amount * transaction.exchange)
                    }, 0)
                }
                else
                {
                    return 0;
                }
            }
        },

        created()
        {
            this.fetchTransaction();
            this.fetchJournal();
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,
            'general': General,
            'form-00001': Form_00001,
            'form-00011': Form_00011,
            'form-00012': Form_00012,
            'form-00002': Form_00002,
            'form-00003': Form_00003
        },

        methods: {
            showModal(journal)
            {
                if(journal === null)
                {
                    $('#general_transactionModal').modal('show');
                }else
                {
                    $('#form_' + journal).modal('show');
                }
            },
            changePerPage()
            {
                this.fetchTransaction();
            },
            sort(query)
            {
                this.query = query;

                this.fetchTransaction();
            },
            next()
            {
                if(this.model.next_page_url) {
                    this.query.page++;
                    this.fetchTransaction()
                }
            },
            prev()
            {
                if(this.model.prev_page_url) {
                    this.query.page--;
                    this.fetchTransaction()
                }
            },
            destroy(transaction)
            {
                this.fetchTransaction();
            },
            fetchJournal()
            {
                axios.get('/api/codes/transaction').then(response => {
                    this.journals = response.data.codes;
                })
            },
            fetchTransaction()
            {
                axios.get('/api/transaction', {
                    params: this.query
                }).then(response => {
                    this.model = response.data.transaction;
                    this.loading = false
                }).catch(errors => {});
            },
            formatPrice(amount) {
                let val = (amount/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }

    }

</script>