
function deleteRecord(x){
    var id  = $(x).data('id');
    var obj = $(x).data('obj');
    var link = $(x).data('url');
    var table = $(x).closest('#datatable-responsive1').DataTable();
    // table.css('background-color','red');
    // return false;
    if(id!='' && obj!=''){

        swal({
            title: "Are you sure?",
            text: "You Want to Fire this Employee.",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Confirm!'
        },
        function(isConfirm) {
            if (isConfirm) {
                $("#loading").show();

                $.post(link, {id: id, obj: obj}, function(result)
                {
                    console.log(result);
                    if(result!='0'){
                        var data = JSON.parse(result);

                        if(data.type == 'success'){
                                    
                                    table.row($(x).parents("tr")).remove().draw();
                                    $("#row-"+id).fadeOut("slow");
                                    $("#row-"+id).remove();
                                    // table.ajax.reload();
                                    // table.clear.draw();
                                    
                                     $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-success alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                            
                                        });
                                    }, 3000);
                                }

                                if(data.type == 'error'){
                                     $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-danger alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);
                                    // swal("Error!", data.msg, "error");
                                }

                            }else{
                                swal("Error!", "Something went wrong.", "error");
                            }
                            $('.loading').hide();
                }

                        );

            } else {
                swal("Cancelled", "Your action has been cancelled!", "error");
            }
        }

        );

    }else{
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}
function activeEmployee(x){
    var id  = $(x).data('id');
    var obj = $(x).data('obj');
    var link = $(x).data('url');
    var table = $(x).closest('#datatable-responsive1').DataTable();
    if(id!='' && obj!=''){

        swal({
            title: "Are you sure?",
            text: "You are going to activate Employee Again.",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Confirm!'
        },
        function(isConfirm) {
            if (isConfirm) {
                $("#loading").show();

                $.post(link, {id: id, obj: obj}, function(result){
                    console.log(result);
                    if(result!='0'){
                        var data = JSON.parse(result);

                        if(data.type == 'success'){
                                    //hide gallery image
                                    table.row($(x).parents("tr")).remove().draw();
                                    // swal("Success!", data.msg, "success");
                                     $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-success alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);
                                    $("#row-"+id).fadeOut("slow");
                                    $("#row-"+id).remove();
                                }

                                if(data.type == 'error'){
                                     $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-danger alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);
                                    // swal("Error!", data.msg, "error");
                                }

                            }else{
                                swal("Error!", "Something went wrong.", "error");
                            }
                            $('.loading').hide();
                        }

                        );

            } else {
                swal("Cancelled", "Your action has been cancelled!", "error");
            }
        }

        );

    }else{
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}

//<a  href="javascript:;" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>                                                            </td>

function deleteNote(x){
    var id  = $(x).data('id');
    var obj = $(x).data('obj');
    var link = $(x).data('url');

    if(id!='' && obj!=''){

        swal({
            title: "Are you sure?",
            text: "You cannot recover it later.",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Confirm!'
        },
        function(isConfirm) {
            if (isConfirm) {
                $('#loading').attr('class', 'loading show');

                $.post(link, {id: id, obj: obj}, function(result){
                   console.log("I'm");
                   if(result!='0'){
                    var data = JSON.parse(result);

                    if(data.type == 'success'){
                     $("#loading").attr("class" , "loading hide");
                                    //hide gallery image
                                    // swal("Success!", data.msg, "success");
                                    $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-success alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);
                                    $("#row-"+id).fadeOut("slow");
                                    $("#row-"+id).remove();
                                }

                                if(data.type == 'error'){
                                 $("#loading").attr("class" , "loading hide");
                                 swal("Error!", data.msg, "error");
                             }

                         }else{
                            swal("Error!", "Something went wrong.", "error");
                        }

                    }

                    );

            } else {
                swal("Cancelled", "Your action has been cancelled!", "error");
            }
        }

        );

    }else{
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}

// project binding

function closeProject(x){
    var id  = $(x).data('id');
    var obj = $(x).data('obj');
    var link = $(x).data('url');

    if(id!='' && obj!=''){

        swal({
            title: "Are you sure?",
            text: "You are going to close the project.",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Confirm!'
        },
        function(isConfirm) {
            if (isConfirm) {
                $('#loading').attr('class', 'loading show');

                $.post(link, {id: id, obj: obj}, function(result){
                   console.log("I'm");
                   if(result!='0'){
                    var data = JSON.parse(result);

                    if(data.type == 'success'){
                     $("#loading").attr("class" , "loading hide");
                                    //hide gallery image
                                    swal("Success!", data.msg, "success");
                                    $("#row-"+id).fadeOut("slow");
                                    $("#row-"+id).remove();
                                }

                                if(data.type == 'error'){
                                 $("#loading").attr("class" , "loading hide");
                                 swal("Error!", data.msg, "error");
                             }

                         }else{
                            swal("Error!", "Something went wrong.", "error");
                        }

                    }

                    );

            } else {
                swal("Cancelled", "Your action has been cancelled!", "error");
            }
        }

        );

    }else{
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}



// Password Resetting

function resetPassword(x){
    var id  = $(x).data('id');
    var email  = $(x).data('email');
    var obj = $(x).data('obj');
    var link = $(x).data('url');

    if(id!='' && obj!=''){

        swal({
            title: "Are you sure?",
            text: "You are going to reset password for that Employee.",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Confirm!'
        },
        function(isConfirm) {
            if (isConfirm) {
                $('#loading').attr('class', 'loading show');

                $.post(link, {id: id, email:email ,obj: obj}, function(result)
                {
                   console.log("I'm");
                   if(result!='0'){
                    var data = JSON.parse(result);

                    if(data.type == 'success'){
                     $("#loading").attr("class" , "loading hide");
                                    //hide gallery image
                                    // swal("Success!", data.msg, "success");
                                     $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-success alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);
                                }

                                if(data.type == 'error'){
                                 $("#loading").attr("class" , "loading hide");
                                 // swal("Error!", data.msg, "error");
                                  $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-danger alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);
                             }

                         }else{
                            swal("Error!", "Something went wrong.", "error");
                        }

                    }

                    );

            } else {
                swal("Cancelled", "Your action has been cancelled!", "error");
            }
        }

        );

    }else{
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}
function deleteEmployee(x){
   
    var id  = $(x).data('id');
    var obj = $(x).data('obj');
    var link = $(x).data('url');
    // var table = $(x).closest('#datatable-responsive1').DataTable();
    // alert(link);
    // return false;
    var table = $(x).closest('#datatable-responsive1').DataTable();

    if(id!='' && obj!=''){

        swal({
            title: "Are you sure?",
            text: "You are going to Remove Employee Permanently",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Confirm!'
        },
        function(isConfirm) 
        {
            if(isConfirm) {
                $('#loading').attr('class', 'loading show');

                $.post(link, {id: id, obj: obj}, function(result){
                    // console.log(result);
                    // return false;
                   if(result!='0')
                   {
                        var data = JSON.parse(result);

                    if(data.type == 'success'){
                                    table.row($(x).parents('tr')).remove().draw();
                                        $("#loading").attr("class" , "loading hide");
                                        window.location.href=window.location.origin+'/admin/employee/list';
                                    //hide gallery image
                                    $("#row-"+id).fadeOut("slow");
                                    $("#row-"+id).remove();
                                    // swal("Success!", data.msg, "success");
                                     $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-success alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);

                                }

                                if(data.type == 'error'){
                                 $("#loading").attr("class" , "loading hide");
                                 // swal("Error!", data.msg, "error");
                                  $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-danger alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                            $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);
                             }

                         }else{
                            swal("Error!", "Something went wrong.", "error");
                        }

                    }

                    );

            } else {
                swal("Cancelled", "Your action has been cancelled!", "error");
            }
        }

        );

    }else{
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}
function activeChecklistNote(x){
    var id  = $(x).data('id');
    var obj = $(x).data('obj');
    var link = $(x).data('url');

    if(id!='' && obj!=''){

        swal({
            title: "Are you sure?",
            text: "You are going to Active this Note",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-default btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Confirm!'
        },
        function(isConfirm) {
            if (isConfirm) {
                $('#loading').attr('class', 'loading show');

                $.post(link, {id: id, obj: obj}, function(result){
                   console.log("I'm");
                   if(result!='0'){
                    var data = JSON.parse(result);

                    if(data.type == 'success'){
                     $("#loading").attr("class" , "loading hide");
                                    //hide gallery image
                                    $("#row-"+id).fadeOut("slow");
                                    $("#row-"+id).remove();
                                    // swal("Success!", data.msg, "success");
                                    $('.msg-alert').css('display', 'block');
                                    $("#result").html('<div class="success" ><div class="alert alert-domain alert-success alert-dismissible fade in  msg-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>' + data.msg + '</div></div>');
                                    window.setTimeout(function() {
                                        $(".alert").fadeTo(2000, 0).slideUp(500, function(){
                                            $(this).remove();
                                        });
                                    }, 3000);                            

                                } 

                                if(data.type == 'error'){
                                 $("#loading").attr("class" , "loading hide");
                                 swal("Error!", data.msg, "error");
                             }

                         }else{
                            swal("Error!", "Something went wrong.", "error");
                        }

                    }

                    );

            } else {
                swal("Cancelled", "Your action has been cancelled!", "error");
            }
        }

        );

    }else{
        swal("Error!", "Information Missing. Please reload the page and try again.", "error");
    }
}
