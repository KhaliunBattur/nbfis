<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Зээлийн хүсэлт бүртгэх
            </h1>
            <ol class="breadcrumb">
                <li class="active">Удирдлага</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content" >
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Анкет
                            </div>
                        </div>
                        <div class="box-body" >
                            <div class="form-horizontal">
                                <div class="cv">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Зураг</label>
                                        <div class="col-sm-10">
                                            <dropzone
                                                      ref="profUpload"
                                                      id="profile"
                                                      class="margin-bottom-10"
                                                      :headers='csrfHeaders'
                                                      :url="profileUpload"
                                                      :use-font-awesome="true"
                                                      :thumbnail-height="100"
                                                      :thumbnail-width="100"
                                                      v-on:vdropzone-success="ProfSuccess"
                                                      v-bind:preview-template="template"
                                                      v-on:vdropzone-error="onError">
                                            </dropzone>
                                        </div>
                                    </div>

                                    <div  v-if="user.imageTemp != '' && user.image == '' " >
                                        <img  :src= "user.imageTemp"  class="cv-picture" />
                                    </div>
                                    <div  v-else-if="user.imageTemp == '' && user.image != '' " >
                                        <img  :src= "'images/profile/user/'+user.image"  class="cv-picture" />
                                    </div>
                                    <div  v-else-if="user.imageTemp != '' && user.image != '' " >
                                        <img  :src= "user.image"  class="cv-picture" />
                                    </div>

                                    <h1 style="margin-top: 130px">01 ЕРӨНХИЙ МЭДЭЭЛЭЛ</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 15%;">Овог нэр:</td>
                                            <td style="width: 35%;" >
                                                <input  type="text" class="form-control input-sm"  v-model="user.first_name" :value="user.first_name"/><br>
                                                <input  type="text" class="form-control input-sm"  v-model="user.name" :value="user.name"/>
                                            </td>
                                            <td style="width: 20%;">Регистерийн дугаар:</td>
                                            <td style="width: 30%;"><masked-input v-model="user.register" mask="AA11111111" placeholder="АА00000000"   @input="setRegister" class="form-control input-sm"></masked-input></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 15%;">Нас:</td>
                                            <td style="width: 35%;">
                                                <input type="number" class="form-control input-sm" v-model="user.age" readonly="readonly" />
                                            </td>
                                            <td style="width: 20%;">Утасны дугаар:</td>
                                            <td style="width: 30%;"><masked-input v-model="user.phone_number" v-bind:value="user.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111" class="form-control input-sm">
                                            </masked-input></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 15%;">Цахим шуудан:</td>
                                            <td style="width: 35%;"><input placeholder="simple@simple.com" type="text" class="form-control input-sm" v-model="user.email" />
                                            </td>
                                            <td style="width: 20%;">Мэргэжил:</td>
                                            <td style="width: 30%;"><input type="text" class="form-control input-sm" v-model="user.profession"/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="cv-table cv-lg cv-top-border-none" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 30%;">Одоо амьдарч буй гэрийн хаяг:</td>
                                            <td style="width: 70%;"><textarea class="form-control input-sm" rows="2" v-model="user.address"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Одоо амьдарч буй байр нь орон сууц, хашаа байшин, хашаа гэр:</td>
                                            <td style="width: 70%;">
                                                <select v-model="user.owner_type" class="form-control input-sm">
                                                    <option v-for="(owner_type, index) in owner_types" :value="index">{{owner_type}}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="cv-table cv-lg cv-top-border-none" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 50%;">Тухайн хаяг дээр амьдарсан жил:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.live_year"  type="number" placeholder="111"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Байр нь зээлийн барьцаанд байгаа бол дэлгэрэнгүй бөглөнө үү:</td>
                                            <td style="width: 50%;">
                                                <textarea class="form-control input-sm" v-model="user.bail_info" ></textarea>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>02 ЗЭЭЛИЙН ХҮСЭЛТ</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody >
                                        <tr>
                                            <td colspan="3" style="width: 100%;">
                                                <select class="form-control input-sm" v-model="user.request.pledge_type" >
                                                    <option v-for="(pledge_type, index) in pledge_types" :value="index">{{pledge_type}}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr >
                                            <td style="width: 30%;">Хүсэж буй зээлийн хэмжээ: </td>
                                            <td style="width: 65%;"><input class="form-control input-sm" v-model="user.request.loan_term" type="number"/></td>
                                            <td style="width: 5%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Зээлийн эргэн төлөх хугацаа:</td>
                                            <td style="width: 65%;"><input class="form-control input-sm" v-model="user.request.expire_date" type="text" /></td>
                                            <td style="width: 5%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Сар бүрийн эргэн төлөлт хийх өдөр:</td>
                                            <td style="width: 65%;"><input class="form-control input-sm" v-model="user.request.payment_day" name="payment_day"
                                                                           v-validate="'max_value:31|min_value:1'" type="number" />
                                                <span v-if="errors.has('payment_day')" class="help is-danger">{{ errors.first('payment_day') }}</span>
                                            </td>
                                            <td style="width: 5%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Зээлийн хугацаа дуусах огноо:</td>
                                            <td style="width: 65%;"><input class="form-control input-sm" v-model="user.request.period_time" v-pick="user.request.period_time"  /></td>
                                            <td style="width: 5%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Нэмэлт тайлбар, тэмдэглэгээ:</td>
                                            <td style="width: 65%;"><input class="form-control input-sm" v-model="user.request.description" type="text"/></td>
                                            <td style="width: 5%"><button class="btn btn-sm btn-success" @click="addRequest()"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                        </tbody >
                                    </table>

                                    <h3 style="margin-top: 20px">зээлийн хүсэлтүүд</h3>

                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                            <tr>
                                                <td style="width:14%">Барьцаа хөрөнгө</td>
                                                <td style="width:14%">Зээлийн хэмжээ</td>
                                                <td style="width:14%">Эргэн төлөх хугацаа</td>
                                                <td style="width:14%">Төлөлт хийх өдөр</td>
                                                <td style="width:14%">Хугацаа дуусах огноо</td>
                                                <td style="width:15%">Тайлбар тэмдэглэгээ</td>
                                                <td style="width: 3%"></td>
                                            </tr>
                                            <tr v-for="(request, index) in user.requests">
                                                <td style="width: 14%" ><input class="form-control input-sm" type="text"   v-model="request.pledge_type" /></td>
                                                <td style="width: 14%" ><input class="form-control input-sm" type="number" v-model="request.loan_term"/></td>
                                                <td style="width: 14%" ><input class="form-control input-sm" type="text"   v-model="request.period_time" /></td>
                                                <td style="width: 14%" ><input class="form-control input-sm" type="number" v-model="request.payment_day" max="31"  /></td>
                                                <td style="width: 14%" ><input class="form-control input-sm" type="text"   v-model="request.expire_date" /></td>
                                                <td style="width: 15%" ><input class="form-control input-sm" type="text"   v-model="request.description" /></td>
                                                <td style="width: 3%;"><button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyRequest(request)"></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h1>03 БАРЬЦАА ХӨРӨНГИЙН МЭДЭЭЛЭЛ</h1>

                                    <table class="cv-table cv-md"  >
                                        <tbody>
                                        <tr>
                                            <td style="width: 100%;" colspan="3">Байр барьцаалах бол 4%</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 45%;">Ашиглалтанд орсон огноо:</td>
                                            <td style="width: 50%;" colspan="2"><input class="form-control input-sm" v-model="user.apartment.commissioned" type="text" v-pick="user.apartment.commissioned"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 45%;">Хаяг:</td>
                                            <td style="width: 50%;" colspan="2"><input class="form-control input-sm" v-model="user.apartment.address" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 45%;">Хэдэн М2:<input class="form-control input-sm" v-model="user.apartment.apart_meter" type="number"  placeholder="111"/></td>
                                            <td style="width: 50%;" colspan="2">Хэдэн өрөө:<input class="form-control input-sm" v-model="user.apartment.room" type="number"  placeholder="11"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 45%;">Зах зээлийн үнэ:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.apartment.price" /></td>
                                            <td style="width: 5%"><button class="btn btn-sm btn-success" @click="addApartment()"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="cv-table cv-md cv-md-margin-left" >
                                        <tbody>
                                        <tr>
                                            <td colspan="3">Машин барьцаалах бол 3.5-4%</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;">Марк:</td>
                                            <td style="width: 60%" colspan="2"><input class="form-control input-sm" v-model="user.car.model" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;">Өнгө:</td>
                                            <td style="width: 60%;" colspan="2"><input class="form-control input-sm" v-model="user.car.color" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;">Үйлдвэрлэсэн огноо:</td>
                                            <td style="width: 60%;" colspan="2"><input class="form-control input-sm" v-model="user.car.manufacture" v-pick="user.car.manufacture" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;">Орж ирсэн огноо:</td>
                                            <td style="width: 60%;" colspan="2"><input class="form-control input-sm" v-model="user.car.entry_date" v-pick="user.car.entry_date" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;">Зах зээлийн үнэ:</td>
                                            <td style="width: 60%;"><input class="form-control input-sm"  v-model="user.car.price"   /></td>
                                            <td><button class="btn btn-sm btn-success" @click="addCar()"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div  class="col-md-12" style="padding-top: 15px; padding:15px 0 15px 0" >

                                        <div class="col-md-6" style="padding-left: 0">
                                            <h4>Байр барьцаалах</h4>
                                            <table class="cv-table"  >
                                                <tbody>
                                                <tr>
                                                    <td style="width: 18%">Ашиглалтанд орсон</td>
                                                    <td style="width: 18%">Хаяг</td>
                                                    <td style="width: 18%">М2</td>
                                                    <td style="width: 18%">Өрөө</td>
                                                    <td style="width: 18%">З/з Үнэ</td>
                                                    <td style="width: 10%"></td>
                                                </tr>
                                                <tr v-for="(apartment,index) in user.apartments">
                                                    <td><input class="form-control input-sm" v-model="apartment.commissioned" /></td>
                                                    <td><input class="form-control input-sm" v-model="apartment.address" /></td>
                                                    <td><input class="form-control input-sm" v-model="apartment.apart_meter" /></td>
                                                    <td><input class="form-control input-sm" v-model="apartment.room" /></td>
                                                    <td><input class="form-control input-sm" v-model="apartment.price" /></td>
                                                    <td><button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyApartment(apartment)"></button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                        <div class="col-md-6" style="padding-right: 0">
                                            <h4>Машин барьцаалах</h4>
                                            <table class="cv-table ">
                                                <tbody>
                                                <tr>
                                                    <td style="width: 18%">Марк</td>
                                                    <td style="width: 18%">Өнгө</td>
                                                    <td style="width: 18%">Үйлдвэрлэсэн огноо</td>
                                                    <td style="width: 18%">орж ирсэн огноо</td>
                                                    <td style="width: 18%">З/з-ийн үнэ</td>
                                                    <td style="width: 10%"></td>
                                                </tr>
                                                <tr v-for="(car , index) in user.cars">
                                                    <td><input class="form-control input-sm" v-model="car.model" /></td>
                                                    <td><input class="form-control input-sm" v-model="car.color" /></td>
                                                    <td><input class="form-control input-sm" v-model="car.manufacture" /></td>
                                                    <td><input class="form-control input-sm" v-model="car.entry_date" /></td>
                                                    <td><input class="form-control input-sm" v-model="car.price" /></td>
                                                    <td><button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyCar(car)"></button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <table class="cv-table cv-lg cv-table-margin-top"  >
                                        <tbody>
                                        <tr>
                                            <td style="width: 23.8%;">Бусад</td>
                                            <td style="width: 75%;" colspan="3"><input class="form-control input-sm" v-model="user.other.name" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 23.8%;">Зах зээлийн үнэ:</td>
                                            <td style="width: 10%;"><input class="form-control input-sm" v-model="user.other.price"   /></td>
                                            <td style="width: 65%;">Тайлбар:<input style="width: 90%; float: right" class="form-control input-sm" v-model="user.other.description" type="text"/> </td>
                                            <td><button class="btn btn-sm btn-success" @click="addOther()"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="col-md-12" style="padding-top: 15px; padding:15px 0 15px 0">
                                        <h4>Бусад барьцаа:</h4>
                                        <table class="cv-table cv-lg">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 30%">Бусад</td>
                                                    <td style="width: 20%">Зах зээлийн үнэ</td>
                                                    <td style="width: 50%" colspan="2">Тайлбар</td>
                                                </tr>
                                            <tr v-for="(other ,index) in user.others">
                                                <td style="width: 30%"><input class="form-control input-sm" v-model="other.name"   /></td>
                                                <td style="width: 20%"><input class="form-control input-sm" v-model="other.price"   /></td>
                                                <td style="width:45%"><input class="form-control input-sm" v-model="other.description"   /></td>
                                                <td style="width: 5%"><button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyOther(other)"></button></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h1>04 АЖЛЫН ГАЗРЫН МЭДЭЭЛЭЛ</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody>

                                        <tr>
                                            <td style="width: 3%">№</td>
                                            <td style="width: 18%">Байгууллагын нэр</td>
                                            <td style="width: 16%">Ажилласан огноо</td>
                                            <td style="width: 16%">Албан тушаал</td>
                                            <td style="width: 16%">Байгууллагын үйл ажиллагааны чиглэл</td>
                                            <td style="width: 16%">Хаяг</td>
                                            <td style="width: 16%">Ажилчдын тоо</td>
                                            <td style="width: 6%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 3%"></td>
                                            <td style="width: 18%;">
                                                <input class="form-control input-sm" v-auto type="text" v-model="user.works.organization" data-target="#work-input"
                                                       @selected="setDataWork(user.works,'#work-input')" />
                                            </td>
                                            <td style="width: 16%;"><input class="form-control input-sm"  type="text" v-model="user.works.date_employment" v-pick="user.works.date_employment"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm"  type="text" v-model="user.works.position"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text" v-model="user.works.activity"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text" v-model="user.works.address"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="number" v-model="user.works.worker_count"  placeholder="1111" /></td>
                                            <td style="width: 6%"><button class="btn btn-sm btn-success" @click="addWork()"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                        <tr v-for="(works , index) in user.workplaces">
                                            <td style="width: 3%;"><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td style="width: 18%;"><input class="form-control input-sm" type="text"   v-model="works.organization"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text"   v-model="works.date_employment" v-pick="works.date_employment"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text"   v-model="works.position"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text"   v-model="works.activity"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text"   v-model="works.address"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="number" v-model="works.worker_count"  placeholder="1111" /></td>
                                            <td style="width: 6%"><button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyWork(works)"></button></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p class="left">
                                        <span>Ажлын байр нь :</span>
                                        <span>А.Өөрийн байр</span>
                                        <span>Б.Түрээс</span>
                                        <span>В.Улаанбаатар хотоос : километр</span>
                                    </p>
                                    <h1>05 ГЭР БҮЛИЙН МЭДЭЭЛЭЛ</h1>
                                    <table class="cv-table cv-lg" >

                                        <tbody>
                                        <tr>
                                            <td style="width: 3%">№:</td>
                                            <td style="width: 15%;">Овог нэр</td>
                                            <td style="width: 15%;">Таны хэн болох</td>
                                            <td style="width: 15%;">Ажил сургууль</td>
                                            <td style="width: 15%;">Регистрийн дугаар</td>
                                            <td style="width: 15%;">Сарын орлого</td>
                                            <td style="width: 15%;">Утас</td>
                                            <td style="width: 6%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 3%;"> </td>
                                            <td style="width: 18%;">
                                                <input class="form-control input-sm" v-auto type="text" v-model="user.members.name" data-target="#member-input"
                                                       @selected="setDataMember(user.members,'#member-input')" />
                                            </td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="user.members.relation"  /></td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="user.members.job"  /></td>
                                            <td style="width: 15%;"><masked-input  mask="AA11111111" placeholder="АА00000000"class="form-control input-sm" type="text" v-model="user.members.register"></masked-input></td>
                                            <td style="width: 15%;"><input v-model="user.members.budged"   class="form-control input-sm"  /></td>
                                            <td style="width: 15%;"><masked-input class="form-control input-sm" type="text" v-model="user.members.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111"></masked-input></td>
                                            <td style="width: 6%"><button class="btn btn-sm btn-success" @click="addMember()"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                        <tr v-for="(member, index) in user.family">
                                            <td style="width: 3%;"><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td style="width: 18%;"> <input class="form-control input-sm" type="text" v-model="member.name"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text" v-model="member.relation"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text" v-model="member.job"  /></td>
                                            <td style="width: 16%;"><masked-input mask="AA11111111" placeholder="АА00000000" class="form-control input-sm" type="text" v-model="member.register"></masked-input></td>
                                            <td style="width: 16%;"><input v-model="member.budged"   /></td>
                                            <td style="width: 16%;"><masked-input class="form-control input-sm"  v-model="member.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111"></masked-input>&nbsp</td>
                                            <td style="width: 6%">
                                                <button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyMember(member)"></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>06 ШААРДЛАГАТАЙ ҮЕД ХОЛБОО БАРИХ ХҮНИЙ МЭДЭЭЛЭЛ</h1>
                                    <p>Доорх хэсэгт ажлын газрын нягтлан бодогч, өөрийн эцэг эх болон гэр бүлийн гишүүний эцэг эхийн г.м</p>
                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 3%">№:</td>
                                            <td style="width: 15%;">Овог нэр</td>
                                            <td style="width: 15%;">Таны хэн болох</td>
                                            <td style="width: 15%;">Ажил сургууль</td>
                                            <td style="width: 15%;">Регистрийн дугаар</td>
                                            <td style="width: 15%;">Сарын орлого</td>
                                            <td style="width: 15%;">Утас</td>
                                            <td style="width: 6%;"></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 3%"></td>
                                            <td style="width: 15%;">
                                                <input class="form-control input-sm" v-auto type="text" v-model="user.emergency.name" data-target="#emergency-input" @selected="setDataEmergency(user.emergency,'#emergency-input')"/>
                                            </td>
                                            <td style="width: 18%;"><input class="form-control input-sm" type="text" v-model="user.emergency.relation"/>
                                            </td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="user.emergency.job"  />
                                            </td>
                                            <td style="width: 15%;"><masked-input mask="AA11111111" placeholder="АА00000000" class="form-control input-sm" type="text" v-model="user.emergency.register" />
                                            </td>
                                            <td style="width: 15%;"><input v-model="user.emergency.budged"    />
                                            </td>
                                            <td style="width: 15%;"><masked-input class="form-control input-sm" type="text" v-model="user.emergency.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111"  />
                                            </td>
                                            <td style="width: 6%;">
                                                <button class="btn btn-sm btn-success" @click="addEmergency()"><i class="fa fa-plus-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-for="(emergency, index) in user.emergencies">
                                            <td style="width: 3%"><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="emergency.name"  /></td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="emergency.relation"  /></td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="emergency.job"  /></td>
                                            <td style="width: 15%;"><masked-input mask="AA11111111" placeholder="АА00000000" class="form-control input-sm" type="text" v-model="emergency.register"></masked-input></td>
                                            <td style="width: 15%;"><input  v-model="emergency.budged"   /></td>
                                            <td style="width: 15%;"><masked-input class="form-control input-sm" type="text" v-model="emergency.phone_number"  mask="\+ (976) 1111-1111" placeholder="1111-1111"></masked-input></td>
                                            <td style="width: 6%;">
                                                <button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyEmergency(emergency)"></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>07 ӨРХИЙН САРЫН НИЙТ ОРЛОГО ЗАРЛАГА</h1>
                                    <h4>Өрхийн орлого</h4>
                                    <table   class="cv-table cv-lg">
                                        <tbody>
                                        <tr>
                                            <td style="width: 3%"><span class="text text-black">#</span></td>
                                            <td style="width: 46%">
                                                <input type="text" class="form-control input-sm" v-auto data-type="budged"
                                                       v-model="user.budget.name" data-target="#budget-input" v-on:selected="setDataBudget(user.budget, '#budget-input')">
                                                <input  type="hidden" v-model="user.budget.name" id="budget-input" />
                                            </td>
                                            <td style="width: 46%"><input v-model="user.budget.budget"  class="form-control input-sm" /></td>
                                            <td style="width: 3%">
                                                <button class="btn btn-sm btn-success" @click="addBudget()"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                        <tr v-for="(b, index) in user.budgets">

                                            <td style="width: 3%"><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td style="width: 46%">
                                                <input type="text" class="form-control input-sm" v-auto data-type="budget" :data-target="'#budget-input' + b.id" :value="b.name" v-on:selected="setDataBudget(b, '#budget-input' + b.id)">
                                                <input type="hidden" v-model="b.name" :id="'budget-input' + b.id" />
                                            </td>
                                            <td style="width: 46%"><input  v-model="b.budget"  class="form-control input-sm" /></td>
                                            <td style="width: 3%">
                                                <div class="btn-group ">
                                                    <button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyBudget(b)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h4>Өрхийн зарлага</h4>
                                    <table  class="cv-table cv-lg">
                                        <tbody>
                                        <tr>
                                            <td style="width: 3%"><span class="text text-black">#</span></td>
                                            <td style="width: 46%">
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="user.expense" v-model="user.expense.name" data-target="#expense-input" v-on:selected="setDataExpense(user.expense, '#expense-input')">
                                                <input type="hidden" v-model="user.expense.name" id="expense-input" />
                                            </td>
                                            <td style="width: 46%"><input  v-model="user.expense.expense"  class="form-control input-sm" /></td>
                                            <td style="width: 3%">
                                                <button class="btn btn-sm btn-success" @click="addExpense()"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                        <tr v-for="(b, index) in user.expenses">
                                            <td style="width: 3%"><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td style="width: 46%">
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="user.expense" :data-target="'#expense-input' + b.id" :value="b.name" v-on:selected="setDataExpense(b, '#expense-input' + b.id)">
                                                <input type="hidden" v-model="b.name" :id="'expense-input' + b.id" />
                                            </td>
                                            <td style="width: 46%"><input v-model="b.expense"  class="form-control input-sm" /></td>
                                            <td style="width: 3%">
                                                <div class="btn-group">
                                                    <button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyExpense(b)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h4>Хөрөнгө</h4>
                                    <table  class="cv-table cv-lg">

                                        <tbody>
                                        <tr>
                                            <td style="width: 3%"><span class="text text-black">#</span></td>
                                            <td style="width: 46%">
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="user.asset" v-model="user.asset.name" data-target="#asset-input" v-on:selected="setDataAsset(user.asset, '#asset-input')">
                                                <input type="hidden" v-model="user.asset.name" id="asset-input" />
                                            </td>
                                            <td style="width: 46%"><input v-model="user.asset.asset" class="form-control input-sm"  /></td>
                                            <td style="width: 3%">
                                                <button class="btn btn-sm btn-success" @click="addAsset()"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                        <tr v-for="(b, index) in user.assets">
                                            <td style="width: 3%"><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td style="width: 46%">
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="asset" :data-target="'#asset-input' + b.id" :value="b.name" v-on:selected="setDataAsset(b, '#asset-input' + b.id)">
                                                <input type="hidden" v-model="b.name" :id="'asset-input' + b.id" />
                                            </td>
                                            <td style="width: 46%"><input  v-model="b.asset" class="form-control input-sm"  /></td>
                                            <td style="width: 3%">
                                                <div class="btn-group">
                                                    <button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyAsset(b)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                    <h1>08 идэвхтэй зээлийн мэдээлэл</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 3%;"></td>
                                            <td style="width: 15%;">Зээл авсан банк санхүүгийн байгууллагын нэр</td>
                                            <td style="width: 13%;">Зээлийн хэмжээ</td>
                                            <td style="width: 13%;">Зээлийн зориулалт</td>
                                            <td style="width: 13%;">Хугацаа</td>
                                            <td style="width: 13%;">Зээлийн хүү</td>
                                            <td style="width: 13%;">Одоогийн үлдэгдэл</td>
                                            <td style="width: 13%;">Сард төлөгдөх төлбөр</td>
                                            <td style="width: 4%"></td>
                                        </tr>
                                        <tr>
                                            <td>№</td>
                                            <td><input class="form-control input-sm" v-auto type="text" v-model="user.credits.organization" data-target="#credit-input"
                                                       @selected="setDataCredit(user.credits,'#credit-input')" /></td>
                                            <td><input class="form-control input-sm" v-model="user.credits.loan_amount"   /></td>
                                            <td><input class="form-control input-sm" type="text"   v-model="user.credits.loan_usage"  /></td>
                                            <td><input class="form-control input-sm" type="text"   v-model="user.credits.loan_date"  /></td>
                                            <td><input class="form-control input-sm" type="number" v-model="user.credits.loan_interest"  placeholder="11"/></td>
                                            <td><input class="form-control input-sm" v-model="user.credits.loan_balance"   /></td>
                                            <td><input class="form-control input-sm" v-model="user.credits.monthly_pay"   /></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" @click="addCredit()"><i class="fa fa-plus-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-for="(credits, index) in user.active_loans">
                                            <td ><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td><input class="form-control input-sm" type="text"   v-model="credits.organization"  /></td>
                                            <td><input class="form-control input-sm" type="text"   v-model="credits.loan_amount"  /></td>
                                            <td><input class="form-control input-sm" type="text"   v-model="credits.loan_usage"  /></td>
                                            <td><input class="form-control input-sm" type="text"   v-model="credits.loan_date"  /></td>
                                            <td><input class="form-control input-sm" type="number" v-model="credits.loan_interest"   placeholder="11"/></td>
                                            <td><input class="form-control input-sm" v-model="credits.loan_balance"   /></td>
                                            <td><input class="form-control input-sm" v-model="credits.monthly_pay"   /></td>
                                            <td>
                                                <button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyCredit(credits)"></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>09 зээл хүсч бүрдүүлсэн материалууд</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 5%;">№</td>
                                            <td style="width: 65%;">Иргэний бүрдүүлэх материалууд</td>
                                            <td style="width: 30%;">Хуудасны тоо</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">1</td>
                                            <td style="width: 65%;">Иргэний үнэмлэх, 1% цээж зураг</td>
                                            <td style="width: 30%;"  @click="getFolderName('1')" >
                                                <dropzone v-model="user.doc_attach"
                                                          ref="profUpload1"
                                                          id="1"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">2</td>
                                            <td style="width: 65%;">Оршин суугаа хорооны тодорхойлолт</td>
                                            <td style="width: 30%;"  @click="getFolderName('2')" >
                                                <dropzone v-model="user.doc_attach" id="2"
                                                          ref="profUpload2"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">3</td>
                                            <td style="width: 65%;">Ажлын газар болон цалингийн тодорхойлолт</td>
                                            <td style="width: 30%;"  @click="getFolderName('3')" >
                                                <dropzone v-model="user.doc_attach" id="3"
                                                          ref="profUpload3"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">4</td>
                                            <td style="width: 65%;">Нийгмийн даатгалын дэвтэр</td>
                                            <td style="width: 30%;"  @click="getFolderName('4')" >
                                                <dropzone v-model="user.doc_attach" id="4"
                                                          ref="profUpload4"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">5</td>
                                            <td style="width: 65%;">Компантай бол дурэм, гэрчилгээ</td>
                                            <td style="width: 30%;"  @click="getFolderName('5')" >
                                                <dropzone v-model="user.doc_attach" id="5"
                                                          ref="profUpload5"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">6</td>
                                            <td style="width: 65%;">Компани, хувь хүний дансны хуулга /Сүүлийн нэг жилээр/</td>
                                            <td style="width: 30%;"  @click="getFolderName('6')" >
                                                <dropzone v-model="user.doc_attach" id="6"
                                                          ref="profUpload6"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">7</td>
                                            <td style="width: 65%;">Гэрлэлтийн лавлагаа</td>
                                            <td style="width: 30%;"  @click="getFolderName('7')" >
                                                <dropzone v-model="user.doc_attach" id="7"
                                                          ref="profUpload7"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">8</td>
                                            <td style="width: 65%;">Бусад банк болон ББСБ-аас авсан төлөгдөөгүй зээлийн өрийн үлдэгдэлтэй бол зээлийн гэрээ, дансны хуулга, төлбөр төлсөн баримт</td>
                                            <td style="width: 30%;"  @click="getFolderName('8')" >
                                                <dropzone
                                                          v-model="user.doc_attach" id="8"
                                                          ref="profUpload8"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">9</td>
                                            <td style="width: 65%;">Бусад холбогдох бичиг баримт</td>
                                            <td style="width: 30%;" @click="getFolderName('9')" >
                                                <dropzone
                                                          id="9"
                                                          ref="profUpload9"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-sending="onFileChange"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  colspan="3" style="width: 100%;">
                                                <div style="display: block; float: left; width: 20%; " v-for="(advertisement, index) in advertisements">
                                                    <input style="margin-left: 5px" class="" type="checkbox" v-bind:value="{advertisement}" v-model="adv" />
                                                    <label style="padding-right: 5px">{{advertisement}}</label>
                                                </div>
                                            </td>
                                        </tr>
                                       </tbody>
                                    </table>
                                    <p class="center">ДЭЭРХ МЭДЭЭЛЛИЙГ ҮНЭН ЗӨВ БОЛОХЫГ БАТАЛСАН /Гарын үсэг/ /......................................................................................../</p>
                                    <p class="center">ХЯНАЖ АВСАН АЖИЛТАН: /Гарын үсэг/ /............................................................................................../</p>
                                    <div class="box-footer">
                                        <div class="btn-group">
                                            <a @click="back()" class="btn btn-sm btn-danger">Буцах</a>
                                        </div>
                                        <div v-if="user.mode==false" class="btn-group pull-right">
                                            <button type="button" class="btn btn-sm btn-success" @click="save()">Хадгалах</button>
                                        </div>
                                        <div v-else-if="user.mode==true" class="btn-group pull-right">
                                            <button type="button" class="btn btn-sm btn-success" @click="update()">Засах</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!-- /.content -->
    </div>
</template>

<script>

    import MaskedInput from 'vue-masked-input'
    import Dropzone from 'vue2-dropzone'
//    import {VMoney} from 'v-money'
    export default {

        components: {
            MaskedInput,
            'masked-input': MaskedInput,
            Dropzone,
//            'money':VMoney
        },
        data()
        {
            return {
                user: {
                    filePaths:[],
                    filePath:'',
                    profilePath:'',
                    image: '',
                    imageTemp:'',
                    first_name: '',
                    name: '',
                    phone_number: '',
                    address: '',
                    email: '',
                    user_type: 'customer',
                    password: '',
                    register: null,
                    birth_day: null,
                    age: null,
                    confirm_password: '',
                    owner_type:'',
                    live_year:'',
                    bail_info:'',
                    profession:'',
                    mode:false,
                    workplaces: [],
                    works: {
                        id:null,
                        organization: null,
                        date_employment: null,
                        position: null,
                        activity: null,
                        address: null,
                        worker_count: null
                    },
                    family: [],
                    members: {
                        id:null,
                        name: null,
                        relation: null,
                        job: null,
                        register: null,
                        budged: null,
                        phone_number: null,
                    },
                    emergencies:[],
                    emergency: {
                        id:null,
                        name: null,
                        relation: null,
                        job: null,
                        register: null,
                        budged: null,
                        phone_number: null
                    },
                    active_loans: [],
                    credits: {
                        id:null,
                        organization: null,
                        loan_amount: null,
                        loan_usage: null,
                        loan_date: null,
                        loan_interest: null,
                        loan_balance: null,
                        monthly_pay: null
                    },
                    assets: [],
                    asset: {
                        id:null,
                        name: null,
                        asset: null
                    },
                    budgets: [],
                    budget: {
                        id:'',
                        name: '',
                        budget: ''
                    },
                    expenses: [],
                    expense: {
                        id:'',
                        name: null,
                        expense: null
                    },
                    requests: [],
                    request: {
                        pledge_type: null,
                        loan_term: null,
                        period_time: null,
                        payment_day: null,
                        loanable: null,
                        loanable_id: null,
                        expire_date: null,
                        description: null,
                    },
                    apartments:[],
                    apartment: {
                        commissioned: null,
                        address: null,
                        apart_meter: null,
                        room: null,
                        price:null
                    },
                    cars:[],
                    car: {
                        model: null,
                        color: null,
                        manufacture: null,
                        entry_date: null,
                        price:null
                    },
                    others:[],
                    other: {
                        name: null,
                        price: null,
                        description: null,
                    },
                    required_doc:{
                        document_name:null,
                    },
                    docs:[],
                    doc_attach:{
                        path:null,
                        file:null
                    }
                },
                loading:false,
                money:{
                    decimal:'.',
                    thousands:',',
                    precision:2,
                    masked:false
                },
                adv:[],
                profileUpload:'/api/cv/profileUpload',
                mediaUpload: '/api/cv/filesUpload',
                nextBudgetId:1,
                nextAssetId:1,
                nextExpenseId:1,
                nextEmergencyId:1,
                nextFamilyId:1,
                nextCreditId:1,
                nextWorkId:1,
                nextReqId:1,
                nextApartId:1,
                nextCarId:1,
                nextOtherId:1,
                owner_types:null,
                pledge_types:null,
                advertisements:null,
                folder:'',
                uid:''
            }
        },
        mounted()
        {
            this.fetchOwnerType();
            this.fetchLoanPledgeType();
            this.fetchAdvertisement();
        },

        created()
        {
            this.csrfHeaders = {
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            }
        },
        methods: {
            'template': function () {
                return `
                    <div class="dz-preview dz-file-preview vue-dropzone" >
                      <div class="dz-image" >
                          <img data-dz-thumbnail /></div>
                      <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                      <div class="dz-error-message"><span data-dz-errormessage></span></div>
                      <div class="dz-success-mark"><i class="fa fa-check"></i></div>
                      <div class="dz-error-mark"><i class="fa fa-close"></i></div>
                  </div>
                `;
            },
            ProfSuccess(file, response) {
                this.user.profilePath = response.tempProfPath;
                this.user.image = response.profPic;

            },
            getFolderName(name) {
                this.folder = name
            },
            onFileChange(file, xhr, formData) {
                formData.append('folder', this.folder);
                this.folder = ''
            },
            showSuccess(file, response) {
                this.user.filePath = response.tempPath;
                this.user.filePaths.push({
                    filePath: this.user.filePath
                });

            },
            onError(file, error) {
                swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
            },
            setRegister() {
                try {
                    var splits = this.user.register.match(/.{1,2}/g);
                    if (parseInt(splits[2]) > 12) {
                        var year = 2000 + parseInt(splits[1]);
                        var month = parseInt(splits[2]) - 20;
                        var birthDay = new Date(year, month - 1, parseInt(splits[3]) + 1);
                    }
                    else
                    {
                        var year = 1900 + parseInt(splits[1]);
                        var birthDay = new Date(year, parseInt(splits[2]) - 1, parseInt(splits[3]) + 1);
                    }
                    this.user.birth_day = birthDay.toISOString().substring(0, 10);
                    this.user.age = this.getAge(birthDay);
                    this.findByRegister(this.user.register);
                }
                catch (error) {

                }
            },
            getAge(d1) {
                var d2 = new Date();
                var diff = d2.getTime() - d1.getTime();
                return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
            },
            findByRegister($register){

                if ($register.length === 10 && ( $register[9]) != '_' )

                {

                    axios.get('/api/user/' + $register + '/find').then(response => {

                        if((response.data.user) !== null)

                        {

                            this.user = response.data.user;
                            this.user.imageTemp = response.data.user.image;
                            this.user.works = response.data.user.workplaces;
                            this.user.members = response.data.user.family;
                            this.user.emergency = response.data.user.emergencies;
                            this.user.budget = response.data.user.budgets;
                            this.user.asset = response.data.user.assets;
                            this.user.expense = response.data.user.expenses;
                            this.user.credits = response.data.user.active_loans;
                            this.user.requests = response.data.user.request;
                            this.user.apartments = response.data.user.apartment;
                            console.log(response.data.user.apartment);
                            this.user.cars = response.data.user.car;
                            this.user.others = response.data.user.other;
                            this.uid = response.data.user.id;
                            this.user.mode = true;
                            Vue.delete(this.user, 'created_at');
                            Vue.delete(this.user, 'updated_at');
                            this.owner_type = response.data.owner_type;
                            this.relations = response.data.relations;
                            this.loading = true;
                        }

                    })

                }
                else
                {
                    console.log('Шинэ хэрэглэгч');
                }
            },
            update()
            {

              axios.patch('/api/cv/'+this.uid,this.user).then(response=> {
                  if (response.data.result) {
                      var self = this;
                      swal({
                          title: 'Ажилттай!',
                          text: 'Хэрэглэгч засагдлаа',
                          type: 'success'
                      },function () {
                          self.reset();
                      })
                  }
              }).catch(function (response) {
                  swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
              })
            },
            save()
            {
                axios.post('/api/cv', this.user).then(response => {
                    if (response.data.result) {
                        var self = this;
                        swal({
                            title: 'Ажилттай!',
                            text: 'Хэрэглэгч бүртгэгдлээ',
                            type: 'success'
                        }, function () {
                            self.reset();
                        })
                    }
                }).catch(function (response) {
                    swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
                })
            },

            back()
            {
                this.$router.push('/users')
            },

            reset() {
                this.$refs.profUpload.removeAllFiles();
                this.$refs.profUpload1.removeAllFiles();
                this.$refs.profUpload2.removeAllFiles();
                this.$refs.profUpload3.removeAllFiles();
                this.$refs.profUpload4.removeAllFiles();
                this.$refs.profUpload5.removeAllFiles();
                this.$refs.profUpload6.removeAllFiles();
                this.$refs.profUpload7.removeAllFiles();
                this.$refs.profUpload8.removeAllFiles();
                this.$refs.profUpload9.removeAllFiles();

                        this.mediaUpload= '/api/cv/filesUpload';
                        this.nextBudgetId = 1;
                        this.nextAssetId = 1;
                        this.nextExpenseId = 1;
                        this.nextEmergencyId = 1;
                        this.nextFamilyId = 1;
                        this.nextCreditId = 1;
                        this.nextWorkId = 1;
                        this.owner_types = null;
//                        this.pledge_types=null,
                        this.advertisements = null;
                        this.user = {
                            image: '',
                            first_name: '',
                            name: '',
                            phone_number: '',
                            address: '',
                            email: '',
                            user_type: 'customer',
                            password: '',
                            register: null,
                            birth_day: null,
                            age: null,
                            confirm_password: '',
                            workplaces: [],
                            mode:false,
                            works: {
                                id:null,
                                organization: null,
                                date_employment: null,
                                position: null,
                                activity: null,
                                address: null,
                                worker_count: null
                            },
                            family: [],
                            members: {
                                id:null,
                                name: null,
                                relation: null,
                                job: null,
                                register: null,
                                budged: null,
                                phone_number: null,
                            },
                            emergencies:[],
                            emergency: {
                                id:null,
                                name: null,
                                relation: null,
                                job: null,
                                register: null,
                                budged: null,
                                phone_number: null
                            },
                            credits:[],
                            credit: {
                                id:null,
                                organization: null,
                                loan_amount: null,
                                loan_usage: null,
                                loan_date: null,
                                loan_interest: null,
                                loan_balance: null,
                                monthly_pay: null
                            },
                            assets: [],
                            asset: {
                                name: null,
                                asset: null
                            },
                            budgets: [],
                            budget: {
                                id:'',
                                name: '',
                                budget: ''
                            },
                            expenses: [],
                            expense: {
                                id:'',
                                name: null,
                                expense: null
                            },
                            request: {
                                pledge_type: null,
                                loanable: null,
                                loanable_id: null,
                                loan_term: null,
                                period_time: null,
                                payment_day: null,
                                expire_date: null,
                                description:  null
                            },
                            apartment: {
                                commissioned: null,
                                address: null,
                                apart_meter: null,
                                room: null,
                                price:null
                            },
                            car: {
                                model: null,
                                color: null,
                                manufacture: null,
                                entry_date: null,
                                price:null
                            },
                            other: {
                                name: null,
                                price:null,
                                description: null,
                            },
                            required_doc:{
                                document_name:null,
                            },
                            docs:[],
                            doc_attach:{
                                path:null,
                                file:null
                            }
                        };
                        this.loading = true;
            },

            setDataCredit(credits,element)
            {
                credits.organization=$(element).val();
            },
            setDataBudget(budget, element)
            {
                budget.name = $(element).val();
            },
            setDataAsset(asset, element)
            {
                asset.name = $(element).val();
            },
            setDataExpense(expense, element)
            {
                expense.name = $(element).val();
            },
            setDataMember(member, element)
            {
                member.name = $(element).val();
            },
            setDataWork(works, element)
            {
                works.organization = $(element).val();
            },
            setDataEmergency(emergency, element)
            {
                emergency.name = $(element).val();
            },
            destroyCredit(credits)
            {
                try {
                    this.user.credits.splice(this.user.credits.indexOf(credits), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyBudget(budget)
            {
                try {
                    this.user.budgets.splice(this.user.budgets.indexOf(budget), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyApartment(apartment)
            {
                try
                {
                    this.user.apartments.splice(this.user.apartments.indexOf(apartment), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyOther(other)
            {
                try {
                    this.user.others.splice(this.user.others.indexOf(other), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyCar(car)
            {
                try {
                    this.user.cars.splice(this.user.cars.indexOf(car), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyRequest(request)
            {
                try {
                    this.user.requests.splice(this.user.requests.indexOf(request), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyWork(works)
            {
                try {
                    this.user.workplaces.splice(this.user.workplaces.indexOf(works), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyMember(member)
            {
                try {
                    this.user.family.splice(this.user.family.indexOf(member), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyEmergency(emergency)
            {
                try {
                    this.user.emergencies.splice(this.user.emergencies.indexOf(emergency), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyAsset(asset)
            {
                try {
                    this.user.assets.splice(this.user.assets.indexOf(asset), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            destroyExpense(expense)
            {
                try {
                    this.user.expenses.splice(this.user.expenses.indexOf(expense), 1);
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            addWork()
            {
                try
                {
                    var self = this;
                    this.loading = true;
                    this.user.workplaces.push({
                        id: this.nextWorkId++,
                        organization: this.user.works.organization,
                        date_employment: this.user.works.date_employment,
                        position: this.user.works.position,
                        activity: this.user.works.activity,
                        address: this.user.works.address,
                        worker_count: this.user.works.worker_count
                    });
                    this.loading=false;
                }
                catch(error)
                {
                    console.log(error);
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            addApartment()
            {
                this.$validator.validateAll();
                if(!this.errors.any())
                {
                    try {
                        var self = this;
                        this.loading = true;
                        this.user.apartments.push({
                            id: this.nextApartId++,
                            commissioned: this.user.apartment.commissioned,
                            address: this.user.apartment.address,
                            apart_meter: this.user.apartment.apart_meter,
                            room: this.user.apartment.room,
                            price: this.user.apartment.price
                        });
                        this.loading = true;
                    }
                    catch (error) {
                        console.log(error);
                        swal({
                            title: 'Уучлаарай',
                            text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                            type: 'error'
                        }, function () {
                            self.loading = false;
                        });
                    }
                }
            },
            addOther()
            {
                this.$validator.validateAll();
                if(!this.errors.any()) {
                    try {
                        var self = this;
                        this.loading = true;
                        this.user.others.push({
                            id: this.nextOtherId++,
                            name: this.user.other.name,
                            price: this.user.other.price,
                            description: this.user.other.description

                        });
                        this.loading = true;
                    }
                    catch (error) {
                        console.log(error);
                        swal({
                            title: 'Уучлаарай',
                            text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                            type: 'error'
                        }, function () {
                            self.loading = false;
                        });
                    }
                }
            },
            addCar()
            {
                this.$validator.validateAll();
                if(!this.errors.any()) {
                    try {
                        var self = this;
                        this.loading = true;
                        this.user.cars.push({
                            id: this.nextCarId++,
                            model: this.user.car.model,
                            color: this.user.car.model,
                            manufacture: this.user.car.manufacture,
                            entry_date: this.user.car.entry_date,
                            price: this.user.car.price
                        });
                        this.loading = true;
                    }
                    catch (error) {
                        console.log(error);
                        swal({
                            title: 'Уучлаарай',
                            text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                            type: 'error'
                        }, function () {
                            self.loading = false;
                        });
                    }
                }
            },
            addRequest()
            {
                this.$validator.validateAll();
                if(!this.errors.any()) {
                    try {
                        var self = this;
                        this.loading = true;
                        this.user.requests.push({
                            id: this.nextReqId++,
                            pledge_type: this.user.request.pledge_type,
                            loan_term: this.user.request.loan_term,
                            period_time: this.user.request.period_time,
                            payment_day: this.user.request.payment_day,
                            expire_date: this.user.request.expire_date,
                            description: this.user.request.description
                        });
                        this.loading = true;
                    }
                    catch (error) {
                        console.log(error);
                        swal({
                            title: 'Уучлаарай',
                            text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                            type: 'error'
                        }, function () {
                            self.loading = false;
                        });
                    }
                }
            },
            addMember()
            {
                try
                {
                    var self = this;
                    this.loading = true;
                    this.user.family.push({
                        id: this.nextFamilyId++,
                        name: this.user.members.name,
                        relation: this.user.members.relation,
                        job: this.user.members.job,
                        register: this.user.members.register,
                        budged: this.user.members.budged,
                        phone_number: this.user.members.phone_number
                    });
                    this.loading=false;
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            addEmergency()
            {
                try {
                    var self = this;
                    this.loading = true;
                    this.user.emergencies.push({
                        id: this.nextEmergencyId++,
                        name: this.user.emergency.name,
                        relation: this.user.emergency.relation,
                        job: this.user.emergency.job,
                        register: this.user.emergency.register,
                        budged: this.user.emergency.budged,
                        phone_number: this.user.emergency.phone_number

                    });
                    this.loading=false;
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            addBudget()
            {
                try {
                    var self = this;
                    this.loading = true;
                    this.user.budgets.push({
                        id: this.nextBudgetId++,
                        name: this.user.budget.name,
                        budget: this.user.budget.budget
                    });
                    this.loading=false;
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }
            },
            addAsset()
            {
                try {
                    var self = this;
                    this.loading = true;
                    this.user.assets.push({
                        id: this.nextBudgetId++,
                        name: this.user.asset.name,
                        asset: this.user.asset.asset
                    });
                    this.loading=false;
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }

            },
            addExpense()
            {
                try {
                    var self = this;
                    this.loading = true;
                    this.user.expenses.push({
                        id: this.nextBudgetId++,
                        name: this.user.expense.name,
                        expense: this.user.expense.expense
                    });
                    this.loading=false;
                }
                catch(error)
                {
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }

            },
            addCredit()
            {
                try
                {
                    var self = this;
                    this.loading = true;
                    this.user.active_loans.push({
                        id: this.nextCreditId++,
                        organization: this.user.credits.organization,
                        loan_amount: this.user.credits.loan_amount,
                        loan_usage: this.user.credits.loan_usage,
                        loan_date: this.user.credits.loan_date,
                        loan_interest: this.user.credits.loan_interest,
                        loan_balance: this.user.credits.loan_balance,
                        monthly_pay: this.user.credits.monthly_pay
                    });
                    this.loading=false;
                }
                catch(error)
                {
                    console.log(error);
                    swal({
                        title: 'Уучлаарай',
                        text: 'Амжилтгүй боллоо! Дахин оролдоно уу',
                        type: 'error'
                    }, function(){
                        self.loading = false;
                    });
                }

            },

            fetchOwnerType()
            {
                axios.get('/api/owner_types' ).then(response=>{
                    this.owner_types = response.data.owner_types;
                    this.loading=false;
                }).catch(errors=>{
                    this.loading = false;
                })
            },
            fetchLoanPledgeType()
            {
                axios.get('/api/pledge_types' ).then(response=>{
                    this.pledge_types = response.data.pledge_types;
                    this.loading=false;
                }).catch(errors=>{
                    this.loading = false;
                })
            },

            fetchAdvertisement()
            {
                axios.get('/api/advertisements' ).then(response=>{
                    this.advertisements = response.data.advertisements;
                    this.loading=false;
                }).catch(errors=>{
                    this.loading = false;
                })
            }
        }

    }
</script>
<style>
    .vue-dropzone {
        min-height:10px;
        padding: 0;
    }
</style>