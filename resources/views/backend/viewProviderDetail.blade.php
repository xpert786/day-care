@include('backend.includes.header')

@include('backend.includes.navbar')

<div class="col-7 col-md-12">

<div class="row p-0 shadow-sm mx-3 mt-4">

<div class="table-responsive table-responsive-data2" style="margin-top: 20px;">

<div class="row p-3">

<div class="col-12 col-md-6 ">

<h5 class="headingStyle">Service Provider Details</h5>

<div class="vist1">

<div class="row">

    <div class="col-12">

        

            @if($data -> user_photo != null)

                <img src="{{ URL::asset('public/provider_images/').'/' }}{{$data -> user_photo}}" class="imageStyle">

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

<p><b>{{$data -> user_name}}</b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Phone Number :</p>

</div>

<div class="col-7">

<p><b>{{$data -> user_phone}}</b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Email :</p>

</div>

<div class="col-7">

<p><b>{{$data -> email}}</b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Location :</p>

</div>

<div class="col-7">

<p><b>{{$data -> user_location}}</b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Address :</p>

</div>

<div class="col-7">

<p><b>{{$data -> user_address}}</b></p>

</div>

</div>

</div>

</div>

<div class="col-12 col-md-6">

<h5 class="headingStyle">Service Details</h5>

<div class="vist1">

<div class="row">

<div class="col-5">

<p>Hourly Rate :</p>

</div>

<div class="col-7">

<p><b>$ {{$data -> hourly_rate}}</b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Service Type :</p>

</div>

<div class="col-7">

<p><b>

    @if($data -> user_service_type == 1)

        Day Care

    @elseif($data -> user_service_type == 2)

        Charter School

    @elseif($data -> user_service_type == 3)

        Therapist

    @else

        Advisor

    @endif

    </b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Services Offered :</p>

</div>

<div class="col-7">

<p><b>{{$data -> services_offered}}</b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Description :</p>

</div>

<div class="col-7">

<p><b>{{$data -> description}}</b></p>

</div>

</div>

</div>


<div class="col-12 col-md-12 mt-3">

    <h5 class="headingStyle">Message's</h5>
    
    <div class="vist1">
      
    <div class="row">
       <?php
        $ContactUs = \App\Models\ContactUs::where('user_id', '=', $data->user_id)->get();
        foreach ($ContactUs as $ContactUsdata){ ?>
            <div class="col-12">
                <label> <?php echo date_format($ContactUsdata->created_at,"d/m/Y g:i:A");?></label>
            <textarea disabled type="text" name="description" class="form-control" id="inputEmail4" placeholder="Product Description" required>{{$ContactUsdata->message}}</textarea>
        </div>
        <?php   }
       ?>
    
    </div>
    
    </div>
    
    </div>

</div>



<div class="row" style="margin-top:20px;">

<div class="col-3">

  <button class="btn btn-primary btnStyle" style="padding: 12px 50px 12px 50px;"> <a href="{{route('providerListingView')}}">Back</a></button>

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