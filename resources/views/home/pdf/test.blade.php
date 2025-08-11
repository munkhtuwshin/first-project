<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>testPdf</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        #section1{
            color: #5d84cb;
            margin: 0 5rem;
            text-align: center;
        }
        .bulan{
            /* display: flex; */
            /* justify-content: space-between; */
            margin: 0 6rem;
            justify-content: center;
            align-content: center;
        }
        .a{
            float: left;
            border-left: 3px solid #5d84ce;
            border-top: 3px solid #5d84ce;
            width: 20px;
            height: 20px;
        }
        .b{
            float: right;
            border-right: 3px solid #5d84ce;
            border-top: 3px solid #5d84ce;
            width: 20px;
            height: 20px;
        }
        .section2{
            margin: 0px 5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    @php
    $path = public_path('R.jpg');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

@endphp
    <div style="">
        <img src="{{ $base64 }}" alt="" width="200" style="margin: 0 37%;" class="centerImg">
    </div>
    <div id="section1">
        <h2 style="font-size: 14pt;"> НИЙСЛЭЛИЙН ЗАСАГ ДАРГЫН ХЭРЭГЖҮҮЛЭГЧ АГЕНТ</h2>
        <h1>АРХИВЫН ГАЗАР </h1>
        <p>Улаанбаатар хот Чингэлтэй дүүрэг</p>
        
        <div>
            <p>Хувьсгалчдын ордон</p>    
            <p>Утас 90432452</p>
        </div>           
        <a href="http://www.archives.gov.mn/">http://www.archives.gov.mn/</a>
        <div>
            <p>___________________№  </p>
            <p>_________________</p>
        </div>
        
        <p> танай ___________  ны № _______________₮</p>
    </div>

    <div class="bulan">
        <div class="a"></div>
        <div class="b"></div>
    </div>

    <div class="section2">
        <h2>
            НИЙСЛЭЛИЙН ЗАСАГ ДАРГЫН ТАМГЫН ГАЗРЫН ХЯНАЛТ ШИНЖИЛГЭЭ,ҮНЭЛГЭЭНИЙ ХЭЛТЭС
        </h2>

        <p>
            Нийслэлийн Архивын газраас Монгол улсын “Архивын тухай хууль”-ийн 9.4.1 дэх заалтын дагуу архив, албан хөтлөлтийн үйл ажиллагааны талаарх хууль тогтоомжийн хэрэгжүүлэх, хяналт тавих, мониторинг үнэлгээ хийх чиглэлээр нийслэлийн хэмжээнд 2011 он, явуулах хяналт шалгалтын төлөвлөгөөг хавсралтаар хүргүүллээ.
        </p>

    </div>
</body>
</html>