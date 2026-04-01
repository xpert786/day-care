@include('backend.includes.header')

@include('backend.includes.navbar')

<div class="row p-3 m-0  justify-content-between">

    <div class="row justify-content-between p-0 pt-2 m-0 ">

      <div class="row justify-content-between shadow  pt-0 ">
        <div class="row p-0 shadow-sm mx-3 mt-4">
          <div class="col-12 p-4">
            <div class="login-page">
                      <div class="form">
                          <form class="login-form addNewClient" action="{{url('admin/commission/postEdit/'.$cat->id)}}" method="post"  enctype="multipart/form-data">
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
                              <label >Commission (%)</label>
                              <input type="text" name="c_name"  value= "{{$cat->percentage}}"class="form-control-file " placeholder="in percentage" id="exampleFormControlFile1" required>
                             
                            </div>
                          </div>
                          <div class="row justify-content-end">
                            <div class="col-2 text-end">
                              <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            
                          </div>
                        </form>
                      </div>
                    </div>
          </div>
        </div>


<!-- Current Order section-->



</div>

@include('backend.includes.footer')

@include('backend.includes.script')