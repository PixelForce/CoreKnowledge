<!-- if not found post or is 404 error -->
<article <?php post_class() ?>>
    <!-- content -->
    <footer class="entry-footer">
        <div class="error-404">
        	<h2 id="hole">404 Error!</h2>
        	<p>
            <?php
                if( is_search () ){
                    _e( 'Unfortunately we did not find any results for your request.' , 'cosmotheme' );
                }else{
                    _e( 'We apologize but this page does not exist or can not be found. Perhaps it has been moved or deleted.' , 'cosmotheme' );
                }

                wp_link_pages();
            ?>
            </p>
        </div>
    </footer>
</article>

