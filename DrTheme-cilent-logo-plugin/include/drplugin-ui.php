<?php
class DrThemeCilentLogoUI {

	/**
	 * The DrTheme Cilent Logo Object
	 *
	 * @var DrThemeCilentLogo
	 */
	private $sg = null;
	private $plugins = array('cilent-logo','menu-widget','contact-info','modal-dialog');
	private $donatelink = 'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=FTBM3EX673NMC&lc=ID&item_name=DrSoftwareLab%27s&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted';
	private $ratefive="";
	public function __construct(DrThemeCilentLogo $cilentlogoBuilder) {
		$this->sg = $cilentlogoBuilder;
		$this->sg->Initate();
	}
	
	/**
	 * Define Settings Page Tab Markup
	 *  
	 * @since 1.0.0
	 * @link`http://www.onedesigns.com/tutorials/separate-multiple-theme-options-pages-using-tabs
	 *
	 */
	 function options_page_tabs() {
	   $tabs = $this->sg->settings_page_tabs();
	   $current=$this->sg->get_current_tab();
	   // check for tabs
	   if ($tabs !='') {
		// wrap each in anchor html tags
		$links = array();
		foreach( $tabs as $tab => $name ) {
			// set anchor class
			$class 		= ($tab == $current? 'nav-tab nav-tab-active' : 'nav-tab');
			$page 		= $_GET['page'];
			// the link
			$links[] 	= "<a class='$class' href='?page=$page&tab=$tab'>$name</a>";
		}
		
		echo '<h3 class="nav-tab-wrapper">';
			foreach ( $links as $link ) {
				echo $link;
			}
		echo '</h3>';
	   }
	 }
	 
	 /**
	 * Prints out all settings sections added to a particular settings page
	 *
	 * @global $wp_settings_sections Storage array of all settings sections added to admin pages
	 * @global $wp_settings_fields Storage array of settings fields and info about their pages/sections
	 * @since 1.0.0
	 *
	 * @param string $page The slug name of the page whose settings sections you want to output
	 */
	function print_settings_sections( $page ) {
		global $wp_settings_sections, $wp_settings_fields;
	
		if ( ! isset( $wp_settings_sections[$page] ) )
			return;
	
		foreach ( (array) $wp_settings_sections[$page] as $section ) {
			if ( $section['title'] )
				echo "<h4>{$section['title']}</h4>\n";
	
			if ( $section['callback'] )
				call_user_func( $section['callback'], $section );
	
			if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) )
				continue;
			echo '<table class="table tabble-fixed table-condensed">';
			$this->print_settings_header();
			$this->print_settings_fields( $page, $section['id'] );
			echo '</table>';
		}
	}
	
	/**
	 * Print out the header table settings fields for a particular settings section
	 *
	 * @since 1.0.0
	 *
	 */
	function print_settings_header() {
		echo "<thead> <tr>";
		foreach ( $this->sg->header_table_fields() as $field ) {
			echo '<th>';
			echo $field;
			echo '</th>';
		}
		echo '</tr></thead>';
	}
	 /**
	 * Print out the settings fields for a particular settings section
	 *
	 * @global $wp_settings_fields Storage array of settings fields and their pages/sections
	 *
	 * @since 1.0.0
	 *
	 * @param string $page Slug title of the admin page who's settings fields you want to show.
	 * @param string $section Slug title of the settings section who's fields you want to show.
	 */
	function print_settings_fields($page, $section) {
		global $wp_settings_fields;
	
		if ( ! isset( $wp_settings_fields[$page][$section] ) )
			return;
	
		foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {	
			echo "<tr>";
			echo '<td class="col-xs-1">';
			call_user_func($field['callback'], $field['args']);
			echo '</td>';
			echo '</tr>';
		}
	}
	/**
	 * helper to show guide body html
	 * @since 1.0.0
	 */
	 function displayguide(){
	 	?>
	 		<h3>
				<?php printf(__('Thank you for downloading DrTheme Cilent Logo Plugin V. %1$s', 'drtheme'),esc_attr($this->sg->GetVersion()));?>
				<small><?php _e(", <br>a WordPress plugin code by Rachmat Yanuarsyah.");?></small>
			</h3><br/>
			
			<h4><?php _e('How to display the number of cilent logo','drtheme');?></h4>
			
			<p>
				<?php printf( __( 'Use the %s shortcode.', 'drtheme' ), '<code>&#91;CilentLogoShortCode image_display="image number to display"&#93;</code>' ); ?>
            	<?php _e( 'For example:', 'drtheme' ); ?><br/>
            	<?php _e( 'this example will generate image display 5 image to show', 'drtheme' ); ?>
       		</p>
       		
        	<div class="panel panel-default">
			  <div class="panel-body">
			    <code>
				    <?php printf( '&#91;CilentLogoShortCode image_display=5&#93;' ); ?>
	            </code>
			  </div>
			</div><br/>
        	
        	<h5><?php _e('Try the other our free plugins :','drtheme');?></h5>
			<p><?php 
				foreach($this->plugins as $each){
					if($each!='cilent-logo'){
						?><a href="https://github.com/rachmatyanuarsyah/DrTheme-<?php echo $each;?>-plugin/" target="_blank">
							<img class="image-icon" src="<?php echo DRTHEME_LOGO_PLUGIN_IMAGES . $each.'.png';?>" style="width:100px;">
						</a><?php
					}
				}
			?></p><br/>
			<p><?php 
				printf(__('Please support further development of this plugin with a small %1$s or %2$s','drtheme'),
					sprintf('<a target="_blank" href="%1$s" title="Donate">%2$s</a>',
						esc_url($this->donatelink),
				  		__('donation','drtheme')
					),
					sprintf('<a target="_blank" href="%1$s" title="rate 5 stars">%2$s</a>',
						esc_url($this->ratefive),
						__('rate it 5 stars','drtheme')
					)
				);?>
			</p>
			<p><?php
				printf('<a target="_blank" href="%1$s" title="Donate">%2$s</a>',
					esc_url($this->donatelink),
					sprintf('<img class="img-responsive img-thumbnail" src="%1$s">',
						DRTHEME_LOGO_PLUGIN_IMAGES.'paypal_donate.png'
					)
				);
			?></p>
		<?php 
	 }
	/**
	 * helper to show tab body html
	 * @since 1.0.0
	 */
	 function displaypage(){
	 	$tab=$this->sg->get_current_tab();
	 	if($tab !='general'){ ?>
			<form action="options.php" method="post" enctype="multipart/form-data">
				<?php settings_fields(DRTHEME_LOGO_PLUGIN_OPTIONS_NAME);?>
				<?php $this->print_settings_sections('cilent_logo'); ?>
				<p class="submit">
					<input id="submit" name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Setting','drtheme'); ?>" />
					<input name="reset" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'drtheme'); ?>" />
				</p>
			</form>
		<?php } else {
			$this->displayguide();
		}
	 }
	/**
	 * Displays the General page
	 *
	 * @since 1.0.0
	 */
	public function HtmlShowOptionsPageSettings() {
?>

		<div class="wrap" id="DrPlugin-div">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<h3>
							<?php _e('Thank you for downloading DrTheme Plugin', 'drtheme');?>
							<small><?php _e(", <br>a WordPress plugin code by Rachmat Yanuarsyah.");?></small>
						</h3>
						<div class="row">
							<div class="col-xs-12 col-sm-8">
								 <?php
								 _e(' If you are looking for a new/better web host, I recommend the following sites.<br/>
									<small>(Full disclosure: I use these sites, am in their affiliate programs, and get paid a commision 
									if you sign up using these links)</small> :','drtheme');
								?>
								<br /><br />
								<ul class="list-group">
									<li class="list-group-item">
										<a href="http://www.bluehost.com/track/drtheme">BlueHost</a> 
										<?php _e('is one of the most popular hosting options on the Internet. 
										They are also the most recommended hosting service by WordPress. 
										BlueHost makes it quick and easy to install WordPress','drtheme');?>
									</li>
									<li class="list-group-item">
										<a href="https://panel.niagahoster.co.id/ref/61880?r=hosting-indonesia">NiagaHoster</a> 
										<?php _e('is a cheap hosting options for IIX SERVERS (Indonesia Internet Exchange). 
										Indonesia#39;s Best Web Hosting Service with unlimited disk space and bandwidth, 
										24 hour technical support, Supermicro server, cPanel hosting, Softaculous, 
										and sophisticated Biznet tier-3 datacenter in Indonesia.','drtheme');?>
									</li>
									<li class="list-group-item">
										<a href="https://member.ardetamedia.com/aff.php?aff=3022">ArdetaMedia</a> 
										<?php _e('is a good hosting options on the Internet. 
										With a very affordable price you can have unlimited server hosting. 
										Our unlimited bandwidth hosting service is not limited to save space just for you','drtheme');?>
									</li>
								</ul>
								<h5><?php _e('Try the other our free plugins :','drtheme');?></h5>
								<p><?php 
							      foreach($this->plugins as $each){
							          ?><a href="https://github.com/rachmatyanuarsyah/DrTheme-<?php echo $each;?>-plugin/" target="_blank">
							          		<img class="image-icon" src="<?php echo DRTHEME_LOGO_PLUGIN_IMAGES . $each.'.png';?>" style="width:100px;">
							          	</a><?php
							        }
							    ?></p>
								<p><?php 
									printf(__('Please support further development of this plugin with a small %1$s or %2$s','drtheme'),
										sprintf('<a target="_blank" href="%1$s" title="Donate">%2$s</a>',
											esc_url($this->donatelink),
									  		__('donation','drtheme')
										),
										sprintf('<a target="_blank" href="%1$s" title="rate 5 stars">%2$s</a>',
											esc_url($this->ratefive),
									  		__('rate it 5 stars','drtheme')
										)
									);?>
								?></p>
								<p><?php
									printf('<a target="_blank" href="%1$s" title="Donate">%2$s</a>',
										esc_url($this->donatelink),
										sprintf('<img class="img-responsive img-thumbnail" src="%1$s">',
											DRTHEME_LOGO_PLUGIN_IMAGES.'paypal_donate.png'
										)
									);
								?></p>
							</div>
							<div class="col-xs-12 col-sm-4">	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	/**
	 * Displays the cilent-logo page
	 *
	 * @since 1.0.0
	 */
	public function HtmlShowOptionsPage() {
?>

		<style type="text/css">
		.table > tbody > tr > td {
		     vertical-align: middle;
		}
		</style>

		<div class="wrap" id="DrPlugin-div">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<h3><?php _e('DrTheme Cilent Logo Plugin Version', 'drtheme'); echo " " . $this->sg->GetVersion() ?> </h3>
						<?php $this->options_page_tabs();?>
						<div class="panel panel-default">
  							<div class="panel-body">
  								<div class="row">
  									<div class="col-xs-12 col-sm-8">
										<?php $this->displaypage();?>
									</div>
									<div class="col-xs-12 col-sm-4">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	
}