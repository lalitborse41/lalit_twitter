<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".button").click(function(){
    $.get("ajaxdata.php",function(data,status){
      alert("Data: " + data + "\nStatus: " + status);
      $("#id_data").html(data)
    });
  });
});
</script>
</head>
<body>

<button>show</button>
<div id='id_data'></div>
</body>
</html>
