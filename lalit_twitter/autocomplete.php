
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Autocomplete - Remote with caching</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  .ui-autocomplete-loading {
    background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat;
  }
  </style>
  <script>
  $(function() {
    var cache = {};
    $( "#birds" ).autocomplete({
      minLength: 2,
      source: function( request, response ) {
        var term = request.term;
        if ( term in cache ) {
          response( cache[ term ] );
          return;
        }
 
        $.getJSON( "ajaxdata.php", request, function( data, status, xhr ) {
          cache[ term ] = data;
          response( data );
        });
      }
    });
  });
  </script>
</head>
<body>
 
<div class="ui-widget">
  <label for="birds">Birds: </label>
  <input id="birds">
</div>
 
 
</body>
</html>