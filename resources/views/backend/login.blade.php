@include('backend.includes.login_header')
	<div class="container-fluid back p-5">
		<div class="row justify-content-center">
			<div class="col-9">
				<div class="row">
					<div class="col-12 col-md-4 p-0">
						<img src="{{ URL::asset('public/images/login.png'); }}" width="100%" height="100%">
					</div>
					<div class="col-12 col-md-8 bg-white  pt-4 shadow">
						<div class="row justify-content-center">
						    <div class="col-12 col-md-10">
          					    <div class="login-page">
        					        <div class="form">
                                        <h1 class="form-title mb-5">Login</h1>
                                        @if (Session::get('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
      						            <form class="login-form" action="{{route('login.check')}}" method="POST" id="login-form">
      						                @csrf
      						                <label id="emailLabel" for="email">Email</label>
        						            <input type="text" autocomplete="off" name="email"/>
        						            <label id="passLabel" for="email">Password</label>
        						            <input id="id_password" type="password" name="password" autocomplete="off"/>
        						            
        						            <!--<div class="checkBox">-->
              						  	   <!--     <input class="rememberCheck" type="checkbox" name="" id="" />-->
              						  	   <!--     <p class="rememberText">Remember Me</p>-->
            						        <!--</div>-->
        						            <div class="foot">
              						  	        <button >
              						  	            <a class="text-white">Login</a>
              						  	        </button>
          						  	        </div>
      						            </form>
        						    </div>
      							</div>
        					</div>
        				</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@include('backend.includes.login_footer')
@include('backend.includes.login_script')




