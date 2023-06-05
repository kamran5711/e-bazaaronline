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
        .container{
            width: 90%;
            margin-right: auto;
            margin-left: auto;
        }
        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-6{
            width: 50%;
            flex: 0 0 auto;
        }
        .col-12{
            width: 100%;
            flex: 0 0 auto;
        }
        .text-white{
            color: #fff;
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
        .right{
            float:right;
        }

        .left{
            float:left;
        }

    </style>
</head>
<body>
    @if($template_data->mention_receiver_name === "true")
        <div class="row">
            <div class="col-12">
                <h3>Dear {{ $name }},</h3>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
          {!! $template_data->contents !!}
        </div>
    </div>
    <div class="container">
        <div style=" background-color: #0d1033;
           padding: 5px; color:white;">
            <div class="row">
                <div class="col-12" style="clear: both; padding: 5px 10px;">
                    <span class="right">Order Date: {{ $order->created_at }}</span>
                    <span class="left">Order # {{ $order->order_number }}</span>
                </div>
            </div>
        </div>

        <div class="body-section">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th class="w-10">Product</th>
                        <th class="w-10">Status</th>
                        <th class="w-10">Cost & Discount</th>
                        <th class="w-10">Calculations</th>
                        <th class="w-10">Line Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subTotal = 0;
                        if($order->shippings[0]->shipping_id != null){
                            $subTotal = $subTotal + $order->shippings[0]->price;
                        }
                        $totalDiscount = 0;
                        $order_details = $order->order_details;
                    @endphp


                    @foreach($order_details as $order_detail)
                        @php
                            $product = $order_detail->product;
                            $color = $order_detail->color->title;
                            $size = $order_detail->size->title;
                            if($order_detail->sale_discount > 0){
                                $net = $order_detail->sale_price - ( $order_detail->sale_price * ( $order_detail->sale_discount / 100 ) );
                                $order_detail->discounted_price = round($net);
                                $product->sub_total = round($net * $order_detail->sale_quantity);
                            }
                        @endphp
                        <tr style='border: 1px solid lightgray;'>
                            <td class="text-center align-items-center">{{ $product->title }}<br>
                                <label class="btn btn-default btn-size-color">{{ $color  }}</label>
                                <label class="btn btn-default btn-size-color">{{ $size }}</label>
                            </td>
                            @php
                                $discount = ($product->price * $product->discount)/100;
                                $product_price = $product->price;
                                $after_discount = $product_price -  $discount;
                                $subTotal = $subTotal + $after_discount * $order_detail->sale_quantity;
                                $totalDiscount = $totalDiscount + $discount;
                            @endphp
                            <td class="text-center align-items-center">{{ $order_detail->status }}</td>
                            <td class="text-center align-items-center">{{ $product->price }} @if($product->discount)  <sup>- {{$product->discount}}%</sup><br /><span> {{$product_price}} - {{$discount}}</span> @endif </td>
                            <td class="text-center align-items-center">{{ $after_discount }} * {{$order_detail->sale_quantity}}X</td>
                            <td class="text-center align-items-center">{{ $order_detail->sale_quantity * $after_discount }}</td>    
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan='3'>&nbsp;</td>
                        <td class="text-center">Sub Total</td>
                        <td class="text-center" style='border-right: 1px solid lightgray;'>{{$subTotal}}</td>
                    </tr>
                    @if(count( $order->coupons ) > 0)
                        @php $subTotal = $subTotal - $order->coupons->sum('value'); @endphp
                        <tr>
                            <td colspan='3'>&nbsp;</td>
                            <td class="text-center">
                                @foreach ($order->coupons as $coupon)
                                    {{ $coupon->store->name }}'s coupon<br />
                                @endforeach
                            </td>
                            <td class="text-center" style='border-right: 1px solid lightgray;'>{{ $order->coupons->sum('value') }}.00</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan='3'>&nbsp;</td>
                        <td class="text-center">Shipping</td>
                        <td class="text-center" style='border-right: 1px solid lightgray;'>
                            <div>{{ $order->shippings[0]->price }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='3'>&nbsp;</td>
                        <td class="text-center"><b>Total Amount</b></td>
                        <td class="text-center" style='border-right: 1px solid lightgray;'>
                            <b>{{number_format( $subTotal, 2)}}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- <br>
            <h3 class="heading">Delivery Address: {{ $user['address1'] }}</h3> --}}
            {{-- <h3 class="heading">Payment Mode: </h3> --}}
        </div>
    </div>
</body>
</html>