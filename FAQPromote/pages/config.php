<?php
auth_reauthenticate();

access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header(plugin_lang_get( 'plugin_format_title' ) );

layout_page_begin();
print_manage_menu();
?>

<br/>

<div class="col-md-6 col-md-offset-3 col-xs-12">
	<form action="<?php echo plugin_page( 'config_edit' ) ?>" method="post">
	
	<div class="widget-box widget-color-green2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">
				<i class="ace-icon fa fa-cogs"></i><?php echo plugin_lang_get( 'plugin_format_title' ) . ': ' . plugin_lang_get( 'plugin_format_config' ) ?>
			</h4>
		</div>
		<div class="widget-body dz-clickable">
			
			<div class="widget-main no-padding">
				<div class="table-responsive">
					<table class="table table-bordered table-condensed">
					<tbody>
					<tr >
						<td class="category" width="50%">
							<?php echo plugin_lang_get( 'plugin_format_project_text' ) ?>
						</td>
						<td class="center">
							<label><input type="radio" name="project_text" value="1" <?php echo ( ON == plugin_config_get( 'project_text' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
						
							<label><input type="radio" name="project_text" value="0" <?php echo ( OFF == plugin_config_get( 'project_text' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
						</td>
					</tr>
					<tr >
						<td class="category">
							<?php echo plugin_lang_get( 'plugin_format_promote_text' ) ?>
						</td>
						<td class="center">
							<label><input type="radio" name="promote_text" value="1" <?php echo ( ON == plugin_config_get( 'promote_text' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
						
							<label><input type="radio" name="promote_text" value="0" <?php echo ( OFF == plugin_config_get( 'promote_text' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
						</td>
					</tr>

					<tr >
						<td class="category">
							<?php echo plugin_lang_get( 'faq_view_window' ) ?>
						</td>
						<td class="center" >
							<label><input type="radio" name="faq_view_window" value="1" <?php echo ( ON == plugin_config_get( 'faq_view_window' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
						
							<label><input type="radio" name="faq_view_window" value="0" <?php echo ( OFF == plugin_config_get( 'faq_view_window' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
						</td>
					</tr>
					<tr >
						<td class="category">
							<?php echo plugin_lang_get( 'faq_view_check' ) ?>
						</td>
						<td class="center" width="20%">
							<label><input type="radio" name="faq_view_check" value="1" <?php echo ( ON == plugin_config_get( 'faq_view_check' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_enabled' ) ?></label>
						
							<label><input type="radio" name="faq_view_check" value="0" <?php echo ( OFF == plugin_config_get( 'faq_view_check' ) ) ? 'checked="checked" ' : ''?>/>
								<?php echo plugin_lang_get( 'plugin_format_disabled' ) ?></label>
						</td>
					</tr>
					<tr >
						<td class="category">
							<?php echo plugin_lang_get( 'faq_view_threshold' ) ?>
						</td>
						<td class="center">
								<select name="faq_view_threshold">
								<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'faq_view_threshold'  ) ) ?>;
								</select>
						</td>
					</tr>
					<tr >
						<td class="category">
							<?php echo plugin_lang_get( 'plugin_format_threshold_text' ) ?>
						</td>
						<td class="center">
								<select name="promote_threshold">
								<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'promote_threshold'  ) ) ?>;
								</select>
						</td>

					</tr>
					</tbody>
					</table>
				</div>
			</div>
			<div class="widget-toolbox padding-8 clearfix">
				<input type="submit" value="<?php echo lang_get( 'change_configuration' ) ?>"  class="btn btn-primary btn-white btn-round" />
			</div>
			
		</div>
		
	</div>
					
	<form>
</div>
<?php
layout_page_end();
