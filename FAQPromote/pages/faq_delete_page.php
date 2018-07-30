<?php
require( "faq_api.php" );

layout_page_header(plugin_lang_get( 'plugin_format_title' ) );
layout_page_begin();

$f_id = gpc_get_int( 'f_id' );
?>

<div class="col-md-12 col-xs-12">
	<div class="space-10"></div>
	<div class="alert alert-warning center">
	<p class="bigger-110">
		<?php echo plugin_lang_get( 'delete_faq_sure_msg' ) ?>
	</p>
	<div class="space-10"></div>
	<form method="post" class="center" action="<?php echo $g_faq_delete ?>">
		<input type="hidden" name="f_id" value="<?php echo $f_id ?>">
		<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get( 'delete_faq_item_button' ) ?>">
	</form>
	<div class="space-10"></div>
	</div>
</div>


<?php
layout_page_end();
