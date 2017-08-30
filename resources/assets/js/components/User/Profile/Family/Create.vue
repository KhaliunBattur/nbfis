<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-horizontal">
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Овог нэр <label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="text" maxlength="255" class="form-control" v-model="member.name" name="name" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('name') }" placeholder="Ихдээ 255 тэмдэгт"/>
                        <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Таны хэн болох <label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <select v-model="member.relation" class="form-control">
                            <option v-for="(relation, index) in relations" :value="index">{{ relation }}</option>
                        </select>
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Ажил/Сургууль/<label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="member.job" name="job" v-validate="'required|max:255'" :class="{'form-control': true, 'is-danger': errors.has('job') }" placeholder="Ихдээ 255 тэмдэгт"/>
                        <div v-show="errors.has('job')" class="help is-danger">{{ errors.first('job') }}</div>
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Регистер<label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <masked-input v-model="member.register" mask="AA11111111" placeholder="АА00000000" class="form-control" />
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Сарын орлого <label class="text-danger">*</label></label>
                    <div class="col-sm-10">
                        <input type="number" maxlength="255" class="form-control" v-model="member.budged" name="budged" v-validate="'required'" :class="{'form-control': true, 'is-danger': errors.has('budged') }" placeholder="Ихдээ 255 тэмдэгт"/>
                        <div v-show="errors.has('budged')" class="help is-danger">{{ errors.first('budged') }}</div>
                    </div>
                </div>
                <hr />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Утас <label class="text-danger">*</label></label>
                    <div class="col-sm-10" @keyup.enter="save()">
                        <masked-input name="phone"  v-validate="'required'" v-model="member.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111" class="form-control" />
                        <div v-show="errors.has('phone')" class="help is-danger">{{ errors.first('phone') }}</div>
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

    import MaskedInput from 'vue-masked-input'

    export default {

        props: ['user', 'relations'],

        components: {
            'masked-input': MaskedInput
        },

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
                this.member = {
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
