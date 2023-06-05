@extends('layouts.admin')
@section('content') 

        <div class="row">
    <div class="nk-block">
            <div class="row g-gs">
                <div class="col-md-4" >
                    <div class="card card-bordered card-full">
                        <div class="nk-wg1">
                            <div class="nk-wg1-block">
                                <div class="nk-wg1-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90">
                                        <rect x="5" y="7" width="60" height="56" rx="7" ry="7" fill="#e3e7fe"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"></rect>
                                        <rect x="25" y="27" width="60" height="56" rx="7" ry="7" fill="#e3e7fe"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2">
                                        </rect>
                                        <rect x="15" y="17" width="60" height="56" rx="7" ry="7" fill="#fff"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"></rect>
                                        <line x1="15" y1="29" x2="75" y2="29" fill="none" stroke="#6576ff"
                                              stroke-miterlimit="10" stroke-width="2"></line>
                                        <circle cx="53" cy="23" r="2" fill="#c4cefe">
                                        </circle>
                                        <circle cx="60" cy="23" r="2" fill="#c4cefe"></circle>
                                        <circle cx="67" cy="23" r="2" fill="#c4cefe"></circle>
                                        <rect x="22" y="39" width="20" height="20" rx="2" ry="2" fill="none"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2">
                                        </rect>
                                        <circle cx="32" cy="45.81" r="2" fill="none" stroke="#6576ff"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"></circle>
                                        <path d="M29,54.31a3,3,0,0,1,6,0" fill="none" stroke="#6576ff"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        <line x1="49" y1="40" x2="69" y2="40" fill="none" stroke="#6576ff"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="49" y1="51" x2="69" y2="51" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="49" y1="57" x2="59" y2="57" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="64" y1="57" x2="66" y2="57" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="49" y1="46" x2="59" y2="46" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="64" y1="46" x2="66" y2="46" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                    </svg>
                                </div>
                                <div class="nk-wg1-text"><h5 class="title">Registered Companies</h5><hr>
                                    Total : {{\App\StoreModal::count()}}<br>
                                    New : {{\App\StoreModal::where('status','0')->count()}}</div>
                            </div>
                            <div class="nk-wg1-action"><a href="{{url('/superadmin/newBusiness')}}" class="link">
                                    <span>{{\App\StoreModal::where('status','0')->count()}}(New)</span> <em class="icon ni ni-chevron-right"></em></a>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-md-4" >
                        <div class="card card-bordered card-full">
                            <div class="nk-wg1">
                                <div class="nk-wg1-block">
                                    <div class="nk-wg1-img">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90">
                                            <rect x="5" y="7" width="60" height="56" rx="7" ry="7" fill="#e3e7fe"
                                                  stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"></rect>
                                            <rect x="25" y="27" width="60" height="56" rx="7" ry="7" fill="#e3e7fe"
                                                  stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2">
                                            </rect>
                                            <rect x="15" y="17" width="60" height="56" rx="7" ry="7" fill="#fff"
                                                  stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"></rect>
                                            <line x1="15" y1="29" x2="75" y2="29" fill="none" stroke="#6576ff"
                                                  stroke-miterlimit="10" stroke-width="2"></line>
                                            <circle cx="53" cy="23" r="2" fill="#c4cefe">
                                            </circle>
                                            <circle cx="60" cy="23" r="2" fill="#c4cefe"></circle>
                                            <circle cx="67" cy="23" r="2" fill="#c4cefe"></circle>
                                            <rect x="22" y="39" width="20" height="20" rx="2" ry="2" fill="none"
                                                  stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2">
                                            </rect>
                                            <circle cx="32" cy="45.81" r="2" fill="none" stroke="#6576ff"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"></circle>
                                            <path d="M29,54.31a3,3,0,0,1,6,0" fill="none" stroke="#6576ff"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            <line x1="49" y1="40" x2="69" y2="40" fill="none" stroke="#6576ff"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                            <line x1="49" y1="51" x2="69" y2="51" fill="none" stroke="#c4cefe"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                            <line x1="49" y1="57" x2="59" y2="57" fill="none" stroke="#c4cefe"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                            <line x1="64" y1="57" x2="66" y2="57" fill="none" stroke="#c4cefe"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                            <line x1="49" y1="46" x2="59" y2="46" fill="none" stroke="#c4cefe"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                            <line x1="64" y1="46" x2="66" y2="46" fill="none" stroke="#c4cefe"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        </svg>
                                    </div>
                                    <div class="nk-wg1-text"><h5 class="title">Number of Invoices</h5><hr>
                                        Total :{{\App\Invoice::count()}} <br>Paid :{{\App\Invoice::where('status',1)->count()}}</div>
                                </div>
                                <div class="nk-wg1-action"><a href="{{url('https://e-bazaaronline.com/invoices/list?status=unpaid')}}" class="link">
                                        <span>Pending :{{\App\Invoice::where('status',0)->count()}} </span> <em class="icon ni ni-chevron-right"></em></a>
                                </div>
                            </div>
                        </div>
                    </div>



                <div class="col-md-4" >
                    <div class="card card-bordered card-full">
                        <div class="nk-wg1">
                            <div class="nk-wg1-block">
                                <div class="nk-wg1-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90">
                                        <rect x="5" y="7" width="60" height="56" rx="7" ry="7" fill="#e3e7fe"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"></rect>
                                        <rect x="25" y="27" width="60" height="56" rx="7" ry="7" fill="#e3e7fe"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2">
                                        </rect>
                                        <rect x="15" y="17" width="60" height="56" rx="7" ry="7" fill="#fff"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"></rect>
                                        <line x1="15" y1="29" x2="75" y2="29" fill="none" stroke="#6576ff"
                                              stroke-miterlimit="10" stroke-width="2"></line>
                                        <circle cx="53" cy="23" r="2" fill="#c4cefe">
                                        </circle>
                                        <circle cx="60" cy="23" r="2" fill="#c4cefe"></circle>
                                        <circle cx="67" cy="23" r="2" fill="#c4cefe"></circle>
                                        <rect x="22" y="39" width="20" height="20" rx="2" ry="2" fill="none"
                                              stroke="#6576ff" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2">
                                        </rect>
                                        <circle cx="32" cy="45.81" r="2" fill="none" stroke="#6576ff"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"></circle>
                                        <path d="M29,54.31a3,3,0,0,1,6,0" fill="none" stroke="#6576ff"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        <line x1="49" y1="40" x2="69" y2="40" fill="none" stroke="#6576ff"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="49" y1="51" x2="69" y2="51" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="49" y1="57" x2="59" y2="57" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="64" y1="57" x2="66" y2="57" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="49" y1="46" x2="59" y2="46" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                        <line x1="64" y1="46" x2="66" y2="46" fill="none" stroke="#c4cefe"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                    </svg>
                                </div>
                                <div class="nk-wg1-text"><h5 class="title">Invoices/Payments</h5>
                                Received Payments  PKR : {{\App\Invoice::where('status','=',1)->sum('amount')}}<hr>
                                 Dues payments <br> PKR: {{\App\Invoice::where('status','=',0)->sum('amount')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div><br><br>
  

        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>

            $(document).ready(function (){
                var xValues = @json($monthsdata);
                var yValues = @json($count);
                var barColors = ["green", "brown","yellow","orange","brown","red", "green","blue","orange","brown","red", "green"];
                // console.log(yValues);
                new Chart("myChart", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        legend: {display: true},
                        title: {
                            display: true,
                            text: "Registered companies  in this year "
                        }
                    }
                });
            })

        </script>
 @endsection 


