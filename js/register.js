$(document).ready(function(){





    $('#register').click(function(){
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
            if(username == "" || password == "" || email==""){
                alert('enter username and password or email')
            }else{
                $.ajax({
                    type: 'POST',
                    url: 'php/register.php',
                    data: {
                        username: username,
                        email:email,
                        password: password
                        },
                        success: function(data) {
                            console.log(data)
                                // Parse the JSON response
                var response = JSON.parse(data);
                            if (response.status == "success") {
                                window.location.href = "index.html"; // Redirect on success
                            } else {
                                alert(response.message); // Show error message from response
                            }
                        }           
                 });
            }



                           

    })
})