<?php
/*
 Template Name: Search
 */

get_header();
$page_num = 1;
if (get_query_var("paged") > 1)
{
    $page_num = get_query_var("paged");
}

global $wp_query;
$excludeCats = array();
$excludeCats[] = get_category_by_slug('argolinks');
query_posts(
	array_merge(
		array( 'post_type' => array('post','page','argolinkroundups','schools') ),
		$wp_query->query
	)
);
?>

<div id="content" class="stories search-results span8" role="main">

	<?php if ( have_posts() ) { ?>

		<h3><?php echo number_format_i18n($wp_query->found_posts) ?> Stories <?php if ($page_num == 1): ?>/ <span id="num_docs_found">0</span> Documents <?php endif; ?>Found</h3>
		<hr/>

	<div id="story_results_container" <?php if ($page_num == 1) { ?>class="src"<?php } ?> >
		<h6 style='color:#B43018'>Top Stories for '<?php echo get_search_query() ?>':</h6>
		<?php
		/* Start the Loop */
		$i = 0;
		if ($page_num == 1) {
			while ( have_posts() && $i < 5 ) : the_post();
				get_template_part( 'partials/content', 'search' );
				$i++;
			endwhile;

			echo "<h6 style='color:#B43018; margin-top: 40px;'>More Stories for '" . get_search_query() . "':</h6>";
			while (have_posts()): the_post();
				get_template_part( 'partials/content','search-other' );
			endwhile;
		} else {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'partials/content', 'search' );
			}
			largo_content_nav( 'nav-below' );
		}
	} else {
		get_template_part( 'partials/content', 'not-found' );
	}

	if ($page_num == 1) {
		?>
			<a href="/page/2/?s=<?php echo urlencode(get_search_query()) ?>" style="color:#B43018; font-size:1.25em; font-weight:bold;"> >> Search more stories</a>
		<?php
	} ?>
	</div>

	<?php if ($page_num == 1): ?>
	<div id="doccloud_results_container" <?php if ($page_num == 1): ?>class="drc"<?php endif; ?>>
		<img src="<?php echo home_url('/wp-content/themes/largo-child/images/ajax-loader.gif');?>" alt="Loading..." />
	</div>
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php
	// Script that powers DocumentCloud results
	if ($page_num == 1) { ?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				var fullMonthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
				var curr_page = 1;
				jQuery.ajax({
					url: 'http://www.documentcloud.org/api/search.json',
					type: "GET",
					crossDomain: true,
					data: {"q": "group:thelens <?php echo get_search_query() ?>"},
					dataType: "json",
					success: function(data) {
						jQuery("#num_docs_found").html(data.total);
						var html = getResultsHtml(data);
						jQuery("#doccloud_results_container").html(html);
					}
				});
				function getResultsHtml (data) {
					if (data.total > 0) {
					var html = "<h6 style='color:#B43018'>Top Documents for '<?php echo get_search_query() ?>':</h6>";
					var top_docs = 5;
					if (data.documents.length < 5) {
						top_docs = data.documents.length;
					}
					for (var i = 0; i < top_docs; i++) {
						html += '<article class="argolinks type-argolinks status-publish hentry clearfix">';
						html += '<header class="search-header">';
						html += '<h5 class="top-tag"><span class="category-documents"><a>Documents</a></span></h5>';
						html += '<h3 class="entry-title"><a rel="bookmark" title="' + data.documents[i].title + '" href="' + data.documents[i].canonical_url + '" target="_blank">';
						html += data.documents[i].title + '</a>';
						html += '</h3><div class="post-meta"></div></header>';
						html += '<div class="entry-content">';
						html += '<div class="byline">Uploaded: ';
						//html += '<span class="by-author">' + data.documents[i].source + '</span>';
						var docdate = new Date (data.documents[i].created_at);
						html += '<time class="entry-date updated dtstamp pubdate" datetime="' + data.documents[i].created_at + '">' + fullMonthNames[docdate.getMonth()] + ' ' + docdate.getDate() + ', ' + docdate.getFullYear() + '</time>';
						html += '</div></div></article>'; 
					}
					if (data.documents.length > 5) {
						html += "<h6 style='color:#B43018; margin-top:40px;'>More Documents for '<?php echo get_search_query() ?>':</h6>";
						for (var i = 5; i < data.documents.length; i++) {
							html += '<article class="argolinks type-argolinks status-publish hentry clearfix" style="border-bottom:1px solid #BABCBE;">';
							html += '<header class="search-header">';
							html += '<h3 class="entry-title"><a rel="bookmark" title="' + data.documents[i].title + '" href="' + data.documents[i].canonical_url + '" target="_blank">';
							html += data.documents[i].title + '</a></h3>';
							html += '</header></article>';
						}
					}
					if (data.total > 10) {
						html += '<a href="search-documents?q=<?php echo urlencode(get_search_query()) ?>&pg=2" style="color:#B43018; font-size:1.25em; font-weight:bold;"> >> Search more documents</a>';
					}
					} else {
						var html = "<h6 style='color:#B43018'>No documents found for '<?php echo get_search_query() ?>'.</h6>";
					}
					return html;
				}
			});
		</script>
	<?php }
?>

<?php get_footer(); ?>
