<?php echo $this->session->userdata('loggedIn'[0]);?>
<form id="loginForm">
    <tr>
        <td>Email : </td>
        <td><input id="email" name="email" type="text"></td>
    </tr>
    <tr>
        <td>Password : </td>
        <td><input type="password" id="password" name="password"></td>
    </tr>
    <tr><button id="logIn"type="button">Login</button></tr>
</form>
    <a href="<?php echo base_url().'signup'?>">Sign Up</a>
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
  <script type="text/javascript">
$(document).ready(function()
{
    $("#logIn").on('click', function()
    {   
        var formData = $("#loginForm"); 
        var data = new FormData(formData[0]);
        // alert('dfe');
        $.ajax
        ({
            method:'POST',
            url:"<?php echo base_url();?>login",
            data:data,
            contentType:false,
            processData:false,
            success:function(result)
            {
                // alert(result);
                console.log('response : '+result);
                window.location.href="<?php echo base_url();?>";
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                    // alert(xhr.status);
                    alert(thrownError);
            }
        })
        // console.log($(formData).serializeArray());
        
    });
});
</script>
