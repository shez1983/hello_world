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
///
</script>


</head>

<body>

<div data-role="page" id="app_login" data-theme="e">
	
    <div data-role="header"  data-theme="e">
    	<h1>TESTING</h1>
  	</div>
  	
    <div data-role="content" data-theme="e">    
        <?php print_r($_GET); ?>
   	</div>
    
  	<div data-role="footer" data-theme="e">
    	<h4>App Name &copy; 2013</h4>
  	</div>
    
</div>

<div data-role="page" id="todays_lesson" data-theme="e">
	
    <div data-role="header"  data-theme="e">
    	<h1>Today's Lesson</h1>
  	</div>
  	
    <div id="activies" data-role="content" data-theme="e">    
        <ul data-role="listview" data-count-theme="e" data-inset="true">
				
		  </ul>
    </div>
    
  	<div data-role="footer" data-theme="e">
    	<h4>App Name &copy; 2013</h4>
  	</div>
    
</div>

</body>
</html>
