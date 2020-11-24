<?php get_header();
/**
 * Default Page Template
 *
 * @package swindonedu
 */
?>
<div class="container grid-gap content">
    <div class="main-content">
        <?php if ( have_posts() ) : 
             while ( have_posts() ) : the_post(); 
                 the_content();
             endwhile; 
        endif;?> 
    </div>
    
    <div class="sidebar-content">
        <section>
            <?php get_template_part ('template-parts/courses-sidebar');?>
        </section>
        <section>
            <?php get_template_part ('template-parts/join-cta');?>
        </section>  
    </div>
    
</div>

<?php get_footer();?>
