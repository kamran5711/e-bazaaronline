@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
    <div class="card shadow mr-4 ml-4 mt-3 mb-5">
        <h5 class="card-header">Details Of Order # {{ $order->order_number }} 
            @if($order->status=="Cancelled")
                <span class="text-right text-danger">This order has been cancelled</span>
            @endif
        </h5>
        <div class="card-body">
            @if($order)
                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="">
                            @php
                                $type_array_colors = array("Received"=>"label-warning","Processed"=>"label-default","Dispatched"=>"label-info","Delivered"=>"label-success","Cancelled"=>"label-danger");
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
                            @php
                            // $order->order_details->groupBy('status')->count();
                            $statuses_grouped = $order->order_details->groupBy('status');
                            $last_four_statuses = $statuses_grouped->has("Received") || $statuses_grouped->has("Processed") || $statuses_grouped->has("Dispatched") || $statuses_grouped->has("Delivered");
                            $last_three_statuses = $statuses_grouped->has("Processed") || $statuses_grouped->has("Dispatched") || $statuses_grouped->has("Delivered");
                            $last_two_statuses = $statuses_grouped->has("Dispatched") || $statuses_grouped->has("Delivered");
                            $last_one_statuses = $statuses_grouped->has("Delivered");
                            // foreach ($statuses_grouped as $key => $value) {
                            //     echo $key . "<br />" . count($value);
                            // }
                            // exit;
                            @endphp
                            <div class="no-print">
                                <!-- Progress-->
                                <div class="steps">
                                    <div class="steps-body">
                                        <div class="Received step status {{ ( $last_four_statuses ? 'step-completed' : 'step-disabled' ) }}">
                                            <span class="fa fa-exclamation-circle text-center fa-2x {{ ( $last_four_statuses ? 'text-success' : 'text-muted ' ) }}"></span>
                                            <br />
                                            Order Received
                                            <br />
                                            @if($statuses_grouped->has("Received"))
                                                <small>{{ $statuses_grouped->get("Received")->count() . " item" }}</small>
                                                <br />
                                            @endif
                                            <small>{{ $order->created_at ? date("d/m/Y h:i A", strtotime($order->created_at)) : '---'}}</small>
                                            <br />
                                            <button class="btn btn-primary btn-xs" id="{{$order->id}}"
                                                    data-toggle="modal" data-target="#modal_verify_order">Process
                                            </button>
                                            <button class="btn btn-danger btn-xs"
                                                    onclick="if(confirm('Are you sure to Cancel this order?')){order_cancel({{$order->id}});}">
                                                Cancel
                                            </button>
                                        </div>
                                        <div class="Processed step status {{ ( $last_three_statuses ? 'step-completed' : 'step-disabled' ) }}">
                                            <span class="fa fa-edit text-center fa-2x {{ ( $last_three_statuses ? 'text-success' : 'text-muted ' ) }}"></span>
                                            <br />Order Processed<br />
                                            @if($statuses_grouped->has("Processed"))
                                                <small>{{ $statuses_grouped->get("Processed")->count() . " item" }}</small>
                                                <br />
                                            @endif
                                            <small>{{ $order->verified_date ? date("d/m/Y h:i A", strtotime($order->verified_date)):'---'}}</small>
                                            <br />
                                            <button class="btn btn-primary btn-xs"
                                                    onclick="$('#paid_amount').attr('value',$(this).attr('data-value'));"
                                                    id="{{$order->id}}"
                                                    data-value="{{$order->total_amount+$order->product_delivery}}"
                                                    data-toggle="modal" data-target="#modal_dispatch_order">Dispatch
                                                Order
                                            </button>
                                        </div>
                                        <div class="Dispatched step status {{ ( $last_two_statuses ? 'step-completed' : 'step-disabled' ) }}">
                                            <span class="fa fa-tag text-center fa-2x {{ ( $last_two_statuses ? 'text-success' : 'text-muted ' ) }}"></span>
                                            <br />Dispatched <br />
                                            @if($statuses_grouped->has("Dispatched"))
                                                <small>{{ $statuses_grouped->get("Dispatched")->count() . " item" }}</small>
                                                <br />
                                            @endif
                                            <small>{{$order->dispatched_date ? date("d/m/Y h:i A", strtotime($order->dispatched_date)):'---'}}</small><br />
                                            <button class="btn btn-primary btn-xs"
                                                    onclick="$('#paid_amount').attr('value',$(this).attr('data-value'));"
                                                    id="{{$order->id}}" data-value="" data-toggle="modal"
                                                    data-target="#modal_complete_order">Mark Delivered
                                            </button>
                                        </div>
                                        <div class="Delivered step status {{ ($statuses_grouped->has('Delivered') ? 'step-completed' : 'step-disabled' ) }}">
                                            <span class="fa fa-check-circle text-center fa-2x {{ ($statuses_grouped->has('Delivered') ? 'text-success' : 'text-muted ' ) }}"></span>
                                            <br>Delivered<br>
                                            @if($statuses_grouped->has("Delivered"))
                                                <small>{{ $statuses_grouped->get("Delivered")->count() . " item" }}</small>
                                                <br />
                                            @endif
                                            <small>{{$order->paid_date ? date("d/m/Y h:i A", strtotime($order->paid_date)):'---'}}</small>
                                        </div>
                                        <div class="step" style="cursor:pointer;" onclick="print_receipt();"><span
                                                class="fa fa-print text-center text-warning fa-2x"></span><br>Print<br><small>Print
                                                Receipt</small></div>
                                    </div>
                                </div>
                            </div>
                            @php $customer_email = $order->email?" (".$order->email.")":"";
                            @endphp
                            <div id='print_area'>
                                <table class='table' width='100%'>
                                    <tbody style='border: 1px solid lightgray;'>
                                        <tr>
                                            <td class="text-left align-items-center" colspan="3"><h3 class="d-inline">Customer Information</h3></td>
                                            <td class="text-right align-items-center" colspan='3'><p>E-Bazar Shopping</p></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Name: {{ ($order->name) ? $order->name : 'Nill' }}</td>
                                            <td colspan="2">Phone: {{ ($order->phone) ? $order->phone : 'Nill' }}</td>
                                            <td colspan="2">Email: {{  ($order->email) ? $order->email : 'Nill' }}</td>
                                        </tr>
                                        @if($order->country_id)
                                            <tr> 
                                                <td colspan="6">Address: 
                                                    {{ $order->address1 . ", " . $order->city->name . ", " . $order->state->name . ", " . $order->country->name }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if($order->address2)
                                            <tr>
                                                <td colspan="6">Second Address: {{$order->address2}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            @if($order->postcode)
                                                <td colspan="2">Post code: {{$order->postcode}}</td>
                                            @endif
                                            @if($order->payment_id)
                                                <td>Payment: {{$order->payment->title}}</td>                                       
                                            @endif
                                            <td colspan="{{ ($order->postcode) ? '3' : '5' }}" class="text-info">Dated: {{date("d/m/Y h:i A", strtotime($order->created_at))}}</td>
                                        </tr>
                                        @if($order->order_notes)
                                            <tr>
                                                <td colspan='6'>Notes: {{$order->order_notes}}</td>
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
                                        <td class="text-center"><b>Status</b></td>
                                        <td class="text-center d-print-none"><b>Mark</b></td>
                                    </thead>
                                    <tbody style='border: 1px solid lightgray;'>
                                    <form action="{{ route('proceed_order_status') }}" method="post" id="update_order_details_statuses" onsubmit="return updateOrderDetailsStatuses()">
                                        {{ csrf_field() }}
                                    </form>
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
                                                <label class="btn btn-default btn-dark btn-size-color">{{ $color  }}</label>
                                                <label class="btn btn-default btn-dark btn-size-color">{{ $size }}</label>
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
                                            <td class="text-center align-items-center">{{ $order_detail->status }}</td>
                                            <td class="text-center align-items-center"><input type="checkbox" name="order_detail_id[]" class="status-checkboxes" form="update_order_details_statuses" value="{{ $order_detail->id }}" checked product="{{ $product->title }}" color="{{ $color }}" _size="{{ $size }}" status="{{ $order_detail->status }}"/></td>
                                        </tr>
                                    @endforeach
                                    @php $product_delivery = $order->product_delivery ? $order->product_delivery : "To Be Advised"; @endphp
                                    <tr>
                                        <td colspan="2">Total Discount: {{$totalDiscount}}</td>
                                        <td colspan="2">Coupon Discount: {{ ! is_null($order->coupon) ? $order->coupon :'00'}}</td>
                                        <td colspan="2">After Discount: {{ $subTotal- $order->coupon}}</td>
                                        <td colspan="2" class="text-right"><button class="btn btn-primary rounded-0" type="submit" form="update_order_details_statuses">Proceed</button> &nbsp; <button type="button" class="btn btn-danger rounded-0" onclick="cancelItem()">Cancel</button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Shipping: {{ ($order->shipping_id) ? $order->shipping->type. '(' . $order->shipping->price . ')' : $product_delivery }}</td>
                                        <td colspan="4"></td>
                                        <td colspan="2">Total Amount: {{number_format( $subTotal- $order->coupon +$order->product_delivery,2)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
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
                        {{-- <div class="form-group col-md-8">
                            <label>Delivery Charges</label>
                            <input id="product_delivery" type="text" class="form-control"
                                   placeholder="Update delivery charges"/>
                        </div> --}}
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
    function updateOrderDetailsStatuses() {
        var dataToAppend = "<table>";
        $('input.status-checkboxes:checked').each(function () {
            var product = $(this).attr("product");
            var color = $(this).attr("color");
            var size = $(this).attr("_size");
            var status = $(this).attr("status");
            alert("its under development!");
            dataToAppend += `<tr><td>${ product }</td><td>${ color }</td><td>${ size }</td><td><input form="update_order_details_statusess" type="number" min="0" name""paid_amount[] /></td></tr>`;
        });
        dataToAppend += "</table>"; 
        var form = $("#update_order_details_statuses");
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                location.reload();
            }
        });
        return false;
    }
    function cancelItem() {
        var form = $("#update_order_details_statuses");
        $.ajax({
            type: form.attr('method'),
            url: "{{ route('proceed_to_cancel') }}",
            data: form.serialize(),
            success: function (data) {
                location.reload();
            }
        });
    }
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
