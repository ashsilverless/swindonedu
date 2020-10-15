<?php get_header();
/**
 * Default Page Template
 *
 * @package swindonedu
 */
?>
<div class="container content">
    <div class="main-content">
        <?php if ( have_posts() ) : 
             while ( have_posts() ) : the_post(); 
                 the_content();
             endwhile; 
        endif;?> 
    </div>
    
    <div class="sidebar-content">
        <?php echo do_shortcode('[loginform]');?>
        <a href="http://swindon-education-trust.local/wp-login.php?action=logout">Logout</a>       
    </div>
    
</div>

<?php get_footer();?>
