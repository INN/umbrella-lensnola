<?php
/*
 * Template Name: Search Documents
 * Description: Displays a DocumentCloud search interface.
 *
 * Example page: 42944
 */

get_header(); ?>
<div id="content" class="stories search-results span8" role="main">
	<div id="doccloud_results_container"><img src="<?php echo home_url('/wp-content/themes/largo-child/images/ajax-loader.gif');?>" alt="Loading..." /></div>
</div><!--/.grid_8 #content-->

<?php get_sidebar(); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        var fullMonthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        jQuery.ajax({
            url: 'http://www.documentcloud.org/api/search.json',
            type: "GET",
            crossDomain: true,
            data: {"q": "group:thelens <?php echo $_GET["q"] ?>", "page": <?php echo (isset($_GET["pg"])) ? $_GET["pg"] : "1"; ?>},
            dataType: "json",
            success: function(data) {
                jQuery("#num_docs_found").html(data.total);
                var html = getResultsHtml(data);
                jQuery("#doccloud_results_container").html(html);
            }
        });
        function getResultsHtml (data) {
            var html = "<h6 style='color:#B43018'>More Documents for '<?php echo urldecode($_GET["q"]) ?>':</h6>";
            for (var i = 0; i < data.documents.length; i++) {
                html += '<article class="argolinks type-argolinks status-publish hentry clearfix">';
                html += '<header class="search-header">';
                html += '<h5 class="documents"><a href="/documents">Documents</a></h5>';
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
            if (data.page > 1 || data.total > 10) {
                html += '<nav id="nav-below" class="pager post-nav">';
                if (data.page > 2) {
                    html += '<a class="prev_link" data-link-type="prev" href="search-documents?q=<?php echo $_GET["q"] ?>&pg=<?php echo $_GET["pg"] - 1 ?>" style="padding-left:38px; width:195px;">Previous Documents</a>';
                } else if (data.page == 2) {
                    html += '<a class="prev_link" data-link-type="prev" href="/?s=<?php echo $_GET["q"] ?>&search+submit=GO">Previous Page</a>';
                }
                if (data.per_page * data.page <= data.total) {
                    html += '<a class="next_link" data-link-type="next" href="search-documents?q=<?php echo $_GET["q"] ?>&pg=<?php echo (isset($_GET["pg"])) ? ($_GET["pg"] + 1) : "2"; ?>">More Documents</a>';
                }
                html += '</nav>';
            }
            return html;
        }
    });
</script>

<?php get_footer(); ?>
