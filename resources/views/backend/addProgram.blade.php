@include('backend.includes.header')
@include('backend.includes.navbar')
<div class="row p-0 shadow-sm mx-3 mt-4">
  <div class="col-12 p-4">
      <h5 class="headingStyle">Add Scholarship Program</h5>
    <div class="login-page">
              <div class="form">
                <form class="login-form" action="{{route('saveProgram')}}" method="POST" id="program-form" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                    <div class="col-12">
                        <label id="emailLabel" for="email" class="addLabel">Program Name</label>
                        <input type="text" class="form-control" name="name">
                        
                    </div>
                    <div class="col-12">
                        <label id="emailLabel" for="email">Address</label>
                        <input type="text" class="form-control" id="inputEmail4" name="address">
                        
                    </div>
                    <div class="col-12">
                        <label id="emailLabel" for="phone" style="top: 14px;">Description</label>
                       <textarea rows="5" class="form-control" style="resize: none;" name="description"></textarea>
                        
                    </div>
                    <div class="col-12">
                         <label id="emailLabel" for="exampleFormControlFile1" style="top:15px;">Image</label>
                      <input type="file" class="form-control-file " id="exampleFormControlFile1" name="image">
                     
                    </div>
                  </div>
                  <div class="row justify-content-end">
                      <div class="col-2 text-end">
                      <button class="btn btn-primary btnStyle"> <a href="{{route('programListingView')}}">Back</a></button>
                    </div>
                    <div class="col-2 text-end">
                      <button class="btn btn-primary btnStyle"> <a>Save</a></button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
@include('backend.includes.footer')
@include('backend.includes.script')