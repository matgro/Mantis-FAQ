<?php
require( "faq_api.php" );

layout_page_header(plugin_lang_get( 'plugin_format_title' ) );
layout_page_begin();


access_ensure_project_level( DEVELOPER );
$f_id = gpc_get_int( 'f_id' );
# Delete the faq entry
$result = faq_delete_query( $f_id );
$t_redirect_url = $g_faq_menu_page;
if ( $result ) {
$msg = lang_get( 'operation_successful' );
$color = "success";
} else {
$msg = print_mantis_error( ERROR_GENERIC );
$color = "danger";

}
?>
	<div class="alert alert-<?php echo $color; ?> center">
		<p class="bold bigger-110"><?php echo $msg; ?></p><br>
		<div class="space-0"></div>	
		<div class="btn-group">
			<?php 
					print_button( $g_faq_menu_page, lang_get( 'proceed' ) );
				
			?>
		</div>
	</div>
<?php
layout_page_end();
