<?php
require( "faq_api.php" );

access_ensure_global_level( plugin_config_get( 'faq_view_threshold' ) );

layout_page_header(plugin_lang_get( 'plugin_format_title' ) );

layout_page_begin();
# Select the faq posts

$minimum_level = access_get_global_level();
$t_where_clausole = "view_access <= $minimum_level";
$p_project_id = helper_get_current_project();

if( $p_project_id != 0 ) {
    $t_where_clausole .= " and ((project_id='".$p_project_id."' OR project_id=0)";
	$t_project_ids = project_hierarchy_get_subprojects( $p_project_id );
	foreach ($t_project_ids as $value) {
		$t_where_clausole .= " or project_id='".$value."'";
	}
	$t_where_clausole .= ")";
}
if(isset($_POST["f_search"]))
{
	$f_search = $_POST["f_search"];
}

if( !isset( $f_search ) ) {
	$f_search = "";
	$f_search3 = "";
	$f_search2 = "";
	
} else {
	$f_search3 = "";
	$f_search2 = "";
    if( $t_where_clausole != "" ){
        $t_where_clausole = $t_where_clausole . " AND ";
	}

	$f_search=trim($f_search);
	$what = " ";
	$pos = strpos($f_search, $what);

	if(isset($_POST["search_string"]))
	{
		$search_string = $_POST["search_string"];
	}
	
	if (($pos === false) or (isset( $search_string ))){
		$t_where_clausole = $t_where_clausole . " ( (question LIKE '%".addslashes($f_search)."%')
				OR (answere LIKE '%".addslashes($f_search)."%') ) ";
	} else {
		$pos1 = strpos($f_search, $what, $pos+1);
		if ($pos1 === false) {
			$f_search2 = substr($f_search, $pos);
		} else {
			$len1=$pos1-$pos;
			$f_search2 = substr($f_search, $pos1,$len1);
		}
		$f_search3 = substr($f_search,0, $pos);
		$f_search3=trim($f_search3);
		$f_search2=trim($f_search2);
		$t_where_clausole = $t_where_clausole . " ((question LIKE '%".addslashes($f_search3)."%') and (question LIKE '%".addslashes($f_search2)."%'))
					OR ((answere LIKE '%".addslashes($f_search3)."%') and (answere LIKE '%".addslashes($f_search2)."%')) ";
	}
}

$query = "SELECT id, poster_id, project_id, UNIX_TIMESTAMP(date_posted) as date_posted, question, answere FROM $g_mantis_faq_table";
if( $t_where_clausole != "" ){
    $query = $query . " WHERE $t_where_clausole";
}

$query = $query . " ORDER BY UPPER(question) ASC";
$result = db_query_bound( $query );
$faq_count = db_num_rows( $result );
?>
<div class="col-md-12 col-xs-12">
<form method="post" action="<?php echo $g_faq_menu_page ?>">
<div class="widget-box widget-color-green2">
	<div class="widget-header widget-header-small">
		<h4 class="widget-title lighter">
			<i class="ace-icon fa fa-filter"></i><?php echo plugin_lang_get( 'search_filter'); ?>
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
							<span class="required">*</span><label for="f_search"><?php echo lang_get( 'search'); ?></label>
						</th>
						<td width="70%">
							<input type="text" size="25" name="f_search" value="<?php echo $f_search; ?>" id="f_search">
						</td>
					</tr>
					<tr>
						<th class="category" width="30%">
							<label for="search_string"><?php echo plugin_lang_get( 'search_string' ) ?></label>
						</th>
						<td>
							<label>
								<input type="checkbox" name="search_string" id="search_string" class="ace"> 
								<span class="lbl padding-6"></span>
							</label>
						</td>
					</tr>
					</tbody>
		
				</table>
			</div>
		</div>
		<div class="widget-toolbox padding-8 clearfix">
			<span class="required pull-right"> * Requerido</span>
			<input type="submit" name="f_filter" value="<?php echo lang_get( 'filter_button') ?>" class="btn btn-primary btn-white btn-round" >
			
		</div>
	</div>
</div>
</form>
</div>

<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="widget-box widget-color-green2">

	<div class="widget-header widget-header-small">
		<h4 class="widget-title lighter">
			<i class="ace-icon fa fa-columns"></i><?php echo plugin_lang_get( 'viewing_faq_title'); ?>
			<span class="badge"><?php echo "Total " . $faq_count . " FAQ"; ?></span>
		</h4>
	</div>
	<div class="widget-body">
		<div class="widget-toolbox padding-8 clearfix">
		<div class="btn-toolbar">
			<div class="btn-group pull-left">
			<?php
					if ( access_has_project_level( DEVELOPER ) ) {
						global $g_faq_add_page;
						print_button( $g_faq_form_page, plugin_lang_get( 'add_faq') );
					}
			?>
			</div>
			</div>
		</div>
	
	
		<div class="widget-main no-padding">
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-striped" style="font-size:13px">
					<tbody>
						<?php

					# Loop through results
					if( $f_search == "" ){
						$faq_count1=15;
						if ($faq_count==0){
							$faq_count1=0;
						}
						if ($faq_count1 > $faq_count){
							$faq_count1=$faq_count;
						}
					} else {
						$faq_count1=$faq_count;
					}

					for ($i=0;$i<$faq_count1;$i++) {
						$row = db_fetch_array($result);
						extract( $row, EXTR_PREFIX_ALL, "v" );
						if(( isset( $search_string )) or (isset($pos) && $pos === false)) {
							$v_question = preg_replace ( "/".$f_search."/i", "<b>".$f_search."</b>", $v_question );
							$v_answere 	= preg_replace ( "/".$f_search."/i", "<b>".$f_search."</b>", $v_answere );
						}
						if( $f_search2 != "" )  {
							$v_question = preg_replace ( "/".$f_search2."/i", "<b>".$f_search2."</b>", $v_question );
							$v_answere 	= preg_replace ( "/".$f_search2."/i", "<b>".$f_search2."</b>", $v_answere );
						}
						if( $f_search3 != "" )  {
							$v_question = preg_replace ( "/".$f_search3."/i", "<b>".$f_search3."</b>", $v_question );
							$v_answere 	= preg_replace ( "/".$f_search3."/i", "<b>".$f_search3."</b>", $v_answere );
						}
						$v_question = string_display( $v_question );
						$v_answere 	= string_display_links( $v_answere );
						$v_date_posted = date( $g_complete_date_format, $v_date_posted );

						# grab the username and email of the poster
						$t_poster_name	= user_get_name($v_poster_id );
						$t_poster_email	= user_get_email($v_poster_id );

						$t_project_name = "Sitewide";
						if( $v_project_id != 0 ) {
							$t_project_name = project_get_field( $v_project_id, "name" );
						}
						$v_answere = trim(substr($v_answere, 0, 25)); 
						
						$target = "";
						$info_proyect = "";
						if (ON == plugin_config_get('faq_view_window') )
						{
							$target = "target=_new";
						}
						if( helper_get_current_project() == '0000000' )
						{
							$info_proyect = "[ $t_project_name ]";
						}
						
						?>

						<tr class="bugnote visible-on-hover-toggle" id="c1">
							<td class="category">
							<div class="pull-right padding-2">		
								<p class="no-margin text-right" > 
									<?php echo $v_question ?>
								</p>
							</div>
							<div class="pull-left padding-2">
							
							<div class="btn-group visible-on-hover invisible">
									<div class="pull-left">
										<form method="post" action="<?php echo "$g_faq_form_page&f_id=$v_id" ?>" class="form-inline inline single-button-form">
											<fieldset>
												<button type="submit" class="btn btn-primary btn-xs btn-white btn-round">Editar</button><input type="hidden" name="bugnote_id" value="1">
											</fieldset>
										</form>
									</div>
									<div class="pull-left">
										<form method="post" action="<?php echo "$g_faq_delete_page&f_id=$v_id" ?>" class="form-inline inline single-button-form">
											<fieldset>
												<input type="hidden" name="bugnote_delete_token" value="20180729WjJbjnV82gq4wLO_FIbzWj990grR-QX8">
												<button type="submit" class="btn btn-primary btn-xs btn-white btn-round">Eliminar</button>
												<input type="hidden" name="bugnote_id" value="1">
											</fieldset>
										</form>
									</div>
								</div>
							<p class="no-margin">
								<i class="fa fa-user grey"></i> 
								<a class="user" href="#">
									<?php echo $t_poster_name;?>
								</a>		
							</p>
							<p class="no-margin small lighter">
								<i class="fa fa-clock-o grey"></i> 
								<?php echo $v_date_posted ?>
							</p>
							<p class="no-margin">
								<i class="fa fa-link grey"></i>
								~<a <?php echo $target ?> title="<?php echo  plugin_lang_get( 'link_title')?>" rel="bookmark" href="#" target=_new class="lighter"><?php echo str_pad($v_id, 7, 0, STR_PAD_LEFT) ?></a>
								<?php echo $info_proyect; ?>
							</p>
							<div class="clearfix"></div>
							<div class="space-2"></div>
								
							</div>
						</td>
						<td class="bugnote-note bugnote-public">
							<?php echo $v_answere ?>
						</td>
					</tr>
					<?php 	}  # end for loop ?>

					
				</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
</div>
<?php
layout_page_end();
