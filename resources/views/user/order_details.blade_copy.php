@extends('frontend.layouts.master')
@section('title','Order Detail')
@section('main-content')
    <div class="card m-5">
        <h5 class="card-header {{ ($order->status == 'Cancelled') ? 'text-danger' : 'text-dark' }}">Order Details @if($order->status=="Cancelled")<span
                style="float: right;" class="text-danger">This order has been cancelled</span>@endif
        </h5>
        <div class="card-body">
            @if($order)

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="">
                            @php
                                $type_array_colors = array("Received"=>"label-warning","Processed"=>"label-default","Dispatched"=>"label-info","Delivered"=>"label-success","Cancelled"=>"label-danger");
                                $status_array = array(
                                                // "pending" ,
                                                "accept" ,
                                                "reject"
                                                );
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
                                .btn-size-color {
                                    border: 1px solid !important;padding: 1px 4px !important;border-radius:4px;
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
                                                class="fa fa-check-circle text-center text-muted fa-2x"></span><br>Delivered<br><small>{{$order->paid_date ? date("d/m/Y h:i A", strtotime($order->paid_date)):'---'}}</small>
                                        </div>
                                        <div class="step" style="cursor:pointer;" onclick="print_receipt();"><span
                                                class="fa fa-print text-center text-warning fa-2x"></span><br>Print<br><small>Print
                                                Receipt</small>
                                        </div>
                                        @if($order->status == 'Delivered')
                                        <div class="step" style="cursor:pointer;" data-toggle="modal" data-target="#return-form"><span
                                                class="fa fa-reply text-center text-danger fa-2x"></span><br>Return<br><small>Return
                                                Order</small></div>
                                        @endif
                                    </div>
                                    <style>
                                        .modal-dialog,
                                        .modal-content {
                                            height: 90%;
                                            margin-top: 70px;
                                        }

                                        /* .modal-body { */
                                            /* 100% = dialog height, 120px = header + footer */
                                            /* max-height: calc(100% - 120px);
                                            overflow-y: scroll; */
                                        /* } */
                                    </style>
                                    <!-- The Modal -->
                                    <div class="modal" id="return-form">
                                        <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                    
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                    
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h4 class="text-left">{{ $order->order_number }}</h4>

                                                            <form method="POST" action="{{ route('customer.return_order_update')}}" id="reply-form" class="form-horizontal">
                                                                @csrf
                                                                <input type="hidden" name="return_id" value="{{ optional($order->return_order)->id }}" />
                                                                <input type="hidden" name="order_id" value="{{ $order->id }}" />
                                                                @if($order->return_order)
                                                                    <div>Status: <strong class="text-capitalize {{ (optional($order->return_order)->status == 'accept') ? 'text-success' : 'text-danger' }}">{{ optional($order->return_order)->status }}</strong></div>
                                                                @endif
                                                                <div class="form-group">
                                                                    <label for="message-text-{{ $order->id }}" class="col-form-label">Reason For Return:</label>
                                                                    <textarea class="form-control" rows="10" name="client_remarks" id="message-text-{{ $order->id }}">{{ optional($order->return_order)->client_remarks }}</textarea>
                                                                </div>
                                                                <div>
                                                                    <strong class="{{ (optional($order->return_order)->status == 'accept') ? 'text-success' : 'text-danger' }}">Store Remarks: </strong><div style="text-indent: 100px;">{{ optional($order->return_order)->store_remarks }}</div>
                                                                </div>
                                                            </form>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                            <button type="submit" form="reply-form" class="btn btn-success">Submit</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                    
                                        </div>
                                        </div>
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
                            <div id='print_area'>
                                <table class='table' width='100%'>
                                    <tbody style='border: 1px solid lightgray;'>
                                    <tr>
                                        <td class="text-left align-items-center" width='30%'><h3
                                                style='display:inline;'>
                                            Customer Information
                                            </h3></td>
                                        <td class="text-right align-items-center" colspan='5'><p
                                                style='display:inline;'>E-Bazar Shopping</p></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Name: {{$order->user->name}}</td>
                                        <td colspan="2">Phone: {{$order->phone}}</td>
                                        <td colspan="2">Email: {{$order->email}}</td>
                                    </tr>
                                    <tr> 
                                        <td colspan="6">Address: {{ $order->address1 . ", " . $order->city->name . ", " . $order->state->name . ", " . $order->country->name }}</td>
                                    </tr>
                                    @if($order->address2)
                                        <tr>
                                            <td colspan="6">Second Address: {{$order->address2}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2">Post code: {{$order->postcode}}</td>
                                        @if($order->payment_id)
                                            <td>Payment: {{$order->payment->title}}</td>                                       
                                        @endif
                                        <td colspan="3" class="text-info">Dated: {{date("d/m/Y h:i A", strtotime($order->created_at))}}</td>
                                    </tr>
                                    @if($order->order_notes)
                                        <tr>
                                            <td colspan='6'>Notes: {{$order->order_notes}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-left align-items-center" width='30%'><h3
                                                style='display:inline;'>
                                            Store Information
                                            </h3></td>
                                        <td class="text-right align-items-center" colspan='5'><p
                                                style='display:inline;'>&nbsp;</p></td>
                                    </tr>
                                    <tr>
                                        {{-- {{ $order->store }} --}}
                                        <td colspan="2">Name: {{$order->store->name}}</td>
                                        <td colspan="2">Phone: {{$order->store->phone}}</td>
                                        <td colspan="2">Email: {{$order->store->email}}</td>
                                    </tr>
                                    <tr> 
                                        <td colspan="6">Address: {{ $order->store->address->address1 . ", " . $order->store->address->city->name . ", " . $order->store->address->state->name . ", " . $order->store->address->country->name }}</td>
                                    </tr>
                                    @if($order->store->address->address2)
                                        <tr>
                                            <td colspan="6">Second Address: {{$order->store->address->address2}}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <table class='table' width='100%'>
                                    <thead style='background:#f9fafc;border: 1px solid lightgray;'>
                                    <td class="text-center"><b>Product</b></td>
                                    <td class="text-center"><b>Product Cost </b></td>
                                    <td class="text-center"><b>Product Discount</b></td>
                                    <td class="text-center"><b>After Discount</b></td>
                                    <td class="text-center"><b>Quantity</b></td>
                                    <td class="text-center"><b>Line Total</b></td>
                                    </thead>
                                    <tbody style='border: 1px solid lightgray;'>
                                    @php
                                        $subTotal = 0;
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
                                            <td class="text-center align-items-center">{{ $product->price }}</td>
                                            <td class="text-center align-items-center">{{ $discount }}</td>
                                            <td class="text-center align-items-center">{{ $after_discount }}</td>
                                            <td class="text-center align-items-center">{{ $order_detail->sale_quantity }}</td>
                                            <td class="text-center align-items-center">{{ $order_detail->sale_quantity * $after_discount }}</td>
                                        </tr>
                                    @endforeach
                                    @php $product_delivery = $order->product_delivery ? $order->product_delivery : "To Be Advised"; @endphp
                                    <tr>
                                        <td class="text-right" colspan='5'>Sub Total</td>
                                        <td class="text-center" style='border-right: 1px solid lightgray;'>{{$subTotal}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan='5'>Discount</td>
                                        <td class="text-center" style='border-right: 1px solid lightgray;'>{{$totalDiscount}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan='5'>Coupon Discount</td>
                                        <td class="text-center" style='border-right: 1px solid lightgray;'>{{ ! is_null($order->coupon) ? $order->coupon :'00'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan='5'>After Discount</td>
                                        <td class="text-center" style='border-right: 1px solid lightgray;'>{{ $subTotal- $order->coupon}}</td>
                                    </tr>
                                    @if($order->shipping_id)
                                        <tr>
                                            <td class="text-right" colspan='5'>Shipping</td>
                                            <td class="text-center" style='border-right: 1px solid lightgray;'>{{ $order->shipping->type. '(' . $order->shipping->price . ')' }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="text-right" colspan='5'> Delivery Charges</td>
                                            <td class="text-center"
                                            style='border-right: 1px solid lightgray;'>{{$product_delivery}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-right" colspan='5'><b>Total Amount</b></td>
                                        <td class="text-center" style='border-right: 1px solid lightgray;'>Rs
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
                    <div class="form-group col-md-8">
                        <label>Delivery Charges</label>
                        <input id="product_delivery" type="text" class="form-control"
                                placeholder="Update delivery charges"/>
                    </div>
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
                    <div class="form-group col-md-8">
                        <label>Received amount</label>
                        <input id="paid_amount" type="text" class="form-control"
                                placeholder="Enter received amount"/>
                    </div>
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
            // headers: { 'csrftoken' : '{{ csrf_token() }}' },
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
                console.log(data);
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