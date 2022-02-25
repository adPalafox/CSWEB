<html>
<head>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>    
</head>
<body>
    <input type="file" id="file" />
    <button onclick="uploadFile();">Upload</button>
</body>
</html>

<script>
function uploadFile(){
    var input = document.getElementById("file");
    file = input.files[0];
    if(file != undefined){
      formData= new FormData();
      if(!!file.type.match(/image.*/)){
        formData.append("image", file);
        $.ajax({
          url: "upload.php",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function(data){
              alert('success');
          }
        });
      }else{
        alert('Not a valid image!');
      }
    }else{
      alert('Input something!');
    }
  }
</script>