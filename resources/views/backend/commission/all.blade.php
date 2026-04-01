@include('backend.includes.header')

@include('backend.includes.navbar')



<div class="row p-3 m-0  justify-content-between">

    <div class="row justify-content-between p-0 pt-2 m-0 ">

      <div class="row justify-content-between shadow  pt-0 ">

        <div class="col-12  p-0 mb-4" style="width: 100%;margin-top: 9px;">
        <table id="myTable" class=" display stripe">

            <thead>

                <tr>

                  <th>S. No</th>
                         <th>Commission  (%)</th>
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

        "ajax": baseURL + "/admin/commission/allData",

        
        "columns":[{
            "mData":"id"
          },
          {
            "mData":"percentage"
          },
          {
          "targets":-1,
          "mData": "Action",
          "bSortable": false,
          "ilter":false,
          "mRender": function(data, type, row){
            return "<a href='{{config('app.baseURL')}}/admin/commission/editCommission/"+row.id+"'><i class='fa-solid fa-pencil text-warning'></i></a>";
        },
          },
          ]

   });

} );

</script>

@include('backend.includes.footer')

@include('backend.includes.script')