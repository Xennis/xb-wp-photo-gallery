<?php
class View_Page_Gallery {
	
	private $id;
	private $tab = 'home';
	
	function __construct() {
		$this->id = is_numeric($_GET['id']) ? $_GET['id'] : NULL;
		if ( isset ( $_GET['tab'] ) ) {
			$this->tab = $_GET['tab'];
		}
		
		$data = stripslashes_deep($_POST['data']);
		if (!empty($data)) {
			$this->table = 'xb_spg_galleries';
			$this->updateData($data);
		}
	}
	
	private function updateData($data) {
		global $wpdb;

		$id = $_POST['data_id'];
		if (isset($id)) {
	        $result = $wpdb->update($this->table, $data, array(
				'id' => $id
			));
		} else {
			$result = $wpdb->insert($this->table, $data);
			if ($result) {
				$this->id = $wpdb->insert_id;
				$this->tab = 'addPhotos';
			}
		}
		
		if ($result) {
			$notices= get_option('spg_deferred_admin_notices', array());
			$notices[]= "Saved";
			update_option('spg_deferred_admin_notices', $notices);	
		}
	}	
	
	public function display() {
		$tabs = array();
		if (isset($this->id)) {
			$tabs['home'] = __('Home', SPG_NAME);
			$tabs['addPhotos'] = __('Add photos', SPG_NAME);
		}
		$tabs['options'] = __('Options', SPG_NAME);
	?>
	<div class="wrap">
		<?php wp_helper_getPageTitleAddNew('Gallery #'.$this->id, '?page=spg-gallery&tab=options', __('Add new gallery', SPG_NAME)); ?>
		<?php echo spg_helper_admin_tabs($_GET['page'].'&id='.$this->id, $tabs, $this->tab); ?>
		<?php
		switch ($this->tab) {
			case 'addPhotos':
				$this->tabAddPhotos();
				break;
			case 'options':
				$this->tabOptions();
				break;
			default:
				$this->tabHome();
				break;
		}
		?>
	</div>	
	<?php			
	}
	
	/**
	 * Tab home
	 */
	private function tabHome() {
		echo "TODO";		
	}

	/**
	 * Tab addPhotos
	 */
	private function tabAddPhotos() {
		$upload_dir = wp_upload_dir();
		$upload_path = $upload_dir['path'] . DIRECTORY_SEPARATOR;
		$resultUpload = spg_helper_uploadFiles($upload_path);

	?>
		<form method="POST" enctype="multipart/form-data" action="admin.php?page=spg-upload" class="dropzone">
			<div class="fallback">
				<input name="file" type="file" multiple /> 
			</div>
		</form>
		<p class="max-upload-size"><?php printf( __( 'Maximum upload file size: %s.' ), esc_html( size_format( wp_max_upload_size() ) ) ); ?></p>
	<?php
	}
	
	/**
     * Tab options
  	 */
	private function tabOptions() {
		require_once(SPG_DIR . '/lib/wp-crud/view/Edit.php');
		$view = (new CRUD_View_Edit('galleries', $this->id))
			->setFields(array(
				new CRUD_Form_Field('name', 'Name', TRUE),
				new CRUD_Form_Field('slug', 'Slug', TRUE),
				new CRUD_Form_Field('description', 'Description', FALSE, NULL, 'text'),			
			) )
		->display('?page='.$_GET['page'].'&id='.$this->id);		
	}
	

	
}