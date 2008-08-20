  <div style="width: 600px;">
    <fieldset>
        <legend id="Insert">
        	&nbsp;Προσθήκη&nbsp;
        </legend>
    
		<form method="post" action="<?php echo currentUrl('insert', APPEND_SEGMENTS); ?>" id="InsertForm">
        	<table width="100%">
        		<?php foreach ($metadata as $field): ?>
        			<tr>
        				<td><?php echo $field->getName(); ?></td>
        				<td>
        					<?php if ($field->getType()=="text"): ?>
        						<textarea  name="<?php echo $field->getName(); ?>" class="inputField" cols="50" rows="5"></textarea>
        						
        					<?php elseif ($field->getType()=="varchar"): ?>
        						<input  name="<?php echo $field->getName(); ?>" type="text" class="inputField" maxlength="<?php echo $field->getSize(); ?>"/>
        						
        					<?php elseif ($field->getType()=="enum"): ?>
        						<select class="inputField" name="<?php echo $field->getName(); ?>">
        							<?php foreach ($field->getValueRange() as $value): ?>
        								<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
        							<?php endforeach; ?>
        						</select>
        						
        					<?php elseif ($field->getType()=="set"): ?>
        						<select multiple="multiple" size="5" class="inputField"  name="<?php echo $field->getName(); ?>[]">
        							<?php foreach ($field->getValueRange() as $value): ?>
        								<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
        							<?php endforeach; ?>
        						</select>
        						
        					<?php elseif ($field->getType()=="blob"): ?>
        						<b>ο τύπος "blob" δεν υποστηρίζεται</b>
        						
        					<?php endif; ?>
        				</td>
        			</tr>
        		<?php endforeach; ?>
        		<tr>
        			<td colspan="2" align="right" style="padding: 10px;">
        				<input type="submit" value="καταχώρηση" class="inputSubmit"/>
        			</td>
        		</tr>
        	</table>
    	</form>

    </fieldset>
  </div>