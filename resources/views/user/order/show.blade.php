@extends('user.layouts.master')
@section('title','Order Detail')
@section('main-content')
    <div class="card">
        <h5 class="card-header">Details of <b>Order # {{$order->id}}</b> @if($order->status=="Cancelled")<span
                style="float: right;" class="text-danger">This order has been cancelled</span>@endif
        </h5>
        <div class="card-body">
            @if($order)

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="">
                            @php $type_array_colors=array("Received"=>"label-warning","Processed"=>"label-default","Dispatched"=>"label-info","Delivered"=>"label-success","Cancelled"=>"label-danger");
                            @endphp
                            <style>
                                .steps {
                                    border: 1px solid #e7e7e7
                                }

                                .steps-header {
                                    padding: .375rem;
                                    border-bottom: 1px solid #e7e7e7
                                }

                                .steps-header .progress {
                                    height: .25rem
                                }

                                .steps-body {
                                    display: table;
                                    table-layout: fixed;
                                    width: 100%
                                }

                                .step {
                                    display: table-cell;
                                    position: relative;
                                    padding: 1rem .75rem;
                                    -webkit-transition: all 0.25s ease-in-out;
                                    transition: all 0.25s ease-in-out;
                                    border-right: 1px dashed #dfdfdf;
                                    color: rgba(0, 0, 0, 0.65);
                                    font-weight: 600;
                                    text-align: center;
                                    text-decoration: none
                                }

                                .step:last-child {
                                    border-right: 0
                                }

                                .step-indicator {
                                    display: block;
                                    position: absolute;
                                    top: .75rem;
                                    left: .75rem;
                                    width: 1.5rem;
                                    height: 1.5rem;
                                    border: 1px solid #e7e7e7;
                                    border-radius: 50%;
                                    background-color: #fff;
                                    font-size: .875rem;
                                    line-height: 1.375rem;
                                }

                                .has-indicator {
                                    padding-right: 1.5rem;
                                    padding-left: 2.375rem
                                }

                                .has-indicator .step-indicator {
                                    top: 50%;
                                    margin-top: -.75rem
                                }

                                .step-icon {
                                    display: block;
                                    width: 1.5rem;
                                    height: 1.5rem;
                                    margin: 0 auto;
                                    margin-bottom: .75rem;
                                    -webkit-transition: all 0.25s ease-in-out;
                                    transition: all 0.25s ease-in-out;
                                    color: #888
                                }

                                .step:hover {
                                    color: rgba(0, 0, 0, 0.9);
                                    text-decoration: none
                                }

                                .step:hover .step-indicator {
                                    -webkit-transition: all 0.25s ease-in-out;
                                    transition: all 0.25s ease-in-out;
                                    border-color: transparent;
                                    background-color: #f4f4f4
                                }

                                .step:hover .step-icon {
                                    color: rgba(0, 0, 0, 0.9)
                                }

                                .step-disabled, .step-disabled:hover {
                                    color: #a7a7a7;
                                    pointer-events: none;
                                    cursor: not-allowed;
                                    font-weight: 100;
                                }

                                .step-disabled .step-icon, .step-disabled:hover .step-icon {
                                    color: #a7a7a7;
                                }

                                .step-active, .step-active:hover {
                                    color: rgba(0, 0, 0, 0.9);
                                    cursor: default
                                }

                                .step-active .step-indicator, .step-active:hover .step-indicator {
                                    border-color: transparent;
                                    background-color: #5c77fc;
                                    color: #fff;
                                }

                                .step-active .step-icon, .step-active:hover .step-icon {
                                    color: #5c77fc;
                                }

                                .step-completed .step-indicator, .step-completed:hover .step-indicator {
                                    border-color: transparent;
                                    background-color: rgba(51, 203, 129, 0.12);
                                    color: #33cb81;
                                    line-height: 1.25rem;
                                }

                                .step-completed .step-indicator .feather, .step-completed:hover .step-indicator .feather {
                                    width: .875rem;
                                    height: .875rem
                                }

                                @media screen and (max-width: 576px) {
                                    .steps-header {
                                        display: none
                                    }

                                    .steps-body, .step {
                                        display: block
                                    }

                                    .step {
                                        border-right: 0;
                                        border-bottom: 1px dashed #e7e7e7
                                    }

                                    .step:last-child {
                                        border-bottom: 0
                                    }

                                    .has-indicator {
                                        padding: 1rem .75rem
                                    }

                                    .has-indicator .step-indicator {
                                        display: inline-block;
                                        position: static;
                                        margin: 0;
                                        margin-right: 0.75rem
                                    }
                                }

                                @media print {
                                    .no-print {
                                        display: none;
                                    }

                                    #view_modal .modal-dialog {
                                        width: 100% !important;
                                    }
                                }

                                .btn-default {
                                    border: 1px solid !important;
                                    padding: 1px 4px;
                                }

                                div.bg-info {
                                    background-color: #1cc88a5c !important;
                                }
                            </style>
                            <div class="no-print">
                                <!-- Progress-->
                                <div class="steps">
                                    <div class="steps-body">
                                        <div class="Received step status"><span
                                                class="fa fa-exclamation-circle text-center text-muted fa-2x"></span><br>Order
                                            Received<br><small>{{$order->created_at?date("d/m/Y h:i A", strtotime($order->created_at)):'---'}}</small><br>
                                            
                                            <button class="btn btn-danger btn-xs"
                                                    onclick="if(confirm('Are you sure to Cancel this order?')){order_cancel({{$order->id}});}">
                                                Cancel
                                            </button>
                                        </div>
                                        <div class="Processed step status"><span
                                                class="fa fa-edit text-center text-muted fa-2x"></span><br>Order
                                            Processed<br><small>{{$order->verified_date?date("d/m/Y h:i A", strtotime($order->verified_date)):'---'}}</small><br>
                                          
                                        </div>
                                        <div class="Dispatched step status"><span
                                                class="fa fa-tag text-center text-muted fa-2x"></span><br>Dispatched<br><small>{{$order->dispatched_date?date("d/m/Y h:i A", strtotime($order->dispatched_date)):'---'}}</small><br>
                                          
                                        </div>
                                        <div class="Delivered step status"><span
                                                class="fa fa-check-circle text-center text-muted fa-2x"></span><br>Delivered<br><small>{{$order->paid_date?date("d/m/Y h:i A", strtotime($order->paid_date)):'---'}}</small>
                                        </div>
                                        <div class="step" style="cursor:pointer;" onclick="print_receipt();"><span
                                                class="fa fa-print text-center text-warning fa-2x"></span><br>Print<br><small>Print
                                                Receipt</small></div>
                                    </div>
                                    <script>
                                        var current_status = '{{$order->status}}';
                                        var status_array = ["Received", "Processed", "Dispatched", "Delivered"];
                                        var status_index = status_array.indexOf(current_status);
                                        var counter = 0;
                                        $('.status').each(function (index) {
                                            if (counter < status_index) {
                                                $(this).addClass('step-completed');
                                                $(this).find('span').removeClass('text-muted');
                                                $(this).find('span').addClass('text-success');
                                                $(this).find('button').remove();
                                            } else if (counter == status_index) {
                                                $(this).addClass('step-completed step-active bg-info');
                                                $(this).find('span').removeClass('text-muted');
                                                $(this).find('span').addClass('text-info');
                                            } else {
                                                $(this).addClass('step-disabled');
                                                $(this).find('button').remove();
                                            }
                                            counter++;
                                        });
                                    </script>
                                </div>
                            </div>
                            @php $customer_email=$order->email?" (".$order->email.")":"";
                            @endphp
                            <div id='print_area'>
                                <table class='table' width='100%'>
                                    <tbody style='border: 1px solid lightgray;'>
                                    <tr>
                                        <td style='vertical-align: middle;' colspan='1' align='left' width='20%'><h3
                                                style='display:inline;'>Invoice # {{$order->id}}</h3></td>
                                        <td style='vertical-align: middle;' colspan='7' align='right' width='30%'><p
                                                style='display:inline;'>E-Bazar Shopping</p></td>
                                    </tr>
                                    <tr>
                                        <td>Customer Name</td>
                                        <td width='10%'>{{$order->user->name}}</td>
                                        <td>Customer Phone</td>
                                        <td width='20%'>{{$order->phone}}</td>
                                        <td>Customer Email</td>
                                        <td width='20%'>{{$order->user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Building Name/Number</td>
                                        <td width='5%'>{{$order->building}} </td>
                                        <td>Address1</td>
                                        <td width='5%'>{{$order->address1}}</td>
                                        <td>Address2</td>
                                        <td width='5%'>{{$order->address2}}</td>
                                        <td>Area</td>
                                        <td width='5%'>{{$order->area}}</td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td width='5%'>{{$order->city}}</td>
                                        <td>Postcode</td>
                                        <td width='5%'>{{$order->postcode}}</td>
                                        <td>Order Date</td>
                                        <td colspan='5'>{{date("d/m/Y h:i A", strtotime($order->created_at))}}</td>
                                    </tr>
                                    <tr>
                                        <td>CNIC</td>
                                        <td width='13%'>{{$order->cnic}}</td>
                                        <td>Order Notes</td>
                                        <td colspan='6'>{{$order->order_notes}}</td>
                                    </tr>
                                    <tr>
                                        <td>Mode of Payment</td>
                                        <td colspan='7'>{{$order->payment->title}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class='table' width='100%'>
                                    <thead style='background:#f9fafc;border: 1px solid lightgray;'>
                                    <td align='center'><b>Product</b></td>
                                    <td align='center'><b>Product Cost </b></td>
                                    <td align='center'><b>Product Discount</b></td>
                                    <td align='center'><b>After Discount</b></td>
                                    <td align='center'><b>Quantity</b></td>
                                    <td align='center'><b>Line Total</b></td>
                                    </thead>
                                    <tbody style='border: 1px solid lightgray;'>
                                    @php
                                        $subTotal=0;
                                        $totalDiscount=0;
                                        $get_order_details=DB::table('order_details')->where('order_id',$order->id)->get();
                                    @endphp
                                    @foreach($get_order_details as $row)
                                        @php
                                            $product=DB::table('products')->where('id',$row->product_id)->first();
                                            $choice=\App\Models\Choice::where('id',$row->choice_id)->first();
                                            $size=\App\Models\Size::where('id',$row->size_id)->first();
                                            $color_name=is_null($choice)?"":$choice->color_name;
                                            $size_title=is_null($size)?"":$size->title;
                                              if($row->sale_discount>0){
                                                  $net=$row->sale_price-($row->sale_price*($row->sale_discount/100));
                                                  $row->discounted_price=round($net);
                                                  $product->sub_total=round($net*$row->sale_quantity);
                                              }
                                        @endphp
                                        <tr style='border: 1px solid lightgray;'>
                                            <td align='center' style='vertical-align: middle;'>{{$product->title}}<br>
                                                @if ($color_name)
                                                    <label class="btn btn-default"
                                                           style="border: 1px solid !important;padding: 1px 4px !important;border-radius:4px;">{{$color_name}}</label>
                                                @endif
                                                @if ($size_title)
                                                    <label class="btn btn-default"
                                                           style="border: 1px solid !important;padding: 1px 4px !important;border-radius:4px;">{{$size_title}}</label>
                                                @endif
                                            </td>
                                            @php
                                                $discount=($product->price * $product->discount)/100;
                                                 $product_price= $product->price;
                                                 $after_discount= $product_price -  $discount;
                                                    $subTotal=  $subTotal + $after_discount * $row->sale_quantity;
                                                    $totalDiscount= $totalDiscount + $discount;
                                            @endphp
                                            <td align='center' style='vertical-align: middle;'>{{$product->price}}</td>
                                            <td align='center' style='vertical-align: middle;'>{{ $discount}}</td>
                                            <td align='center' style='vertical-align: middle;'>{{$after_discount}}</td>
                                            <td align='center'
                                                style='vertical-align: middle;'>{{$row->sale_quantity}}</td>
                                            <td align='center'
                                                style='vertical-align: middle;'>{{ $row->sale_quantity * $after_discount}}</td>
                                        </tr>
                                    @endforeach
                                    @php $product_delivery=$order->product_delivery?$order->product_delivery:"To Be Advised";@endphp
                                    <tr>
                                        <td align='right' colspan='5'>Sub Total</td>
                                        <td align='center' style='border-right: 1px solid lightgray;'>{{$subTotal}}</td>
                                    </tr>
                                   <!---  <tr>
                                       <td align='right' colspan='5'>Discount</td>
                                        <td align='center'
                                            style='border-right: 1px solid lightgray;'>{{$totalDiscount}}</td>
                                    </tr>--->
                                    <tr>
                                        <td align='right' colspan='5'>Coupon Discount</td>
                                        <td align='center'
                                            style='border-right: 1px solid lightgray;'>{{ ! is_null($order->coupon) ? $order->coupon :'00'}}</td>
                                    </tr>
                                    <tr>
                                        <td align='right' colspan='5'>After Discount</td>
                                        <td align='center'
                                            style='border-right: 1px solid lightgray;'>{{ $subTotal- $order->coupon}}</td>
                                    </tr>
                                    <tr>
                                        <td align='right' colspan='5'> Delivery Charges</td>
                                        <td align='center'
                                            style='border-right: 1px solid lightgray;'>{{$product_delivery}}</td>
                                    </tr>
                                    <tr>
                                        <td align='right' colspan='5'><b>Total Amount</b></td>
                                        <td align='center' style='border-right: 1px solid lightgray;'>Rs
                                            <b>{{number_format( $subTotal- $order->coupon +$order->product_delivery,2)}}</b>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            {{-- <!----{{$row->discounted_price}}----> --}}
                            </div>
                        </div>
                </section>
            @endif

        </div>
    </div>

    <!-- Verify Modal -->
    <div data-id="{{$order->id}}" class="modal modal-info fade col-md-12" data-toggle="modal"
         data-target=".bs-example-modal-lg" id="modal_verify_order" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog modal-md" role="document" style="margin-top: 140px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Process Order</h5>
                </div>
                <div class="modal-body text-center" id="verify_order_data">
                    <h5>Are you sure to process this order ?</h5>
                    <center>
                        <div class="form-group col-md-8">
                            <label>Delivery Charges</label>
                            <input id="product_delivery" type="text" class="form-control"
                                   placeholder="Update delivery charges"/>
                        </div>
                    </center>
                    <a href="javascript:void(0)" onclick="verify_order();" class="btn btn-primary"><i
                            class="fa fa-fw fa-check-circle"></i> Process</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--End of verify modal-->

    <!-- Dispatch order Modal -->
    <div data-id="{{$order->id}}" class="modal modal-info fade col-md-12" data-toggle="modal"
         data-target=".bs-example-modal-lg" id="modal_dispatch_order" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog modal-md" role="document" style="margin-top: 140px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Dispatch Order</h5>
                </div>
                <div class="modal-body text-center" id="dispatch_order_data">
                    <h5>Are you sure to Dispatch this Order ?</h5>
                    <a href="javascript:void(0)" onclick="dispatch_order();" class="btn btn-primary"><i
                            class="fa fa-fw fa-tag"></i> Dispatch</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--End of Dispatch order modal-->

    <!-- Complete order Modal -->
    <div data-id="{{$order->id}}" class="modal modal-info fade col-md-12" data-toggle="modal"
         data-target=".bs-example-modal-lg" id="modal_complete_order" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog modal-md" role="document" style="margin-top: 140px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Complete Order</h5>
                </div>
                <div class="modal-body text-center" id="complete_order_data">
                    <h5>Are you sure to Complete this Order ?</h5>
                    <center>
                        <div class="form-group col-md-8">
                            <label>Received amount</label>
                            <input id="paid_amount" type="text" class="form-control"
                                   placeholder="Enter received amount"/>
                        </div>
                    </center>
                    <a href="javascript:void(0)" onclick="complete_order();" class="btn btn-primary"><i
                            class="fa fa-fw fa-check-circle"></i> Complete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--End of complete order modal-->
@endsection

<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script>
    function verify_order() {
        var status = 'Processed';
        var product_delivery = $('#product_delivery').val();
        $.ajax({
            url: "{{route('update_order_status')}}",
            method: 'POST',
            dataType: 'json',
            data: {
                status: status,
                product_delivery: product_delivery,
                action: "update_order_status",
                order_id: $('#modal_verify_order').attr('data-id'),
                _token: "{{csrf_token()}}"
            },
            success: function (data) {
                //console.log(data);
                alert(data['msg']);
                location.reload();
            },
            error: function (data) {
                alert("Error code : " + data.status + " , Error message : " + data.statusText);
            }
        });
    }

    function dispatch_order() {
        var status = 'Dispatched';
        $.ajax({
            url: "{{route('update_order_status')}}",
            method: 'POST',
            dataType: 'json',
            data: {
                status: status,
                action: "update_order_status",
                order_id: $('#modal_dispatch_order').attr('data-id'),
                _token: "{{csrf_token()}}"
            },
            success: function (data) {
                //console.log(data);
                alert(data['msg']);
                location.reload();
            },
            error: function (data) {
                alert("Error code : " + data.status + " , Error message : " + data.statusText);
            }
        });
    }

    function complete_order() {
        var status = 'Delivered';
        var paid_amount = $('#paid_amount').val();
        var valid = 0;
        if (!paid_amount) {
            $('#paid_amount').focus();
        } else {
            valid = 1;
        }
        if (valid == 1) {
            $.ajax({
                url: "{{route('update_order_status')}}",
                method: 'POST',
                dataType: 'json',
                data: {
                    status: status,
                    paid_amount: paid_amount,
                    action: "update_order_status",
                    order_id: $('#modal_verify_order').attr('data-id'),
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    alert(data['msg']);
                    location.reload();
                },
                error: function (data) {
                    alert("Error code : " + data.status + " , Error message : " + data.statusText);
                }
            });
        }
    }

    function order_cancel($order_id) {
        var status = 'Cancelled';
        $.ajax({
            url: "{{route('update_order_status')}}",
            method: 'POST',
            dataType: 'json',
            data: {
                status: status,
                action: "update_order_status",
                order_id: $order_id,
                _token: "{{csrf_token()}}"
            },
            success: function (data) {
                alert(data['msg']);
                location.reload();
            },
            error: function (data) {
                alert("Error code : " + data.status + " , Error message : " + data.statusText);
            }
        });
    }

    function print_receipt() {
        var data = $("#print_area");
        var mywindow = window.open('', 'PRINT');
        mywindow.document.write('<html><head><title>Print Order Receipt</title>');
        mywindow.document.write('<link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}">');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data.html());
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.focus();
        setTimeout(function () {
            mywindow.print();
            mywindow.close();
            return true;
        }, 500);
    }
</script>
