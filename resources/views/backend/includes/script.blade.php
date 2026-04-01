<script>
    $(document).ready(function() {
        $("#school-form").validate({
            rules: {
            name: {
                required: true
            },
            board: {
                required: true,
            },
            classes: {
                required: true
            },
            residential: {
                required: true
            },
            ownership: {
                required: true,
            },
            campusSize: {
                required: true
            },
            highestGrade: {
                required: true
            },
            openingYear: {
                required: true,
            },
            hotel: {
                required: true
            },
            meuseum: {
                required: true
            },
            park: {
                required: true,
            },
            hospital: {
                required: true
            },
            address: {
                required: true,
            },
            description: {
                required: true
            },
            image: {
                required:  true,
                extension: "jpg|jpeg|png|bmp"
            }
            },
            messages : {
                name: {
                    required: "Please enter school name."
                },
                board: {
                    required: "Please enter school board."
                },
                classes: {
                    required: "Please enter number of classes."
                },
                residential: {
                    required: "Please enter residential area."
                },
                ownership: {
                    required: "Please enter school ownership."
                },
                campusSize: {
                    required: "Please enter school campus size."
                },
                highestGrade: {
                    required: "Please enter school highest grade."
                },
                openingYear: {
                    required: "Please enter school opening year."
                },
                hotel: {
                    required: "Please enter school neighbourhood hotel."
                },
                meuseum: {
                    required: "Please enter school neighbourhood meuseum."
                },
                park: {
                    required: "Please enter school neighbourhood park."
                },
                hospital: {
                    required: "Please enter school neighbourhood hospital."
                },
                address: {
                    required: "Please enter school address."
                },
                description: {
                    required: "Please enter school description."
                },
                image: {
                    required: "Please upload school image.",
                    extension: "Please upload valid image with extension .jpg, .jpeg, .png, .bmp."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        $("#program-form").validate({
            rules: {
            name: {
                required: true
            },
            address: {
                required: true,
            },
            description: {
                required: true
            },
            image: {
                required: true,
                extension: "jpg|jpeg|png|bmp"
            }
            },
            messages : {
                name: {
                    required: "Please enter program name."
                },
                address: {
                    required: "Please enter program address."
                },
                description: {
                    required: "Please enter program description."
                },
                image: {
                    required: "Please upload program image.",
                    extension: "Please upload valid image with extension .jpg, .jpeg, .png, .bmp."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        $("#provider-form").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                    emailExt: true
                },
                user_age: {
                    required: true
                },
                user_phone: {
                    required: true,
                },
                user_location: {
                    required: true
                },
                user_address: {
                    required: true
                },
                user_service_type: {
                    required: true,
                    valueNotEquals: "default"
                },
                services_offered: {
                    required: true
                },
                hourly_rate: {
                    required: true
                },
                description: {
                    required: true,
                },
                certification: {
                    required: true
                },
                user_photo: {
                    required: true,
                    extension: "jpg|jpeg|png|bmp"
                }
            },
            messages : {
                first_name: {
                    required: "Please enter first name."
                },
                last_name: {
                    required: "Please enter last name."
                },
                email: {
                    required: "Please enter email.",
                    emailExt: "Please enter valid email address."
                },
                user_age: {
                    required: "Please enter age."
                },
                user_phone: {
                    required: "Please enter contact number."
                },
                user_location: {
                    required: "Please enter location."
                },
                user_address: {
                    required: "Please enter address."
                },
                user_service_type: {
                    required      : "Please select service type.",
                    valueNotEquals: "Please select service type."
                },
                services_offered: {
                    required: "Please enter offered services."
                },
                hourly_rate: {
                    required: "Please enter hourly rate."
                },
                description: {
                    required: "Please enter profile description."
                },
                certification: {
                    required: "Please enter certifications detail."
                },
                user_photo: {
                    required: "Please upload profile image.",
                    extension: "Please upload valid image with extension .jpg, .jpeg, .png, .bmp."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        $("#admin-form").validate({
            rules: {
            name: {
                required: true
            },
            phone: {
                required: true,
            }
            },
            messages : {
                name: {
                    required: "Please enter name."
                },
                phone: {
                    required: "Please enter phone number."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        $("#change-form").validate({
            rules: {
            old: {
                required: true
            },
            newPassword: {
                required: true,
            },
            confirmPassword: {
                 equalTo : "#newPassword"
            }
            },
            messages : {
                old: {
                    required: "Please enter old password."
                },
                newPassword: {
                    required: "Please enter new password."
                },
                confirmPassword: {
                 equalTo : "New password and confirm password do not match."
            }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        // add the rule here
        $.validator.addMethod("valueNotEquals", function(value, element, arg){
          return arg !== value;
        }, "Value must not equal arg.");
        setTimeout(function() {
           $('.alert').fadeOut('fast');
        }, 3000); 
        
        //jobs
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;
        for (i = 0; i < dropdown.length; i++) {
          dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active1");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
              dropdownContent.style.display = "none";
            } else {
              dropdownContent.style.display = "block";
            }
          });
        }
        
        //settings
        var dropdown1 = document.getElementsByClassName("dropdown-btn1");
        var i1;
        for (i1 = 0; i1 < dropdown1.length; i1++) {
          dropdown1[i1].addEventListener("click", function() {
            this.classList.toggle("active1");
            var dropdownContent1 = this.nextElementSibling;
            if (dropdownContent1.style.display === "block") {
              dropdownContent1.style.display = "none";
            } else {
              dropdownContent1.style.display = "block";
            }
          });
        }
    });
</script>