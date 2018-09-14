<section class="wrap_recommend">
	<h2>このゲームに興味のある方におすすめオンラインゲーム</h2>	
<?php
$related_query_args = Array(
	'post_type' => 'post',
	'category' => $cat_ids,
	'posts_per_page' => 6,
	'meta_key' => 'relatedArticle',
	'meta_value' => '1',
	'meta_compare' => '=',
	'orderby' => 'rand'
);
$related_query = new WP_Query($related_query_args);


$cnt=1;
while($related_query->have_posts()): $related_query->the_post();

	// メインカテゴリ
	$cat_obj = get_category_by_slug( get_post_meta($post->ID, 'mainCategory', true));
	$cat_name = $cat_obj->cat_name;

	if($cnt == 1) 
		echo '<ul class="wrap_top3">';
	else if($cnt == 4)
		echo '<ul class="wrap_top3 u-mtl2">';
?>
		<li>
			<a href="<?php the_permalink() ?>" class="top3_thumb"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
			<h4><a href="<?php the_permalink() ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h4>
			<div>
				<?php echo get_release_status($post->ID); ?>
				<?php if( get_pc_sp($post->ID) != null): ?>
					<a href="#" class="label_small label_device"><?php echo get_pc_sp($post->ID); ?></a>
				<?php endif; ?>
				<?php if( get_price_tag($post->ID) != null): ?>
					<a href="#" class="label_small"><?php echo get_price_tag($post->ID); ?></a>
				<?php endif; ?>
				<a href="#" class="label_small"><?php echo $cat_name; ?></a>
			</div>
			<p><a href="<?php the_permalink() ?>"><?php echo get_post_meta($post->ID, 'metaDescription', true);?></a></p>
		</li>

<?php
	if($cnt == 3 || $cnt == 6)
		echo '</ul>';

	$cnt++;
endwhile;
?>				
</section>