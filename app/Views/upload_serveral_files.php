<!doctype html>
<html>
<head>
<!--Reference: Y. Parmar, "Drag and Drop File Upload with Dropzone in CodeIgniter 4," Makitweb, Sep. 3, 2020. [Online]. Available: 
https://makitweb.com/drag-drop-file-upload-with-dropzone-in-codeigniter-4/. 
Accessed: Apr. 27, 2023. ([5] and [6] are referred for file upload.) -->
   <title>Drag and Drop file upload with Dropzone</title>

   <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

</head>
<body>

   <!-- CSRF token --> 
   <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

   <div class='content'>
      <!-- Dropzone -->
      <form action="<?=base_url('advancedUpload/fileUpload')?>", class='dropzone' ></form> 
   </div>

   <!-- Script -->
   <script>

   Dropzone.autoDiscover = false;
   var myDropzone = new Dropzone(".dropzone",{ 
      maxFilesize: 2, // 2 mb
      acceptedFiles: ".jpeg,.jpg,.png,.pdf",
   });
   myDropzone.on("sending", function(file, xhr, formData) {
      // CSRF Hash
      var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
      var csrfHash = $('.txt_csrfname').val(); // CSRF hash

      formData.append(csrfName, csrfHash);
   }); 
   myDropzone.on("success", function(file, response) {
      $('.txt_csrfname').val(response.token);
      if(response.success == 0){ // Error
         alert(response.error);
      }
      if(response.success == 2){
         alert(response.message);
      }

   });
   </script>
   <a href="<?php echo base_url(); ?>" class="btn btn-link btn-lg" style="display: inline-block;">Go back home</a>
</body>
</html>
