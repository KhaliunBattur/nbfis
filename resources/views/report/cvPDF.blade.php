<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>

    body {
        font-family: DejaVu Sans,
        sans-serif;
        font-size: 16px;
        }

    .cv {
        position: relative;
        margin: 0 30px;
        width: 100%;
    }

    table {
        border-collapse: collapse;
    }

    .cv-picture {
        width: 118px;
        height: 157px;
        position: absolute;
        right: 0;
        border: 1px solid #000;
    }

    .cv > h1 {
        padding-top:10px;
        color: #3C8DBC;
        font-size: 24px;
        width: 100%;
        text-transform: uppercase;
    }

    .cv p {
        padding-top: 10px;
    }

    .cv p.center {
        text-align: center;
    }

    .cv p.left {
        text-align: left;
    }

    .cv span {
        padding: 0 5px;
    }

    .cv-table {
        height: auto;
        border: 1px solid #000;
    }

    .cv-table td {
        padding: 2px 5px;
    }

    .cv-table tr,
    .cv-table td,
    .cv-table th {
        border: 1px solid #000;
    }

    .cv-lg {
        width: 100%;
    }

    .cv-md {
        width: 30%;
    }

    .cv-md-margin-left {
        margin-left: 4%;

    }

    .cv-table-margin-top {
        margin-top: 10px;
    }

    .cv-top-border-none,
    .cv-top-border-none tr,
    .cv-top-border-none td {
     border-top: none !important;
    }
</style>
</head>
<body>
<div class="cv">
    <img src="#" class="cv-picture" />
    <h1 style="margin-top: 130px">01 ЕРӨНХИЙ МЭДЭЭЛЭЛ</h1>
    <table class="cv-table cv-lg" >
        <tbody>
        <tr>
            <td style="width: 15%;">Овог нэр:</td>
            <td style="width: 35%;">
                {{$user->first_name}}  {{$user->name}}
            </td>
            <td style="width: 20%;">Регистерийн дугаар:</td>
            <td style="width: 30%;">
                {{$user->register}}
            </td>
        </tr>
        <tr>
            <td style="width: 15%;">Нас:</td>
            <td style="width: 35%;">
                {{$user->age}}
            </td>
            <td style="width: 20%;">Утасны дугаар:</td>
            <td style="width: 30%;">
                {{$user->phone_number}}
            </td>
        </tr>
        <tr>
            <td style="width: 15%;">Цахим шуудан:</td>
            <td style="width: 35%;">
                {{$user->email}}&nbsp;
            </td>
            <td style="width: 20%;">Мэргэжил:</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        </tbody>
    </table>
    <table class="cv-table cv-lg cv-top-border-none" >
        <tbody>
        <tr>
            <td style="width: 30%;">Одоо амьдарч буй гэрийн хаяг:</td>
            <td style="width: 70%;">
                {{$user->address}}
            </td>
        </tr>
        <tr>
            <td style="width: 30%;">Одоо амьдарч буй байр нь орон сууц, хашаа байшин, хашаа гэр:</td>
            <td style="width: 70%;">
                {{$user->owner_type}}
            </td>
        </tr>
        </tbody>
    </table>
    <table class="cv-table cv-lg cv-top-border-none" >
        <tbody>
        <tr>
            <td style="width: 50%;">Тухайн хаяг дээр амьдарсан жил:</td>
            <td style="width: 50%;">
                {{$user->live_year}}
            </td>
        </tr>
        <tr>
            <td style="width: 50%;">Байр нь зээлийн барьцаанд байгаа бол дэлгэрэнгүй бөглөнө үү:</td>
            <td style="width: 50%;">
                {{$user->bail_info}}
            </td>
        </tr>
        </tbody>
    </table>
    <h1>02 ЗЭЭЛИЙН ХҮСЭЛТ</h1>
    <table class="cv-table cv-lg" >
        <tbody>
        @foreach($user->Request as  $request)
        <tr>
            <td colspan="2" style="width: 100%;">
                    {{$request->pledge_type}}
            </td>
        </tr>
        <tr>
            <td style="width: 30%;">Хүсэж буй зээлийн хэмжээ:</td>
            <td style="width: 70%;">
                {{$request->loan_term}}
            </td>
        </tr>
        <tr>
            <td style="width: 30%;">Зээлийн эргэн төлөх хугацаа:</td>
            <td style="width: 70%;">{{$request->period_time}}</td>
        </tr>
        <tr>
            <td style="width: 30%;">Сар бүрийн эргэн төлөлт хийх өдөр:</td>
            <td style="width: 70%;">&nbsp;{{$request->payment_day}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <h1>03 БАРЬЦАА ХӨРӨНГИЙН МЭДЭЭЛЭЛ</h1>
        <div class="cv-lg">
            <table class="cv-table cv-md" >
                <tbody>
                <tr>
                    <td style="width: 100%;" colspan="2">Байр барьцаалах бол 4%</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Ашиглалтанд орсон огноо:</td>
                    <td style="width: 50%;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Хаяг:</td>
                    <td style="width: 50%;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Хэдэн М2::</td>
                    <td style="width: 50%;">Хэдэн өрөө: М2:</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Зах зээлийн үнэ:</td>
                    <td style="width: 50%;">&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <table class="cv-table cv-md cv-md-margin-left" >
                <tbody>
                <tr>
                    <td colspan="2">Машин барьцаалах бол 3.5-4%</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Марк/өнгө:</td>
                    <td style="width: 50%;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Үйлдвэрлэсэн огноо:</td>
                    <td style="width: 50%;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Орж ирсэн огноо:</td>
                    <td style="width: 50%;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width: 50%;">Зах зээлийн үнэ:</td>
                    <td style="width: 50%;">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    <table class="cv-table cv-lg cv-table-margin-top" >
        <tbody>
        <tr>
            <td style="width: 23.8%;">Бусад</td>
            <td style="width: 75%;"></td>
        </tr>
        </tbody>
    </table>
    <table class="cv-table cv-lg cv-top-border-none">
        <tbody>
        <tr>
            <td style="width: 23.8%;">Зах зээлийн үнэ:</td>
            <td style="width: 10%;"></td>
            <td style="width: 65%;">Тайлбар: </td>
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
            <td style="width: 18%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 18%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
            <td style="width: 16%;">&nbsp;</td>
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
            <td style="width: 19%;">Овог нэр</td>
            <td style="width: 16%;">Таны хэн болох</td>
            <td style="width: 16%;">Ажил сургууль</td>
            <td style="width: 16%;">Регистрийн дугаар</td>
            <td style="width: 16%;">Сарын орлого</td>
            <td style="width: 16%;">Утас</td>
        </tr>
        @foreach($user->family as $member)
        <tr>
            <td style="width: 18%;">{{$member->name}}</td>
            <td style="width: 16%;">{{$member->relation}}</td>
            <td style="width: 16%;">{{$member->job}}</td>
            <td style="width: 16%;">{{$member->register}}</td>
            <td style="width: 16%;">{{$member->budged}}</td>
            <td style="width: 16%;">{{$member->phone_number}}</td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <h1>06 ШААРДЛАГАТАЙ ҮЕД ХОЛБОО БАРИХ ХҮНИЙ МЭДЭЭЛЭЛ</h1>
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
        @foreach($user->emergencies as $emergency)
            <tr>
                <td style="width: 18%;">{{$emergency->name}}</td>
                <td style="width: 16%;">{{$emergency->relation}}</td>
                <td style="width: 16%;">{{$emergency->job}}</td>
                <td style="width: 16%;">{{$emergency->register}}</td>
                <td style="width: 16%;">{{$emergency->budged}}</td>
                <td style="width: 16%;">{{$emergency->phone_number}};</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <h1>07 ӨРХИЙН САРЫН НИЙТ ОРЛОГО ЗАРЛАГА</h1>
    <h4>Өрхийн зарлага</h4>
    <table class="cv-table cv-md">
        <tbody>
        <tr>
            <td>Сарын зарлага</td>
            <td>Сарын дүн</td>
        </tr>
        @foreach($user->expenses as $expense)
        <tr>
            <td style="width: 65%;">{{$expense->name}}</td>
            <td style="width: 40%;">{{$expense->expense}} </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <h4>Өрхийн орлого</h4>
    <table class="cv-table cv-md">
        <tbody>
        <tr>
            <td>Сарын орлого</td>
            <td>Сарын дүн</td>
        </tr>
        @foreach($user->budgets as $budget)
        <tr>
            <td style="width: 60%;">{{$budget->name}}</td>
            <td style="width: 40%;">{{$budget->budget}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <h4>Хөрөнгө</h4>
    <table class="cv-table cv-lg">
        <tbody>
        <tr>
            <td style="width: 30%;">Хөрөнгө:</td>
            <td style="width: 20%;">Үнэлгээ</td>
            <td style="width: 30%;">Тайлбар</td>
        </tr>
        @foreach($user->assets as $asset)
        <tr>
            <td style="width: 30%;">{{$asset->name}}</td>
            <td style="width: 20%;">{{$asset->asset}}</td>
            <td style="width: 30%;">{{$asset->description}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <h1>08 идэвхтэй зээлийн мэдээлэл</h1>
    <table class="cv-table cv-lg" >
        <tbody>
        <tr>
            <td style="width: 5%;">№</td>
            <td style="width: 17%;">Зээл авсан банк санхүүгийн байгууллагын нэр</td>
            <td style="width: 13%;">Зээлийн хэмжээ</td>
            <td style="width: 13%;">Зээлийн зориулалт</td>
            <td style="width: 13%;">Хугацаа</td>
            <td style="width: 13%;">Зээлийн хүү</td>
            <td style="width: 13%;">Одоогийн үлдэгдэл</td>
            <td style="width: 13%;">Сард төлөгдөх төлбөр</td>
        </tr>
        @foreach($user->activeLoans as $loan)

        <tr>
            <td>{{$loan->id}}</td>
            <td>{{$loan->organization}}</td>
            <td>{{$loan->loan_amount}}</td>
            <td>{{$loan->loan_usage}}</td>
            <td>{{$loan->loan_date}}</td>
            <td>{{$loan->loan_interest}}</td>
            <td>{{$loan->loan_balance}}</td>
            <td>{{$loan->monthly_pay}}</td>
        </tr>
        @endforeach
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
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">2</td>
            <td style="width: 65%;">Оршин суугаа хорооны тодорхойлолт</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">3</td>
            <td style="width: 65%;">Ажлын газар болон цалингийн тодорхойлолт</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">4</td>
            <td style="width: 65%;">Нийгмийн даатгалын дэвтэр</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">5</td>
            <td style="width: 65%;">Компантай бол дурэм, гэрчилгээ</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">6</td>
            <td style="width: 65%;">Компани, хувь хүний дансны хуулга /Сүүлийн нэг жилээр/</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">7</td>
            <td style="width: 65%;">Гэрлэлтийн лавлагаа</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">8</td>
            <td style="width: 65%;">Бусад банк болон ББСБ-аас авсан төлөгдөөгүй зээлийн өрийн үлдэгдэлтэй бол зээлийн гэрээ, дансны хуулга, төлбөр төлсөн баримт</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width: 5%;">9</td>
            <td style="width: 65%;">Бусад холбогдох бичиг баримт</td>
            <td style="width: 30%;">&nbsp;</td>
        </tr>
        </tbody>
    </table>
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
</body>
</html>