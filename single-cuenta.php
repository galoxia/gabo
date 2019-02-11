<?php 
get_header();

if(have_posts()):
	the_post(); 
	
	$cuenta_A = get_post_meta( get_the_ID(), '_cuenta_meta_A', true );
	$cuenta_B = get_post_meta( get_the_ID(), '_cuenta_meta_B', true );
?>

<h1>Resultado de la cuenta <?php the_title(); ?>:</h1>
<div class="output">
	<p><span class="addend"><?php echo $cuenta_A; ?></span> + <span class="addend"><?php echo $cuenta_B; ?></span> = <span class="result"><?php echo $cuenta_A + $cuenta_B; ?></span></p>
</div><!-- /.output -->

<?php 
endif;

get_footer();	