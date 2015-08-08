<?php
class View_Page_Gallery {
	
	const TABLE = 'galleries';
	const TABLE_PHOTOS = 'photos';
	
	const FORM_HOME_DATA = 'photos';
	const THUMB_DIR = 'thumb';
	
	private $id;
	private $tab = 'home';
	private $gallery;
	private $page;	
	
	private $modelPhotos;
	private $modelGalleries;
	
	function __construct() {
		$this->id = is_numeric($_GET['id']) ? $_GET['id'] : NULL;
		$this->page = '?page='.$_GET['page'].'&id='.$this->id;
		
		$this->modelGalleries = new WPLDK_Database_Model(self::TABLE); 
		$this->modelPhotos = new WPLDK_Database_Model(self::TABLE_PHOTOS);
		
		if (isset($this->id)) {
			$this->gallery = $this->modelGalleries->get($this->id);
		}
		
		if ( isset ( $_GET['tab'] ) ) {
			$this->tab = $_GET['tab'];
		}
		
		// Update settings
		$data = stripslashes_deep($_POST['data']);
		if (!empty($data)) {
			$this->updateSettings($data);
		}
		
		// Update photos
		$photosData = $_POST[self::FORM_HOME_DATA];
		if (!empty($photosData)) {
			$this->updatePhotos($photosData);
		}		
	}
	
	private function updateSettings($data) {
		global $wpdb;

		$id = $_POST['data_id'];
		
		if (isset($id)) {
			$result = $this->modelGalleries->update($data, $id);
		} else {
			$insertId = $this->modelGalleries->insert($data);
			if (is_int($insertId)) {
				$result = TRUE;
				$this->id = $insertId;
				$this->tab = 'addPhotos';
			}
		}

		global $wpldkHelperAdminNotice;
		if ($result === FALSE) {
			$wpldkHelperAdminNotice->addError('Failed to save settings');			
		} else if ($result) {
			$wpldkHelperAdminNotice->addUpdate('Saved settings');			
		}
	}
	
	private function updatePhotos($data) {
		var_dump($data);
		$result = $this->modelPhotos->updateMultiple($data);
		
		global $wpldkHelperAdminNotice;
		if ($result === TRUE) {
			$wpldkHelperAdminNotice->addUpdate("Saved");
		} else {
			$wpldkHelperAdminNotice->addError("Failed to save photos with ID ".implode(', ', $result));
		}
	}
	
	public function display() {
		$tabs = array();
		if (isset($this->id)) {
			$tabs['home'] = __('Home', SPG_NAME);
			$tabs['addPhotos'] = __('Add photos', SPG_NAME);
		}
		$tabs['settings'] = __('Settings', SPG_NAME);
	?>
	<div class="wrap">
		<?php wp_helper_getPageTitleAddNew('Gallery '.$this->gallery->name); ?>
		<?php echo spg_helper_admin_tabs($this->page, $tabs, $this->tab); ?>
		<?php
		switch ($this->tab) {
			case 'addPhotos':
				$this->tabAddPhotos();
				break;
			case 'settings':
				$this->tabSettings();
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
		$query = $this->modelPhotos->getMultiple("gallery=".$this->id, 'sequence');
		
		$upload_dir = wp_upload_dir();
		$galleryPath = $upload_dir['baseurl'].DIRECTORY_SEPARATOR.SPG_NAME.DIRECTORY_SEPARATOR.self::THUMB_DIR.DIRECTORY_SEPARATOR.$this->gallery->slug.DIRECTORY_SEPARATOR;
?>
<form method="POST" action="">
	<div class="spg-photozone sortable">
		<script>
jQuery(function() {

	jQuery('.spg-photozone').endlessPhotoScroll(<?php echo json_encode($query); ?>, {
		path: '<?php echo $galleryPath; ?>',
		name_prefix: '<?php echo self::FORM_HOME_DATA; ?>'
	});
});		
		</script>
	<?php submit_button(); ?>
	</div>
</form>

	<?php
	}

	/**
	 * Tab addPhotos
	 */
	private function tabAddPhotos() {
		$upload_dir = wp_upload_dir();
		$upload_dir = $upload_dir['basedir'].DIRECTORY_SEPARATOR.SPG_NAME;
		$resultUpload = $this->tabAddPhotos_uploadFiles($upload_dir);

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
	 * @param string $upload_dir
	 * @return boolean True, if upload was successful
     */
	private function tabAddPhotos_uploadFiles($upload_dir) {
		if (!empty($_FILES)) {
			// Upload path
			$upload_path = $upload_dir.DIRECTORY_SEPARATOR.$this->gallery->slug;
			spg_helper_makeDir($upload_path);
			// Thumbnail path
			$upload_thumb_path = $upload_dir.DIRECTORY_SEPARATOR.self::THUMB_DIR.DIRECTORY_SEPARATOR.$this->gallery->slug;
			spg_helper_makeDir($upload_thumb_path);
			
			$tempFile = $_FILES['file']['tmp_name'];//this is temporary server location
			$fileName = $_FILES['file']['name'];
	
			// Adding timestamp with image's name so that files with same name can be uploaded easily.
			$targetFile = $upload_path.DIRECTORY_SEPARATOR.$fileName;
			 
			if (move_uploaded_file($tempFile, $targetFile)) {
				$this->createThumbnail($targetFile, $upload_thumb_path.DIRECTORY_SEPARATOR.$fileName);
				
				$this->modelPhotos->insert(array(
					'file' => $fileName,
					'gallery' => $this->id
				));
			}
		}
		return FALSE;
	}
	
	private function createThumbnail($file, $target) {
		require_once(SPG_DIR.'/vendor/abeautifulsite/simpleimage/src/abeautifulsite/SimpleImage.php');
		$img = new abeautifulsite\SimpleImage($file);
		$img->thumbnail(250, 250)
			->save($target, 70);
	}
	
	/**
     * Tab options
  	 */
	private function tabSettings() {
		require_once(WPLDK_DIR . '/View/Settings/Common.php');
		require_once(WPLDK_DIR . '/View/Settings/DatabaseTable.php');
		$view = (new WPLDK_View_Settings_DatabaseTable('galleries', $this->id))
			->setFields(array(
				new WPLDK_Form_Field('name', 'Name', 'string', TRUE),
				new WPLDK_Form_Field('slug', 'Slug', 'string', TRUE),
				new WPLDK_Form_Field('description', 'Description', 'text', FALSE, NULL),			
			) )
		->display($this->page);		
	}
	

	
}