<?php 
/**
Template Name: Homepage One
*/
get_header();
	
	get_template_part('sections/cartable','slider');
	get_template_part('sections/cartable','product');	
	get_template_part('sections/specia','features');
	get_template_part('sections/specia','portfolio');	
	get_template_part('sections/specia','call-action');	
	get_template_part('sections/specia','blog');
	
get_footer();
