@extends('frontend.layouts.customer-layout')
@section('title','Order Detail')
@section('main-content')
<div class="card m-5">
    <h5 class="card-header {{ ($order->status == 'Cancelled') ? 'text-danger' : 'text-dark' }}">Details Of Order # {{ $order->order_number }} @if($order->status=="Cancelled")<span
            style="float: right;" class="text-danger">This order has been cancelled</span>@endif
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
                            $statuses_grouped = $order->order_details->groupBy('status');
                            $last_four_statuses = $statuses_grouped->has("Received") || $statuses_grouped->has("Processed") || $statuses_grouped->has("Dispatched") || $statuses_grouped->has("Delivered");
                            $last_three_statuses = $statuses_grouped->has("Processed") || $statuses_grouped->has("Dispatched") || $statuses_grouped->has("Delivered");
                            $last_two_statuses = $statuses_grouped->has("Dispatched") || $statuses_grouped->has("Delivered");
                            $last_one_statuses = $statuses_grouped->has("Delivered");
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
                                    </div>
                                    <div class="Processed step status {{ ( $last_three_statuses ? 'step-completed' : 'step-disabled' ) }}">
                                        <span class="fa fa-edit text-center fa-2x {{ ( $last_three_statuses ? 'text-success' : 'text-muted ' ) }}"></span>
                                        <br />Order Processed<br />
                                        @if($statuses_grouped->has("Processed"))
                                            <small>{{ $statuses_grouped->get("Processed")->count() . " item" }}</small>
                                            <br />
                                        @endif
                                        <small>{{ (optional($order->order_details->groupBy("verified_date")->first()[0])->verified_date) ? date("d/m/Y h:i A", strtotime($order->order_details->groupBy("verified_date")->first()[0]->verified_date)):'---'}}</small>
                                    </div>
                                    <div class="Dispatched step status {{ ( $last_two_statuses ? 'step-completed' : 'step-disabled' ) }}">
                                        <span class="fa fa-tag text-center fa-2x {{ ( $last_two_statuses ? 'text-success' : 'text-muted ' ) }}"></span>
                                        <br />Dispatched <br />
                                        @if($statuses_grouped->has("Dispatched"))
                                            <small>{{ $statuses_grouped->get("Dispatched")->count() . " item" }}</small>
                                            <br />
                                        @endif
                                        <small>{{ (optional($order->order_details->groupBy("dispatched_date")->first()[0])->dispatched_date) ? date("d/m/Y h:i A", strtotime($order->order_details->groupBy("dispatched_date")->first()[0]->dispatched_date)): '---' }}</small><br />
                                    </div>
                                    <div class="Delivered step status {{ ($statuses_grouped->has('Delivered') ? 'step-completed' : 'step-disabled' ) }}">
                                        <span class="fa fa-check-circle text-center fa-2x {{ ($statuses_grouped->has('Delivered') ? 'text-success' : 'text-muted ' ) }}"></span>
                                        <br>Delivered<br>
                                        @if($statuses_grouped->has("Delivered"))
                                            <small>{{ $statuses_grouped->get("Delivered")->count() . " item" }}</small>
                                            <br />
                                        @endif
                                        <small>{{ (optional($order->order_details->groupBy("paid_date")->first()[0])->paid_date) ? date("d/m/Y h:i A", strtotime($order->order_details->groupBy("paid_date")->first()[0]->paid_date)): '---' }}</small>
                                    </div>
                                    <div class="step" style="cursor:pointer;" onclick="print_receipt();"><span
                                            class="fa fa-print text-center text-warning fa-2x"></span><br>Print<br><small>Print
                                            Receipt</small></div>
                                </div>
                            </div>
                        </div>
                        <div id='print_area'>
                            <table class='table' width='100%'>
                                <tbody style='border: 1px solid lightgray;'>
                                    <tr>
                                        <td class="text-left align-items-center" colspan="4"><h3 class="d-inline">Customer Information</h3></td>
                                        <td class="text-right align-items-center" colspan='2'><p>E-Bazar Shopping</p></td>
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
                                </tbody>
                            </table>
                            <table class='table' width='100%'>
                                <thead style='background:#f9fafc;border: 1px solid lightgray;'>
                                <td class="text-center"><b>Product</b></td>
                                <td class="text-center"><b>Store</b></td>
                                <td class="text-center"><b>Status</b></td>
                                <td class="text-center"><b>Cost & Discount</b></td>
                                {{-- <td class="text-center"><b>Product Discount</b></td> --}}
                                <td class="text-center"><b>Calculations</b></td>
                                {{-- <td class="text-center"><b>Quantity</b></td> --}}
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
                                        <td class="text-center align-items-center">
                                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-html="true" title="Click to view" onclick="showStoreDetails({{ json_encode($order_detail->product->store) }})">{{ $product->store->name }}
                                                {{-- <i class="fas fa-search"></i> --}}
                                            </a>
                                        </td>
                                        <td class="text-center align-items-center">@if($order_detail->return_order == null ) {{ $order_detail->status }} <br /> @endif
                                            @if($order_detail->status == 'Delivered')
                                                <span style="cursor:pointer;" onclick="returnOrderModal({{ json_encode($order_detail) }}, {{ json_encode($order->order_number)}})">
                                                    <span class="fa fa-reply text-danger"></span>
                                                    <small>Return Order</small>
                                                </span>
                                            @endif
                                        </td>
                                        @php
                                            $discount = ($product->price * $product->discount)/100;
                                            $product_price = $product->price;
                                            $after_discount = $product_price -  $discount;
                                            $subTotal = $subTotal + $after_discount * $order_detail->sale_quantity;
                                            $totalDiscount = $totalDiscount + $discount;
                                        @endphp
                                        <td class="text-center align-items-center">{{ $product->price }} @if($product->discount) <sup class="badge badge-pill badge-danger d-print-none">- {{$product->discount}}%</sup> <sup class="d-print-inline">- {{$product->discount}}%</sup> <br /><span> {{$product_price}} - {{$discount}}</span> @endif </td>
                                        {{-- <td class="text-center align-items-center">{{ $discount }}</td> --}}
                                        <td class="text-center align-items-center">{{ $after_discount }} * {{$order_detail->sale_quantity}}X</td>
                                        {{-- <td class="text-center align-items-center">{{ $order_detail->sale_quantity }}</td> --}}
                                        <td class="text-center align-items-center">{{ $order_detail->sale_quantity * $after_discount }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan='4'>&nbsp;</td>
                                    <td class="text-center">Sub Total</td>
                                    <td class="text-center" style='border-right: 1px solid lightgray;'>{{$subTotal}}</td>
                                </tr>
                                {{-- <tr>
                                    <td colspan='3'>&nbsp;</td>
                                    <td class="text-center">Total Discount</td>
                                    <td class="text-center" style='border-right: 1px solid lightgray;'>{{$totalDiscount}}</td>
                                </tr> --}}
                                @if(count( $order->coupons ) > 0)
                                    @php $subTotal = $subTotal - $order->coupons->sum('value'); @endphp
                                    <tr>
                                        <td colspan='4'>&nbsp;</td>
                                        <td class="text-center">
                                            @foreach ($order->coupons as $coupon)
                                                {{ $coupon->store->name }}'s coupon ({{$coupon->value}})<br />
                                            @endforeach
                                        </td>
                                        <td class="text-center" style='border-right: 1px solid lightgray;'>{{number_format( $order->coupons->sum('value'), 2)  }}</td>
                                    </tr>
                                @endif
                                @php $total_shipping = 0; @endphp
                                @foreach ($order->shippings as $shipping)
                                @php $total_shipping = ($shipping->shipping_id) ? $total_shipping + $shipping->price : $total_shipping @endphp
                                    <tr>
                                        <td colspan='4'>&nbsp;</td>
                                        <td class="text-center">{{ $shipping->store }}'s Delivery</td>
                                        <td class="text-center" style='border-right: 1px solid lightgray;'>
                                            {{ $shipping->price }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan='4'>&nbsp;</td>
                                    <td class="text-center"><b>Total Amount</b></td>
                                    <td class="text-center" style='border-right: 1px solid lightgray;'>Rs
                                        <b>{{number_format( $subTotal + $total_shipping, 2)}}</b>
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
@endsection


<div class="modal" id="return-form">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="return-order-modal-body">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <input type="hidden" form="reply-form" name="_token" value="{{ csrf_token() }}" />
            <button type="submit" form="reply-form" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

    </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="store-detail-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-5" id="store-detail-modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Complete Order</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
  
      </div>
    </div>
</div>

<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script>

function returnOrderModal(obj, orderNumber) {
    $('#return-form').modal('show');
    console.log(obj);
    var url = "{{ route('customer.return_order_update')}}";
    var dataToAppend = `<div class="container">
                <div class="row mt-3">
                    <div class="col-12">
                        <h4 class="text-left">${orderNumber}</h4>
                        <form method="POST" action="${url}" id="reply-form" class="form-horizontal">
                            <input type="hidden" name="return_id" value="${ obj?.return_order?.id ?? null }" />
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                            <input type="hidden" name="order_detail_id" value="${obj.id}" />
                            <input type="hidden" name="product_id" value="${obj.product_id}" />
                            <input type="hidden" name="order_id" value="${ obj.order_id }" />`;
                            if(obj.return_order)
                                dataToAppend += `<div>Status: <strong class="text-capitalize ${ (obj.return_order?.status == 'accept') ? 'text-success' : 'text-danger' }}">${ obj?.return_order?.status }</strong></div>`;

                            dataToAppend += `<div class="form-group">
                                <label for="message-text-${obj.id}" class="col-form-label">Reason For Return:</label>
                                <textarea class="form-control" rows="8" name="client_remarks" id="message-text-${obj.id}">${ obj?.return_order?.client_remarks ?? '' }</textarea>
                            </div>`;
                            if(obj?.return_order?.store_remarks)
                                dataToAppend +=`<div>
                                    <strong class="${ (obj?.return_order?.status == 'accept') ? 'text-success' : 'text-danger' }">Store Remarks: </strong><div style="text-indent: 100px;">${ obj?.return_order?.store_remarks ?? ''}</div>
                                </div>`;
                            dataToAppend += `
                        </form>
                    </div>                                                        
                </div>
            </div>`;
            $("#return-order-modal-body").html(dataToAppend);
}

function showStoreDetails(obj){

var store_image_directory = "{{ asset('images/stores/') }}";
var storeDetail = `<div class="modal-header">
                        <h4 class="modal-title text-center">${obj.name}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class='table table-sm table-bordered'>
                            <tr>
                                <th class='text-center'><strong class='text-capitalize'>Contact</strong></th>
                                <td>${obj.email}<br />${obj.phone}</td>
                            </tr>
                            <tr>
                                <th class='text-center'><strong class='text-capitalize'>Address</strong></th>
                                <td>${obj.address.address1 }, ${obj.address.city.name}, ${obj.address.state.name}, ${obj.address.country.name}.</td>
                            </tr>
                            <tr>
                                <th class='text-center'><strong class='text-capitalize'>Store Image</strong></th>
                                <td><img src="${store_image_directory}/${obj.image}" class="img-fluid zoom" style="max-width:120px" /></td>
                            </tr>
                            <tr>
                                <th class='text-center'><strong class='text-capitalize'>Description</strong></th>
                                <td>
                                    <p>${obj.short_description}</p>
                                </td>
                            </tr>
                            <tr>
                                <th class='text-center'><strong class='text-capitalize'>Details</strong></th>
                                <td>
                                    ${obj.long_description}
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>`;    

    $('#store-detail-modal-content').html(storeDetail);
    $('#store-detail-modal').modal('show');
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