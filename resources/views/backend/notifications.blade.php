@include('backend.includes.header')

@include('backend.includes.navbar')


<div class="row p-3 m-0  justify-content-between">

  <div class="row justify-content-between p-0 pt-2 m-0 ">

    {{-- <div class="row justify-content-between shadow  pt-0 "> --}}

      <div class="col-12  p-0 mb-4" style="width: 100%;margin-top: 9px;">

          <div class="row justify-content-between" id="test">

          </div>

        </div>
      </div>
    </div>
          </div>
         </div>
        </div>
      </div>
    </div>


@include('backend.includes.footer')

@include('backend.includes.script')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script>
      const togglePassword = document.querySelector("#togglePassword");
      const password = document.querySelector("#id_password");



     togglePassword.addEventListener("click", function (e) {
        // toggle the type attribute
        const type =
          password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        // toggle the eye slash icon
        this.classList.toggle("fa-eye-slash");
      });
    </script>
    <script >

            // setInterval(function(){
            //     $('#test').load( '{{url("dynamicnotifiy")}}');
            // },1000);

      function change_image(image){

                 var container = document.getElementById("main-image");

                container.src = image.src;
            }



            document.addEventListener("DOMContentLoaded", function(event) {







            });
    </script>
    <script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
