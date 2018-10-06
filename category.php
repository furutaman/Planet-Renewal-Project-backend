<?php 

get_header();

// カテゴリデータ取得
$cat_data = get_option('cat_'.intval($cat));
// 順位更新日（表示用）
$rank_update_date = get_rank_update_date();
// 順位更新日（タグ用）
$rank_update_date_replace = str_replace('/', '-',$rank_update_date);

?>

	

<main>

	<!-- パンくず -->
	<ul class="breadcrumb u-clearfix">
		<li><a href="<?php echo esc_url( get_home_url() ); ?>">オンラインゲームPLANET</a></li>
		<li><a href="<?php echo get_category_link($cat); ?>"><?php single_cat_title(); ?></a></li>
	</ul>

	<h1 class="cat-title"><?php single_cat_title(); ?></h1>
	<p class="cat-title_sub"><?php echo esc_html($cat_data['extra_text']); ?></p>


	<!-- 2カラム（親カラム） -->
	<div class="parent-column u-clearfix">

	<?php
		// メインループ
		include_once('inc/category-main.php');
	?>


	<!-- 右カラム -->
    <div class="right-column">
<?php
	$right_query_args = Array(
		'post_type' => 'post',
		'cat' => $cat,
		'posts_per_page' => 20,
		'meta_query' => array(
			'relation' => 'AND',
			'meta_topicsStatus'=>array(
				'key' => 'topicsStatus',
				'value' => 'null',
				'compare' => '!=',
			),
			'meta_topicsUpdateDate'=>array(
				'key' => 'topicsUpdateDate',
				'value' => 'null',
				'compare' => '!=',
			),
		),
		'orderby' => array( 'meta_topicsUpdateDate' => 'DESC' ),

		// 'meta_key' => 'topicsStatus',
		// 'meta_value' => 'null',
		// 'meta_compare' => '!=',
		// 'orderby' => 'topicsUpdateDate',
		// 'order' => 'DESC'
	);
	$right_query = new WP_Query($right_query_args);
	// ナンバリング
	$cnt=1;
	if($right_query->have_posts()): while($right_query->have_posts()): $right_query->the_post();
		if($cnt == 1):
?>
	<section>
		<h2>最新トピックス（<?php single_cat_title(); ?>）</h2>
<?php 	
		endif; 

		// 更新日（表示用）
		$topics_update_date = get_post_meta($post->ID, 'topicsUpdateDate', true);
		// 更新日（タグ用）
		$topics_update_date_replace = str_replace('/', '-',$topics_update_date);
?>
		<div class="wrap_topic">
			<div class="wrap_topic-left">
			<?php if(get_topics_status($post->ID) != null): ?>
				<div class="label_topic"><?php echo get_topics_status($post->ID); ?></div>
			<?php endif; ?>
				<div class="time"><time datetime="<?php echo $topics_update_date_replace;?>"><?php echo $topics_update_date;?></time></div>
				<h3><a href="<?php echo the_permalink($post->ID); ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h3>
				<p><a href="<?php echo the_permalink($post->ID); ?>" class="u-mrs"><?php echo get_post_meta($post->ID, 'topicsText', true); ?></a></p>
				<div>
				<?php if( get_pc_sp($post->ID) != null): ?>
					<span class="label_small label_device"><?php echo get_pc_sp($post->ID);?></span>
				<?php endif;?>
					<a href="<?php echo get_category_url($post->ID); ?>" class="label_small"><?php echo get_category_name($post->ID); ?></a>
				</div>
			</div>
			<div class="wrap_topic-right">
				<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
			</div>
		</div>
<?php 
	$cnt++;
	endwhile;
endif;
wp_reset_postdata();
?>
	</section>

    </div><!-- /right-column -->

  </div><!-- /parent-column -->

</main>

<?php get_footer(); ?>
