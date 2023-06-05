
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
                <h3 class="heading">Dear <b>{{ $user['name']}}</b></h3>
        </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="heading">Please see below your order details</h3>
        </div>
        </div>
        <div class="body-section" style=" background-color: #0d1033;
           padding: 10px 40px; color:white;">
            <div class="row">
                <div class="col-6">
                    <h2 class="heading">Order Items</h2>
                </div>
                <div class="col-6">
                    <p class="heading">Order Date: {{ $user['created_at']}}</p>
                </div>
            </div>
        </div>

        <div class="body-section">
            <h3 class="heading"></h3>
            <br>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th class="w-10">Product</th>
                        <th class="w-10">Product Cost</th>
                        <th class="w-10">Product Discount</th>
                        <th class="w-10">After Discount</th>
                        <th class="w-10">Quantity</th>
                        <th class="w-10">Line Total</th>
                    </tr>
                </thead>
                <tbody>
                       @php
                           $orderTotal=0;
                           $subTotal=0;

                         @endphp
                        @foreach($orderDetail as $orderDetails)
                          @php
                          $total_disc=($orderDetails->product->price *$orderDetails->product->discount)/100;
                          $orderTotal= $orderTotal +  $total_disc;
                         @endphp

                            <tr>
                        <td>{{ $orderDetails->product->title }}</td>
                                <td>{{$orderDetails->product->price}}</td>
                                <td> {{($orderDetails->product->price *$orderDetails->product->discount)/100 }}</td>
                                <td>{{ $orderDetails->product->selling_gross }}</td>
                                <td>{{ $orderDetails->sale_quantity }}</td>
                                @php
                                    $subTotal = $subTotal + $orderDetails->product->selling_gross* $orderDetails->sale_quantity
                                @endphp
                                <td>{{ $orderDetails->product->selling_gross* $orderDetails->sale_quantity}}</td>


                            </tr>
                        @endforeach
                    <tr>
                        <td colspan="5" class="text-right"><b>Sub Total :</b> </td>
                        <td> {{ $subTotal }} </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <td colspan="5" class="text-right"><b>Discount :</b></td>--}}
{{--                        <td> {{$orderTotal}}</td>--}}
{{--                    </tr>--}}
                       <tr>
                           <td colspan="5" class="text-right"><b>Coupon :</b></td>
                           <td> {{ ! is_null($coupon) ?$coupon :'00'}}</td>
                       </tr>
                       <tr>
                           <td colspan="5" class="text-right"><b>Delivery Charges :</b></td>
                           <td> To Be Advised</td>
                       </tr>
                    <tr>
                        <td colspan="5" class="text-right"><b>Invoice Total :</b> </td>
                        <td> {{ $subTotal-$coupon }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h3 class="heading">Delivery Address: {{ $user['address1'] }}</h3>
            {{-- <h3 class="heading">Payment Mode: </h3> --}}
        </div>

        <div class="body-section">
            <ol>
                <li>
                 Tracking ID:<b><a href="{{url('https://mobile-shop.e-bazaaronline.com/product/track')}}">{{ $user['order_number']}}</a><b>
                </li>
                <li>
                Login to your Dashboard <a href="{{url('/login')}}">{{url('/login')}}</a>
               </li>
               <li>
                Any problem please contact us 03005349599
               </li>
               <li>
                Shop Address:
               </li>
               <li>
                This service is being provided by <a href="{{url("")}}"><strong> E-bazaar</strong></a> A Shopping Marketplace for small and medium business.
               </li>
            </ol>
        </div>
    </div>

</body>
</html>
