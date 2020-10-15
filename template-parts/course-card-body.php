<div class="course-item">
	<div class="summary">
		<h2><?php the_title();?></h2>
		<p><?php the_field('date_of_course');?></p>
		<p class="read-more">Read More</p>
	</div>
	<a href="<?php the_permalink();?>" class="book">Book Now</a>
	<div class="description">
		<?php the_content();?>
		<p class="read-less">Close</p>
	</div>
</div>
