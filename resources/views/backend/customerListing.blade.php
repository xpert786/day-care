@include('backend.includes.header')

@include('backend.includes.navbar')



<div class="row p-3 m-0  justify-content-between">

    <div class="row justify-content-between p-0 pt-2 m-0 ">

      <div class="row justify-content-between shadow  pt-0 ">

        <div class="col-12  p-0 mb-4" style="width: 100%;margin-top: 9px;">
            <div class="row justify-content-end" style="margin-top:-45px;">
                <div class="text-end mt-5">
                    <a style="float:right;" href="{{url('export_customer')}}" class="btn btn-success mx-2">Export to Excel</a>
                    <a style="float:right;" href="{{url('pdf_export_customer')}}" class="btn btn-info">Export to PDF</a>
                </div>
              
              </div>
        <table id="myTable" class=" display stripe">

            <thead>

                <tr>

                    <th>Sr. No.</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

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

        "ajax": baseURL + "/customerListing",

          "columns": [

            { "data": "user_id", 

                "mRender": function(data, type, row){

                    return i = i+1;

                },

            },

            { "data": "user_name" },

            { "data": "email" },

            { "data": "user_phone" },

            {

                "targets":-1,

                "data": "is_user_block",

                "bSortable": false,

                "ilter":false,

                "mRender": function(data, type, row){

                    if(row.is_user_block == 0){

                        return "<a href='{{config('app.baseURL')}}/viewCustomerDetail/"+row.user_id+"' class='action'><i class='fa fa-eye fa-2x' style='color: #46a4fa;font-size: 13px;'></i></a><a href='{{config('app.baseURL')}}/unblock/"+row.user_id+"'><i class='fa fa-toggle-off fa-2x' style='color:#ff1000;font-size: 15px;margin-left: 10px;'></i></a>";

                    }else{

                        return "<a href='{{config('app.baseURL')}}/viewCustomerDetail/"+row.user_id+"' class='action'><i class='fa fa-eye fa-2x' style='color: #46a4fa;font-size: 13px;'></i></a><a href='{{config('app.baseURL')}}/block/"+row.user_id+"'><i class='fa fa-toggle-off fa-2x' style='color:#7FDA4F;font-size: 15px;margin-left: 10px;'></i></a>";

                    }

                },

            },

        ]

   });

} );

</script>

@include('backend.includes.footer')

@include('backend.includes.script')