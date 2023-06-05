<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-bazaar</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <style>
        body{
            background-color: #F6F6F6;
            margin: 0;
            padding: 0;
        }
        h1,h2,h3,h4,h5,h6{
            margin: 0;
            padding: 0;
        }
        p{
            margin: 0;
            padding: 0;
        }
        .container{
            width: 80%;
            margin-right: auto;
            margin-left: auto;
        }
        th {
            font-weight: blod !important;
            color: #000 !important;
        }
        table{
            background-color: #fff;
            width: 100%;
            border-collapse: collapse;
        }
        table thead tr{
            border: 1px solid #111;
            background-color: #f2f2f2;
        }
        table td {
            vertical-align: middle !important;
            text-align: center;
        }
        table th, table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }
        .table-bordered{
            box-shadow: 0px 0px 5px 0.5px gray;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .child {
            display: inline-block;
            padding: 1rem 1rem;
            vertical-align: middle;
            float: left;
        }
        .child1{
            display: inline-block;
            padding: 1rem 1rem;
            vertical-align: middle;
            float: right;
        }
        .main {
            background: #ffffff;
            border-bottom: 15px solid #0aa89e;
            border-top: 15px solid #0aa89e;
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 40px 30px !important;
            position: relative;
            box-shadow: 0 1px 21px #808080;
            font-size: 12px;
        }
        .main thead {
            background: #0aa89e;
            color: #fff;
        }

    </style>
</head>
<body>
<div class="section-body">
    <section>
        <div class="section-body">
            <div class="row">

                <div class="col-lg-8  col-md-offset-2 main">
                    <div class="card">
                        <svg viewBox="0 0 1440 320">
                            <path fill="#0aa89e" fill-opacity="1" d="M0,320L21.8,266.7C43.6,213,87,107,131,80C174.5,53,218,107,262,138.7C305.5,171,349,181,393,160C436.4,139,480,85,524,90.7C567.3,96,611,160,655,170.7C698.2,181,742,139,785,106.7C829.1,75,873,53,916,42.7C960,32,1004,32,1047,48C1090.9,64,1135,96,1178,106.7C1221.8,117,1265,107,1309,106.7C1352.7,107,1396,117,1418,122.7L1440,128L1440,0L1418.2,0C1396.4,0,1353,0,1309,0C1265.5,0,1222,0,1178,0C1134.5,0,1091,0,1047,0C1003.6,0,960,0,916,0C872.7,0,829,0,785,0C741.8,0,698,0,655,0C610.9,0,567,0,524,0C480,0,436,0,393,0C349.1,0,305,0,262,0C218.2,0,175,0,131,0C87.3,0,44,0,22,0L0,0Z"></path>
                        </svg>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="col-md-10 col-md-offset-1">
                                    <h1>Dear {{$user->person_name}}</h1>
                                    <br>
                                    @if($diffInDays<=3)
                                        <p>Your Invoice {{$invoice->invoice_in}} was due on.it is now {{$diffInDays}} day overdue</p>
                                    @elseif($diffInDays==4)
                                        <p>Your Invoice {{$invoice->invoice_id}} was due on.it is now {{$diffInDays}} day overdue please note if you dont pay this by {{$dealerInvoice->created_at}} than your membership will be suspended on </p>
                                        <br>
                                        <p>If you need more information please do not hesitated to contact us</p>
                                    @elseif($diffInDays==5)
                                        <p>Your Invoice {{$invoice->invoice_id}} was due on  {{$UserInactive}}.Hour  you haven't made your suspended fee will today.It is to inform you that you will not be able to access  your dashboard/business page from   until you dear all your dues.</p>
                                        <br>
                                        <p>If you need more information please do not hesitated to contact us</p>
                                    @endif
                                    <br>
                                    <p>Thanks for using our services.</p>
                                    <p>Best Regard<br>EB</p>
                                </div>
                                <br><br><br>
                                <ol>
                                    <li>
                                        You can pay by bank Transfer <b>08940010062328530010</b> Softech
                                        business services (smc-pvt) limited.
                                    </li>
                                    <li>
                                        You can pay by bank Easypaisa <b>033557433800</b>
                                    </li>
                                    <li>
                                        You must use Invoice number as payment reference.
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <svg viewBox="0 0 1440 320">
                            <path fill="#0aa89e" fill-opacity="1" d="M0,192L24,186.7C48,181,96,171,144,186.7C192,203,240,245,288,250.7C336,256,384,224,432,213.3C480,203,528,213,576,224C624,235,672,245,720,224C768,203,816,149,864,160C912,171,960,245,1008,240C1056,235,1104,149,1152,144C1200,139,1248,213,1296,208C1344,203,1392,117,1416,74.7L1440,32L1440,320L1416,320C1392,320,1344,320,1296,320C1248,320,1200,320,1152,320C1104,320,1056,320,1008,320C960,320,912,320,864,320C816,320,768,320,720,320C672,320,624,320,576,320C528,320,480,320,432,320C384,320,336,320,288,320C240,320,192,320,144,320C96,320,48,320,24,320L0,320Z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
