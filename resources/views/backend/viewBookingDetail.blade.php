@include('backend.includes.header')
@include('backend.includes.navbar')
<div class="col-7 col-md-12">
<div class="row p-0 shadow-sm mx-3 mt-4">
<div class="table-responsive table-responsive-data2" style="margin-top: 20px;">
<div class="row p-3">
<div class="col-12 col-md-5 ">
<h5 class="headingStyle">Booking Details</h5>
<div class="vist1">
<div class="row" style="margin-top:15px;">
<div class="col-5">
<p>Booking Date :</p>
</div>
<div class="col-7">
<p><b>{{$data -> booking_date}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Customer Name :</p>
</div>
<div class="col-7">
<p><b>{{$data -> customer_name}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Provider Name :</p>
</div>
<div class="col-7">
<p><b>{{$data -> provider_name}}</b></p>
</div>
</div>
</div>
</div>
<!--<div class="row" style="margin-top:20px;">-->
<!--<div class="col-3">-->
<!--  <button class="btn btn-primary btnStyle" style="padding: 12px 50px 12px 50px;"> <a href="{{route('ongoingJobListingView')}}">Back</a></button>-->
<!--</div>-->
<!--</div>-->
</div>
</div>

<!-- Earning Section-->
<!-- Current Order section-->
</div>
</div>
</div>
@include('backend.includes.footer')
@include('backend.includes.script')