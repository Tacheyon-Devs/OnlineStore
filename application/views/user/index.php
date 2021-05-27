<h2><?php echo $this->session->flashdata('message'); ?></h2> <?php $j=0;?>
<br>
<!-- <h2><?php echo $totalSpace;?></h2> -->
<!-- <a style="float:right;" href="<?php echo base_url().'user/logout';?>" id="logOut"> Logout</a>    -->
                <div class="row">
                    <div class="col-md-4">
                        <form id="uploadFolderForm" enctype="multipart/form-data">
                            <label for="uploadFolder" class="ourButton">
                                <i class="fa fa-cloud-upload"></i> Select Folder To Upload 
                            </label>&nbsp;
                            <input type="file" multiple name="uploadFolder[]" hidden directory webkitdirectory id="uploadFolder" >
                            <input type="hidden" name="parentFolder" id="parentFolder" value="<?php echo $parentFolder;?>">
                            <input type="hidden" name="user" id="user" value="<?php echo $this->session->userdata("loggedIn")["id"];?>">
                            <button class="ourButton" type="button" id="uploadFolderButton" name="uploadFolderButton">Upload Folder</button>

                        </form>
                    </div>
                    <div class="col-md-4">
                        <form id="uploadFileForm" enctype="multipart/form-data">
                            <label for="uploadFile" class="ourButton">
                            <i class="fa fa-cloud-upload"></i> Upload Files
                            </label>
                               <input multiple type="file" name="uploadFile[]" hidden id="uploadFile" value="+ Files">
                           
                            <button type="button" class="ourButton" id="uploadButton" name="uploadButton">Upload Files </button>
                        </form>
                    </div>
                    <div class="col-md-4">
                           <!-- Button trigger modal -->
                        <button type="button" class="ourButton" data-toggle="modal" data-target="#exampleModal">
                        + Create Folder
                        </button>
                    </div>
                </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please Enter Folder Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="modalInput" id="createFolderInput" name="createFolderInput"><div class="error" style="color:red;">Please  enter something</div>
        <input type="hidden"  name="parentFolderForNew" id="parentFolderForNew" value="<?php echo $parentFolder;?>" >
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" id="createFolderYes" class="btn btn-success">Create Folder</button>
      </div>
    </div>
  </div>
</div>
<form method="POST" action="<?php echo base_url();?>createZipFolder" id="zipForm" name="zipForm">
    <?php if($data):?>
            <?php foreach($data as $file):?>         
                <?php if($j%3==0 && $j==0):?>
                    <div class="row" style="">
                    <div class="col-md-4 cell" style="">
                        <?php if($file['is_folder']==0):?>
                            <input type="checkbox" onchange="checkboxCheck(this)" name="zipFiles[]"  value="<?php echo $file['id'];?>"  class="zipFiles"><a target="_blank" href="<?= $file['path'];?>"><i class="fa fa-file"></i></a> <?= $file['name'];?>
                            <?php if($file['size']>1024 && $file['size']<1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1024);?> KB</span>
                            <?php elseif($file['size']>=1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1048576);?> KB</span>
                            <?php else:?>
                                <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?>
                            <?php elseif($file['is_folder']==1):?>
                            <a href="<?php echo base_url()."loadfolder/".$file['id']?>"><i class="fa fa-folder"></i></a> <?= $file['name'];?>
                            <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?>
                            </div>
                    <?php elseif($j%3== 0 && $j!=0):?>
                    </div>
                    <div class="row" style="">
                        <div class="col-md-4 cell" style=""><?php if($file['is_folder']==0):?>
                            <input type="checkbox" onchange="checkboxCheck(this)" name="zipFiles[]" value="<?php echo $file['id'];?>" class="zipFiles"><a target="_blank" href="<?= $file['path'];?>"><i class="fa fa-file"></i> </a><?= $file['name'];?>
                            <?php if($file['size']>1024 && $file['size']<1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1024);?> KB</span>
                            <?php elseif($file['size']>=1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1048576);?> KB</span>
                            <?php else:?>
                                <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?>
                            <?php elseif($file['is_folder']==1):?>
                            <a href="<?php echo base_url()."loadfolder/".$file['id']?>"><i class="fa fa-folder"></i></a> <?= $file['name'];?>
                            <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?>
                    </div>
                    <?php elseif($j==(count($data)-1)):?>            
                        <div class="col-md-4 cell" style=""><?php if($file['is_folder']==0):?>
                            <input type="checkbox" onchange="checkboxCheck(this)" name="zipFiles[]" value="<?php echo $file['id'];?>" class="zipFiles"><a target="_blank" href="<?= $file['path'];?>"><i class="fa fa-file"></i></a> <?= $file['name'];?>
                            <?php if($file['size']>1024 && $file['size']<1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1024);?> KB</span>
                            <?php elseif($file['size']>=1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1048576);?> KB</span>
                            <?php else:?>
                                <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?>
                            <?php elseif($file['is_folder']==1):?>
                            <a href="<?php echo base_url()."loadfolder/".$file['id']?>"><i class="fa fa-folder"></i></a> <?= $file['name'];?>
                            <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?></div>
                
                    </div>
                    <?php else:?>
                        <div class="col-md-4 cell" style=""><?php if($file['is_folder']==0):?>
                            <input type="checkbox" onchange="checkboxCheck(this)" name="zipFiles[]" value="<?php echo $file['id'];?>" class="zipFiles"><a target="_blank" href="<?= $file['path'];?>"><i class="fa fa-file"></i></a> <?= $file['name'];?>
                            <?php if($file['size']>1024 && $file['size']<1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1024);?> KB</span>
                            <?php elseif($file['size']>=1048576):?>
                            <span class="tooltiptext"><?= round($file['size']/1048576);?> KB</span>
                            <?php else:?>
                                <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?>
                            <?php elseif($file['is_folder']==1):?>
                            <a href="<?php echo base_url()."loadfolder/".$file['id']?>"><i class="fa fa-folder"></i></a> <?= $file['name'];?>
                                <span class="tooltiptext"><?= $file['size'];?> bytes</span>
                            <?php endif;?></div>
                    <?php endif;?>
                    <?php $j++;?>
            <?php endforeach;?>
    <?php endif;?>
    <br>
    <button type="button" id="disabledButton" disabled class="ourButton" data-toggle="modal" data-target="#zipModal">
    Zip Files
    </button>

<!-- Modal -->
<div class="modal fade" id="zipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please Enter Folder Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="modalInput" id="zipFolder" name="zipFolder"><div class="error" style="color:red;">Please  enter something</div>
        <!-- <input type="hidden"  name="parentFolderForNew" id="parentFolderForNew" value="<?php echo $parentFolder;?>" > -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" id="zipFormSubmitButton" name="zipFormSubmitButton"  class="btn btn-secondary">Zip Files</button>
      </div>
    </div>
  </div>
</div>  
</form>
<script type="text/javascript">
var disabled = 0;
$( document ).ready(function() 
{
    $(".error").css("display","none");
    var data;
    var object_data;
    $("#createFolderYes").on('click',function()
    {
        if($("#createFolderInput").val()=="")
            {
                $(".error").css("display","block");
                $("#createFolderInput").focus();
            }
            else
            {
                $(".error").css("display","none");
                $.ajax
                ({
                    method:'POST',
                    data:
                    {
                        folderName:$("#createFolderInput").val(),
                        parentFolder:$("#parentFolderForNew").val()
                    },
                    url:'<?php echo base_url();?>createNewFolder',
                    success: function(result)
                    {
                        console.log((result));
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                        console.log(textStatus, errorThrown);
                    }
                    
                });
            }
    });
    $("#createFolderInput").on('change',function()
       {
            if($("#createFolderInput").val()=="")
            {
                $(".error").css("display","block");
                $("#createFolderInput").focus();
            }
            else
            {   
                $(".error").css("display","none");
            }
       }) ;
    $("#uploadFolder").on('change',function(event)
    {
         data = event.target.files;
         object_data = Object.entries(data);
         console.log(object_data);
    });
    $("#uploadFolderButton").on('click',function(event)
    {    
        for (var key in  object_data)
        {
            if(object_data.hasOwnProperty(key))
            {
                var uploadFolderForm = $("#uploadFolderForm");
                var form = new FormData(uploadFolderForm[0]);
                var indexedFile = object_data[key][1]['webkitRelativePath'].split("/");
                var fileSize = object_data[key][1]['size'];
                form.append('filePath',indexedFile);
                form.append('parentFolder',$("#parentFolder").val())
                form.append('user',$("#user").val());
                form.append('currentFile',key);
                form.append('fileSize',fileSize);
                
                $.ajax
                ({
                    method:'POST',
                    data:form,
                    contentType:false,
                    processData:false,
                    url:'<?php echo base_url();?>folderUpload',
                    success: function(result)
                    {
                        console.log((result));
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                        console.log(textStatus, errorThrown);
                    }
                });    
            }
        }   
    });
    $("#uploadButton").on('click',function(event)
    {
        // alert('hi');
        var formData = $("#uploadFileForm");
        var data = new FormData(formData[0]);
        data.append('parentFolder',$("#parentFolder").val())
        $.ajax
        ({
            method:'POST',
            data:data,
            contentType:false,
            processData:false,
            url:'<?php echo base_url();?>fileUpload',
            success: function(result)
            {
                console.log(result);
            
            }
        });
    });
  // Handler for .ready() called.
    $("#logOut").on('click', function(event)
    {
        $.ajax
        ({
            method:'post',
            url:'<?php echo base_url();?>User/logOut',
            success: function(result)
            {
                alert(result);
            }
        });
    });
});
function checkboxCheck(event)
{
    var data = $(".zipFiles");
    var myButtonAttribute =  $(event).is(':checked');
    if(myButtonAttribute)
    {
        disabled++;
    }
    else
    {
        disabled--;
    };
    if(disabled>0)
    {
        $("#disabledButton").prop("disabled",false);
    }
    else
    {
        $("#disabledButton").prop("disabled",true);
    }
}
</script>