<html>
 <head>
  <title><?php echo $title; ?></title>
 </head>
 <body>
  <!-- html code goes here.... -->
  <!-- html code goes here.... -->
  <?php $this->view->include("another_view_file"); ?>
  <!-- html code goes here.... -->
  <!-- html code goes here.... -->
  <?php foreach ($blog_categories as $Cats): ?>
	  <!-- html code goes here.... -->
	  <?php echo $Cats->tagName; ?>
	  <!-- html code goes here.... -->
	  <!-- html code goes here.... -->
	  <!-- html code goes here.... -->
  <?php endforeach; ?>
  <!-- html code goes here.... -->
  <!-- html code goes here.... -->
  <!-- html code goes here.... -->
  <!-- html code goes here.... -->
  <!-- html code goes here.... -->
  <!-- html code goes here.... -->
  <?php foreach ($blog_posts as $Post): ?>
	  <!-- html code goes here.... -->
	  <?php echo $Post['topic']; ?>
	  <!-- html code goes here.... -->
	  <!-- html code goes here.... -->
	  <!-- html code goes here.... -->
  <?php endforeach; ?>
 </body>
</html>	
