@include('backend.includes.header')
@include('backend.includes.navbar')
<div class="row p-0 shadow-sm mx-3 mt-4">
  <div class="col-12 p-4">
      @if (Session::get('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 11px!important;">
                {{ Session::get('error') }}
            </div>
        @endif
      <h5 class="headingStyle">Add Service Provider</h5>
    <div class="login-page">
              <div class="form">
                <form class="login-form" action="{{route('saveProvider')}}" method="POST" id="provider-form" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                    <div class="col-6 ">
                        <label id="emailLabel" for="email" class="addLabel">First Name</label>
                        <input type="text" class="form-control" name="first_name">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Last Name</label>
                       <input type="text" class="form-control" name="last_name">
                  
                    </div>
                    <div class="col-6 mt-2">
                        <label id="emailLabel" for="Number">Age</label>
                        <input type="text" class="form-control" id="inputEmail4"name="user_age" >
                  
                    </div>
                    <div class="col-6 mt-2">
                        <label id="emailLabel" for="Vehicletype">Hourly rate</label>
                        <input type="text" class="form-control" id="" name="hourly_rate">
                  
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Email</label>
                        <input type="email" class="form-control" id="" name="email">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="phone">Phone Number</label>
                        <input type="number" class="form-control" id="" name="user_phone">
                  
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="inputAddress">Location</label>
                         <input type="text" class="form-control" id="" name="user_location">
                  
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="inputAddress">Address</label>
                         <input type="text" class="form-control" id="" name="user_address">
                  
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="inputZip" style="top:-51px; ">Service Type</label>
                        <select class="form-control" name="user_service_type" style="font-size: 12px; border:1px solid #e5f5ff;">
                            <option value="default">Choose Service Type</option>
                            <option value="1">Day Care</option>
                            <option value="2">Charter School</option>
                            <option value="3">Therapist</option>
                            <option value="4">Advisor</option>
                        </select>
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="exampleFormControlFile1" style="top:14px;">Profile Image</label>
                      <input type="file" class="form-control-file " id="exampleFormControlFile1" name="user_photo">
                      
                    </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-6 ">
                          <label id="emailLabel" for="Color" style="top:14px;">Services Offered</label>
                        <textarea rows="5" class="form-control" style="resize: none; border:1px solid #e5f5ff;" name="services_offered"></textarea>
                  
                    </div>
                    
                    <div class="col-6 ">
                        <label id="emailLabel" for="Color" style="top:14px;">Certifications</label>
                        <textarea rows="5" class="form-control" style="resize: none; border:1px solid #e5f5ff;" name="certification"></textarea>
                  
                    </div>
                    <div class="col-12 ">
                        <label id="emailLabel" for="Color" style="top:14px;">Profile Description</label>
                        <textarea rows="5" class="form-control" style="resize: none; border:1px solid #e5f5ff;" name="description"></textarea>
                  
                    </div>
                  </div>
                  <div class="row justify-content-between">
                    <div class="col-2 text-end">
                      <button class="btn btn-primary btnStyle"> <a href="{{route('providerListingView')}}">Back</a></button>
                    </div>
                    <div class="col-2 text-end">
                      <button class="btn btn-primary btnStyle"> <a>Save</a></button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div></div>
@include('backend.includes.footer')
@include('backend.includes.script')