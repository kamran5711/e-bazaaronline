
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-bazaar</title>
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
        .brand-section{
            background-color: #0d1033;
            padding: 10px 40px;
        }
        .logo{
            width: 50%;
        }

        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-6{
            width: 50%;
            flex: 0 0 auto;
        }
        .text-white{
            color: #fff;
        }
        .company-details{
            float: right;
            text-align: right;
        }
        .body-section{
            padding: 16px;
            border: 1px solid gray;
        }
        .heading{
            font-size: 20px;
            margin-bottom: 08px;
        }
        .sub-heading{
            color: #262626;
            margin-bottom: 05px;
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
        .text-right{
            text-align: end;
        }
        .w-20{
            width: 20%;
        }
        .float-right{
            float: right;

        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="heading">Dear {{$user['name']}}<b></b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 class="heading">We are pleased to confirm that your business  {{ $user['name'] }}, is now registered on our portal. </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 > To access your dashboard <a href="{{url('https://e-bazaaronline.com/user')}}">Link</a><b>
                .<br> Your login credentials are: <br>
            User Name: {{ $user['email'] }}<br>
            Password: You set this at the time of registration</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 >We strongly advise you to setup your shop as soon as possible. <br> To start you will need to add categories ( Parent and any Subcategories ) and products.<br>
            You will also need to add pictures, sizes, colors, price etc,<br> we have added some guidelines documents and videos to your dashboard which will assist you to setup, <br>sell your products, confirm orders deliver orders and update status. <br> However, if you need order further assestance lpease feel free to contact  <a href="{{url('https://e-bazaaronline.com')}}">E-bazaar</a>  on 0512308311 </h4>
        </div>
    </div>

</div>

</body>
</html>
