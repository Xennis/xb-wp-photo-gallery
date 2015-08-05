<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Edit
 *
 * @author Fabian
 */
class CRUD_View_Edit {
	
	private $table;
	private $model;
	private $id;
	private $cssClass = 'form-table';
	private $fields;

	public function __construct($model, $id = NULL) {
		$this->table = 'xb_spg_'.$model;
		$this->model = $model;
		$this->id = $id;
		return $this;
	}
	
	public function setFields(array $fields) {
		$this->fields = $fields;
		return $this;
	}

	private function _getData() {
		global $wpdb;
		return $wpdb->get_row("SELECT * FROM $this->table WHERE id = $this->id", 'ARRAY_A');
	}
	
	private function _outputTableBody() {
		if ($this->id) {
			$data = $this->_getData();
		} else {
			$data = array();
		}
		
		foreach ($this->fields as $index => $field) {
			?>
				<tr>
					<th><?php echo $field->label; ?></th>
					<td><?php echo $field->getElement( $data[$field->name] ); ?></td>
				</tr>
			<?php
		}
	}
	
	public function display($page) {
		?>
	<form action="<?php echo $page; ?>" method="post">
		<?php if ($this->id) echo '<input type="hidden" name="data_id" value="'.$this->id.'">'; ?>
		<table class="<?php echo $this->cssClass; ?>">
			<tbody>
				<?php $this->_outputTableBody(); ?>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
		<?php
	}
}
