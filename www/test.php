<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="jquery-mobile/jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css">
<link href="jquery-mobile/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css">
<script src="jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
	 ///
	});  
</script>


</head>

<body>

<div data-role="page" id="app_login" data-theme="e">
	
    <div data-role="header"  data-theme="e">
    	<h1>Testing</h1>
  	</div>
  	
    <div data-role="content" data-theme="e">    
       <?= print_r($_GET); ?>
    
   	</div>
    
  	<div data-role="footer" data-theme="e">
    	<h4>App Name &copy; 2013</h4>
  	</div>
    
</div>

</body>
</html>
