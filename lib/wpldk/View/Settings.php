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
class WPLDK_View_Settings {
	
	const CSS_CLASS_FORM = 'form-table';

	private $model;
	private $id;
	private $fields;

	public function __construct($model, $id = NULL) {
		$this->model = $model;
		$this->id = $id;
		return $this;
	}
	
	public function setFields(array $fields) {
		$this->fields = $fields;
		return $this;
	}

	private function _outputTableBody() {
		if ($this->id) {
			$data = (new WPLDK_Database_Model($this->model))->get($this->id, WPLDK_Database_Model::OUTPUT_TYPE_ARRAY_A);
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
		<table class="<?php echo self::CSS_CLASS_FORM; ?>">
			<tbody>
				<?php $this->_outputTableBody(); ?>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
		<?php
	}
}