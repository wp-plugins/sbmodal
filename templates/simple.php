<?php
defined('ABSPATH') or die("No script kiddies please!");
?>
<div class="modal fade <?php echo $class; ?>" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog <?php echo $width; ?>" style="<?php echo $style; ?>">
		<div class="modal-content">
			<div class="modal-body">
				<?php echo $modal_content; ?>
			</div>
			<a href="#close" data-dismiss="modal" class="modal-close" title="Close">x</a>
		</div>
	</div>
</div>