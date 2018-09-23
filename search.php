<?php 
get_header();

$total_results = $wp_query->found_posts;

?>

<main>

	<!-- パンくず -->
	<ul class="breadcrumb u-clearfix">
		<li><a href="<?php echo esc_url( get_home_url() ); ?>">オンラインゲームPLANET</a></li>
		<li><a href="">該当オンラインゲーム（キーワード：<?php echo get_search_query(); ?>）</a></li>
	</ul>

	<h1 class="cat-title">"<?php echo get_search_query(); ?>"の検索結果</h1>


	<!-- 2カラム（親カラム） -->
	<div class="parent-column u-clearfix">

	<!-- 左カラム -->
    <div class="left-column">

		<section>
			<h2>該当オンラインゲーム　<span style="font-size:150%;"><?php echo $total_results ?></span> 件</h2>
<?php 
if(have_posts()): while(have_posts()):the_post();

	// リリース日（表示用）
	$game_release_date = get_post_meta($post->ID, 'gameRelease', true);
	// リリース（タグ用）
	$game_release_date_replace = str_replace('/', '-',$game_release_date);

?>
			<section class="u-mtl2">
				<h3><a href="<?php the_permalink(); ?>" class="name_game"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a><?php echo get_release_status($post->ID,"3"); ?></h3>
				<p class="title_game">発行部数31万越えの人気小説が無料ブラウザゲームとして登場！素材収集や装備加工、自給自足が楽しめる生活系ブラウザRPG！</p>
				<div class="wrap_koma">
					<div class="koma_left">
						<div class="u-relative">
							<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
						</div>
						<div class="time no-icon">リリース日：<time datetime="<?php echo $game_release_date_replace;?>"><?php echo $game_release_date;?></time></div>

						<div>
						<?php if( get_pc_sp($post->ID) != null): ?>
							<a href="#" class="label_large label_device"><?php echo get_pc_sp($post->ID);?></a>
						<?php endif; ?>
						<?php if( get_price_tag($post->ID) != null): ?>
							<a href="#" class="label_large label_fee"><?php echo get_price_tag($post->ID)?></a>
						<?php endif; ?>
							<?php echo get_categorys_link(3); ?>
						</div>
						<div>
						<?php
							$categorys = get_the_category();
							foreach ($categorys as $category):
								if($category->slug == "browser-games")
									continue;
						?>
							<a href="<?php echo get_category_link( $category->term_id ); ?>" class="label_large"><?php echo $category->cat_name; ?></a>
						<?php endforeach; ?>
						</div>
					</div>
					<div class="koma_right">
						<?php echo get_post_meta($post->ID, 'leadIndex', true); ?>
						<a href="<?php the_permalink(); ?>" class="btn_detail">詳しくみる</a>
					</div>
				</div>
			</section>
<?php 
endwhile; endif;
?>
	        <div class="pager">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
			</div>
		</section>

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
?>

			<div class="wrap_topic u-mtl2">
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
