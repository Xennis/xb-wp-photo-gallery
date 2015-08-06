<?php
class View_Page_Gallery {
	
	private $id;
	private $tab = 'home';
	private $gallery;
	private $page;
	
	const TABLE = 'xb_spg_galleries';
	const TABLE_PHOTOS = 'xb_spg_photos';
	
	function __construct() {
		$this->id = is_numeric($_GET['id']) ? $_GET['id'] : NULL;
		if (isset($this->id)) {
			global $wpdb;
			$this->gallery = $wpdb->get_row("SELECT * FROM ".self::TABLE." WHERE id = ".$this->id);
		}
		
		if ( isset ( $_GET['tab'] ) ) {
			$this->tab = $_GET['tab'];
		}
		
		$data = stripslashes_deep($_POST['data']);
		if (!empty($data)) {
			$this->updateData($data);
		}
		
		$this->page = '?page='.$_GET['page'].'&id='.$this->id;
	}
	
	private function updateData($data) {
		global $wpdb;

		$id = $_POST['data_id'];
		if (isset($id)) {
	        $result = $wpdb->update(self::TABLE, $data, array(
				'id' => $id
			));
		} else {
			$result = $wpdb->insert(self::TABLE, $data);
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
		<?php echo spg_helper_admin_tabs($this->page, $tabs, $this->tab); ?>
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
		require_once(SPG_DIR . '/lib/wp-crud/table/Horizontal.php');
		require_once(SPG_DIR.'/src/view/table/View_Table_Photos.php');
		$view = new View_Table_Photos($this->id, $this->gallery->slug);
		$view->display();
	}

	/**
	 * Tab addPhotos
	 */
	private function tabAddPhotos() {
		$upload_dir = wp_upload_dir();
		$upload_path = $upload_dir['basedir'].DIRECTORY_SEPARATOR.SPG_NAME.DIRECTORY_SEPARATOR.$this->gallery->slug.DIRECTORY_SEPARATOR;
		if (!file_exists($upload_path)) {
			mkdir ($upload_path, 0755, true);
		}
		$resultUpload = $this->tabAddPhotos_uploadFiles($upload_path);

	?>
		<form method="POST" enctype="multipart/form-data" action="<?php echo $this->page; ?>&tab=addPhotos" class="dropzone">
			<div class="fallback">
				<input name="file" type="file" multiple /> 
			</div>
		</form>
		<p class="max-upload-size"><?php printf( __( 'Maximum upload file size: %s.' ), esc_html( size_format( wp_max_upload_size() ) ) ); ?></p>
	<?php
	}
	
	/**
	 * 
	 * @param string $upload_path
	 * @return boolean True, if upload was successful
     */
	private function tabAddPhotos_uploadFiles($upload_path) {
		if (!empty($_FILES)) { 	
			$tempFile = $_FILES['file']['tmp_name'];//this is temporary server location
	
			// Adding timestamp with image's name so that files with same name can be uploaded easily.
			$targetFile = $upload_path . $_FILES['file']['name'];

			global $wpdb;
			$wpdb->insert(self::TABLE_PHOTOS, array(
				'file' => $_FILES['file']['name'],
				'gallery' => $this->id
			));
			 
			return move_uploaded_file($tempFile, $targetFile);
		}
		return FALSE;	
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
		->display($this->page);		
	}
	

	
}