@include('backend.includes.header')
@include('backend.includes.navbar')
<div class="row p-0 shadow-sm mx-3 mt-4">
  <div class="col-12 p-4">
      <h5 class="headingStyle">Add School</h5>
        <div class="login-page">
              <div class="form">
                <form class="login-form" action="{{route('saveSchool')}}" method="POST" id="school-form" enctype="multipart/form-data">
                    @csrf
                  <div class="row">
                    <div class="col-6">
                        <label id="emailLabel" for="email" class="addLabel">School Name</label>
                        <input type="text" class="form-control" name="name">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Board</label>
                        <input type="text" class="form-control"  name="board">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email" class="addLabel">Classes</label>
                        <input type="text" class="form-control" name="classes">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email" class="addLabel">Residential</label>
                        <input type="text" class="form-control" name="residential">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Ownership</label>
                        <input type="text" class="form-control"  name="ownership">
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email" class="addLabel">Campus Size</label>
                        <input type="text" class="form-control" name="campusSize">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Highest Grade</label>
                        <input type="text" class="form-control"  name="highestGrade">
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email" class="addLabel">Opening Year</label>
                        <input type="text" class="form-control" name="openingYear">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Neighbourhood Hotel</label>
                        <input type="text" class="form-control"  name="hotel">
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email" class="addLabel">Neighbourhood Meuseum</label>
                        <input type="text" class="form-control" name="meuseum">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Neighbourhood Park</label>
                        <input type="text" class="form-control"  name="park">
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email" class="addLabel">Neighbourhood Hospital</label>
                        <input type="text" class="form-control" name="hospital">
                        
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="email">Address</label>
                        <input type="text" class="form-control"  name="address">
                    </div>
                    <div class="col-6">
                        <label id="emailLabel" for="exampleFormControlFile1" style="top:15px;">School Image</label>
                      <input type="file" class="form-control-file " id="exampleFormControlFile1" name="image">
                      
                    </div>
                    <div class="col-12">
                        <label id="emailLabel" for="phone" style="top: 15px;">Description</label>
                       <textarea rows="5" class="form-control" style="resize: none; border:1px solid #e5f5ff;" name="description"></textarea>
                        
                    </div>
                  </div>
                  <div class="row justify-content-end">
                    <div class="col-2 text-end">
                      <button class="btn btn-primary btnStyle"> <a>Save</a></button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('backend.includes.footer')
@include('backend.includes.script')