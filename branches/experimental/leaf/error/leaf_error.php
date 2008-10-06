<br />
<br />
<div style="margin: 0px auto; width: 600px; overflow: hidden; color: #000000;">
    <div style="font-size: 16px; background-color: #f7f7da; padding: 5px;">
        <img src="<?php echo baseDir(); ?>content/leaf/error.png" style="vertical-align: middle;"/>
        <i>Leaf Error</i> &mdash;
        <?php echo $error_code; ?>
    </div>

    <div style="background-color: #f0f0f0; color: #000000; margin: 5px 0px 0px 0px; border: 1px solid #c5c5c5; padding: 10px;">
        <fieldset style="border: 0px;">
            <legend>
				<b>
					<?php leaf_Base::fetch("Locale")->getError('Message'); ?>
				</b>
			</legend>
            <span style="font: Arial; font-size: 12px;"><?php echo $error_message; ?></span>
        </fieldset>

        <fieldset style="border: 0px;">
            <legend><b>Traceback</b></legend>
            <span style="font: Arial; font-size: 12px;">
            <pre style="white-space: pre-wrap; white-space: -moz-pre-wrap; word-wrap: break-word;"><?php echo $error_trace; ?></pre>
            </span>
        </fieldset>
		
		<?php if ($showSourceCode==TRUE): ?>
		
        <fieldset style="border: 0px;">
            <legend>
				<b>
					<?php leaf_Base::fetch("Locale")->getError('SourceCode'); ?>
				</b>
			</legend>
            <span style="font: Arial; font-size: 12px;">
            <pre><?php echo $error_scode; ?></pre>

            <span style="font-style: italic;">
				<?php leaf_Base::fetch("Locale")->getError('Snippet'); ?>:
			</span><br />
            <span style="font-size: 10px;"><?php echo $error_file; ?></span>
            </span>
        </fieldset>
		
		<?php endif; ?>
		
    </div>

</div>
<br />
<br />
    
