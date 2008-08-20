<?php
	$colors = array ("#f9f8f8", "#f3f3f3");
	$currBgColor = 1;
?>
   <div>
	<fieldset>
		<legend>
			&nbsp;<?php if (isset($total)) echo $total; ?> Εγγραφές&nbsp;
		</legend>
		
		<table width="100%" id="Records" cellpadding="5" cellspacing="1" border="0">
		 <tr align="center">
			<td colspan="2">&nbsp;</td>
			 <?php if(!empty($metadata)): ?>
				<?php foreach($metadata as $field): ?>
				 <td valign="top">
					<b><?php echo $field->getName(); ?></b>
					
					<?php if ($field->isPrimaryKey() || $field->isKey() || $field->isUniqueKey()): ?>
					 <img src="<?php echo baseDir(); ?>/content/Scaffolding/primary_key.png" alt="key" />
					<?php endif; ?>
					
					<?php if ($field->isAutoIncrement()): ?>
					 <img src="<?php echo baseDir(); ?>/content/Scaffolding/auto_increment.png" alt="auto increment" />
					<?php endif; ?>
					
					<br /><small>τύπος: <?php echo $field->getType(); ?></small>
					<?php if ($field->getSize()!=NULL): ?>
						<br /><small>μέγεθος: <?php echo $field->getSize(); ?> </small>
					<?php endif; ?>
				 </td>
				<?php endforeach; ?>
			 <?php else: ?>
			  <td align="center">
				<i>δεν είναι διαθέσιμες οι πληροφορίες metadata</i>
			  </<td>
			 <?php endif; ?>
		 </tr>
		 
			<?php
			    if (isset($records) && !empty($records)):
				foreach($records as $record):
					$currBgColor = ($currBgColor==1) ? 0 : 1;
					
					$query_string = NULL;
					
					if (isset($primaryKeys)) {
						foreach ($primaryKeys as $k) {
							$query_string[$k] = $record[$k];
						}
					}
					$qs = base64_encode(serialize($query_string));
			?>
				<tr align="center" bgcolor="<?php echo $colors[$currBgColor]; ?>" class="record" id="record_<?php echo $record['id']; ?>">
				 <td width="16" bgcolor="#ffffff">
					<a href="<?php echo currentUrl("delete", $query_string, APPEND_QUERY_STRING, APPEND_SEGMENTS); ?>">
						<img src="<?php echo baseDir(); ?>content/Scaffolding/delete.png" alt="delete"/>
					</a>
				 </td>
				 <td width="16" bgcolor="#ffffff">
					<a href="<?php echo currentUrl("edit", $query_string, APPEND_QUERY_STRING, APPEND_SEGMENTS); ?>">
						<img src="<?php echo baseDir(); ?>content/Scaffolding/edit.png" alt="edit"/>
					</a>
				 </td>
				 <?php foreach($record as $field => $value): ?>
				 <td>
					<?php if ($record->fieldMetadata($field)->getType()=="text" &&
							  $record->fieldMetadata($field)->isPrimaryKey()==FALSE):
							
							$classes = "updatable";
							
							if ($value=="")
								$classes .= " editable_empty";
					?>
						<p class="<?php echo $classes; ?>" rel="k=<?php echo $qs . "&f=" . $field; ?>">
							<?php echo $value; ?>
						</p>
					<?php else: ?>
						<?php echo $value; ?>
					<?php endif; ?>
				 </td>
				 <?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</table>
		
    	<?php if($total>0): ?>
    		<div style="overflow: hidden; padding: 15px 0px 5px 0px; text-align: center;">
    				<img src="<?php echo baseDir(); ?>content/Scaffolding/first.png"/>&nbsp;
    				<img src="<?php echo baseDir(); ?>content/Scaffolding/prev.png"/>&nbsp;
    				<img src="<?php echo baseDir(); ?>content/Scaffolding/next.png"/>&nbsp;
    				<img src="<?php echo baseDir(); ?>content/Scaffolding/last.png"/>
    		</div>
		
    		<div id="Truncate">
    			<a href="<?php echo currentUrl('truncate', APPEND_SEGMENTS); ?>" onclick="if(confirm('Στα αλήθεια θέλετε να αδειάσετε τον πίνακα;')==false) { return false; }">
    				άδειασμα <img src="<?php echo baseDir();?>content/Scaffolding/truncate.png"/>
    			</a>
    		</div>
		<?php endif; ?>
		
	</fieldset>
   </div>
   <br /><br />