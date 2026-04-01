@include('backend.includes.header')

@include('backend.includes.navbar')

<div class="col-7 col-md-12">

<div class="row p-0 shadow-sm mx-3 mt-4">

<div class="table-responsive table-responsive-data2" style="margin-top: 20px;">

<div class="row p-3">

<div class="col-12 col-md-5 ">

<h5 class="headingStyle">Customer Details</h5>

<div class="vist1">

<div class="row">

    <div class="col-12">

        

            @if($data -> user_photo != null)

                <img src="{{ URL::asset('public/customer_images/').'/' }}{{$data -> user_photo}}" class="imageStyle">

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

<p>Address :</p>

</div>

<div class="col-7">

<p><b>{{$data -> user_address}}</b></p>

</div>

</div><br>

<div class="row">

<div class="col-5">

<p>Number of Children :</p>

</div>

<div class="col-7">

<p><b>{{$childCount}}</b></p>

</div>

</div>

</div>

</div>

<div class="col-12 col-md-7">

<h5 class="headingStyle">Children Details</h5>

<div class="row">

    <table class="tableStyle">

        <thead>

                <th>#</th>

                <th style="width: 115px;">Image</th>

                <th>Name</th>

                <th>Father's Name</th>

                <th>Mother's Name</th>

                <th>Age</th>

                <th>Gender</th>

        </thead>

        <tbody>

            @php 

                $i = 1;

            @endphp

            @if(count($children)>0)

            @foreach($children as $child)

            <tr class="trData">

                <td>{{ $i }}</td>

                <td><img src="{{ URL::asset('public/child_images/').'/' }}{{$child -> child_photo}}" class="childimageStyle"></td>

                <td>{{ $child->first_name }} {{ $child->last_name }}</td>

                <td>{{ $child->father_name }}</td>

                <td>{{ $child->mother_name }}</td>

                <td>{{ $child->age }}</td>

                <td>{{ $child->gender }}</td>

            </tr>

            @php

                $i = $i+1;

            @endphp

            @endforeach

            @else

            <tr class="trData" colspan="7">

                <td>No records found.</td>

            </tr>

            @endif

        </tbody>

    </table>

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
<div class="row" style="margin-top:20px;">

<div class="col-3">

  <button class="btn btn-primary btnStyle" style="padding: 12px 50px 12px 50px;"> <a href="{{route('customerListingView')}}">Back</a></button>

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