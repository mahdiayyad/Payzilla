// Add User From Admin Side
var addAccountElement = document.querySelector('.addAccount');
    addAccountElement.addEventListener('click', function() {
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var type = $('#type').val();
        var status = $('#status').val();
        var token = $('#token').val();
        $.ajax({
            type: 'POST',
            url: "/users/create",
            data: {
                name: name,
                email: email,
                password: password,
                type: type,
                status: status,
                _token: token
            },
            success: function(data) {
                if (data.success == true) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#type').val('');
                        $('#status').val('');
                        $('#token').val('');
                    });
                } else {
                   Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            }
        });
    });