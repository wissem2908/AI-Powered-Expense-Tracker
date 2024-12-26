$(document).ready(function(){





    $('#login').click(function(){
        var username = $('#username').val();
        var password = $('#password').val();
            if(username == "" || password == ""){
                alert('enter username and password')
            }else{
                $.ajax({
                    type: 'POST',
                    url: 'php/login.php',
                    data: {
                        email: username,
                        password: password
                        },
                        success: function(data) {
                            console.log(data)
                                // Parse the JSON response
                var response = JSON.parse(data);
                            if (response.status == "success") {
                                window.location.href = "dashboard.php"; // Redirect on success
                            } else {
                                alert(response.message); // Show error message from response
                            }
                        }           
                 });
            }



                           

    })
})