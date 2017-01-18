<?php

/**
 * Outputs custom byline and link (if set), otherwise outputs author link and post date
 *
 * @param $echo bool echo the string or return it (default: echo)
 * @return string byline as formatted html
 * @since 1.0
 */
function largo_byline( $echo = true, $includeAuthor = true, $includeTime=false, $includeOpinion=true, $includeNickname=false ) {
	$html = '';
	if ($includeOpinion && has_category('opinion'))
		$html .= '<span class="opinion-label">Opinion</span>&nbsp;&nbsp;&nbsp;&nbsp;';

	if ($includeAuthor) {
		$nickname = get_the_author_meta('nickname');
		$html .= '<span class="by-author"><span class="sep">By</span> <span class="author vcard">%1$s</span>' . (($includeNickname && $nickname) ? '<span class="nickname">, %4$s</span>' : '') . '</span>&nbsp;&nbsp;&nbsp;&nbsp;<time class="entry-date updated dtstamp pubdate" datetime="%2$s">%3$s</time>';
	}

	else $html .= '<time class="entry-date updated dtstamp pubdate" datetime="%2$s">%3$s</time>';

	$output = sprintf( $html,
		largo_author_link( false ),
		esc_attr( get_the_date( 'c' ) ),
		largo_time( false, $includeTime ),
		$nickname
	);

	if ( $echo )
		echo $output;
	return $output;
}

/**
 * For posts published less than 24 hours ago, show "time ago" instead of date, otherwise just use get_the_date
 *
 * @param $echo bool echo the string or return itv (default: echo)
 * @return string date and time as formatted html
 * @since 1.0
 */
function largo_time( $echo = true, $includeTime=false ) {
	$time_difference = current_time('timestamp') - get_the_time('U');

	if($time_difference < 86400) {
		$output = '<span class="time-ago">' . human_time_diff(get_the_time('U'), current_time('timestamp')) . __(' ago', 'largo') . '</span>';
	} else if ($includeTime) {
		$output = get_the_date("F j, Y g:ia");
	} else {
		$output = get_the_date();
	}

	if ( $echo )
		echo $output;
	return $output;
}

/**
 * Display navigation to next/previous pages when applicable
 *
 * @since 1.0
 */
function largo_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>

	<nav id="<?php echo $nav_id; ?>" class="pager post-nav">
		<?php previous_posts_link( __( 'Later Stories', 'largo' ) ); ?>
        <?php next_posts_link( __( 'Earlier Stories', 'largo' ) ); ?>
	</nav><!-- .post-nav -->

	<?php endif;
}


function largo_child_category_link($term,$slug) {
	if ($slug == "charterschools") return home_url('/charterschools');
	return get_category_link($term);
}