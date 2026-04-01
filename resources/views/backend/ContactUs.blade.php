@include('backend.includes.header')

@include('backend.includes.navbar')



<div class="row p-3 m-0  justify-content-between">

    <div class="row justify-content-between p-0 pt-2 m-0 ">

      <div class="row justify-content-between shadow  pt-0 ">

        <div class="col-12  p-0 mb-4" style="width: 100%;margin-top: 9px;">
        <table id="myTable" class=" display stripe">

            <thead>

                <tr>

                    <th>Sr. No.</th>

                    <th>User Type</th>

                    <th>User Name</th>

                    <th>User Email</th>

                    <th>Message</th>

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

        "ajax": baseURL + "/contactUsListing",

          "columns": [

            { "data": "user_id", 

                "mRender": function(data, type, row){

                    return i = i+1;

                },

            },

            {

                "targets":-1,

                "data": "is_user_block",

                "bSortable": false,

                "ilter":false,

                "mRender": function(data, type, row){

                    if(row.role_id == 2){

                        return "<span>Customer</span>";

                    }
                    else{

                        return "<span>Provider</span>";

                    }

                },

                },

            { "data": "customer_details.user_name"},
            
            { "data": "customer_details.email"},

            // { "data": "message" },

            {
                    data:'message',
                    render: function(data){
                        if(data){
                            return (data.length > 10)?data.substring(0, 10)+'...':data;
                        } else {
                            return '';
                        }
                    },
                },


            {

                "targets":-1,

                "data": "is_user_block",

                "bSortable": false,

                "ilter":false,

                "mRender": function(data, type, row){

                    if(row.role_id == 2){

                        return "<a href='{{config('app.baseURL')}}/viewCustomerDetail/"+row.user_id+"' class='action'><i class='fa fa-eye fa-2x' style='color: #46a4fa;font-size: 13px;'></i></a>";

                    }else{

                        return "<a href='{{config('app.baseURL')}}/viewProviderDetail/"+row.user_id+"' class='action'><i class='fa fa-eye fa-2x' style='color: #46a4fa;font-size: 13px;'></i></a>";

                    }

                },

            },

        ]

   });

} );

</script>

@include('backend.includes.footer')

@include('backend.includes.script')