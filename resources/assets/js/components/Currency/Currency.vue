<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Вальют
            </h1>
            <ol class="breadcrumb">
                <li><router-link to="/"><i class="fa fa-dashboard"></i> Удирдлага</router-link></li>
                <li class="active">Вальют</li>
            </ol>
        </section>
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                               {{mode}}
                            </div>
                        </div>
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Нэр <label class="text-danger">*</label></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="currency.name" />
                                        <div class="text-danger" v-if="errorMessages.name">
                                            {{ errorMessages.name[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Ханш<label class="text-danger">*</label></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="currency.exchange" />
                                        <div class="text-danger" v-if="errorMessages.exchange">
                                            {{ errorMessages.exchange[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Тэмдэг<label class="text-danger">*</label></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="currency.marker" @keyup.enter="save()" />
                                        <div class="text-danger" v-if="errorMessages.marker">
                                            {{ errorMessages.marker[0] }}
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm pull-right" @click="save()">Хадгалах</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Жагсаалт
                            </div>
                            <div class="box-body">
                                <div v-bind:class="loading ? 'table-responsive table-sm loading' : 'table-responsive table-sm'">
                                    <div class="input-group input-group-sm input-small with-margin-bottom pull-left">
                                        <input type="text" v-model="query.per_page" class="form-control" @keyup.enter="changePerPage()"/>
                                        <div class="input-group-btn">
                                            <button class="btn" @click="changePerPage()">-р хуудаслах</button>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <sort :column="'name'" :query="query" :text="'Нэр'" v-on:sorted="sort"></sort>
                                            <th>Ханш</th>
                                            <th>Тэмдэг</th>
                                            <th class="action-controls-sm">

                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="currency in model.data">
                                            <td>{{currency.name }}</td>
                                            <td>{{currency.exchange}}</td>
                                            <td>{{currency.marker}}</td>
                                            <td>
                                                <button class="btn btn-warning btn-xs" @click="edit(currency)"><i class="fa fa-pencil-square"></i></button>
                                                <delete-confirm :item="currency" :url="'/api/currency/' + currency.id" v-on:destroyed="destroy(currency)"></delete-confirm>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3">
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
        </section>
    </div>
</template>

<script>

    import Sort from './../Helper/Sort.vue';
    import vSelect from 'vue-select'
    import DeleteConfirm from './../Helper/DeleteConfirm.vue';

    export default {

        data()
        {
            return {
                mode:'Вальют нэмэх',
                model: [],
                loading: false,
                roots: [],
                currency: {
                    id: 0,
                    name: null,
                    exchange:null,
                    maker:null
                },
                query: {
                    page: 1,
                    column: 'name',
                    direction: 'asc',
                    per_page: 10,
                    user_type: 'all',
                    search: {
                        name: null,
                    }
                },
                errorMessages: {
                    name: null,
                }
            }
        },

        created()
        {
            this.fetchCurrency();
        },

        components: {
            'sort' : Sort,
            'v-select': vSelect,
            'delete-confirm': DeleteConfirm
        },

        methods: {
            changePerPage()
            {
                this.fetchCurrency();
            },

            fetchCurrency()
            {
                this.loading = true;
                axios.get('/api/currency', {
                    params: {
                        per_page: this.query.per_page,
                        column: this.query.column,
                        direction: this.query.direction,
                        page: this.query.page,
                        search: JSON.stringify(this.query.search)
                    }
                }).then(response => {
                    this.loading = false;
                    this.model = response.data.model;
                }).catch(errors => {
                    this.loading = false;
                    swal('Уучлаарай', 'Вальютын мэдээлэл татаж чадсангүй', 'error')
                })
            },
            edit(currency)
            {
                this.currency = currency;
                this.mode = 'Вальют засварлах'
            },
            save()
            {
                var self = this;
                axios.post('/api/currency', this.currency).then(response => {
                    if(response.data.result)
                    {
                        swal({
                            title: 'Амжилттай',
                            text: 'Вальют бүртгэгдлээ',
                            type: 'success',
                            timer: 3000
                        }, function(){
                            self.currency = {
                                id: 0,
                                name: null
                            };
                            self.errorMessages = {
                                name: null
                            };
                            self.fetchCurrency();
                        })
                    }
                }).catch(error => {
                    this.errorMessages = error.response.data;
                })
            },
            sort(query)
            {
                this.query = query;

                this.fetchCurrency();
            },
            next()
            {
                if(this.model.next_page_url) {
                    this.query.page++
                    this.fetchCurrency()
                }
            },
            prev()
            {
                if(this.model.prev_page_url) {
                    this.query.page--
                    this.fetchCurrency()
                }
            },
            destroy(currency)
            {
                this.model.data.splice(this.model.data.indexOf(currency), 1);
                this.model.total = this.model.total - 1;
                this.fetchCurrency();
            }
        }

    }

</script>