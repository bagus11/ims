<script>
   function clear_pass(){
    $('.message_error').html('');
    $('#current_password').val('')
    $('#new_password').val('')
    $('#confirm_password').val('')
   }
   $('#save_change_password').on('click', function(){
        change_password()
    })
    $('#update_profile').on('click', function(){
        update_user()
    })
    $('#btnSignatureModal').on('click', function(){
        $('#signatureContainer').empty()
        $('#signatureContainer').prop('hidden', true)
        var signature = $('#signaturePad').val()
      
        if(signature == null || signature ==''){
           
            $('#signatureContainer').empty()
            $('#signatureContainer').prop('hidden', true)
        }else if(signature !=''){
         
            $('#signatureContainer').prop('hidden', false)   
            $('#signatureContainer').prepend(
                `
                <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Current Signature</legend>
                        <img src="${signature}" id="" alt="">
                    </fieldset>
                `
            )
           
        }
    })
   function change_password(){
        var data =
        {
            'current_password' : $('#current_password').val(),
            'new_password' : $('#new_password').val(),
            'confirm_password' : $('#confirm_password').val(),
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('change_password')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('.message_error').html('');
                    if(response.status==422)
                        {
                            $.each(response.message, (key, val) => 
                            {
                            $('span.'+key+'_error').text(val[0])
                            });
                            return false;
                        }else{
                            toastr['success'](response.message);
                            window.location = "{{route('setting_password')}}";
                          
                        }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
}
    function update_user(){
        var data ={
            'user_name':$('#user_name').val(),
            'email_user':$('#email_user').val()
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_user')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('.message_error').html('');
                    if(response.status==422)
                        {
                            $.each(response.message, (key, val) => 
                            {
                            $('span.'+key+'_error').text(val[0])
                            });
                            return false;
                        }else{
                            toastr['success'](response.message);
                            window.location = "{{route('setting_password')}}";
                          
                        }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }

    // Update Signature 
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('canvas');
        var signaturePad = new SignaturePad(canvas);
        $("#clear").on("click", function () {
            signaturePad.clear();
        });
        $('#btnSaveSignature').on('click', function(){
            // Convert to 
            var canvas = signaturePad._canvas;
            var dataURL = canvas.toDataURL(); 
            var imageElement = document.createElement('img');
            imageElement.src = dataURL;
            document.body.appendChild(imageElement);
            var data ={
                'signature'  : dataURL,
            }
            saveHelper('updateSignature', data,'setting_password')
        })
    });
    // Update Signature 
</script>