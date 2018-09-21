
<?php get_header(); ?>

<main>
<!-- メインイメージ -->
	<div>
		<ul class="slider">
			<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/main-img_01.jpg" width="100%"></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/main-img_02.jpg" width="100%"></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/main-img_03.jpg" width="100%"></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/main-img_01.jpg" width="100%"></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/main-img_02.jpg" width="100%"></a></li>
		</ul>
	</div>

<!-- おすすめトップ10 -->
<?php
/**
 * おすすめオンラインゲームTOP10
*/
$top_query_args = Array(
	'post_type' => 'post',
	'posts_per_page' => 10,
	'meta_key' => 'popularRank',
	'meta_value' => 'null',
	'meta_compare' => '!=',
	'orderby' => 'meta_value_num',
	'order' => 'ASC'
);
$top_query = new WP_Query($top_query_args);

// ナンバリング
$cnt=1;
if($top_query->have_posts()): while($top_query->have_posts()): $top_query->the_post();
		if($cnt == 1):
			// 更新日（表示用）
			$popular_update_date = get_post_meta($post->ID, 'popularRankUpdateDate', true);
			// 更新日（タグ用）
			$popular_update_date_replace = str_replace('/', '-',$popular_update_date);
?>

	<div class="wrap-top10 u-clearfix">
		<div class="top10_title">
			<h1>おすすめオンラインゲーム</h1>
			<span>TOP10</span>
			<div class="time">更新日：<time datetime="<?php echo $popular_update_date_replace?>"><?php echo $popular_update_date ?></time></div>
		</div>
		<ol>
			
	<?php
		endif;
		// メインカテゴリ
		$cat_obj = get_category_by_slug( get_post_meta($post->ID, 'mainCategory', true));
		$cat_name = $cat_obj->cat_name;

		// TOP10用画像取得
		$top10_image = wp_get_attachment_image_src(get_post_meta($post->ID,'top10Image', true),'thumbnail');
		if($top10_image == false){
			$top10_image[0] = get_the_post_thumbnail_url( get_the_ID(), 'thumbnails_438x328' );
		}
	?>

			<li><a href="<?php the_permalink(); ?>"><img src="<?php echo $top10_image[0] ?>" width="100%" /><span class="number"><?php echo $cnt ?></span><span class="label"><?php echo $cat_name?></span><span class="text"><span class="u-fs-13"><?php echo get_post_meta($post->ID, 'gameName', true); ?></span><br><?php echo get_post_meta($post->ID, 'top10Text', true); ?></span></a></li>

<?php
		$cnt++;
	endwhile;
endif;
wp_reset_postdata();
?>
		</ol>
	</div><!-- /wrap-top10 -->
	

	<!-- 2カラム（親カラム） -->
	<div class="parent-column u-clearfix">

	<!-- 左カラム -->
	<div class="left-column">
<?php
// 一年前日付を取得
$one_year_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-12 month"));

/**
 * 新作オンラインゲームおすすめランキング
*/
$new_query_args = Array(
	'post_type' => 'post',
	'posts_per_page' => 3,
	'meta_key' => 'popularRank',
	'meta_value' => 'null',
	'meta_compare' => '!=',
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => 'releaseStatus',
			'value' => array('2','3','4','5','6',),
			'compare' => 'IN',
		),
		array(
			'relation' => 'AND',
			array(
				'key' => 'releaseStatus',
				'value' => '1',
				'compare' => '=',
			),
			array(
				'key' => 'gameRelease',
				'value' => $one_year_ago,
				'compare' => '>=',
			)
		)
	),
	'orderby' => 'meta_value_num',
	'order' => 'ASC'
);
	
$new_query = new WP_Query($new_query_args);


// ナンバリング
$cnt=1;
if($new_query->have_posts()): while($new_query->have_posts()): $new_query->the_post();
	if($cnt == 1):
?>
		<section>
			<h2>新作オンラインゲームおすすめランキング</h2>
		<ol class="wrap_top3">
	<?php
		endif;

		// メインカテゴリ
		$cat_obj = get_category_by_slug( get_post_meta($post->ID, 'mainCategory', true));
		$cat_name = $cat_obj->cat_name;
	?>

				<li>
					<a href="<?php the_permalink(); ?>" class="top3_thumb"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"><span class="number"><?php echo $cnt; ?></span></a>
					<h3><a href="<?php the_permalink(); ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h3>
					<div>
						<?php echo get_release_status($post->ID); ?>
						<?php if( get_pc_sp($post->ID) != null): ?>
							<span class="label_small label_device"><?php echo get_pc_sp($post->ID); ?></span>
						<?php endif; ?>
						<?php if( get_price_tag($post->ID) != null): ?>
							<span class="label_small"><?php echo get_price_tag($post->ID); ?></span>
						<?php endif; ?>
						<a href="#" class="label_small"><?php echo $cat_name ?></a>
					</div>
					<p><a href="<?php the_permalink(); ?>"><?php echo get_post_meta($post->ID, 'metaDescription', true);?></a></p>
				</li>
<?php 
	$cnt++;
endwhile; endif;
wp_reset_postdata();
?>
			</ol>
			<div class="wrap_btn_all-cat">
				<a href="#">全てのランキングを見る</a>
			</div>
		</section>
<?php
// 一覧に表示するカテゴリをセット
$cat_lists = array('browser-games','mmorpg','fps','action');

/**
 * カテゴリのおすすめランキング
*/
foreach ($cat_lists as $cat_list):
	$cat_query_args = Array(
		'category_name' => $cat_list,
		'post_type' => 'post',
		'posts_per_page' => 3,
		'meta_key' => 'popularRank',
		'meta_value' => 'null',
		'meta_compare' => '!=',
		'orderby' => 'meta_value_num',
		'order' => 'ASC'
	);
	$cat_query = new WP_Query($cat_query_args);

	// カテゴリ名
	$cat_list_obj = get_category_by_slug($cat_list);
	$cat_list_name = $cat_list_obj->cat_name;
	
	// ナンバリング
	$cnt=1;
	while($cat_query->have_posts()): $cat_query->the_post();
		if($cnt == 1):
?>
		<section>
			<h2><?php echo $cat_list_name ?>おすすめランキング</h2>
			<ol class="wrap_top3">
		<?php
			endif;

			// メインカテゴリ
			$cat_obj = get_category_by_slug( get_post_meta($post->ID, 'mainCategory', true));
			$cat_name = $cat_obj->cat_name;
		?>

				<li>
					<a href="<?php the_permalink(); ?>" class="top3_thumb"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"><span class="number"><?php echo $cnt; ?></span></a>
					<h3><a href="<?php the_permalink(); ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h3>
					<div>
						<?php echo get_release_status($post->ID); ?>
						<?php if( get_pc_sp($post->ID) != null): ?>
							<span class="label_small label_device"><?php echo get_pc_sp($post->ID); ?></span>
						<?php endif; ?>
						<?php if( get_price_tag($post->ID) != null): ?>
							<span class="label_small"><?php echo get_price_tag($post->ID); ?></span>
						<?php endif; ?>
						<a href="#" class="label_small"><?php echo $cat_name ?></a>
					</div>
					<p><a href="<?php the_permalink(); ?>"><?php echo get_post_meta($post->ID, 'metaDescription', true);?></a></p>
				</li>
<?php 
			$cnt++;
		endwhile;
?>
			</ol>
			<div class="wrap_btn_all-cat">
				<a href="#">全てのランキングを見る</a>
			</div>
		</section>
<?php 
		wp_reset_postdata();
	endforeach;
?>			
	</div><!-- /left-column -->

	<!-- 右カラム -->
	<div class="right-column">
<?php
/**
 * 最新トピックス
*/
$right_query_args = Array(
	'post_type' => 'post',
	'posts_per_page' => 20,
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'topicsStatus',
			'value' => 'null',
			'compare' => '!=',
		),
		array(
			'key' => 'topicsUpdateDate',
			'value' => 'null',
			'compare' => '!=',
		)
	),
	'meta_key' => 'topicsUpdateDate',
	'orderby' => 'meta_value',
	'order' => 'DESC'
);
$right_query = new WP_Query($right_query_args);
// ナンバリング
$cnt=1;
if($right_query->have_posts()): while($right_query->have_posts()): $right_query->the_post();
	if($cnt == 1):
?>
		<section>
			<h2>最新トピックス</h2>
<?php 	
	endif; 

	// 更新日（表示用）
	$topics_update_date = get_post_meta($post->ID, 'topicsUpdateDate', true);
	// 更新日（タグ用）
	$topics_update_date_replace = str_replace('/', '-',$topics_update_date);
	// メインカテゴリ
	$cat_obj = get_category_by_slug( get_post_meta($post->ID, 'mainCategory', true));
	$cat_name = $cat_obj->cat_name;
?>
			<div class="wrap_topic">
				<div class="wrap_topic-left">
			<?php if(get_topics_status($post->ID) != null): ?>
					<div class="label_topic"><?php echo get_topics_status($post->ID); ?></div>
			<?php endif; ?>
					<div class="time"><time datetime="<?php echo $topics_update_date;?>"><?php echo $topics_update_date_replace;?></time></div>
					<h3><a href="<?php echo the_permalink($post->ID); ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h3>
					<p><a href="<?php echo the_permalink($post->ID); ?>" class="u-mrs"><?php echo get_post_meta($post->ID, 'topicsText', true); ?></a></p>
					<div>
				<?php if( get_pc_sp($post->ID) != null): ?>
						<span class="label_small label_device"><?php echo get_pc_sp($post->ID);?></span>
				<?php endif;?>
						<a href="#" class="label_small"><?php echo $cat_name; ?></a>
					</div>
				</div>
				<div class="wrap_topic-right">
					<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
				</div>
			</div>
<?php 
	$cnt++;
	endwhile;
?>
		</section>
<?php 
endif;
wp_reset_postdata();
?>
	</div><!-- /right-column -->

</div><!-- /parent-column -->

</main>

<?php get_footer(); ?>