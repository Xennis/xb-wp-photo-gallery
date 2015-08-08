<?php

abstract class WPLDK_View_Settings_Common  {
	
	const CSS_CLASS_FORM = 'form-table';

	private $fields;
	
	abstract protected function getData($field);
	
	public function setFields(array $fields) {
		$this->fields = $fields;
		return $this;
	}

	private function _outputTableBody() {
		foreach ($this->fields as $index => $field) {
			?>
				<tr>
					<th><?php echo $field->label; ?></th>
					<td><?php echo $field->getElement( $this->getData($field->name) ); ?></td>
				</tr>
			<?php
		}
	}
	
	protected function _outputTable() {
		?>
		<table class="<?php echo self::CSS_CLASS_FORM; ?>">
			<tbody>
				<?php $this->_outputTableBody(); ?>
			</tbody>
		</table>
		<?php
	}

	public function display($page) {
		?>
	<form action="<?php echo $page; ?>" method="post">
		<?php $this->_outputTable(); ?>
		<?php submit_button(); ?>
	</form>
		<?php
	}
}