<?php
require( "faq_api.php" );

layout_page_header(plugin_lang_get( 'plugin_format_title' ) );

layout_page_begin();
?>

<?php
	access_ensure_project_level( DEVELOPER );

	$f_question	  = gpc_get_string( 'question' );
	$f_answere	  = gpc_get_string( 'answere' );
	$f_project_id = gpc_get_string( 'project_id' );
		
	if( isset($_POST['f_id']) )
	{
		$f_poster_id  = gpc_get_int( 'f_id' );
		if (plugin_config_get('faq_view_check') )
			$f_view_access = gpc_get_int( 'faq_view_threshold' );
		else
			$f_view_access = 0;
			
		$result = faq_update_query( $f_poster_id, $f_question, $f_answere, $f_project_id,$f_view_access );
	}
	
	else
	{

		$f_poster_id  = auth_get_current_user_id();
		if (ON == plugin_config_get('faq_view_check') )
			$f_view_level = gpc_get_string( 'faq_view_threshold' );
		else 
			$f_view_level = plugin_config_get('faq_view_threshold');
			
		$result	= faq_add_query( $f_project_id, $f_poster_id, $f_question, $f_answere ,$f_view_level);
	}
	
    $f_question = string_display( $f_question );
    $f_answere 	= string_display( $f_answere );
?>
<div class="col-md-12 col-xs-12">
	<div class="space-0"></div>
	<?php if ( $result ) {# SUCCESS ?>
	<div class="alert alert-success center">
		<p class="bold bigger-110"><?php echo lang_get( 'operation_successful' ); ?></p><br>
		<div class="col-md-6 text-right"><b> <?php echo plugin_lang_get( 'question' ) ?>:</b></div>
		<div class="col-md-6 text-left"> <?php echo $f_question ?> </div>
		<div class="col-md-6 text-right"><b> <?php echo plugin_lang_get( 'answere' ) ?>:</b></div>
		<div class="col-md-6 text-left"> <?php echo $f_answere ?> </div>
		<div class="space-0"></div>	
		<div class="btn-group">
			<?php 
					print_button( $g_faq_menu_page, lang_get( 'proceed' ) );
				
			?>
		</div>
	</div>
	<?php } else { ?>
	<div class="alert alert-danger center">
		<?php echo print_sql_error( $query ); ?>
	</div>
	
	<?php } ?>
</div>

<?php

layout_page_end();
