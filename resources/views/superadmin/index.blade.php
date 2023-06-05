@extends('layouts.subscribelogin')
@section('content')
    <div class="nk-content-wrap">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">Welcome, {{ucfirst(Auth::user()->person_name) }} </h2>
                    <div class="nk-block-des">
                        <p>Welcome to our dashboard. Manage your account and your subscriptions.</p>
                    </div>
                </div>
            </div>
        </div><!-- .nk-block-head -->
        @if($user->paid==0)
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-md-4">
                        <div class="price-plan card card-bordered text-center">
                            <div class="card-inner">
                                <div class="price-plan-media">
                                    <img src="{{ url('images/plan-s1.svg')}}" alt="">
                                </div>
                                <div class="price-plan-info">
                                    <h5 class="title">Starter</h5>
                                    <span>If you are a small business amn please select this plan</span>
                                </div>
                                <div class="price-plan-amount">
                                    <div class="amount">$99 <span>/yr</span>
                                    </div>
                                    <span class="bill">1 User, Billed Yearly</span>
                                </div>
                                <div class="price-plan-action">
                                    <a href="#" class="btn btn-primary">Select Plan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="price-item card card-bordered text-center">
                            <div class="card-inner">
                                <div class="price-plan-media">
                                    <img src="{{ url('images/plan-s2.svg')}}" alt="">
                                </div>
                                <div class="price-plan-info">
                                    <h5 class="title">Pro</h5>
                                    <span>If you are a small business amn please select this plan</span>
                                </div>
                                <div class="price-plan-amount">
                                    <div class="amount">$299 <span>/yr</span>
                                    </div>
                                    <span class="bill">5 User, Billed Yearly</span>
                                </div>
                                <div class="price-plan-action">
                                    <a href="#" class="btn btn-primary">Select Plan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="price-item card card-bordered text-center">
                            <div class="card-inner">
                                <div class="price-plan-media">
                                    <img src="{{ url('images/plan-s3.svg')}}" alt="">
                                </div>
                                <div class="price-plan-info">
                                    <h5 class="title">Enterprise</h5>
                                    <span>If you are a small business amn please select this plan</span>
                                </div>
                                <div class="price-plan-amount">
                                    <div class="amount">$599 <span>/yr</span>
                                    </div>
                                    <span class="bill">20 User, Billed Yearly</span>
                                </div>
                                <div class="price-plan-action">
                                    <a href="#" class="btn btn-primary">Select Plan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif;
    </div>
@endsection
