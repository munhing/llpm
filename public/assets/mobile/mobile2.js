/*
.mobile-btn-find
.mobile-form-confirm
.mobile-input
.mobile-result

.mobile-btn-confirm

*/
var MobileView = function() {

    var info = {};

    $('.mobile-btn-confirm').on('click', function(e){

        // stop from submitting
        e.preventDefault();

        if ($('input[type="checkbox"]:checked').length > 0) {
            // alert('confirm?');
            $('.password-modal-sm').modal('show');
        } else {
            alert('Nothing was selected');
        }
                      
    });

    $('.password-modal-sm').on('shown.bs.modal', function () {
        $('#password').focus();
    });
    
    $('.password-btn').on('click', function(e){

        e.preventDefault();

        var submitForm = true;

        // ajax to check on the password is correct
        var formData = $('.form-password').serialize();
        var pwd = $('#password').val();

        submitForm = validatePassword(pwd);

        if(submitForm) {

            $.ajax({
                url: info["url_pwd_check"],
                type: 'POST',
                data: formData,
                success: function(data) {
                    // alert(data);

                    if (data == 1) {

                        var arr_confirmation = [];
                        var arr_carrier = [];
                        var arr_lifter = [];

                        $('tr').each(function(index,rowhtml){
                         var checked = $('input[type="checkbox"]:checked',rowhtml).length;
                         if (checked == 1){
                           arr_confirmation.push($('input[type="checkbox"]:checked',rowhtml).val());
                           arr_carrier.push(t.fnGetData( rowhtml, 9 ));
                           arr_lifter.push(t.fnGetData( rowhtml, 10 ));
                         }
                        });

                        $('#a_confirmation').val(JSON.stringify(arr_confirmation));
                        $('#a_carrier').val(JSON.stringify(arr_carrier));
                        $('#a_lifter').val(JSON.stringify(arr_lifter));

                        console.log(arr_confirmation);      
                        console.log(arr_carrier);      
                        console.log(arr_lifter);      
                        console.log(arr_lifter); 

                        $('#mobile-form-confirm').submit();
                    } else {
                        alert('Password is Incorrect!');
                    }              

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    
    });

    var validatePassword = function(password){

        // must not be blank
        if(password.trim() == "") {
            alert("No password entered!");
            return false;    
        }

        return true;
        
    };

    return {
        init: function(data, table) {
            info = data;
            t = table;
        }
    };

}();