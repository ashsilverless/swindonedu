<?php
/**
 * ============== Template Name: Home Page
 *
 * @package swindonedu
 */
get_header();?>
<div class="container content">
    <div class="main-content">
        <?php
        if ( have_posts() ) : 
        while ( have_posts() ) : the_post(); 
        //the_content();
        echo "<p>This is the Home template</p>";
        endwhile; 
        endif; 
        ?>       
    </div>
    
    <div class="sidebar-content">
        SIDE
    </div>
    
</div>


<?php get_footer();?>