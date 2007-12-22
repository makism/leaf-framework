<html>
 <head>
  <title><?php echo $title; ?></title>
  <style type="text/css">
	* {
		font-family: Arial, serif;
	}
	
	a:link, a:visited, a:active {
		text-decoration: none;
		color: #000;
	}
	
	a:hover {
		font-style: italic;
	}
	
  </style>
 </head>
 <body>
  <?php
    $this->View->render("intro", null, array("merge"=>false, "expose"=>true));
  ?>
 </body>
</html>
