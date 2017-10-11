<template>
    <div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="box" v-if="journal">
                    <div class="box-header with-border">
                        <div class="box-title">
                            {{journal.name }}
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
                                        <li v-for="(journal, index) in journals"><a class="links" @click="showModal(index)">{{ journal }}</a></li>
                                    </ul>
                                </div>
                                <!--<button type="button" class="btn btn-success btn-sm" @click="showModal(journal.form_code)">Шинээр гүйлгээ</button>-->
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
                                        <th style="width: 20px"></th>
                                        <sort :column="'name'"   :query="query" :text="'Харилцагч'" v-on:sorted="sort"></sort>
                                        <sort :column="'start_date'"   :query="query" :text="'Огноо'" v-on:sorted="sort"></sort>
                                        <sort :column="'closing_date'" :query="query" :text="'Хаах огноо'" v-on:sorted="sort"></sort>
                                        <sort :column="'amount'"  :query="query" :text="'Хэмжээ'" v-on:sorted="sort"></sort>
                                        <th>Үлдэгдэл</th>
                                        <sort :column="'created_at'" :query="query" :text="'Үүсгэсэн'" v-on:sorted="sort"></sort>
                                    </tr>
                                    </thead>
                                    <tbody v-for="(receivable, index) in model.data">
                                    <tr>
                                        <td>
                                            <button :class="receivable.show ? 'btn btn-danger btn-xs' : 'btn btn-success btn-xs'" @click="showTransaction(receivable)" :disabled="!receivable.showTransaction" data-toggle="tooltip" data-placement="top" data-trigger="focus" title="Гүйлгээний задаргаа" v-tip>
                                                <i :class="receivable.show ? 'fa fa-minus' : 'fa fa-plus'"></i>
                                            </button>
                                        </td>
                                        <td>{{ receivable.customer.first_name + ' ' + receivable.customer.name }}</td>
                                        <td>{{ receivable.start_date }}</td>
                                        <td>{{ receivable.closing_date }}</td>
                                        <td>{{ receivable.transactions.length > 0 ? formatPrice(receivable.transactions[0].amount) : 0 }}</td>
                                        <td></td>
                                        <td>
                                            {{ receivable.transactions[0].user.name}}
                                            <div class="text-block">{{ receivable.created_at }}</div>
                                        </td>
                                    </tr>
                                    <tr v-if="receivable.showTransaction" v-show="receivable.show">
                                        <td></td>
                                        <td colspan="6">
                                            <table class="table table-bordered table-hover">
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
                                                <tbody v-for="transaction in receivable.transactions">
                                                    <tr v-for="tran in transaction.other_transactions">
                                                        <td>{{ tran.transaction_number }}</td>
                                                        <td>
                                                            {{ tran.account.name }}
                                                            <div class="text-block">{{ tran.account.account_number }}</div>
                                                        </td>
                                                        <td>{{ tran.transaction_date }}</td>
                                                        <td>{{ tran.description }}</td>
                                                        <td>
                                                            <div v-if="tran.type == 'debit'">
                                                                <div style="width: 100%">
                                                                    {{ formatPrice(tran.amount * tran.exchange) }}
                                                                </div>
                                                                <div class="text-block pull-left" v-if="tran.account.currency.is_current == 0">{{ tran.amount }}{{ tran.account.currency.marker }}</div>
                                                                <div class="text-block pull-right" v-if="tran.account.currency.is_current == 0">Ханш: {{ tran.exchange }}</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div v-if="tran.type == 'credit'">
                                                                <div style="width: 100%">
                                                                    {{ formatPrice(tran.amount * tran.exchange) }}
                                                                </div>
                                                                <div class="text-block pull-left" v-if="tran.account.currency.is_current == 0">{{ tran.amount }}{{ tran.account.currency.marker }}</div>
                                                                <div class="text-block pull-right" v-if="tran.account.currency.is_current == 0">Ханш: {{ tran.exchange }}</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ receivable.customer.first_name + ' ' + receivable.customer.name }}
                                                        </td>
                                                        <td>
                                                            {{ tran.user.name }}
                                                            <div class="text-block">{{ tran.created_at }}</div>
                                                        </td>
                                                        <td>
                                                            <delete-confirm :item="tran" :url="'/api/transaction/' + tran.transaction_number" v-on:destroyed="destroy(tran)"></delete-confirm>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7">
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
        <form-00002 v-on:modalHided="fetchReceivable"></form-00002>
    </div>
</template>

<script>

    import Sort from './../../Helper/Sort.vue';
    import DeleteConfirm from './../../Helper/DeleteConfirm.vue';
    import Form_00002 from './../Form/Journal/form_00002.vue';

    export default {

        props: ['journals', 'journal'],

        watch: {
            '$route.params.id': function(){
                this.fetchReceivable();
            }
        },

        data() {
            return {
                closed: true,
                loading: true,
                advancedSearch: false,
                model: {},
                query: {
                    page: 1,
                    journal_id: null,
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

        },

        created()
        {
            this.query.journal_id = this.journal.id;
            this.fetchReceivable();
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,
            'form-00002': Form_00002
        },

        methods: {
            showModal(journal)
            {
                $('#form_' + journal).modal('show');
            },
            changePerPage()
            {
                this.fetchReceivable();
            },
            sort(query)
            {
                this.query = query;

                this.fetchReceivable();
            },
            next()
            {
                if(this.model.next_page_url) {
                    this.query.page++;
                    this.fetchReceivable()
                }
            },
            prev()
            {
                if(this.model.prev_page_url) {
                    this.query.page--;
                    this.fetchReceivable()
                }
            },
            showTransaction(receivable)
            {
                receivable.show = receivable.show == false ? true : false;
            },
            fetchReceivable()
            {
                axios.get('/api/receivable', {
                    params: this.query
                }).then(response => {
                    this.model = response.data.receivables;
                    this.loading = false;
                }).catch(errors => {});
            },
            formatPrice(amount) {
                let val = (amount/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            destroy(transaction)
            {
                this.fetchReceivable();
            },
        }

    }

</script>