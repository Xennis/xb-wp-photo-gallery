<?php

class WPLDK_View_Settings_Options extends WPLDK_View_Settings_Common {

	protected function getData($field) {
		return esc_attr( get_option($field) );
	}

}