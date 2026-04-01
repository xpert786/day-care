@include('backend.includes.header')
@include('backend.includes.navbar')
<div class="col-7 col-md-12">
<div class="row p-0 shadow-sm mx-3 mt-4">
<div class="table-responsive table-responsive-data2" style="margin-top: 20px;">
<div class="row p-3">
<div class="col-12 col-md-6 ">
<h5 class="headingStyle">School Details</h5>
<div class="vist1">
<div class="row">
    <div class="col-12">
        
            @if($data -> user_photo != null)
                <img src="{{ URL::asset('public/school_images/').'/' }}{{$data -> school_image}}" class="imageStyle">
            @else
                <img src="{{ URL::asset('public/images/dummy.png'); }}" class="imageStyle">
            @endif
        
    </div>
</div>
<div class="row" style="margin-top:15px;">
<div class="col-5">
<p>Name :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_name}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Board :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_board}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Ownership :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_ownership}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Number Of Classes :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_classes}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Highest Grade :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_highest_grade}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Campus Size :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_campus_size}}</b></p>
</div>
</div>
</div>
</div>
<div class="col-12 col-md-6">
<h5 class="headingStyle">Address Details</h5>
<div class="vist1">
<div class="row">
<div class="col-5">
<p>Address :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_address}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Residential Area :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_residential}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Neighborhood Hotel :</p>
</div>
<div class="col-7">
<p><b>{{$data -> neighborhood_hotel}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Neighborhood Museum :</p>
</div>
<div class="col-7">
<p><b>{{$data -> neighborhood_museum}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Neighborhood Park :</p>
</div>
<div class="col-7">
<p><b>{{$data -> neighborhood_park}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Neighborhood Hospital :</p>
</div>
<div class="col-7">
<p><b>{{$data -> neighborhood_hospital}}</b></p>
</div>
</div><br>
<div class="row">
<div class="col-5">
<p>Description :</p>
</div>
<div class="col-7">
<p><b>{{$data -> school_description}}</b></p>
</div>
</div>
</div>
</div>
<div class="row" style="margin-top:20px;">
<div class="col-3">
  <button class="btn btn-primary btnStyle" style="padding: 12px 50px 12px 50px;"> <a href="{{route('schoolListingView')}}">Back</a></button>
</div>
</div>
</div>
</div>

<!-- Earning Section-->
<!-- Current Order section-->
</div>
</div>
</div>
@include('backend.includes.footer')
@include('backend.includes.script')