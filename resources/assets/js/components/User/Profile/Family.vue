<template>
    <div class="tab-pane" id="Family">
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Шинээр нэмэх
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Овог <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="family.first_name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нэр <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="family.last_name" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Таны хэн болох <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="family.relation" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ажил/Сургууль/<label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="family.job" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Регистер<label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="family.register" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Нэр <label class="text-danger">*</label></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="family.monthBudged" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Утас</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" v-model="family.phone" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Хаяг</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                            <hr />

                    <div class="box-footer">
                        <div class="btn-group">
                            <router-link to="/users" class="btn btn-sm btn-danger">Буцах</router-link>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-sm btn-success" @click="save()">Хадгалах</button>
                        </div>
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

    export default {

        props: ['user'],

        data()
        {
            return {
                family: {
                    firts_name: '',
                    last_name: '',
                    relation: '',
                    job: '',
                    register: '',
                    monthBudged: '',
                    phone: 'customer',
                }
            }
        },

        methods: {

        }

    }
</script>
