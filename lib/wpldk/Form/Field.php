<?php
/**
 * (Input) fields used for forms.
 * 
 * @package back-end
 * @subpackage model
 */
class WPLDK_Form_Field {

	/**
	 * Name of the field (mostly database table column)
	 * 
	 * @var string
	 */
	public $name;
	/**
	 * Label of the field
	 * 
	 * @var string 
	 */
	public $label;
	/**
	 * Type of the field: string|date|hidden|bool|text|reference
	 * @var string 
	 */
	private $type;
	/**
	 * True, if field is required.
	 * 
	 * @var bollean 
	 */
	private $required = false;

	/**
	 * Maximum input length of the field.
	 * 
	 * @var integer 
	 */
	private $maxLength;
	/**
	 * CSS class of the input field
	 * 
	 * @var string
	 */
	private $cssClass;
	
	/**
	 * Create a (input) field.
	 * 
	 * @param string $name Name of the field
	 * @param string $label Label of the field
	 * @param string $type Type of the field: string|date|hidden|bool|text|reference
	 * @param null|string $cssClass
	 * @return MT_Admin_Field
	 */
	public function __construct($name, $label, $type = 'string', $required = FALSE, $maxLength = NULL, $cssClass = NULL) {
		$this->name = $name;
		$this->label = $label;
		$this->type = $type;
		$this->required = $required;
		$this->maxLength = $maxLength;
		$this->cssClass = $cssClass;
		return $this;
	}
	
	/**
	 * Get the content of the field as string.
	 * 
	 * @param string $value Value of the field
	 * @return string Content of the field
	 */
	public function getString($value) {
		if ($this->type === self::TYPE_DATE) {
			return date('m.d.Y, H:i', $value);
		}
		else {
			return ''.$value;
		}
	}
	
	/**
	 * Get the element/field.
	 * 
	 * @param string $value Value of the field
	 * @param integer $elementNumber
	 * @return string Element as string
	 */
	public function getElement($value = NULL) {
		if ($this->disabled) {
			return $this->getString($value);
		}
		$arrayElement = 'data['.$this->name.']';

		$attribute = '';
		if($this->required) {
			$attribute .= 'required';
		}
		if(!empty($this->cssClass)) {
			$attribute .= ' class="'.$this->cssClass.'"';
		}
		
		switch ($this->type) {
			case 'string':
				return $this->getInputField('text', $arrayElement, $value, 50);
			case 'text':
				return '<textarea name="'.$arrayElement.'" cols="38" rows="4" '.$attribute.'>'.$value.'</textarea>';
		}
	}
	
	/**
	 * Returns an input field as string.
	 * 
	 * @param string $type Input type, e.g. 'text'
	 * @param string $name Name of the input field
	 * @param string $value Value of the input field
	 * @param integer|null $size Size of the input field
	 * @return string Input field as string
	 */
	private function getInputField($type, $name, $value, $size = NULL) {
		$attribute = '';
		if (!empty($size)) {
			$attribute .= ' size="'.$size.'"';
		}
		if (!empty($this->required)) {
			$attribute .= ' required';
		}
		if (!empty($this->maxLength)) {
			$attribute .= ' maxlength="'.$this->maxLength.'"';
		}
		if (!empty($this->cssClass)) {
			$attribute .= ' class="'.$this->cssClass.'"';
		}
		return '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" '.$attribute.'>';
	}
}