@include('backend.includes.header')
@include('backend.includes.navbar')
<div class="row p-0 shadow-sm mx-3 mt-4">
    @if (Session::get('error'))
            <div class="alert alert-danger" role="alert" style="margin-top: 11px!important;">
                {{ Session::get('error') }}
            </div>
        @endif
        @if (Session::get('success'))
            <div class="alert alert-success" role="alert" style="margin-top: 11px!important;">
                {{ Session::get('success') }}
            </div>
        @endif
  <div class="col-12 p-4">
      <h5 class="headingStyle">Change Password</h5>
    <div class="login-page">
              <div class="form">
                <form class="login-form" action="{{route('updatePassword')}}" method="POST" id="change-form">
                    @csrf
                  <div class="row">
                    <div class="col-12">
                        <label id="emailLabel" for="email" class="addLabel">Old Password</label>
                        <input type="password" class="form-control" name="old">
                        
                    </div>
                    <div class="col-12">
                        <label id="emailLabel" for="email">New Password</label>
                        <input type="password" class="form-control"  name="newPassword" id="newPassword">
                        
                    </div>
                    <div class="col-12">
                        <label id="emailLabel" for="email">Confirm Password</label>
                        <input type="password" class="form-control" name="confirmPassword">
                        
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