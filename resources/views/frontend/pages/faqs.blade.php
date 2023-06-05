@extends('layouts.main')
@section('content')
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
<style>
.template_faq {
    background: #edf3fe none repeat scroll 0 0;
}
.panel-group {
    background: #fff none repeat scroll 0 0;
    border-radius: 3px;
    box-shadow: 0 5px 30px 0 rgba(0, 0, 0, 0.04);
    margin-bottom: 0;
    padding: 30px;
}
#accordion .panel {
    border: medium none;
    border-radius: 0;
    box-shadow: none;
    margin: 0 0 15px 10px;
}
#accordion .panel-heading {
    border-radius: 30px;
    padding: 0;
}
#accordion .panel-title a {
    background: #ffb900 none repeat scroll 0 0;
    border: 1px solid transparent;
    border-radius: 30px;
    color: #fff;
    display: block;
    font-size: 18px;
    font-weight: 600;
    padding: 12px 20px 12px 50px;
    position: relative;
    transition: all 0.3s ease 0s;
}
#accordion .panel-title a.collapsed {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #ddd;
    color: #333;
}
#accordion .panel-title a::after, #accordion .panel-title a.collapsed::after {
    background: #ffb900 none repeat scroll 0 0;
    border: 1px solid transparent;
    border-radius: 50%;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.58);
    color: #fff;
    content: "";
    font-family: fontawesome;
    font-size: 25px;
    height: 55px;
    left: -20px;
    line-height: 55px;
    position: absolute;
    text-align: center;
    top: -5px;
    transition: all 0.3s ease 0s;
    width: 55px;
}
#accordion .panel-title a.collapsed::after {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #ddd;
    box-shadow: none;
    color: #333;
    content: "";
}
#accordion .panel-body {
    background: transparent none repeat scroll 0 0;
    border-top: medium none;
    padding: 20px 25px 10px 9px;
    position: relative;
}
#accordion .panel-body p {
    border-left: 1px dashed #8c8c8c;
    padding-left: 25px;
}
</style>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <div class="container">
      <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">FAQS</li>
    </div>
  </ol>
</nav>

<div class="container mb-5 h-100" style="min-height: 350px!important;">
  <div class="row">
    <div class="col-md-12">
      <div class="section-title text-center wow zoomIn mt-3 mb-3">
        <h3>Frequently Asked Questions</h3>
      </div>
    </div>
  </div>
  <div class="row">				
    <div class="col-md-12">
      @if(count($faqs) > 0)
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach ($faqs as $faq)
            
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading-{{ $faq->id }}">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse-{{ $faq->id }}">
                {{ $faq->question }}
              </a>
            </h4>
          </div>
          <div id="collapse-{{ $faq->id }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-{{ $faq->id }}">
            <div class="panel-body">
              <p> {{ $faq->answer }} </p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <h4 class="text-info text-center">No FAQS are added yet, please add some.</h4>
      @endif
    </div><!--- END COL -->		
  </div><!--- END ROW -->			
</div>

<script>
  (function($) {
	'use strict';
	
	jQuery(document).on('ready', function(){
	
			$('a.page-scroll').on('click', function(e){
				var anchor = $(this);
				$('html, body').stop().animate({
					scrollTop: $(anchor.attr('href')).offset().top - 50
				}, 1500);
				e.preventDefault();
			});		

	}); 	

				
})(jQuery);

</script>
@endsection