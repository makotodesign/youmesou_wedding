<?php
/*--------------------------------------------------------------

	recruit_index_wp_module

	@memo

---------------------------------------------------------------*/

##	base

	/* setting */
	// archive_list_num
	$display_post_num_archive_list = -1;

##	tag

	/* archive_list */
	// arg
	$args = array(
		'showposts' => $display_post_num_archive_list
	);
	// tag
	$posts_array = get_posts( $args );
	$tag = '';
	$tb  = "\t\t\t\t\t\t\t";
	if( $posts_array ) {
		foreach( $posts_array as $post ) {
			setup_postdata( $post );
			/* wp_elements */
			// base
			$this_post_id             = $post->ID;
			$post_title               = get_the_title();
			$permalink                = get_permalink();
			// category
			$the_categories           = get_the_category();
			$the_cat                  = $the_categories[ 0 ];
			$the_cat_id               = $the_cat->cat_ID;
			$the_cat_slug             = $the_cat->slug;
			$the_cat_name             = $the_cat->name;
			//acf
			$recruit_place            = get_field( 'recruit_place', $post->ID );
			$recruit_time             = get_field( 'recruit_time', $post->ID );
			$recruit_salary           = get_field( 'recruit_salary', $post->ID );
			$recruit_welfare          = get_field( 'recruit_welfare', $post->ID );
			$recruit_qualification    = get_field( 'recruit_qualification', $post->ID );
			/* loop_tag( *editable ) */
			// archive_list
			$tag .= $tb . "" . '<div class="part">' . "\n";
			$tag .= $tb . "\t" . '<h3 class="heading03">' . $post_title . '</h3>' . "\n";
			$tag .= $tb . "\t" . '<table class="table01">' . "\n";
			$tag .= $tb . "\t\t" . '<tr>' . "\n";
			$tag .= $tb . "\t\t\t" . '<th>勤務場所</th>' . "\n";
			$tag .= $tb . "\t\t\t" . '<td>' . "\n";
			$tag .= $tb . "\t\t\t\t" . '<p>' . $recruit_place . '</p>' . "\n";
			$tag .= $tb . "\t\t\t" . '</td>' . "\n";
			$tag .= $tb . "\t\t" . '</tr>' . "\n";
			$tag .= $tb . "\t\t" . '<tr>' . "\n";
			$tag .= $tb . "\t\t\t" . '<th>勤務時間</th>' . "\n";
			$tag .= $tb . "\t\t\t" . '<td>' . "\n";
			$tag .= $tb . "\t\t\t\t" . '<p>' . $recruit_time . '</p>' . "\n";
			$tag .= $tb . "\t\t\t" . '</td>' . "\n";
			$tag .= $tb . "\t\t" . '</tr>' . "\n";
			$tag .= $tb . "\t\t" . '<tr>' . "\n";
			$tag .= $tb . "\t\t\t" . '<th>給与</th>' . "\n";
			$tag .= $tb . "\t\t\t" . '<td>' . "\n";
			$tag .= $tb . "\t\t\t\t" . '<p>' . $recruit_salary . '</p>' . "\n";
			$tag .= $tb . "\t\t\t" . '</td>' . "\n";
			$tag .= $tb . "\t\t" . '</tr>' . "\n";
			$tag .= $tb . "\t\t" . '<tr>' . "\n";
			$tag .= $tb . "\t\t\t" . '<th>待遇</th>' . "\n";
			$tag .= $tb . "\t\t\t" . '<td>' . "\n";
			$tag .= $tb . "\t\t\t\t" . '<p>' . $recruit_welfare . '</p>' . "\n";
			$tag .= $tb . "\t\t\t" . '</td>' . "\n";
			$tag .= $tb . "\t\t" . '</tr>' . "\n";
			$tag .= $tb . "\t\t" . '<tr>' . "\n";
			$tag .= $tb . "\t\t\t" . '<th>応募資格</th>' . "\n";
			$tag .= $tb . "\t\t\t" . '<td>' . "\n";
			$tag .= $tb . "\t\t\t\t" . '<p>' . $recruit_qualification . '</p>' . "\n";
			$tag .= $tb . "\t\t\t" . '</td>' . "\n";
			$tag .= $tb . "\t\t" . '</tr>' . "\n";
			$tag .= $tb . "\t" . '</table>' . "\n";
			$tag .= $tb . "" . '</div>' . "\n";
		}
	} else {
		$tag .= $tb . "" . '<div class="part texts">' . "\n";
		$tag .= $tb . "\t" . '<p>現在募集情報はありません。</p>' . "\n";
		$tag .= $tb . "" . '</div>' . "\n";
	}

	$tag_archive_list = $tag;

?>