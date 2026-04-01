@include('backend.includes.header')
@include('backend.includes.navbar')

<div class="row p-3 m-0  justify-content-between">
    <div class="row justify-content-between p-0 pt-2 m-0 ">
      <div class="row justify-content-between shadow  pt-0 ">
        <div class="col-12  p-0 mb-4" style="width: 100%;margin-top: 9px;">
            <h5 class="headingStyle">Upcoming Jobs Listing</h5>
        <table id="myTable" class=" display stripe">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Booking Date</th>
                    <th>Customer Name</th>
                    <th>Provider Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
          </table>
      </div>
      </div>
    </div>

<!-- Current Order section-->

</div>
<script>
$(document).ready( function () {
    var baseURL = {!! json_encode(url('/')) !!};
    var i = 0;
    $('#myTable').DataTable({
        processing : true,
        search: {
            return: true,
        },
        type: "POST",
        "ajax": baseURL + "/upcomingJobListing",
          "columns": [
            { "data": "id", 
                "mRender": function(data, type, row){
                    return i = i+1;
                },
            },
            { "data": "booking_date" },
            {
                "targets":-1,
                "data": "customer_name",
                "bSortable": false,
                "ilter":false,
                "mRender": function(data, type, row){
                    return "<a href='{{config('app.baseURL')}}/viewCustomerDetail/"+row.customer_id+"' class='action linkStyle'>"+row.customer_name+"</a>";
                },
            },
            {
                "targets":-1,
                "data": "provider_name",
                "bSortable": false,
                "ilter":false,
                "mRender": function(data, type, row){
                    return "<a href='{{config('app.baseURL')}}/viewProviderDetail/"+row.provider_id+"' class='action linkStyle'>"+row.provider_name+"</a>";
                },
            },
            {
                "targets":-1,
                "data": "id",
                "bSortable": false,
                "ilter":false,
                "mRender": function(data, type, row){
                    return "<a href='{{config('app.baseURL')}}/bookingDetail/"+row.id+"' class='action'><i class='fa fa-eye fa-2x' style='color: #46a4fa;font-size: 13px;'></i></a>";
                },
            },
        ]
   });
} );
</script>
@include('backend.includes.footer')
@include('backend.includes.script')