<?php
class View_Page_Galleries extends WPLDK_Table_List {
	
	/**
	* Constructor, we override the parent to pass our own arguments
	* We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	*/
	function __construct() {
		parent::__construct(array(
			'singular'  => 'gallery',     //singular name of the listed records
			'plural'    => 'galleries',    //plural name of the listed records
			'ajax'      => false        //does this table support ajax?
		));
	}

	/**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
		return array(
			'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			'name' => 'Name',
			'slug' => 'Slug',		   
			'description ' => 'Description'
		);
	}

	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	 */
	public function get_sortable_columns() {
		return array(
			'name' => array('name'),
			'slug' => array('slug')
		);
	}
	
	function column_name($item){

		//Build row actions
		$actions = array(
			'settings'      => '<a href="?page=spg-gallery&tab=settings&id='.$item['id'].'">Settings</a>',
			'delete'    => '<a href="?page='.$_REQUEST['page'].'&action=delete&'.$this->_args['singular'].'='.$item['id'].'">Delete</a>'
		);

		//Return the title contents
		return '<a href="?page=spg-gallery&id='.$item['id'].'">'.$item['name'].'</a> '.$this->row_actions($actions);
	}	

	function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete',
		);
		return $actions;
	}
	
	function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if( 'delete'===$this->current_action() ) {
			
			global $wpdb;
			$wpdb->delete('xb_spg_galleries', array(
				'id' => $_GET['id']
			));
//			wp_die('Items deleted (or they would be if we had items to delete)!');
		} 
	}
	
	function display() {
		parent::prepare_items();
		?>
	<div class="wrap">
		<?php wp_helper_getPageTitleAddNew('Galleries', '?page=spg-gallery&tab=options'); ?>
		<form method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php parent::display(); ?>
		</form>	
	</div>
		<?php
	}	
}
