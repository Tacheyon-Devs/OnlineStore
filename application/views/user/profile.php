 <form enctype="multipart/form-data" method="post" id="updateForm">
    <div class="row">
        <div class="col-md-12">
            <tr>
                <td>Email : </td>
                <td><input  type="text" value="<?= $email;?>" name='email'></td>
            </tr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
    
            <tr>
                <td>Password : </td>
                <td><input type="password" value="<?= $password;?>" name="password"></td>
            </tr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <tr>
                <td>Name : </td>
                <td><input type="text" name="name" value="<?= $name;?>"></td>
            </tr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
    
            <tr>
                <td>Upload Image : </td>
                <td><img height="200px" width="200px" id="image" src="<?php echo $profile_picture;?>"></td>
            </tr>
            <input type="file" name="newProfilePicture" id="newProfilePicture">
        </div>
    </div>
    <tr><button id="updateUserProfile" class="btn btn-success" type="button">Update</button></tr>
</form>
<br> 
<script>
$(document).ready(function() 
{
    $("#updateUserProfile").on('click', function(e)
    {
        var form = $("#updateForm");
        console.log(form);
        var data = new FormData(form[0]);
        $.ajax
        ({
            method:'POST',
            data:data,
            contentType:false,
            processData:false,
            url:'<?php echo base_url();?>updateuserprofile',
            success: function(result)
            {
                console.log((result));
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                console.log(textStatus, errorThrown);
            }
                  
        });

    });
});
</script>