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
	private $cssClass = 'widefat';
	private $fields;

	public function __construct($model) {
		$this->table = 'xb_spg_'.$model;
		$this->model = $model;
		$this->id = is_numeric($_GET['id']) ? $_GET['id'] : NULL;
		
		$data = stripslashes_deep($_POST['data']);
		if (!empty($data)) {
			$this->updateData($data);
		}
		
		return $this;
	}

	private function updateData($data) {
		global $wpdb;
		if (isset($this->id)) {
	        $result = $wpdb->update($this->table, $data, array(
				'id' => $this->id
			));
		} else {
			$result = $wpdb->insert($this->table, $data);
		}
		
		if ($result) {
			$notices= get_option('spg_deferred_admin_notices', array());
			$notices[]= "Saved";
			update_option('spg_deferred_admin_notices', $notices);	
		}
	}
	
	public function setFields(array $fields) {
		$this->fields = $fields;
		return $this;
	}

	private function _getData() {
		global $wpdb;
		return $wpdb->get_row("SELECT * FROM $this->table WHERE id = $this->id", 'ARRAY_A');
	}

	private function _outputTableHead() {
		echo '<tr><th>Feld</th><th>Wert</th></tr>';
	}
	
	private function _outputTableBody() {
		if ($this->id) {
			$data = $this->_getData();
		} else {
			$data = array();
		}
		
		var_dump($data);
		
		foreach ($this->fields as $index => $field) {
			?>
				<tr <?php echo ($index % 2 == 0 ? 'class="alternate"' : ''); ?>>
					<td><?php echo $field->label; ?></td>
					<td><?php echo $field->getElement( $data[$field->name] ); ?></td>
				</tr>
			<?php
		}
	}
	
	public function display() {
		?>
<div class="wrap">
	<h2><?php echo ucfirst($this->model); ?><a href="?page=spg-<?php echo $this->model; ?>&action=edit" class="add-new-h2">Add new</a></h2>
	<form action="?page=spg-<?php echo $this->model; ?>&action=edit&id=<?php echo $this->id; ?>" method="post">
		<table class="<?php echo $this->cssClass; ?>">
			<thead>
				<?php $this->_outputTableHead(); ?>
			</thead>
			<tbody>
				<?php $this->_outputTableBody(); ?>
			</tbody>
			<tfoot>
				<?php $this->_outputTableHead(); ?>
			</tfoot>
		</table>
	<?php submit_button(); ?>
	</form>
</div>
		<?php
	}
}
