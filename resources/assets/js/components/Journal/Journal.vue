<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Журнал
            </h1>
            <ol class="breadcrumb">
                <li><router-link to="/"><i class="fa fa-dashboard"></i> Удирдлага</router-link></li>
                <li class="active">Журнал</li>
            </ol>
        </section>
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Журнал нэмэх
                            </div>
                        </div>
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Харья бүлэг <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <v-select v-model="journal.root" :debounce="250" :on-search="fetchRoot" :options="roots" label="name" placeholder="Харьяа бүлэг"></v-select>
                                        <div class="text-danger" v-if="errorMessages.root">
                                            {{ errorMessages.root[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Нэр <label class="text-danger">*</label></label>
                                    <div class="col-sm-9">
                                        <input maxlength="255" type="text" class="form-control" v-model="journal.name" />
                                        <div class="text-danger" v-if="errorMessages.name">
                                            {{ errorMessages.name[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Форум код <label class="text-danger">*</label></label>
                                    <div class="col-sm-9">
                                        <select v-model="journal.form_code" class="form-control">
                                            <option v-for="(code, index) in codes" :value="index">{{ code }}</option>
                                        </select>
                                        <div class="text-danger" v-if="errorMessages.form_code">
                                            {{ errorMessages.form_code[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Форум код (Гүйлгээ) <label class="text-danger">*</label></label>
                                    <div class="col-sm-9">
                                        <select v-model="journal.form_code_transaction" class="form-control">
                                            <option v-for="(code, index) in codes_transaction" :value="index">{{ code }}</option>
                                        </select>
                                        <div class="text-danger" v-if="errorMessages.form_code_transaction">
                                            {{ errorMessages.form_code_transaction[0] }}
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
                                        <input type="text" v-model="query.per_page" class="form-control" />
                                        <div class="input-group-btn">
                                            <button class="btn" @click="changePerPage()">-р хуудаслах</button>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <sort :column="'name'" :query="query" :text="'Нэр'" v-on:sorted="sort"></sort>
                                            <th>Харья бүлэг</th>
                                            <th class="action-controls-sm">

                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="journal in model.data">
                                            <td>{{ journal.name }}</td>
                                            <td>{{ journal.root ? journal.root.name : '' }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-xs" @click="edit(journal)"><i class="fa fa-pencil-square"></i></button>
                                                <delete-confirm :item="journal" :url="'/api/journal/' + journal.id" v-on:destroyed="destroy(journal)"></delete-confirm>
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
                model: [],
                loading: false,
                roots: [],
                codes: [],
                codes_transaction: [],
                journal: {
                    id: 0,
                    name: null,
                    root: null,
                    form_code: null,
                    form_code_transaction: null
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
                    name: null
                }
            }
        },

        created()
        {
            this.fetchJournal();
            this.fetchCodes();
            this.fetchCodesTransaction();
        },

        components: {
            'sort' : Sort,
            'v-select': vSelect,
            'delete-confirm': DeleteConfirm
        },

        methods: {
            changePerPage()
            {
                this.fetchJournal();
            },
            fetchCodes()
            {
                axios.get('/api/codes').then(response => {
                    this.codes = response.data.codes
                }).catch(errors => {});
            },
            fetchCodesTransaction()
            {
                axios.get('/api/codes/transaction').then(response => {
                    this.codes_transaction = response.data.codes
                }).catch(errors => {});
            },
            fetchRoot(search, loading)
            {
                loading(true);
                axios.get('/api/journal/lists?q=' + search + '&ignore=' + this.journal.id).then(response => {
                    this.roots = response.data.lists
                    loading(false)
                }).catch(errors => {
                    loading(false)
                })
            },
            fetchJournal()
            {
                this.loading = true;
                axios.get('/api/journal', {
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
                    swal('Уучлаарай', 'Журналын мэдээлэл татаж чадсангүй', 'error')
                })
            },
            edit(journal)
            {
                this.journal = journal;
            },
            save()
            {
                var self = this;
                axios.post('/api/journal', this.journal).then(response => {
                    if(response.data.result)
                    {
                        swal({
                            title: 'Амжилттай',
                            text: 'Журнал бүртгэгдлээ',
                            type: 'success',
                            timer: 3000
                        }, function(){
                            self.journal = {
                                id: 0,
                                name: null
                            }
                            self.errorMessages = {
                                name: null
                            }
                            self.fetchJournal();
                        })
                    }
                }).catch(error => {
                    this.errorMessages = error.response.data;
                })
            },
            sort(query)
            {
                this.query = query;

                this.fetchJournal();
            },
            next()
            {
                if(this.model.next_page_url) {
                    this.query.page++
                    this.fetchJournal()
                }
            },
            prev()
            {
                if(this.model.prev_page_url) {
                    this.query.page--
                    this.fetchJournal()
                }
            },
            destroy(journal)
            {
                this.model.data.splice(this.model.data.indexOf(journal), 1);
                this.model.total = this.model.total - 1;
            }
        }

    }

</script>