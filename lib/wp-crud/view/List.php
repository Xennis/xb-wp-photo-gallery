<?php

abstract class CRUD_View_List extends CRUD_Table_Horizontal {

	function display() {
		parent::prepare_items();
		?>
	<div class="wrap">
		<?php wp_helper_getPageTitleAddNew($this->_args['plural']); ?>
		<form method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php parent::display(); ?>
		</form>	
	</div>
		<?php
	}	
}