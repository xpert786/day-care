@php
 use Illuminate\Support\Facades\Session;
@endphp
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Commission</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/20a495a3d8.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
        @include('layouts.inc.adminsidebar')
      <!-- logo end -->
      <div class="col-7 col-md-9 col-lg-10">
        @php
        $fn = auth()->user()->first_name;
        $ln = auth()->user()->last_name;
        $first_character = substr($fn, 0, 1);
        $first_last_character = substr($ln, 0, 1);
          @endphp

        <div class="row p-0 justify-content-between shadow">
            {{-- <div class="col-3 p-4">
              <h1>Add Commission</h1>
            </div> --}}
            <div class="col-4 p-4 text-end">
              <span>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
               <img src="{{asset('asssets/img/bell.png')}}">
              <div class="dropdown" >
                <a class="btn  dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="profile" >{{$first_character}}{{$first_last_character}}</span>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{route('logout')}}">Log Out</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row p-0 shadow-sm mx-3 mt-4">
            <div class="col-12 p-4">
              <div class="login-page">
                        <div class="form">
                            <form class="login-form addNewClient" action="{{url('admin/commission/add')}}" method="post"  enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                @if(Session::has('failure'))
                                <div class='alert alert-danger alert-dismissible fade show mt-2'  id="wrong_current" role='alert'>
                                  {{Session::get('failure') }}
                                  <a type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></a>
                                </div>
                                @php
                                Session::forget('success');
                                @endphp
                                @endif
                              <div class="col-12">
                                <input type="number" name="c_name"  class="form-control-file " placeholder="in percentage" id="exampleFormControlFile1" required>
                                <label id="emailLabel" for="exampleFormControlFile1">Commission (%)</label>
                              </div>
                            </div>
                            <div class="row justify-content-end">
                              <div class="col-2 text-end">
                                <button type="submit" class="btn btn-warning">Submit</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  @include('layouts.inc.adminfooter')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#id_password");
   togglePassword.addEventListener("click", function (e) {
      // toggle the type attribute
      const type =
        password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      // toggle the eye slash icon
      this.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>
