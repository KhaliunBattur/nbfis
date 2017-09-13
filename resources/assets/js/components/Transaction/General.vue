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
                                        Шинээр нэмэх
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li v-for="journal in journals"><a class="links" @click="showModal(journal)">{{ journal.name }}</a></li>
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
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Гүйлгээний дугаар</th>
                                        <th>Данс</th>
                                        <th>Огноо</th>
                                        <th>Гүйлгээний утга</th>
                                        <th>Дебет</th>
                                        <th>Кредит</th>
                                        <th>Харилцагч</th>
                                        <th>Үүсэгсэн</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="tran in model.data">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
        </div>
        <general></general>
    </section>
</template>

<script>

    import Sort from './../Helper/Sort.vue';
    import DeleteConfirm from './../Helper/DeleteConfirm.vue';
    import General from './Form/General.vue';

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
                    column: 'id',
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
            this.fetchTransaction();
            this.fetchJournal();
        },

        components: {
            'sort' : Sort,
            'delete-confirm': DeleteConfirm,
            'general': General
        },

        methods: {
            showModal(journal)
            {
                $('#transactionModal').modal('show');
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
                    this.query.page++
                    this.fetchTransaction()
                }
            },
            prev()
            {
                if(this.model.prev_page_url) {
                    this.query.page--
                    this.fetchTransaction()
                }
            },
            destroy(transaction)
            {

            },
            fetchJournal()
            {
                axios.get('/api/journal/lists/with/account').then(response => {
                    this.journals = response.data.lists
                })
            },
            fetchTransaction()
            {
                axios.get('/api/transaction').then(response => {
                    this.model = response.data.transaction;
                    this.loading = false
                }).catch(errors => {});
            }
        }

    }

</script>