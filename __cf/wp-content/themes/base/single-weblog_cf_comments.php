<?php if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) { ?>
	<p class="nocomments">This post is password protected. Enter the password to view any comments.</p>
<?php return; } ?>

<?php if (have_comments()): ?>
	<div class="comping">
	<?php $comments_cnt = get_comment_only_number();?>
	<!-- コメント -->
	<?php if ($comments_cnt > 0) { ?>
		<h3><?= $comments_cnt ?>件のコメント</h3>
		<ul class="commentlist">
			<?php wp_list_comments('type=comment&callback=mytheme_comment');?>
		</ul>
	<?php } ?>
	<!-- トラックバック -->
	<?php if (get_comments_number()-$comments_cnt > 0) { ?>
		<h3><?= get_comments_number()-$comments_cnt ?>件のトラックバック</h3>
		<ul class="pinglist">
			<?php wp_list_comments('type=pings&callback=mytheme_pings');?>
		</ul>
	<?php } ?>
	</div>
<?php endif;?>

<?php $defaults = array(
	'comment_notes_before' => '',
	'fields' => array(
		'author' => '<div class="form_list_wrap"><dl class="comment-form-author"><dt>' . '<label for="author">' . ( $req ? '<span class="required">*</span>' : '' ) . __( 'Name' ) . '</label></dt><dd>' . '<input id="author" name="author" class="input_text nomal" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . '></dd></dl></div>',
		'email'  => '<div class="form_list_wrap"><dl class="comment-form-email"><dt>' . '<label for="email">' . ( $req ? '<span class="required">*</span>' : '' ) . __( 'E-mial（非公開）' ) . '</label></dt><dd>' . '<input id="email" name="email" class="input_text nomal" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . '></dd></dl></div>',
		'url'    => ''
	),
	'comment_field' => '<div class="form_list_wrap"><dl class="comment-form-comment"><dt><label for="comment">' . _x( 'Comment', 'noun' ) . '</label></dt><dd><textarea id="comment" class="textarea nomal" name="comment" aria-required="true"></textarea></dd></dl></div>',
	'comment_notes_after'  => ''
);?>

<?php comment_form( $defaults );?>
