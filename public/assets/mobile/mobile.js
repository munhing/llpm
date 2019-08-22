/*
.mobile-btn-find
.mobile-form-confirm
.mobile-input
.mobile-result

.mobile-btn-confirm

*/
var MobileView = function() {

    var info = {};

    $('.mobile-btn-find').on('click', function(e){

        // prevent button from submitting
        e.preventDefault();

        var submitForm = true;

        // use .serialize() to convert all form input into string for POST submission
        var formData = $('.mobile-form-confirm').serialize();

        // get the value of the text input for validation later
        var containerNo = $('.mobile-input').val();

        // console.log(formData);

        // Validate the input
        submitForm = validate(containerNo);


        //get data from the db

        // getActiveByContainerNo

        if(submitForm) {
            $.ajax({
                url: info["url_find"],
                type: 'POST',
                data: formData,
                success: function(data) {
                    // console.log(data);

                    // clear previous results
                    $('.mobile-result').empty();

                    if(data != 0) {

                        displayResult(data);

                    } else {
                        var newH2 = $('<h2></h2>', {
                            'class': 'form-confirmation-heading text-center',
                            'text': 'Container Not Found!'
                        });

                        newH2.appendTo('.mobile-result');
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            }); 
        }       
    });

    $('.mobile-result').on('click', '.mobile-btn-confirm', function(e){

        // stop from submitting
        e.preventDefault();
                      
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
                        console.log($('#confirmationId'));

                        var container_id = $('#confirmationId').val();
                        //alert(container_id);

                        $.ajax({
                            url: info["url_confirm"],
                            type: 'POST',
                            // This is query string i.e. country_id=123
                            data: {"confirmationId": [container_id]},
                            success: function(data) {
                                console.log(data);  
                                alert(data);
                                $('.mobile-result').empty();
                                $('.password-modal-sm').modal('hide');
                                $('#password').val('');
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert(errorThrown);
                            }   
                        });
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

    var validate = function(containerNo){

        // regular expression for alphanumeric
        var regexp = /((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i;

        // must not be blank
        if(containerNo.trim() == "") {
            alert("Please enter container no!");
            return false;    
        }

        // must be 11 characters long
        if(containerNo.length != 11) {
            alert("Container no must be 11 characters long!");
            return false;    
        }

        // must be alphanumberic
        if(!containerNo.match(regexp)) {
            alert("Container no must be alphanumberic!");
            return false;    
        }

        return true;
        
    };

    var validatePassword = function(password){

        // must not be blank
        if(password.trim() == "") {
            alert("No password entered!");
            return false;    
        }

        return true;
        
    };

    var displayResult = function(data){

        //convert data into array
        var ctn = JSON.parse(data);
        var woLength = ctn["workorders"].length;
        var workorder = ctn["workorders"][woLength - 1];
        var confirmationId = ctn["id"] + "-" + ctn["content"] + "-" + workorder["workorder_no"] + "-" + workorder["movement"];
        
        var newInput = $('<input>', {
            'name': 'confirmationId',
            'id': 'confirmationId',
            'type': 'hidden',
            'value': confirmationId
        });

        var newH2 = $('<h2></h2>', {
            'class': 'form-confirmation-heading text-center',
            'text': ctn["container_no"]
        });

        var newH3 = $('<h3></h3>', {
            'class': 'form-confirmation-heading text-center',
            'text': workorder["workorder_no"] + " - " + workorder["movement"]
        });

        var newButton = $('<button></button>', {
            'class': 'btn btn-lg btn-success btn-block mobile-btn-confirm',
            'data-toggle': 'modal',
            'data-target': '.password-modal-sm',
            'text': 'Confirm'
        });

        newInput.appendTo('.mobile-result');
        newH2.appendTo('.mobile-result');
        newH3.appendTo('.mobile-result');
        newButton.appendTo('.mobile-result');

    };

    return {
        init: function(data) {
            info = data;
        }
    };

}();