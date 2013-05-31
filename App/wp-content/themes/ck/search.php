<?php get_header(); ?>
<div class="b_content clearfix" id="main">

    <!-- title bar -->
    <div class="content-title">
        <div class="left">&nbsp;</div>
        <div class="title">
        	<h1 class="entry-title search"><?php _e( 'Search' , 'cosmotheme' ); ?></h1>
        </div>
        <div class="right">&nbsp;</div>
    </div>

    <!-- Start content -->
    <div class="b_page clearfix">

        <!-- left sidebar -->
        <?php layout::side( 'left' , 0 , 'search' ); ?>

        <div id="primary" class="w_640 fr">
            <div id="content" role="main">
                <div class="w_610  page search_result">
					<?php
                        if ( have_posts () ) { ?>
                            <h2>Searches related to &quot<?php echo wp_specialchars($s); ?>&quot<small> - <?php echo $wp_query->found_posts . ' results'; ?></small></h2><?php
                        } else {  ?>
                            <h2>Your search &quot<?php echo wp_specialchars($s); ?>&quot did not match any documents.</h2>
							<h4 class="suggestions">Suggestions:</h4>
                            <ul class="suggestions">
                                <li>Make sure all words are spelled correctly.</li>
                                <li>Try different keywords.</li>
                                <li>Try more general keywords.</li>
                            </ul>
							<?php
                        }
                    ?>
					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
					<script>
                    $(function() {
                        $('ul#search_list li:nth-child(even)').addClass('even');
                        $('ul#search_list li:nth-child(1)').addClass('first');
                        $('ul#search_list li:nth-child(2)').addClass('first');
                    });
                    </script>
                    <ul id="search_list">
                    <?php while (have_posts()) : the_post();
                    	if (get_post_type() == "page") { $post_type = "Page"; }
                    	elseif (get_post_type() == "wpsc-product") { $post_type = "Product"; }
                    	elseif (get_post_type() == "post") { $post_type = "News"; }
					?>
            
                        <li><a href="<?php the_permalink(); ?>">
                        	<span><?php echo $post_type; ?></span>
                        	<h3><?php the_title(); ?></h3>
                        </a></li>
            
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- right sidebar -->
        <?php layout::side( 'right' , 0 , 'search' ); ?>
    </div>
</div>
<?php get_footer(); ?>

