<?php
defined('ABSPATH') or die("No script kiddies please!");
?>
<div class="modal fade <?php echo $class; ?>" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog <?php echo $width; ?>" style="<?php echo $style; ?>">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title"><?php echo $modal_title; ?></h4>
			</div>
			<div class="modal-body">
				<?php echo $modal_content; ?>
			</div>
			<div class="modal-footer">
				<?php echo $modal_footer; ?>
			</div>
		</div>
	</div>
</div>