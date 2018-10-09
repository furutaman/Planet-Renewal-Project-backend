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

<?php

/**
 *  注目の新作オンラインゲーム
*/

// 3ヶ月前の日付を取得
$three_month_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-3 month"));

$attention_query_args = Array(
	'post_type' => 'post',
	'posts_per_page' => 5,
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'attentionNew',
			'value' => 'null',
			'compare' => '!=',
		),
		array(
			'key' => 'gameRelease',
			'value' => $three_month_ago,
			'compare' => '>=',
		)
	),
	'orderby' => 'meta_value',
	'meta_key' => 'gameRelease',
	'order' => 'DESC'
);
$attention_query = new WP_Query($attention_query_args);

$cnt=1;
if($attention_query->have_posts()): while($attention_query->have_posts()): $attention_query->the_post();
	if($cnt == 1):
?>

	<!-- 注目の新作オンラインゲーム -->
	<section class="wrap-new-game">
	<h2>注目の新作オンラインゲーム</h2>
	<p class="new-game_title_sub">3ヶ月以内にリリースされた中から注目度の高いタイトルをピックアップ！</p>

    	<ul class="new-game u-clearfix">
<?php 	
	endif; 
?>
			<li>
				<span class="time">リリース日：<?php echo get_post_meta($post->ID, 'gameRelease', true); ?></span>
				<a href="<?php echo the_permalink($post->ID); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
				<h3><a href="<?php echo the_permalink($post->ID); ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h3>
				<div>
				<?php if( get_pc_sp($post->ID) != null): ?>
					<span class="label_small label_device"><?php echo get_pc_sp($post->ID); ?></span>
				<?php endif; ?>
					<a href="<?php echo get_category_url($post->ID); ?>" class="label_small"><?php echo get_category_name($post->ID); ?></a>
				</div>
			</li>
<?php 
	$cnt++;
	endwhile;
?>
		</ul>
	</section>
<?php
endif;
wp_reset_postdata();
?>

	<!-- 2カラム（親カラム） -->
 	<div class="parent-column u-clearfix">

	<?php
		// メインループ
		include_once('inc/category-main.php');
	?>


	<!-- 右カラム -->
    <div class="right-column">
<?php

/**
 *  1ヶ月以内にリリースされたオンラインゲーム
*/

// 1ヶ月前の日付を取得
$one_month_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-1 month"));

$attention_query_args = Array(
	'post_type' => 'post',
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'gameRelease',
			'value' => 'null',
			'compare' => '!=',
		),
		array(
			'key' => 'gameRelease',
			'value' => $one_month_ago,
			'compare' => '>=',
		)
	),
	'orderby' => 'meta_value',
	'meta_key' => 'gameRelease',
	'order' => 'DESC'
);

$attention_query = new WP_Query($attention_query_args);

$cnt=1;
if($attention_query->have_posts()): while($attention_query->have_posts()): $attention_query->the_post();
	if($cnt == 1):
?>
	<section>
		<h2>1ヶ月以内にリリースされたオンラインゲーム</h2>
<?php 
	endif;
?>
		<div class="wrap_topic">
			<div class="wrap_topic-left">
				<div class="time no-icon">リリース日：<?php echo get_post_meta($post->ID, 'gameRelease', true); ?></div>
				<h3><a href="<?php echo the_permalink($post->ID); ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h3>
				<div>
					<?php if( get_pc_sp($post->ID) != null): ?>
						<span class="label_small label_device"><?php echo get_pc_sp($post->ID); ?></span>
					<?php endif ;?>
					<a href="<?php echo get_category_url($post->ID); ?>" class="label_small"><?php echo get_category_name($post->ID); ?></a>
				</div>
			</div>
			<div class="wrap_topic-right">
				<a href="<?php echo the_permalink($post->ID); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
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

	<section>
<?php
/**
 *  βテスト・事前登録中のゲーム
*/
$beta_query_args = Array(
	'post_type' => 'post',
	'meta_query' => array(
		'relation' => 'AND',
		'meta_releaseStatus'=>array(
			'key' => 'releaseStatus',
			'value' => array('2', '3'),
			'compare' => 'IN',
		),
		'meta_preStartDate'=>array(
			'key' => 'preStartDate',
			'value' => 'null',
			'compare' => '!=',
		)
	),
	'orderby' => array( 'meta_releaseStatus' => 'DESC', 'meta_preStartDate' => 'DESC' ),
);
$beta_query_args_args = new WP_Query($beta_query_args);


$cnt=1;
if($beta_query_args_args->have_posts()): while($beta_query_args_args->have_posts()): $beta_query_args_args->the_post();
	if($cnt == 1):
?>
	<section>
		<h2>βテスト・事前登録中のゲーム</h2>
<?php 
endif;
?>
		<div class="wrap_topic">
			<div class="wrap_topic-left">
				<?php echo get_release_status2($post->ID); ?>
				<div class="time no-icon"><?php echo get_start_end_date($post->ID); ?></div>
				<h4><a href="<?php echo the_permalink($post->ID); ?>"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a></h4>
				<div>
				<?php if( get_pc_sp($post->ID) != null): ?>
					<span class="label_small label_device"><?php echo get_pc_sp($post->ID); ?></span>
				<?php endif; ?>
					<a href="<?php echo get_category_url($post->ID); ?>" class="label_small"><?php echo get_category_name($post->ID); ?></a>
				</div>
			</div>
			<div class="wrap_topic-right">
				<a href="<?php echo the_permalink($post->ID); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>"></a>
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
