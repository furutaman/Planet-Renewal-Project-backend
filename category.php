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

	<!-- 左カラム -->
    <div class="left-column">

		<section>
			<h2><?php single_cat_title(); echo get_cat_title(); ?>ランキング</h2>
			<div class="time">ランキング更新日：<time datetime="<?php echo $rank_update_date_replace; ?>"><?php echo $rank_update_date ?></time></div>

				<ul class="wrap_tab">
					<li <?php echo get_cat_active_class("recommend"); ?>><a class="recommend-link" href="<?php echo get_category_link($cat); ?>">おすすめ順</a></li>
					<li <?php echo get_cat_active_class("new"); ?>><a href="<?php echo get_category_link($cat); echo '?sort=new'; ?>">新着順</a></li>
					<li <?php echo get_cat_active_class("popular"); ?>><a href="<?php echo get_category_link($cat); echo '?sort=popular'; ?>">閲覧数順</a></li>
				</ul>

<?php 
$cnt=1;
if(have_posts()): while(have_posts()):the_post();

	// リリース日（表示用）
	$game_release_date = get_post_meta($post->ID, 'gameRelease', true);
	// リリース（タグ用）
	$game_release_date_replace = str_replace('/', '-',$game_release_date);
?>
				<section>
					<h3><a href="<?php the_permalink(); ?>" class="name_game"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a><?php echo get_release_status_cat($post->ID); ?></h3>
					<p class="title_game"><?php echo get_the_title(); ?></p>
					<div class="wrap_koma">
						<div class="koma_left">
							<div class="u-relative">
								<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
								<span class="number"><?php echo $cnt ?>位</span>
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
$cnt++;
endwhile; endif;
?>


        <div class="pager">
        	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
          <ul class="pager-inner">
            <li class="previouspostslink" rel="previous"><a href="#">Prev</a></li>
            <li class="is-current"><span>1</span></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">⋯</a></li>
            <li><a href="#">9</a></li>
            <li class="nextpostslink" rel="next"><a href="#">Next</a></li>
          </ul>
        </div>

      </section>

    </div><!-- /left-column -->


<!-- 右カラム -->
    <div class="right-column">
<?php
	$right_query_args = Array(
		'post_type' => 'post',
		'cat' => $cat,
		'posts_per_page' => 20,
		'meta_key' => 'topicsStatus',
		'meta_value' => 'null',
		'meta_compare' => '!=',
		'orderby' => 'topicsUpdateDate',
		'order' => 'DESC'
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
endif;
?>
	</section>

    </div><!-- /right-column -->

  </div><!-- /parent-column -->

</main>

<?php get_footer(); ?>
