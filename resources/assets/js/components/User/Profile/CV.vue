<template>
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
                        <div class="cv" v-if="user">
                            <img v-if="user.image" :src="user.image" class="cv-picture" />
                            <h1 style="margin-top: 130px">01 ЕРӨНХИЙ МЭДЭЭЛЭЛ</h1>
                            <table class="cv-table cv-lg" >
                                <tbody>
                                <tr>
                                    <td style="width: 15%;">Овог нэр:</td>
                                    <td style="width: 35%;">{{ user.first_name }} {{ user.name }}</td>
                                    <td style="width: 20%;">Регистерийн дугаар:</td>
                                    <td style="width: 30%;">{{ user.register }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Нас:</td>
                                    <td style="width: 35%;">{{ user.age }}</td>
                                    <td style="width: 20%;">Утасны дугаар:</td>
                                    <td style="width: 30%;">{{ user.phone_number }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Цахим шуудан:</td>
                                    <td style="width: 35%;">{{ user.email }}</td>
                                    <td style="width: 20%;">Мэргэжил:</td>
                                    <td style="width: 30%;">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="cv-table cv-lg cv-top-border-none" >
                                <tbody>
                                <tr>
                                    <td style="width: 30%;">Одоо амьдарч буй гэрийн хаяг:</td>
                                    <td style="width: 70%;">{{ user.address }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%;">Одоо амьдарч буй байр нь орон сууц, хашаа байшин, хашаа гэр:</td>
                                    <td style="width: 70%;">
                                        <span v-for="(type, index) in owner_type" v-html=" index == user.owner_type ? '<u>' + type + '</u>' : type "></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="cv-table cv-lg cv-top-border-none" >
                                <tbody>
                                <tr>
                                    <td style="width: 50%;">Тухайн хаяг дээр амьдарсан жил:</td>
                                    <td style="width: 50%;">{{ user.live_year }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">Байр нь зээлийн барьцаанд байгаа бол дэлгэрэнгүй бөглөнө үү:</td>
                                    <td style="width: 50%;">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                            <!--<h1>02 ЗЭЭЛИЙН ХҮСЭЛТ</h1>-->
                            <!--<table class="cv-table cv-lg" >-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td colspan="2" style="width: 100%;">-->
                                        <!--<span>А. Автомашин</span>-->
                                        <!--<span>Б. Байр </span>-->
                                        <!--<span>В. Граш </span>-->
                                        <!--<span>Г. Автомашин, байр хосолсон </span>-->
                                        <!--<span>Д. Барилга </span>-->
                                        <!--<span>Е. Үйлчилгээний талбай</span>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 30%;">Хүсэж буй зээлийн хэмжээ:</td>-->
                                    <!--<td style="width: 70%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 30%;">Зээлийн эргэн төлөх хугацаа:</td>-->
                                    <!--<td style="width: 70%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 30%;">Сар бүрийн эргэн төлөлт хийх өдөр:</td>-->
                                    <!--<td style="width: 70%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                            <!--<h1>03 БАРЬЦАА ХӨРӨНГИЙН МЭДЭЭЛЭЛ</h1>-->
                            <!--<table class="cv-table cv-md" style=" ;" >-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td style="width: 100%;" colspan="2">Байр барьцаалах бол 4%</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Ашиглалтанд орсон огноо:</td>-->
                                    <!--<td style="width: 50%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Хаяг:</td>-->
                                    <!--<td style="width: 50%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Хэдэн М2::</td>-->
                                    <!--<td style="width: 50%;">Хэдэн өрөө: М2:</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Зах зээлийн үнэ:</td>-->
                                    <!--<td style="width: 50%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                            <!--<table class="cv-table cv-md cv-md-margin-left">-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td colspan="2">Машин барьцаалах бол 3.5-4%</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Марк/өнгө:</td>-->
                                    <!--<td style="width: 50%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Үйлдвэрлэсэн огноо:</td>-->
                                    <!--<td style="width: 50%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Орж ирсэн огноо:</td>-->
                                    <!--<td style="width: 50%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 50%;">Зах зээлийн үнэ:</td>-->
                                    <!--<td style="width: 50%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                            <!--<table class="cv-table cv-lg cv-table-margin-top" >-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td style="width: 23.8%;">Бусад</td>-->
                                    <!--<td style="width: 75%;"></td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                            <!--<table class="cv-table cv-lg cv-top-border-none">-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td style="width: 23.8%;">Зах зээлийн үнэ:</td>-->
                                    <!--<td style="width: 10%;"></td>-->
                                    <!--<td style="width: 65%;">Тайлбар: </td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                            <h1>02 АЖЛЫН ГАЗРЫН МЭДЭЭЛЭЛ</h1>
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
                                <tr v-for="workplace in user.workplaces">
                                    <td style="width: 18%;">{{ workplace.organization }}</td>
                                    <td style="width: 16%;">{{ workplace.date_employment }}</td>
                                    <td style="width: 16%;">{{ workplace.position }}</td>
                                    <td style="width: 16%;">{{ workplace.activity }}</td>
                                    <td style="width: 16%;">{{ workplace.address }}</td>
                                    <td style="width: 16%;">{{ workplace.worker_count }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <p class="left">
                                <span>Ажлын байр нь :</span>
                                <span>А.Өөрийн байр</span>
                                <span>Б.Түрээс</span>
                                <span>В.Улаанбаатар хотоос : километр</span>
                            </p>
                            <h1>03 ГЭР БҮЛИЙН МЭДЭЭЛЭЛ</h1>
                            <table class="cv-table cv-lg" >
                                <tbody>
                                <tr>
                                    <td style="width: 19%;">Овог нэр</td>
                                    <td style="width: 16%;">Таны хэн болох</td>
                                    <td style="width: 16%;">Ажил сургууль</td>
                                    <td style="width: 16%;">Регистрийн дугаар</td>
                                    <td style="width: 16%;">Сарын орлого</td>
                                    <td style="width: 16%;">Утас</td>
                                </tr>
                                <tr v-for="member in user.family">
                                    <td style="width: 18%;">{{ member.name }}</td>
                                    <td style="width: 16%;">{{ getRelation(member.relation) }}</td>
                                    <td style="width: 16%;">{{ member.job }}</td>
                                    <td style="width: 16%;">{{ member.register }}</td>
                                    <td style="width: 16%;">{{ member.budged }}</td>
                                    <td style="width: 16%;">{{ member.phone_number }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <h1>04 ШААРДЛАГАТАЙ ҮЕД ХОЛБОО БАРИХ ХҮНИЙ МЭДЭЭЛЭЛ</h1>
                            <p>Доорх хэсэгт ажлын газрын нягтлан бодогч, өөрийн эцэг эх болон гэр бүлийн гишүүний эцэг эхийн г.м</p>
                            <table class="cv-table cv-lg" >
                                <tbody>
                                <tr>
                                    <td style="width: 19%;">Овог нэр</td>
                                    <td style="width: 16%;">Таны хэн болох</td>
                                    <td style="width: 16%;">Ажил сургууль</td>
                                    <td style="width: 16%;">Регистрийн дугаар</td>
                                    <td style="width: 16%;">Сарын орлого</td>
                                    <td style="width: 16%;">Утас</td>
                                </tr>
                                <tr v-for="emergency in user.emergencies">
                                    <td style="width: 18%;">{{ emergency.name }}</td>
                                    <td style="width: 16%;">{{ getRelation(emergency.relation) }}</td>
                                    <td style="width: 16%;">{{ emergency.job }}</td>
                                    <td style="width: 16%;">{{ emergency.register }}</td>
                                    <td style="width: 16%;">{{ emergency.budged }}</td>
                                    <td style="width: 16%;">{{ emergency.phone_number }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <h1>05 ӨРХИЙН САРЫН НИЙТ ОРЛОГО ЗАРЛАГА</h1>
                            <table class="cv-table cv-md">
                                <tbody>
                                <tr>
                                    <td>ОРЛОГО, ЗАРДАЛ</td>
                                    <td>Сарын дүн</td>
                                </tr>
                                <tr v-for="budget in user.budgets">
                                    <td style="width: 65%;">{{ budget.name }}:</td>
                                    <td style="width: 40%;">{{ budget.budget }}</td>
                                </tr>
                                <tr v-for="expense in user.expenses">
                                    <td style="width: 65%;">{{ expense.name }}:</td>
                                    <td style="width: 40%;">{{ expense.expense }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="cv-table cv-md cv-md-margin-left">
                                <tbody>
                                <tr>
                                    <td style="width: 30%;">Хөрөнгө:</td>
                                    <td style="width: 20%;">Үнэлгээ</td>
                                    <td style="width: 30%;">Тайлбар</td>
                                </tr>
                                <tr v-for="asset in user.assets">
                                    <td style="width: 30%;">{{asset.name}}</td>
                                    <td style="width: 20%;">{{asset.asset}}</td>
                                    <td style="width: 30%;">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                            <!--<h1>08 идэвхтэй зээлийн мэдээлэл</h1>-->
                            <!--<table class="cv-table cv-lg" >-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">№</td>-->
                                    <!--<td style="width: 17%;">Зээл авсан банк санхүүгийн байгууллагын нэр</td>-->
                                    <!--<td style="width: 13%;">Зээлийн хэмжээ</td>-->
                                    <!--<td style="width: 13%;">Зээлийн зориулалт</td>-->
                                    <!--<td style="width: 13%;">Хугацаа</td>-->
                                    <!--<td style="width: 13%;">Зээлийн хүү</td>-->
                                    <!--<td style="width: 13%;">Одоогийн үлдэгдэл</td>-->
                                    <!--<td style="width: 13%;">Сард төлөгдөх төлбөр</td>-->
                                <!--</tr>-->
                                <!--<tr v-for="(loan, index) in user.active_loans">-->
                                    <!--<td>{{ index + 1 }}</td>-->
                                    <!--<td>{{ loan.organization }}</td>-->
                                    <!--<td>{{ loan.loan_amount }}</td>-->
                                    <!--<td>{{ loan.loan_usage }}</td>-->
                                    <!--<td>{{ loan.loan_date }}</td>-->
                                    <!--<td>{{ loan.loan_interest }}</td>-->
                                    <!--<td>{{ loan.loan_balance }}</td>-->
                                    <!--<td>{{ loan.monthly_pay }}</td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                            <!--<h1>09 зээл хүсч бүрдүүлсэн материалууд</h1>-->
                            <!--<table class="cv-table cv-lg" >-->
                                <!--<tbody>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">№</td>-->
                                    <!--<td style="width: 65%;">Иргэний бүрдүүлэх материалууд</td>-->
                                    <!--<td style="width: 30%;">Хуудасны тоо</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">1</td>-->
                                    <!--<td style="width: 65%;">Иргэний үнэмлэх, 1% цээж зураг</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">2</td>-->
                                    <!--<td style="width: 65%;">Оршин суугаа хорооны тодорхойлолт</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">3</td>-->
                                    <!--<td style="width: 65%;">Ажлын газар болон цалингийн тодорхойлолт</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">4</td>-->
                                    <!--<td style="width: 65%;">Нийгмийн даатгалын дэвтэр</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">5</td>-->
                                    <!--<td style="width: 65%;">Компантай бол дурэм, гэрчилгээ</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">6</td>-->
                                    <!--<td style="width: 65%;">Компани, хувь хүний дансны хуулга /Сүүлийн нэг жилээр/</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">7</td>-->
                                    <!--<td style="width: 65%;">Гэрлэлтийн лавлагаа</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">8</td>-->
                                    <!--<td style="width: 65%;">Бусад банк болон ББСБ-аас авсан төлөгдөөгүй зээлийн өрийн үлдэгдэлтэй бол зээлийн гэрээ, дансны хуулга, төлбөр төлсөн баримт</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td style="width: 5%;">9</td>-->
                                    <!--<td style="width: 65%;">Бусад холбогдох бичиг баримт</td>-->
                                    <!--<td style="width: 30%;">&nbsp;</td>-->
                                <!--</tr>-->
                                <!--</tbody>-->
                            <!--</table>-->
                            <p class="center">
                                <span>А.Харилцагчаас</span>
                                <span>Б.Интернет</span>
                                <span>В.Телевиз</span>
                                <span>Г.Бэлтгэн нийлүүлэгч</span>
                                <span>Д.ФМ радио</span>
                                <span>Е.Сонин хэвлэл</span>
                                <span>Ж.Бусад</span>
                            </p>
                            <p class="center">ДЭЭРХ МЭДЭЭЛЛИЙГ ҮНЭН ЗӨВ БОЛОХЫГ БАТАЛСАН /Гарын үсэг/ /......................................................................................../</p>
                            <p class="center">ХЯНАЖ АВСАН АЖИЛТАН: /Гарын үсэг/ /............................................................................................../</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    export default {

        data()
        {
            return {
                user: null,
                owner_type: null,
                relations: null
            }
        },

        mounted()
        {
            this.getUser();
        },

        methods: {
            getUser()
            {
                axios.get('/api/user/' + this.$route.params.id + '/info').then(response => {
                    this.user = response.data.user;
                    this.owner_type = response.data.owner_type;
                    this.relations = response.data.relations;
                    this.user.birth_day = null;
                    this.user.age = null;
                    this.setRegister();
                }).catch(function (response) {
                    swal('Уучлаарай!', 'Хэрэглэгчийн мэдээлэл татаж чадсангүй', 'error')
                })
            },
            getRelation(index)
            {
                return this.relations[index];
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
        }

    }

</script>