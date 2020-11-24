<?php
/**
 * ============== Template Name: Home Page
 *
 * @package swindonedu
 */
get_header();?>
<div class="container grid-gap content">
    <div class="main-content">
        <section>
            <h2 class="heading heading__5"><?php the_field('sub_heading');?></h2>
            <?php the_field('lead_copy');?>
        </section>
        <section>
            <?php get_template_part ('template-parts/join-cta');?>
        </section>
    </div>
    
    <div class="sidebar-content">
        <?php get_template_part ('template-parts/courses-sidebar');?>
    </div>
    
</div>


<?php get_footer();?>