@include('backend.includes.header')

@include('backend.includes.navbar')

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

<div class="row p-3 m-0  justify-content-between">

          <div class="col-2  shadow mx-1 pt-2 top-box" >

            <div class="row p-0">

              <div class="col-4" >

                <i class="fa fa-users main-icon" aria-hidden="true" ></i>

              </div>

              <div class="col-8 space">

                <span class="spanStyle">Customers</span>

                <h1>{{ $userCount }}</h1>

              </div>

            </div>

            

          </div>

          <div class="col-3  shadow mx-1 pt-2 top-box" >

            <div class="row p-0">

              <div class="col-4 px-4" >

                <i class="fa fa-users main-icon" aria-hidden="true" ></i>

              </div>

              <div class="col-8 space">

                <span class="spanStyle">Services Providers</span>

                <h1>{{ $providerCount }}</h1>

              </div>

            </div>

            

          </div>

          <div class="col-3  shadow mx-1 pt-2 top-box" >

            <div class="row p-0">

              <div class="col-4" >

                <i class="fa fa-user-plus main-icon" aria-hidden="true" ></i>

              </div>

              <div class="col-8 space">

                <span class="spanStyle">Requests</span>

                <h1>125</h1>

              </div>

            </div>

            

          </div>

          <div class="col-3  shadow mx-1 pt-2 top-box" >

            <div class="row p-0">

              <div class="col-4" >

                <i class="fa fa-usd main-icon" aria-hidden="true"></i>

              </div>

              <div class="col-8 space">

                <span class="spanStyle">Total Profit</span>

                <h1>125</h1>

              </div>

            </div>

            

          </div>

        </div>


      <div class="row p-4 border">
    <div class="chart-container"  style="width:100%;height:-30%;">
      <canvas id="mycanvas"></canvas>
    </div>



        <div class="row justify-content-between p-0 pt-2 m-0 ">

          <div class="row justify-content-between shadow  pt-0 ">

            <div class="col-12  p-0 border rounded  mb-4" style="width: 100%;">

            <table>

              <tr class="bg2" style="background-color: #46A4FA;">

                  <th colspan="5"><h2>Customers</h2></th>

                  <th colspan="1" class="viewAll"><a href="{{route('customerListingView')}}">View All <i class="fa fa-external-link" aria-hidden="true"></i></a></th>

                </tr>

                <tr>

                    <th>#</th>

                    <th>Image</th>

                    <th>Customer Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Status</th>

                </tr>

                @php

                    $i = 1

                @endphp

                @foreach ($users as $user)

                <tr class="trData">

                    <td>{{ $i }}</td>

                    @if ( $user->user_photo  == "")

                    <td><img src="{{ URL::asset('public/images/user.png')}}"  class="profile"></td>

                    @else

                    <td><img src="{{ URL::asset('public/customer_images/')}}/{{ $user->user_photo }}"  class="profile"></td>

                    @endif

                    <td>{{ $user->user_name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->user_phone }}</td>

                    @if ( $user->is_user_active  == "Active")

                    <td class="green">

                        {{ $user->is_user_active }}

                    </td>

                    @else

                    <td class="red">

                        {{ $user->is_user_active }}

                    </td>

                    @endif

                </tr>

                @php

                    $i = $i+1

                @endphp

                @endforeach

              </table>

          </div>

          </div>

        </div>

        <div class="row justify-content-between p-0 pt-2 m-0 ">

          <div class="row justify-content-between shadow  pt-0 ">

            <div class="col-12  p-0 border rounded  mb-4" style="width: 100%;">

            <table>

              <tr class="bg2" style="background-color: #46A4FA;">

                  <th colspan="5"><h2>Service Providers</h2></th>

                  <th colspan="1" class="viewAll"><a href="{{route('providerListingView')}}">View All <i class="fa fa-external-link" aria-hidden="true"></i></a></th>

                </tr>

                  <tr>

                    <th>#</th>

                    <th>Image</th>

                    <th>Service Provider Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Status</th>

                </tr>

                @php

                    $i = 1

                @endphp

                @foreach ($providers as $provider)

                <tr class="trData">

                    <td>{{ $i }}</td>

                    @if ( $provider->user_photo  == "")

                    <td><img src="{{ URL::asset('public/images/user.png')}}"  class="profile"></td>

                    @else

                    <td><img src="{{ URL::asset('public/provider_images/')}}/{{ $provider->user_photo }}"  class="profile"></td>

                    @endif

                    <td>{{ $provider->user_name }}</td>

                    <td>{{ $provider->email }}</td>

                    <td>{{ $provider->user_phone }}</td>

                    @if ( $provider->is_user_active  == "Active")

                    <td class="green">

                        {{ $provider->is_user_active }}

                    </td>

                    @else

                    <td class="red">

                        {{ $provider->is_user_active }}

                    </td>

                    @endif

                </tr>

                @php

                    $i = $i+1

                @endphp

                @endforeach

              </table>

          </div>

          </div>

        </div>

@include('backend.includes.footer')

@include('backend.includes.script')