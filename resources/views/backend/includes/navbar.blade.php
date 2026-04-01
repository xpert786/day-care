
<style>
      #notifications_counter {
         display:block;
         position:absolute;
         background:#E1141E;
         color:#FFF;
         font-size:12px;
         font-weight:normal;
         padding:1px 3px;
         margin:-8px 0 0 25px;
         border-radius:2px;
         -moz-border-radius:2px; 
         -webkit-border-radius:2px;
         z-index:1;
         }
</style>
<body>

    <div class="container-fluid">

        <div class="row">

            <div class="col-2 shadow ">

                <div class="row p-0">

                    <div class="col-12 text-center" style="margin-top: 25px;">

                        <img src="{{ URL::asset('public/images/logo.png'); }}" width="50%">

                    </div>

                    <div class="col-12 p-0 text-white  manu">

                    <!--Main Navigation-->

                    <!-- Sidebar -->

                        <nav id="sidebarMenu" class=" d-lg-block sidebar">

                            <div class="list-group-flush  mt-4">

                                <a href="{{route('dashboard')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover {{ Request::routeIs('dashboard') ? 'active' : '' }}" aria-current="true" style="border-top: 1px solid #3c91e6;">

                                    <i class="fas fa-tachometer-alt fa-fw me-3 iconText"></i><span>Dashboard</span>

                                </a>

                                <a href="{{route('customerListingView')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover {{ Request::routeIs('customerListingView') ? 'active' : '' }}{{ Request::routeIs('unblock') ? 'active' : '' }}{{ Request::routeIs('block') ? 'active' : '' }}{{ Request::routeIs('viewCustomerDetail') ? 'active' : '' }}">

                                    <i class="fa fa-users me-3 iconText" aria-hidden="true"></i><span>Customers</span>

                                </a>

                                <a href="{{route('providerListingView')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover {{ Request::routeIs('providerListingView') ? 'active' : '' }}{{ Request::routeIs('addProviderView') ? 'active' : '' }}{{ Request::routeIs('unblockProvider') ? 'active' : '' }}{{ Request::routeIs('blockProvider') ? 'active' : '' }}{{ Request::routeIs('viewProviderDetail') ? 'active' : '' }}">

                                    <i class="fa fa-users me-3 iconText" aria-hidden="true"></i><span>Service Providers</span>

                                    </a>

                                <a href="{{route('schoolListingView')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover {{ Request::routeIs('schoolListingView') ? 'active' : '' }}{{ Request::routeIs('addSchoolView') ? 'active' : '' }}{{ Request::routeIs('unblockSchool') ? 'active' : '' }}{{ Request::routeIs('blockSchool') ? 'active' : '' }}{{ Request::routeIs('viewSchoolDetail') ? 'active' : '' }}">

                                    <i class="fa fa-building  me-3 iconText" aria-hidden="true"></i><span>Schools</span>

                                    </a>

                                <a href="{{route('programListingView')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover {{ Request::routeIs('programListingView') ? 'active' : '' }}{{ Request::routeIs('addProgramView') ? 'active' : '' }}{{ Request::routeIs('unblockProgram') ? 'active' : '' }}{{ Request::routeIs('blockProgram') ? 'active' : '' }}{{ Request::routeIs('viewProgramDetail') ? 'active' : '' }}">

                                    <i class="fa fa-star me-3 iconText" aria-hidden="true"></i><span>Scholarship Programs</span>

                                    </a>

                                <a href="javascript:void(0);" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover dropdown-btn {{ Request::routeIs('ongoingJobListingView') ? 'active' : '' }}{{ Request::routeIs('upcomingJobListingView') ? 'active' : '' }}{{ Request::routeIs('pastJobListingView') ? 'active' : '' }}{{ Request::routeIs('bookingDetail') ? 'active' : '' }}">

                                    <i class="fa fa-users me-3 iconText" aria-hidden="true"></i><span>Job Management <i class="fa fa-caret-down"></i></span>

                                    </a>

                                      <div class="dropdown-container">

                                        <a href="{{route('ongoingJobListingView')}}" class="dropdownChildStyle text-center">Ongoing Jobs</a>

                                        <a href="{{route('upcomingJobListingView')}}" class="dropdownChildStyle text-center">Upcoming Jobs</a>

                                        <a href="{{route('pastJobListingView')}}" class="dropdownChildStyle text-center">Past Jobs</a>

                                      </div>

                                <a href="{{url('admin/account/all')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover">
                                     
                                    <i class="fa fa-user-secret me-3 iconText" aria-hidden="true"></i><span>Accounts</span>

                                </a>

                                <a href="{{route('reviewRatingView')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover">

                                    <i class="fa fa-star-half-o me-3 iconText" aria-hidden="true"></i><span>Reviews and Ratings</span>

                                </a>

                                {{-- <a href="#" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover">

                                    <i class="fa fa-address-card me-3 iconText" aria-hidden="true"></i><span>Reports</span>

                                </a> --}}

                                <a href="{{url('admin/commission/all')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover">

                                    <i class="fa fa-percent me-3 iconText" aria-hidden="true"></i><span>Commissions</span>

                                </a>

                                {{-- <a href="#" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover">

                                    <i class="fa fa-bar-chart me-3 iconText" aria-hidden="true"></i><span>Analytics</span>

                                </a> --}}

                                <a href="{{route('contactUsView')}}" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover">

                                    <i class="fa fa-bar-chart me-3 iconText" aria-hidden="true"></i><span> Contact us queries</span>

                                </a>

                        
                                <a href="javascript:void(0);" class="list-group-item list-group-item-action py-4 px-4 navbarText side-hover dropdown-btn1 {{ Request::routeIs('logout') ? 'active' : '' }}{{ Request::routeIs('changePassword') ? 'active' : '' }}{{ Request::routeIs('editAdminProfile') ? 'active' : '' }}{{ Request::routeIs('updateAdminProfile') ? 'active' : '' }}">

                                    <i class="fa fa-cogs me-3 iconText" aria-hidden="true"></i><span>Settings <i class="fa fa-caret-down"></i></span>

                                    </a>

                                      <div class="dropdown-container">

                                        <a href="{{route('editAdminProfile')}}" class="dropdownChildStyle text-center">Edit Profile</a>

                                        <a href="{{route('changePassword')}}" class="dropdownChildStyle text-center">Change Password</a>

                                        <a href="{{route('logout')}}" class="dropdownChildStyle text-center">Logout</a>

                                      </div>

                </div>

                        </nav>

                    </div>

                </div>

            </div>

            <div class="col-10">

<div class="row p-0 justify-content-between shadow">

<div class="col-3" style="padding: 1.6rem!important;">

<h3>Hi, {{ Auth::user()->user_name }}</h3>

</div>

<div class="col-1 p-3 text-end">
    <?php
  
?>
<a href="{{url('notifications')}}"> <span id="notifications_counter"></span> <i class="fa fa-bell-o" aria-hidden="true"></i> </a>
  
</div>

</div>

<script>
// setInterval(function(){
//                 $('#notifications_counter').load( '{{url("countnotifiy")}}');
//             },1000);
</script>