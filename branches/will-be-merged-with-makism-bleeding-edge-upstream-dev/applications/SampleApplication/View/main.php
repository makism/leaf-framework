<html>
 <head>
  <title><?php echo $title; ?></title>
 </head>
 <body>
  <?php
    $this->View->render("intro", null, array("merge"=>false, "expose"=>true));
  ?>
 </body>
</html>	
