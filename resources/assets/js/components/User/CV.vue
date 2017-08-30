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
        <section class="content">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Анкет
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-horizontal">
                                <div class="cv">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Зураг</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control input-sm" @change="onFileChange" />
                                        </div>
                                        <!--<div class="col-sm-2 col-sm-offset-2 cv-picture" v-if="user.image != ''">-->
                                            <!--<img :src="user.image" class="profile-user-img img-responsive " style="margin: 10px 0" />-->
                                        <!--</div>-->
                                    </div>

                                        <img :src="user.image" class="cv-picture" />

                                    <h1 style="margin-top: 130px">01 ЕРӨНХИЙ МЭДЭЭЛЭЛ</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 15%;">Овог нэр:</td>
                                            <td style="width: 35%;"> <input type="text" class="form-control input-sm" v-model="user.first_name" /><br><input type="text" class="form-control input-sm" v-model="user.name" /></td>
                                            <td style="width: 20%;">Регистерийн дугаар:</td>
                                            <td style="width: 30%;"><masked-input v-model="user.register" mask="AA11111111" placeholder="АА00000000" @input="setRegister" class="form-control input-sm"></masked-input></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 15%;">Нас:</td>
                                            <td style="width: 35%;"><input type="number" class="form-control input-sm" v-model="user.age" readonly="readonly" /></td>
                                            <td style="width: 20%;">Утасны дугаар:</td>
                                            <td style="width: 30%;"><masked-input v-model="user.phone_number" mask="\+ (976) 1111-1111" placeholder="1111-1111" class="form-control input-sm"></masked-input></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 15%;">Цахим шуудан:</td>
                                            <td style="width: 35%;"><input placeholder="simple@simple.com" type="text" class="form-control input-sm" v-model="user.email" /></td>
                                            <td style="width: 20%;">Мэргэжил:</td>
                                            <td style="width: 30%;"><input type="text" class="form-control input-sm" v-model="user.profession"/></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="cv-table cv-lg cv-top-border-none" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 30%;">Одоо амьдарч буй гэрийн хаяг:</td>
                                            <td style="width: 70%;"><textarea class="form-control input-sm" rows="2" v-model="user.address"></textarea></td>
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
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.lyears"  type="number" placeholder="111"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Байр нь зээлийн барьцаанд байгаа бол дэлгэрэнгүй бөглөнө үү:</td>
                                            <td style="width: 50%;">
                                                <input class="form-control input-sm" v-model="user.bail_info" type="text"/>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>02 ЗЭЭЛИЙН ХҮСЭЛТ</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                        <tr>
                                            <td colspan="2" style="width: 100%;">
                                                <select class="form-control input-sm" v-model="user.request.pledge_type" >
                                                    <option v-for="(pledge_type, index) in pledge_types" :value="index">{{pledge_type}}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Хүсэж буй зээлийн хэмжээ:</td>
                                            <td style="width: 70%;"><input v-model="user.request.loan_term"   /></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Зээлийн эргэн төлөх хугацаа:</td>
                                            <td style="width: 70%;"><input class="form-control input-sm" v-model="user.request.expire_date" type="text" /></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Сар бүрийн эргэн төлөлт хийх өдөр:</td>
                                            <td style="width: 70%;"><input class="form-control input-sm" v-model="user.request.payment_day" type="number"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Зээлийн хугацаа дуусах огноо:</td>
                                            <td style="width: 70%;"><input class="form-control input-sm" v-pick="user.request.period_time" v-model="user.request.period_time" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">Нэмэл тайлбар, тэмдэглэгээ:</td>
                                            <td style="width: 70%;"><input class="form-control input-sm" v-model="user.request.description" type="text"/></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>03 БАРЬЦАА ХӨРӨНГИЙН МЭДЭЭЛЭЛ</h1>
                                    <table class="cv-table cv-md" style=" ;" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 100%;" colspan="2">Байр барьцаалах бол 4%</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Ашиглалтанд орсон огноо:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.bail_apart.commissioned" type="text" v-pick="user.bail_apart.commissioned"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Хаяг:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.bail_apart.address" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Хэдэн М2::<input class="form-control input-sm" v-model="user.bail_apart.apart_meter" type="number"  placeholder="111"/></td>
                                            <td style="width: 50%;">Хэдэн өрөө: М2:<input class="form-control input-sm" v-model="user.bail_apart.room" type="number"  placeholder="11"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Зах зээлийн үнэ:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.bail_apart.price" /></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="cv-table cv-md cv-md-margin-left">
                                        <tbody>
                                        <tr>
                                            <td colspan="2">Машин барьцаалах бол 3.5-4%</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Марк/өнгө:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.bail_car.model" type="text"/><input class="form-control input-sm" v-model="user.bail_car.color" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Үйлдвэрлэсэн огноо:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.bail_car.manufacture" v-pick="user.bail_car.manufacture" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Орж ирсэн огноо:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm" v-model="user.bail_car.entry_date" v-pick="user.bail_car.entry_date" type="text"/></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;">Зах зээлийн үнэ:</td>
                                            <td style="width: 50%;"><input class="form-control input-sm"  v-model="user.bail_car.price"   /></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="cv-table cv-lg cv-table-margin-top" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 23.8%;">Бусад</td>
                                            <td style="width: 75%;"><input class="form-control input-sm" v-model="user.bail_other.name" type="text"/></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="cv-table cv-lg cv-top-border-none">
                                        <tbody>
                                        <tr>
                                            <td style="width: 23.8%;">Зах зээлийн үнэ:</td>
                                            <td style="width: 10%;"><input class="form-control input-sm" v-model="user.bail_other.price"   /></td>
                                            <td style="width: 65%;">Тайлбар:<input class="form-control input-sm" v-model="user.bail_other.description" type="text"/> </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h1>04 АЖЛЫН ГАЗРЫН МЭДЭЭЛЭЛ</h1>
                                    <table class="cv-table cv-lg" >
                                        <tbody>
                                        <tr>
                                            <td style="width: 18%;">Байгууллагын нэр</td>
                                            <td style="width: 16%;">Ажилласан огноо</td>
                                            <td style="width: 16%;">Албан тушаал</td>
                                            <td style="width: 16%;">Байгууллагын үйл ажиллагааны чиглэл</td>
                                            <td style="width: 16%;">Хаяг</td>
                                            <td style="width: 16%;">Ажилчдын тоо</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 18%;"><input class="form-control input-sm" type="text" v-model="user.workplace.organization"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm"  type="text" v-model="user.workplace.date_employment" v-pick="user.workplace.date_employment"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm"  type="text" v-model="user.workplace.position"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text" v-model="user.workplace.activity"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="text" v-model="user.workplace.address"  /></td>
                                            <td style="width: 16%;"><input class="form-control input-sm" type="number" v-model="user.workplace.worker_count"  placeholder="1111" /></td>
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
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="user.emergency.name"  /></td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="user.emergency.relation"  /></td>
                                            <td style="width: 15%;"><input class="form-control input-sm" type="text" v-model="user.emergency.job"  /></td>
                                            <td style="width: 15%;"><masked-input mask="AA11111111" placeholder="АА00000000" class="form-control input-sm" type="text" v-model="user.emergency.register"></masked-input></td>
                                            <td style="width: 15%;"><input  v-model="user.emergency.budged"   /></td>
                                            <td style="width: 15%;"><masked-input class="form-control input-sm" type="text" v-model="user.emergency.phone_number"  mask="\+ (976) 1111-1111" placeholder="1111-1111"></masked-input></td>
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
                                            <td><span class="text text-black">#</span></td>
                                            <td>
                                                <input type="text" class="form-control input-sm" v-auto data-type="budged"
                                                       v-model="user.budget.name" data-target="#budget-input" v-on:selected="setDataBudget(user.budget, '#budget-input')">
                                                <input  type="hidden" v-model="user.budget.name" id="budget-input" />
                                            </td>
                                            <td><input v-model="user.budget.budget"   /></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" @click="addBudget()"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                        <tr v-for="(b, index) in user.budgets">

                                            <td><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td>
                                                <input type="text" class="form-control input-sm" v-auto data-type="budget" :data-target="'#budget-input' + b.id" :value="b.name" v-on:selected="setDataBudget(b, '#budget-input' + b.id)">
                                                <input type="hidden" v-model="b.name" :id="'budget-input' + b.id" />
                                            </td>
                                            <td><input  v-model="b.budget"   /></td>
                                            <td>
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
                                            <td><span class="text text-black">#</span></td>
                                            <td>
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="user.expense" v-model="user.expense.name" data-target="#expense-input" v-on:selected="setDataExpense(user.expense, '#expense-input')">
                                                <input type="hidden" v-model="user.expense.name" id="expense-input" />
                                            </td>
                                            <td><input  v-model="user.expense.expense"   /></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" @click="addExpense()"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                        <tr v-for="(b, index) in user.expenses">
                                            <td><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td>
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="user.expense" :data-target="'#expense-input' + b.id" :value="b.name" v-on:selected="setDataExpense(b, '#expense-input' + b.id)">
                                                <input type="hidden" v-model="b.name" :id="'expense-input' + b.id" />
                                            </td>
                                            <td><input v-model="b.expense"   /></td>
                                            <td>
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
                                            <td><span class="text text-black">#</span></td>
                                            <td>
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="user.asset" v-model="user.asset.name" data-target="#asset-input" v-on:selected="setDataAsset(user.asset, '#asset-input')">
                                                <input type="hidden" v-model="user.asset.name" id="asset-input" />
                                            </td>
                                            <td><input v-model="user.asset.asset"   /></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" @click="addAsset()"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                        <tr v-for="(b, index) in user.assets">
                                            <td><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td>
                                                <input type="text" class="form-control input-sm input-sm" v-auto data-type="asset" :data-target="'#asset-input' + b.id" :value="b.name" v-on:selected="setDataAsset(b, '#asset-input' + b.id)">
                                                <input type="hidden" v-model="b.name" :id="'asset-input' + b.id" />
                                            </td>
                                            <td><input  v-model="b.asset"   /></td>
                                            <td>
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
                                            <td><input class="form-control input-sm" v-auto type="text" v-model="user.credit.organization" data-target="#credit-input" @selected="setDataCredit(user.credit,'#credit-input')" /></td>
                                            <td><input v-model="user.credit.loan_amount"   /></td>
                                            <td><input class="form-control input-sm" type="text" v-model="user.credit.loan_usage"  /></td>
                                            <td><input class="form-control input-sm" type="text" v-model="user.credit.loan_date"  /></td>
                                            <td><input class="form-control input-sm" type="number" v-model="user.credit.loan_interest"   placeholder="11"/></td>
                                            <td><input v-model="user.credit.loan_balance"   /></td>
                                            <td><input v-model="user.credit.monthly_pay"   /></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" @click="addCredit()"><i class="fa fa-plus-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-for="(credit, index) in user.credits">
                                            <td ><span class="text text-black">{{ index + 1 }}</span></td>
                                            <td><input class="form-control input-sm" type="text" v-model="user.credit.organization"  /></td>
                                            <td><input v-model="user.credit.loan_amount"   /></td>
                                            <td><input class="form-control input-sm" type="text" v-model="user.credit.loan_usage"  /></td>
                                            <td><input class="form-control input-sm" type="text" v-model="user.credit.loan_date"  /></td>
                                            <td><input class="form-control input-sm" type="number" v-model="user.credit.loan_interest"   placeholder="11"/></td>
                                            <td><input v-model="user.credit.loan_balance"   /></td>
                                            <td><input v-model="user.credit.monthly_pay"   /></td>
                                            <td>
                                                <button class="fa fa-trash-o btn btn-sm btn-danger" @click="destroyCredit(credit)"></button>
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
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="1"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">2</td>
                                            <td style="width: 65%;">Оршин суугаа хорооны тодорхойлолт</td>
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="2"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">3</td>
                                            <td style="width: 65%;">Ажлын газар болон цалингийн тодорхойлолт</td>
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="3"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">4</td>
                                            <td style="width: 65%;">Нийгмийн даатгалын дэвтэр</td>
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="4"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">5</td>
                                            <td style="width: 65%;">Компантай бол дурэм, гэрчилгээ</td>
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="5"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">6</td>
                                            <td style="width: 65%;">Компани, хувь хүний дансны хуулга /Сүүлийн нэг жилээр/</td>
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="6"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">7</td>
                                            <td style="width: 65%;">Гэрлэлтийн лавлагаа</td>
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="7"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">8</td>
                                            <td style="width: 65%;">Бусад банк болон ББСБ-аас авсан төлөгдөөгүй зээлийн өрийн үлдэгдэлтэй бол зээлийн гэрээ, дансны хуулга, төлбөр төлсөн баримт</td>
                                            <td style="width: 30%;">
                                                <dropzone v-model="user.doc_attach" id="8"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
                                                          v-on:vdropzone-success="showSuccess"
                                                          v-on:vdropzone-error="onError">
                                                </dropzone>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;">9</td>
                                            <td style="width: 65%;">Бусад холбогдох бичиг баримт</td>
                                            <td style="width: 30%;">&nbsp;
                                                <dropzone v-model="user.doc_attach" id="9"
                                                          class="margin-bottom-10"
                                                          :headers='csrfHeaders'
                                                          :url="mediaUpload"
                                                          :use-font-awesome="true"
                                                          :thumbnail-height="100"
                                                          :thumbnail-width="100"
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
                                        <div class="btn-group pull-right">
                                            <button type="button" class="btn btn-sm btn-success" @click="save()">Хадгалах</button>
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
                money:{
                    decimal:'.',
                    thousands:',',
                    precision:2,
                    masked:false
                },
                adv:[],
                csrfHeaders: null,
                mediaUpload: '/api/cv/imageUpload',
                nextBudgetId:1,
                nextAssetId:1,
                nextExpenseId:1,
                nextEmergencyId:1,
                nextFamilyId:1,
                nextCreditId:1,
                owner_types:null,
                pledge_types:null,
                advertisements:null,
                user: {
                    filePaths:[],
                    filePath:'',
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
                    owner_type:'',
                    workplace: {
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
                    request: {
                        loanable: null,
                        loanable_id: null,
                        loan_term: null,
                        period_time: null,
                        payment_day: null,
                        expire_date: null,
                        pledge_type:null,
                        description:null
                    },
                    bail_apart: {
                        commissioned: null,
                        address: null,
                        apart_meter: null,
                        room: null,
                        price:null
                    },
                    bail_car: {
                        model: null,
                        color: null,
                        manufacture: null,
                        entry_date: null,
                        price:null
                    },
                    bail_other: {
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
                },loading: true,
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
            showSuccess(file,response) {
                    console.log(file);
                this.user.filePath= response.tempPath;
                    this.user.filePaths.push({
                        filePath: this.user.filePath
                    });
                    this.reset();
            },
            onError (file, error) {
                swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
            },
            setRegister()
            {
                try {
                    var splits = this.user.register.match(/.{1,2}/g);
                    if(parseInt(splits[2]) > 12)
                    {
                        var year = 2000 + parseInt(splits[1]);
                        var month = parseInt(splits[2]) - 20;
                        var birthDay = new Date(year, month - 1, parseInt(splits[3]) + 1);
                    }
                    else
                    {
                        var year = 1900 + parseInt(splits[1]);
                        var birthDay = new Date(year, parseInt(splits[2]) - 1 , parseInt(splits[3]) + 1);
                    }
                    this.user.birth_day = birthDay.toISOString().substring(0, 10);
                    this.user.age = this.getAge(birthDay);
                }
                catch(error)
                {

                }
            },

            getAge(d1){
                var d2 = new Date();
                var diff = d2.getTime() - d1.getTime();
                return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
            },

            save()
            {
                axios.post('/api/cv', this.user).then(response => {
                    if(response.data.result)
                    {
                        var self = this;
                        swal({
                            title: 'Ажилттай!',
                            text: 'Хэрэглэгч бүртгэгдлээ',
                            type: 'success'
                        }, function(){
                            self.reset();
                        })
                    }
                }).catch(function(response){
                    swal('Уучлаарай!', 'Амжилтгүй боллоо!', 'error')
                })
            },

            back()
            {
                this.$router.push('/users')
            },

            reset()
            {

                return {
                    csrfHeaders: null,
                    mediaUpload: '/api/cv/imageUpload',
                    nextBudgetId:1,
                    nextAssetId:1,
                    nextExpenseId:1,
                    nextEmergencyId:1,
                    nextFamilyId:1,
                    nextCreditId:1,
                    owner_types:null,
                    pledge_types:null,
                    advertisements:null,
                    user: {
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
                        workplace: {
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
                        request: {
                            pledge_type:null,
                            loanable: null,
                            loanable_id: null,
                            loan_term: null,
                            period_time: null,
                            payment_day: null,
                            expire_date: null,
                            description:  null
                        },
                        bail_apart: {
                            commissioned: null,
                            address: null,
                            apart_meter: null,
                            room: null,
                            price:null
                        },
                        bail_car: {
                            model: null,
                            color: null,
                            manufacture: null,
                            entry_date: null,
                            price:null
                        },
                        bail_other: {
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
                    },loading: true,
                }
            },

            onFileChange(e)
            {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.user.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage: function (e) {
                this.user.image = '';
            },
            setDataCredit(credit,element)
            {
                credit.organization=$(element).val();
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
            setDataEmergency(emergency, element)
            {
                emergency.name = $(element).val();
            },
            destroyCredit(credit)
            {
                try {
                    this.user.credits.splice(this.user.credits.indexOf(credit), 1);
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
                try {
                    var self = this;
                    this.loading = true;
                    this.user.credits.push({
                        id: this.nextCreditId++,
                        organization: this.user.credit.organization,
                        loan_amount: this.user.credit.loan_amount,
                        loan_usage: this.user.credit.loan_usage,
                        loan_date: this.user.credit.loan_date,
                        loan_interest: this.user.credit.loan_interest,
                        loan_balance:this.user.credit.loan_balance,
                        monthly_pay: this.user.credit.monthly_pay
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