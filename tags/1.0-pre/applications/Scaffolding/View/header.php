<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <title>Scaffolding Application ~ leaf framework</title>
  <link rel="stylesheet" href="<?php echo baseDir(); ?>content/Scaffolding/styles.css" type="text/css" media="screen"  />
  <script type="text/javascript" src="<?php echo baseDir(); ?>content/Scaffolding/mootools-release-1.2.js"></script>
  <script type="text/javascript" src="<?php echo baseDir(); ?>content/Scaffolding/mootools-1.2-more.js"></script>
  <script type="text/javascript">
	var updateUrl = "<?php echo currentUrl('update', APPEND_SEGMENTS); ?>"
  </script>
  <script type="text/javascript" src="<?php echo baseDir(); ?>content/Scaffolding/ajax.js"></script>
 </head>
 <body>
 <div style="overflow: hidden; background-color: #f0f0f0; padding: 6px; border-bottom: 1px solid #cccccc;">
 
  <div>
  <form method="post" action="<?php echo currentUrl(); ?>">
   <b>επιλογή προφίλ</b> <small>(προφίλ &mdash; β.δ./πίνακας)</small>:
	<select name="profile">
	<?php foreach($profiles as $profile => $record): ?>
	 <optgroup label="<?php echo $profile; ?>">
	  <?php
        if (!empty($record['tables'])):
		foreach($record['tables'] as $table):
			$selected = ($currProfile==$profile && $currTable==$table)
						? " selected=\"selected\""
						: NULL;
	  ?>
	   <option value="<?php echo $profile . "." . $table; ?>" <?php echo $selected; ?>><?php echo $record['db'] . "." . $table; ?></option>
	  <?php
        endforeach;
        endif;
      ?>
	 </optgroup>
	<?php endforeach; ?>
	</select>
    <input type="submit" value="επιλογή"/>
  </form>
  </div>
 </div>
 
 <div id="message">&nbsp;</div>  
 
 <br />
 
 <div style="padding: 2%;">
 
 <?php
     if (!empty($metadata)) {
         $this->View->render("show_records", VIEW_EXPOSE);
         $this->View->render("show_execute_query");
         $this->View->render("show_insert", VIEW_EXPOSE);
     }
 ?> 
 
 </div>
 
