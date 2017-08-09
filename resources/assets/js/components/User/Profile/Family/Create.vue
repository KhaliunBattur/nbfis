<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Овог нэр <label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="member.name" />
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Таны хэн болох <label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="member.relation" />
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Ажил/Сургууль/<label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="member.job" />
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Регистер<label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="member.register" />
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Сарын орлого <label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="member.budged" />
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Утас</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="member.phone_number" />
                    </div>
                </div>

                <hr />

                <div class="box-footer">
                    <div class="btn-group">
                        <a @click="back()" class="btn btn-sm btn-danger">Буцах</a>
                    </div>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-sm btn-success" @click="save()">Хадгалах</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>

    export default {

        props: ['user'],

        data()
        {
            return {
                family: [],
                member: {
                    name: null,
                    relation: null,
                    job: null,
                    register: null,
                    budged: null,
                    phone_number: null,
                }
            }
        },

        methods: {
            reset()
            {
              this.family = {
                  name: null,
                  relation: null,
                  job: null,
                  register: null,
                  budged: null,
                  phone_number: null,
              }
            },

            back()
            {
              this.$emit('closed');
            },

            save()
            {
              var self = this;
              axios.post('/api/user/' + this.user.id + '/family', this.member).then(response=>{
                  if(response.data.result)
                  {
                      swal({
                          title: 'Ажилттай',
                          text: 'Бүртгэгдлээ',
                          type: 'success'
                      }, function(){
                          self.reset();
                      });
                  }
              }).catch(errors=>{
                  swal('Уучлаарай', 'Амжилтгүй боллоо', 'error');
              })
            }
        }

    }
</script>
