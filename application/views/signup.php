
<form enctype="multipart/form-data" id="signUpForm" action="">
    <div class="row">
        <div class="col-md-12">
            <tr>
                <td>Email : </td>
                <td><input  type="text" name='email'></td>
            </tr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
    
            <tr>
                <td>Password : </td>
                <td><input type="password" name="password"></td>
            </tr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <tr>
                <td>Name : </td>
                <td><input type="text" name="name"></td>
            </tr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
    
            <tr>
                <td>Upload Image : </td>
                
                <td><input type="file" name="profilePicture"></td>
            </tr>
        </div>
    </div>
    <tr><button id="signUp" type="button">Sign Up</button></tr>
</form>
<br>
    <a href="<?php echo base_url().'welcome/login';?>">Login In</a>
<script type="text/javascript">
$(document).ready(function()
{
    $("#signUp").on('click', function()
    {   
        var formData = $("#signUpForm"); 
        var data = new FormData(formData[0]);
       
        $.ajax
        ({
            method:'POST',
            url:"<?php echo base_url();?>createUser",
                data:data,
            contentType:false,
            processData:false,
            // dataType: 'json',
            success:function(result)
            {
                console.log('True : '+result);
                // window.location.href="<?php echo base_url().'welcome/index'?>";
                // return false;
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                    // alert(xhr.status);
                    alert(thrownError);
            }
        })
        
    });
});
</script>
