<style>
    .shop-newsletter .newsletter-inner .btn {
        background: #EE4540;
        opacity: 0.9;
    }

    .shop-newsletter .newsletter-inner .btn:hover{
        background: #510A32;
    }
</style>
<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section mt-5 mb-5">
    <div class="container-fluid">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>Newsletter</h4>
                        <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                        <form action="{{route('subscribe')}}" method="post" class="newsletter-inner">
                            @csrf
                            <input name="email" placeholder="Your email address" required="" type="email">
                            <button class="btn active" type="submit">Subscribe</button>
                        </form>
                    </div>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->