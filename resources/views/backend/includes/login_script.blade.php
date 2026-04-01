<script src="Bootstrap/js/bootstrap.min.js" ></script>
<script>
    $(document).ready(function() {
        $("#login-form").validate({
            rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            }
            },
            messages : {
                email: {
                    required: "Please enter email-id.",
                    email: "The email should be in the format: abc@domain.tld"
                },
                password: {
                    required: "Please enter password."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        setTimeout(function() {
           $('.alert').fadeOut('fast');
        }, 3000); 
    });
    
</script>
</body>
</html>