<?php
require( "faq_api.php" );

layout_page_header(plugin_lang_get( 'plugin_format_title' ) );

layout_page_begin();

access_ensure_project_level( DEVELOPER );

if( isset($_GET['f_id']) )
{
	$f_id = gpc_get_int( 'f_id' );
	
	# Retrieve faq item data and prefix with v_
	$row = faq_select_query( $f_id );
	if ( $row ) {
		extract( $row, EXTR_PREFIX_ALL, "v" );
	}
	$v_question = string_attribute( $v_question );
	$v_answere 	= string_textarea( $v_answere );
	$title = plugin_lang_get( 'edit_faq_title' );
	$project_id = $v_project_id ;
	$button = plugin_lang_get( 'update_faq_button' ) ;
}
elseif(isset($_GET['promote']))
{
	$v_question	  = gpc_get_string( 'question' );
	$v_answere	  = gpc_get_string( 'answere' );
	$project_id = gpc_get_string( 'project_id' );
		$title = plugin_lang_get( 'add_faq_title' );
	$button = plugin_lang_get( 'post_faq_button' ) ;
}else{
	$project_id = helper_get_current_project();
	$v_question = "";
	$v_answere 	= "";
	$title = plugin_lang_get( 'add_faq_title' );
	$button = plugin_lang_get( 'add_faq_button' ) ;
}



?>

<div class="col-md-8 col-md-offset-2 col-xs-12">
	<form method="post" action="<?php echo $g_faq_form2 ?>">
	
	<?php if( isset($_GET['f_id']) ) { ?>
		<input type="hidden" name="f_id" value="<?php echo $v_id ?>">
	<?php }else{ ?>
		<input type="hidden" name="f_poster_id" value="<?php echo current_user_get_field( "id" ) ?>">
	<?php }?>
	
	<div class="widget-box widget-color-green2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">
				<i class="ace-icon fa fa-edit"></i><?php echo $title ?>
			</h4>
			<div class="widget-toolbar">
				<div class="widget-menu"></div>
					<a id="filter-toggle" data-action="collapse" href="#">
						<i class="1 ace-icon fa bigger-125 fa-chevron-up"></i>
					</a>
			</div>
		</div>
		<div class="widget-body dz-clickable">
			
			<div class="widget-main no-padding">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed">
						
						<tbody>
						<tr>
							<th class="category" width="30%">
								<span class="required">*</span> <label for="question"><?php echo plugin_lang_get( 'question' ) ?></label>
							</th>
							<td width="70%">
								<input value="<?php echo $v_question ?>" type="text" name="question" size="80" maxlength="255" id="question">
							</td>
						</tr>
						<tr>
							<th class="category" width="30%">
								<span class="required">*</span> <label for="answere"><?php echo plugin_lang_get( 'answere' ) ?></label>
							</th>
							<td>
								<textarea id="answere" name="answere" cols="80" rows="10" wrap="virtual"> <?php echo $v_answere ?></textarea>
							</td>
						</tr>
						<?php if (ON == plugin_config_get('faq_view_check') ){ ?>
						<tr>
							<th class="category" width="30%">
								<label for="answere"><?php echo plugin_lang_get( 'faq_view_threshold' ) ?></label>
							</th>
							<td>
								<select name="faq_view_threshold">
								<?php print_enum_string_option_list( 'access_levels',  plugin_config_get( 'faq_view_threshold') )?>
								</select>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<th class="category" width="30%">
								<span class="required">*</span> <label for="project_id"><?php echo lang_get( 'post_to' ) ?></label>
							</th>
							<td>
								<select name="project_id">
								<?php
									$t_sitewide = false;
									if ( access_has_project_level( MANAGER ) ) {
										$t_sitewide = true;
									}
									print_project_option_list( $project_id, $t_sitewide );
								?>
								</select>
							</td>
						</tr>
						</tbody>
						
					</table>
				</div>
			</div>
			<div class="widget-toolbox padding-8 clearfix">
				<span class="required pull-right"> * Requerido</span>
				<input type="submit" value="<?php echo $button ?>" class="btn btn-primary btn-white btn-round" >
			</div>
			
		</div>
		
	</div></form>
</div>

<?php # Add faq Form END ?>

<?php

layout_page_end();
