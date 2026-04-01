<meta name="csrf-token" content="{{ csrf_token() }}">
@include('backend.includes.header')

@include('backend.includes.navbar')

<div class="row p-3 m-0  justify-content-between">

    <div class="row justify-content-between p-0 pt-2 m-0 ">

      <div class="row justify-content-between shadow  pt-0 ">

        <div class="col-12  p-0 mb-4" style="width: 100%;margin-top: 9px;">

            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <h5>Account Details</h5>
                                <div class="row ">
                                    <div class="col-md-12 mt-3">
                                        <div class="border p-2 ">
                                            <label> Total Earning's</label>
                                            <h6>${{ $i}}</h6>
                                        </div>
                                    </div>
                
                                    <div class="col-md-12 mt-3">
                                        <div class="border p-2 ">
                                            <label> View earnings of the month/day</label>
                                            <h6>
                                                <div class="row">
                                                <div class="col-md-3 mt-3">
                                                <input type="date" id="date" class="form-control">
                                                </div>
                                                <div class="col-md-3 mt-3">
                                                <select class="form-control" name="" id="month">
                                                    <option value="1" >January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11" <?php $month = date('m'); if($month == 11){
                                                        echo "selected";
                                                     } else {
                                                        echo "selected";
                                                     }?>>November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <button type="button" onclick="reload();" class="btn btn-success">Reset</button>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <div class="border p-1">
                                                <label> Earning's</label>
                                                <h6>$<span id="mon_ear">{{ $j}}</span></h6>
                                            </div>
                                        </div>
                                            </h6>
                                        </div>
                                    </div>
                
                                    <div class="row shadow-sm  mx-3 mt-4" style="border-radius: 20px; ">
                                        <div class="col-12 p-2 order-list">
                                          <h2>View Total Transaction's</h2>
                                        </div>
                                        <hr>
                
                                        <div class="row  text-center">
                                          <div class="col-12 p-0">
                                            <table class="table table-borderless" id="myTable">
                                              <thead>
                                                <tr>
                                                        <th>S No.</th>
                                                        <th>Date / Time</th>
                                                        <th>Transaction ID</th>
                                                        <th>Payment Mode</th>
                                                         <th>Booking Start Date</th>
                                                        <th>Booking End Date</th>
                                                        <th>Provider Name</th>
                                                        <th>Customer Name</th>
                                  
                                                        <th>Booking Status</th>
                                                        <th>Amount Paid ($)</th>
                                                        {{-- <th>Order Status</th> --}}
                                                        {{-- <th>Action</th> id="footer-table" --}}
                                                </tr>
                                              </thead>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
    </div>
<!-- Current Order section-->

</div>
<script>
    function reload(){
        location.reload();
    }
                      $(document).ready(function () {
                          $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });
    
                          $('#date').on('change', function() {
                            var get_mon = $(this).val();
                            $.ajax({
                                type: "POST",
                                url: "get_mon_earn",
                                data: {get_mon:get_mon,dt:"dt"},
                                success: function (response) {
    
                                    $('#mon_ear').text(response);
                                }
                            });
                        });
    
                          $('#month').on('change', function() {
                            var get_mon = $(this).find(":selected").val();
                            $.ajax({
                                type: "POST",
                                url: "get_mon_earn",
                                data: {get_mon:get_mon,mon:"mon"},
                                success: function (response) {
                                    $('#mon_ear').text(response);
                                }
                            });
                        });
    
                      });
    
                
                    </script>
                   
<script>

$(document).ready( function () {

    var baseURL = {!! json_encode(url('/')) !!};

    var i=0;

    $('#myTable').DataTable({

        processing : true,

        search: {

            return: true,

        },

        type: "POST",

        "ajax": baseURL + "/admin/account/allData",

          "columns": [

            { "data": "id",

                "mRender": function(data, type, row){

                    return i = i+1;

                },

            },

            { "data": "created_at" },

            { "data": "transaction_id" },

             { "data": "id",

                "mRender": function(data, type, row){

                    return "Online - Paypal";

                },

            },
                 { "data": "booking_date" },


            { "data": "booking_end_date" },

        { "data": "provider_details.user_name" },
          {  "defaultContent": "","data": "customer_details.user_name" },
            {
                "targets":-1,

                "data": "booking_status",

                "bSortable": false,

                "ilter":false,

                "mRender": function(data, type, row){

                    if(row.booking_status == 1){
                        return "<span>Pending</span>";

                    }
                    else if (row.booking_status == 2){

                         return "<span>Accepted</span>";

                    }
                      else if (row.booking_status == 3){

                         return "<span>Rejected</span>";

                    }
                      else if (row.booking_status == 4){

                         return "<span>Completed</span>";

                    }

                },

            },

              { "data": "amount" },


          ]

   });

} );

</script>

{{-- @include('backend.includes.footer') --}}

@include('backend.includes.script')