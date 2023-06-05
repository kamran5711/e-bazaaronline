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
        p {
            margin: 0;
            padding: 0;
        }
        .mt-2{
            margin-top: 2px;
        }
        .mb-2{
            margin-bottom: 2px;
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
                <h3 class="heading text-center">Dear <b>{{ $store->user->name }},</b></h3>
                <p class="mt-2 mb-2">You have successfully extended membership plan upto {{ ( $invoice->payment != 0 ) ? $invoice->months.' Month(s)' : '(Free) Plan' }} & it is valid upto {{ $invoice->expiry_date }}.</p>

            </div>
        </div>
        <div class="body-section">
            <h3 class="heading">{{ $store->name }}</h3>
            <br>
            <table class="table-bordered">
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <th>Payment</th>
                        <td>{{ $invoice->payment }}</td>
                    </tr>
                    <tr>
                        <th>Month<small>(s)</small></th>
                        @if($invoice->payment != 0)
                            <td>{{ $invoice->months }} Month</td>
                        @else
                            <td>Free Trail</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $invoice->start_date}}</td>
                    </tr>
                    <tr>
                        <th>Expiry Date</th>
                        <td>{{ $invoice->expiry_date }}</td>
                    </tr>
                    <tr>
                        <th>Dated</th>
                        <td>{{ $invoice->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>