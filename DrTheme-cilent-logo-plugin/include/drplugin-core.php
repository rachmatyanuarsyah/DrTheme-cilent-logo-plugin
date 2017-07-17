<?php
/**
 * Class to generate a DrTheme Cilent Logo
 *
 * @package DrTheme Cilent Logo
 * @author Rachmat Yanuarsyah
 * @since 1.0
 */
final class DrThemeCilentLogo {
	/**
	 * @var array The unserialized array with the stored options
	 */
	private $options = array();

	/**
	 * @var array The saved additional pages
	 */
	private $pages = array();


	/**
	 * @var bool True if init complete (options loaded etc)
	 */
	private $isInitiated = false;


	/**
	 * Holds the user interface object
	 *
	 * @since 1.0.0
	 * @var DrThemeCilentLogoUI
	 */
	private $ui = null;

	/**
	 * @var bool Defines if the options have been loaded
	 */
	private $optionsLoaded = false;


	/*************************************** CONSTRUCTION AND INITIALIZING ***************************************/

	/**
	 * Initializes a new DrTheme Cilent Logo
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

	}

	/**
	 * Returns the instance of the DrTheme Cilent Logo
	 *
	 * @since 1.0.0
	 * @return DrThemeCilentLogo The instance or null if not available.
	 */
	public static function GetInstance() {
		if(isset($GLOBALS["DrPlugin_instance"])) {
			return $GLOBALS["DrPlugin_instance"];
		} else return null;
	}

	/**
	 * Enables the DrThemeCilentLogo and registers the WordPress hooks
	 *
	 * @since 1.0.0
	 */
	public static function Enable() {
		if(!isset($GLOBALS["DrPlugin_instance"])) {
			$GLOBALS["DrPlugin_instance"] = new DrThemeCilentLogo();
		}
	}
	/**
	 * Loads up the configuration and validates the prioity providers
	 *
	 * This method is only called if the DrTheme Cilent Logo needs to be build or the admin page is displayed.
	 *
	 * @since 1.0.0
	 */
	public function Initate() {
		if(!$this->isInitiated) {
			load_plugin_textdomain('DrPlugin_Cilent_logo',false,dirname( DRTHEME_LOGO_PLUGIN ) .  '/lang');
			$this->isInitiated = true;
		}
	}
	
	/**
	 * Group scripts (js & css)
	 * 
	 * @since 1.0.0
	 */
	function settings_scripts(){
	    if ('drtheme-plugins_page_'.DRTHEME_LOGO_PLUGIN_BASENAME == get_current_screen() -> id || 'toplevel_page_'.DRTHEME_PLUGIN_SETTINGS == get_current_screen() -> id ) {
	    	wp_enqueue_style('plugin-style', DRTHEME_LOGO_PLUGIN_STYLES . 'bootstrap.min.css');
			if ('drtheme-plugins_page_'.DRTHEME_LOGO_PLUGIN_BASENAME == get_current_screen() -> id){
		 		wp_enqueue_script( 'plugin-js', DRTHEME_LOGO_PLUGIN_SCRIPTS . 'drtheme-upload.js', array('jquery'),null, true);
		        wp_enqueue_script('thickbox');
		        wp_enqueue_style('thickbox');
		        wp_enqueue_script('media-upload');
		 		wp_enqueue_media();
			}
	    }
	}
	/**
	 * Group scripts (js & css)
	 * 
	 * @since 1.0.0
	 */
	function add_scripts(){
	    wp_enqueue_style('cilent-logo-style', DRTHEME_LOGO_PLUGIN_STYLES . 'cilentlogo.css');
	}
	/*************************************** VERSION AND LINK HELPERS ***************************************/

	/**
	 * Returns the version of the DrTheme Cilent Logo
	 *
	 * @since 1.0.0
	 * @return int The version
	 */
	public static function GetVersion() {
		return DrThemeCilentLogoLoader::GetVersion();
	}
			
	/**
	 * Helper function: Check for tabs and return the current tab name
	 * @Since 1.0.0
	 * @return string
	 */
	function get_current_tab() {
		// read the current tab when on our settings page
		$current_tab 	= (isset($_GET['tab']) ? $_GET['tab'] : 'general');
		
		return $current_tab;
	}
	
	/**
	 * Form Fields HTML
	 * All form field types share the same function!!
	 * @Since 1.0.0
	 * @param (array) $args The array of arguments to be used in creating html output
	 * @return echoes output
	 */
	function FormFieldsPage($args = array()) {
		extract( $args );
		$options 			= get_option(DRTHEME_LOGO_PLUGIN_OPTIONS_NAME);

		// pass the standard value if the option is not yet set in the database
		if ( !isset( $options[$id] ) && 'type' != 'checkbox') {
			$options[$id] = $std;
		}
		// additional field class. output only if the class is defined in the create_setting arguments
		$field_class = ($class != '') ? ' ' . $class : '';
		// switch html display based on the setting type.
		
		switch ( $type ) {
			case 'group':
				$name=$id.'_name';
				$url=$id.'_url';
				$image=$id.'_logo';
				$options[$name] = esc_attr(stripslashes($options[$name] ));
				$options[$url] = esc_attr(stripslashes($options[$url]));
				$options[$image]  = esc_attr(stripslashes($options[$image]));
				$text=array();
				($options[$image] != '') ? $text="Change File": $text="Browse File";
				($options[$image] != '') ? $src=$options[$image]: $src=DRTHEME_LOGO_PLUGIN_IMAGES.'no_preview.jpg';
				echo $order."</td><td class='col-xs-4'>
				<div class='input-group input-group-sm'>
					<input class='form-control' type='text' id='$name' name='" . DRTHEME_LOGO_PLUGIN_OPTIONS_NAME . "[$name]' placeholder='Input Cilent Name' value='$options[$name]' />
				</div>
				</td><td class='col-xs-5'>
				<div class='input-group input-group-sm '>
					<input class='form-control' type='text' id='$url' name='" . DRTHEME_LOGO_PLUGIN_OPTIONS_NAME . "[$url]' placeholder='Input Cilent WEB URL ' value='$options[$url]' />
				</div>
				</td><td class='col-xs-3'>
				<div class='input-group input-group-sm'>
					<input class='input-group-sm form-control $field_class' type='hidden' id='$image' name='" . DRTHEME_LOGO_PLUGIN_OPTIONS_NAME . "[$image]' placeholder='$placeholder' value='$options[$image]' />
					<img src='".$src."' class='img-thumbnail' alt='$image' id='preview_$image'>
					<input id='$image' class='btn btn-default btn-xs upload_group' type='button' value='".$text."'>
				</div>";
			break;
		}
	}
	
	/**
	 * Validate input
	 * @Since 1.0.0
	 * @return array
	 */
	function ValidateOptions($input= array()) {
		// for enhanced security, create a new empty array
	    $valid_input = array();
		// get the settings sections array
		$options = $this->options_page_fields();
		if (isset($_POST['reset'])) {
			return $valid_input; 
		}
		// run a foreach and switch on option type
		foreach ($options as $option) {
			switch ( $option['type'] ) {
				case 'group':
					$name=$option['id'].'_name';
					$logo=$option['id'].'_logo';
					$url=$option['id'].'_url';
					//accept the input only after stripping out all html, extra white space etc!
					$input[$name]= trim($input[$name]); // trim whitespace
					$valid_input[$name] = addslashes($input[$name]);
					//accept the input only when the url has been sanited for database usage with esc_url_raw()
					$input[$logo]= trim($input[$logo]); // trim whitespace
					$valid_input[$logo] = esc_url_raw($input[$logo]);
					//accept the input only when the url has been sanited for database usage with esc_url_raw()
					$input[$url]= trim($input[$url]); // trim whitespace
					$valid_input[$url] = esc_url_raw($input[$url]);
				break;
			}
		}
		return $valid_input; // return validated input
	}
	
	/**
	 * Helper function for creating admin messages
	 * src: http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area
	 *
	 * @param (string) $message The message to echo
	 * @param (string) $msgclass The message class
	 * @return echoes the message
	 */
	function ShowMsgPlugin($message, $msgclass = 'info') {
	    echo "<div id='setting-error-settings_updated' class='$msgclass notice is-dismissible'>$message</div>";
	}
	
	/** Call the function and collect in variable
	 * Should be used in template files like this:
	 * <?php echo $drtheme_option['name of option']; ?>
	 * 
	 * @since 1.0.0
	 * @return array
	 */
	function GetCilentLogoOptions() {
		$option_names =get_option(DRTHEME_LOGO_PLUGIN_OPTIONS_NAME);
		return $option_names;
	}
	
	/**
	 * Helper function for registering our form field  cilent logo settings to shortcode
	 *
	 * @param (array) $args The array of arguments to be used in creating the field
	 * @return echos output
	 */
	function CilentLogoShortCode($args){
		$options = $this->GetCilentLogoOptions();
		extract(shortcode_atts(array( 
			'image_display' => 9,
		), $args));
		echo '<div id="cilent-logo">';
		for($i=0;$i<(int)$image_display;$i++){
			$j=$i+1;
			if($options['cilent_logo_'.$j.'_logo']!==''){
				echo '<div class="thumbnail"><div class="gallery">';
				echo '<a target="_blank" href="'.esc_url($options['cilent_logo_'.$j.'_url']).'">';
				echo '<img src="'.$options['cilent_logo_'.$j.'_logo'].'" alt="'.$options['cilent_logo_'.$j.'_name'].'" width="100" height="80">';
				echo '</a><div class="desc">'.$options['cilent_logo_'.$j.'_name'].'</div></div></div>';
			}
		}
		echo '</div>';
	}
	
	/*************************************** USER INTERFACE ***************************************/
	
	/**
	 * Plugin Admin Settings Page Tabs
	 *  
	 * @Since 1.0.0
	 */
	 function settings_page_tabs() {
	 	$tabs = array();
	 	$tabs['general'] = __('General','drtheme');
		$tabs['add_cilent_image'] = __('Add Cilent Logo','drtheme');
		return $tabs;
	 } 
	
	/**
	 * Define our settings sections
	 *
	 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
	 * @Since 1.0.0
	 * @return array
	 */
	function options_page_sections() {
		$tab=$this->get_current_tab();
		$sections = array();
		if($tab!='general'){
			$sections['cilent_logo'] 	= __('Cilent logo upload', 'drtheme');
		}
		return $sections;
	}
	
	/**
	 * Define our form fields (options) 
	 *
	 * @Since 1.0.0
	 * @return array
	 */
	function options_page_fields() {
		// setting fields according to tab
		$options = array();
		for($i=1;$i<13;$i++){	
			$options[] = array(
				"section" => "cilent_logo",
				"id"      => "cilent_logo_".$i,
				"title"   => "",
				"std"     => "",
				"type"    => "group",
				"desc"    => "",
				"class"   => "",
				"order"	  => $i
			);
		}
		return $options;
	}
	
	/**
	 * Define our table header settings sections
	 *
	 * @Since 1.0.0
	 * @return array
	 */
	function header_table_fields() {
		$header=array(
		 		"No",
		 		 __('Cilent Name','drtheme'),
		 		 __('Cilent Web Url','drtheme'),
		 		 __('Cilent Logo','drtheme')
		);
		return $header;
	}
	
	/**
	 * Includes the user interface class and initializes it
	 *
	 * @since 1.0.0
	 * @see DrThemeCilentLogoUI
	 * @return DrThemeCilentLogoUI
	 */
	private function GetUI() {

		if($this->ui === null) {
			if(!class_exists('DrThemeCilentLogoUI')) {
				if(!file_exists(trailingslashit(dirname(__FILE__)) . 'drplugin-ui.php')) return false;
					require_once(trailingslashit(dirname(__FILE__)) . 'drplugin-ui.php');
			}
			$this->ui = new DrThemeCilentLogoUI($this);
		}

		return $this->ui;
	}
	/**
	 * Shows the option page of the general plugin. this function was basically the UI, afterwards the UI was outsourced to another class
	 *
	 * @see DrThemeCilentLogo
	 * @since 1.0.0
	 * @return bool
	 */
	public function HtmlShowOptionsPageSettings() {

		$ui = $this->GetUI();
		if($ui) {
			$ui->HtmlShowOptionsPageSettings();
			return true;
		}

		return false;
	}
	/**
	 * Shows the option page of the plugin. this function was basically the UI, afterwards the UI was outsourced to another class
	 *
	 * @see DrThemeCilentLogo
	 * @since 1.0.0
	 * @return bool
	 */
	public function HtmlShowOptionsPage() {

		$ui = $this->GetUI();
		if($ui) {
			$ui->HtmlShowOptionsPage();
			return true;
		}

		return false;
	}
}