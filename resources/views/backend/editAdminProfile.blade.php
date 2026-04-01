@include('backend.includes.header')
@include('backend.includes.navbar')
<div class="row p-0 shadow-sm mx-3 mt-4">
  <div class="col-12 p-4">
      <h5 class="headingStyle">Edit Admin Profile</h5>
    <div class="login-page">
              <div class="form">
                <form class="login-form" action="{{route('updateAdminProfile')}}" method="POST" id="admin-form" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                    <div class="col-12">
                        <label id="emailLabel" for="email" class="addLabel">Name</label>
                        <input type="text" class="form-control" name="name" value="{{$data -> user_name}}">
                        
                    </div>
                    <div class="col-12">
                        <label id="emailLabel" for="email">Phone Number</label>
                        <input type="text" class="form-control" id="inputEmail4" name="phone" value="{{$data -> user_phone}}">
                        
                    </div>
                  </div>
                  <div class="row justify-content-end">
                      <div class="col-2 text-end">
                      <button class="btn btn-primary btnStyle"> <a href="{{route('dashboard')}}">Cancel</a></button>
                      </div>
                    <div class="col-2 text-end">
                      <button class="btn btn-primary btnStyle"> <a>Update</a></button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
@include('backend.includes.footer')
@include('backend.includes.script')