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
	/**
	 * ナンバリング
	*/
	$cnt=1;
	$page_num = get_query_var('paged'); //ページ番号の取得;

	// 2P以降はページ目、最大件数から算出）
	if($page_num > 1){
		$max_disp = get_option('posts_per_page'); 
		$cnt = ( $max_disp * ($page_num-1) ) + 1;
	}

	if(have_posts()): while(have_posts()):the_post();
?>
			<section>
				<h3><a href="<?php the_permalink(); ?>" class="name_game"><?php echo get_post_meta($post->ID, 'gameName', true); ?></a><?php echo get_release_status($post->ID,"3"); ?></h3>
				<p class="title_game"><?php echo get_the_title(); ?></p>
				<div class="wrap_koma">
					<div class="koma_left">
						<div class="u-relative">
							<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%"></a>
							<?php echo get_cat_numbering($cnt); ?>
							
						</div>
						<div class="time no-icon">リリース日：<?php echo get_post_meta($post->ID, 'gameRelease', true);?></div>
						<div>
						<?php if( get_pc_sp($post->ID) != null): ?>
							<span class="label_large label_device"><?php echo get_pc_sp($post->ID);?></span>
						<?php endif; ?>
						<?php if( get_price_tag($post->ID) != null): ?>
							<span class="label_large label_fee"><?php echo get_price_tag($post->ID)?></span>
						<?php endif; ?>
							<?php echo get_categorys_link(3); ?>
						</div>
						<div>
						<?php
							$categorys = get_the_category();
							foreach ($categorys as $category):
								if($category->slug == "browser-games" || $category->slug == "new")
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
			</div>

    	</section>

    </div><!-- /left-column -->