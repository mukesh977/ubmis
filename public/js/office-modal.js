$('.add-new-office').click(function(e){
    e.preventDefault();
    $('#officeModal').modal('show');
});



$('#officeModal').on('hidden.bs.modal', function () {
    clearform();
})


function clearform(){
    $('#officeModal').find('.form-group').each(function(){
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
    });
}

$('#save-new-office').click(function(){
    var name = $('input[name="name"]').val();
    var address = $('input[name="officeAddress"]').val();
    var token = $('input[name="_token"]').val();
    // console.log(baseUrl);

    $.ajax({
        url: baseUrl + "office",
        type: "POST",
        data:{ _token:token, name:name, address:address, method:'post'},
        success: function(result){
            $('#officeModal').find('.form-group').each(function(){
                //reset field
                $(this).find('input').val();
                //clear erorrs class
                $('.form-group').removeClass('has-error');
                $('.help-block').empty();
            });
            $('#officeModal').modal('hide');
            clearform();
            // console.log(result);
            $('#office').find('select[name="company_id"]').append('<option value='+ result.data.id +' selected>'+ result.data.name +'</option>');
            //success message
            $('#office').find('#officeMsg').append(result.message).css('color','#449d44');
            setTimeout(function() { $('#officeMsg').text(''); }, 5000);

        },

        error: function(errors){
            if(errors.readyState == 4){
                if(errors.status == 422){
                    var obj = $.parseJSON(errors.responseText);
                    // console.log(obj);
                    // $.each(obj,function(name,error){
                    //     // console.log(error);
                    //     var err = $("#form-group-name");
                    //     err.addClass('has-error');
                    //     err.find('.help-block').text(error.name);
                    // });

                    clearform();
                    
                    $.each(obj.errors,function(key,value){
                        if(key=='name')
                        {
                            var err = $("#form-group-name");
                            err.addClass('has-error');
                            err.find('.help-block').text(value);
                        }
                        else if(key=='address')
                        {
                            var err = $("#form-group-address");
                            err.addClass('has-error');
                            err.find('.help-block').text(value);
                        }

                    });
                }
            }

        },
    });
})
