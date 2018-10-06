<?php get_header(); ?>
<main>

<?php
while (have_posts()) : the_post();
	// リリース日（表示用）
	$gameRelease_date = get_post_meta($post->ID, 'gameRelease', true);
	// リリース日（タグ用）
	$gameRelease_date_replace = str_replace('/', '-',$gameRelease_date);
	// 更新日（表示用）
	$topics_update_date = get_post_meta($post->ID, 'topicsUpdateDate', true);
	// 更新日（タグ用）
	$topics_update_date_replace = str_replace('/', '-',$topics_update_date);
	// ゲームリンク
	$game_link = get_game_link($post->ID);
	// ゲーム名
	$game_name = get_post_meta($post->ID, 'gameName', true); 
	// 公式サイト・リンク
	$link_to_official = get_link_to_official($post->ID);

	// カテゴリID保存用
	$cat_ids = [];
?>

	<!-- パンくず -->
	<ul class="breadcrumb u-clearfix">
		<li><a href="<?php echo esc_url( get_home_url() ); ?>">オンラインゲームPLANET</a></li>
		<li><a href="<?php echo get_category_url($post->ID); ?>"><?php echo get_main_category($post->ID); ?></a></li>
		<li><a href="<?php echo the_permalink($post->ID); ?>"><?php echo $game_name; ?></a></li>
	</ul>

	<!-- タイトル -->
	<h1 class="cat-title"><?php echo $game_name; ?></h1>
	<div class="wrap-release-date">
		<span class="time">リリース日：<time datetime="<?php echo $gameRelease_date_replace; ?>"><?php echo $gameRelease_date; ?></time></span>
		<?php echo get_release_status($post->ID,"2"); ?>
	</div>
	<div class="wrap-label u-mts">
		<?php if( get_pc_sp($post->ID) != null): ?>
			<span class="label_large label_device"><?php echo get_pc_sp($post->ID); ?></span>
		<?php endif; ?>
		<?php if( get_price_tag($post->ID) != null): ?>
			<span class="label_large label_fee"><?php echo get_price_tag($post->ID); ?></span>
		<?php endif; ?>
		<?php 
			$categorys = get_the_category();
			foreach ($categorys as $category):
				
				if($category->slug == "new")
					continue;

				array_push($cat_ids,$category->term_id);
		?>
				<a href="<?php echo get_category_link( $category->term_id ); ?>" class="label_large"><?php echo $category->cat_name; ?></a>
		<?php 
			endforeach;
		?>
	</div>
	<div class="wrap-post-date">
		<span class="time">最終更新日：<time datetime="<?php the_modified_date('Y-m-d') ?>"><?php the_modified_date('Y/m/d') ?></time></span>
		<span class="time">投稿日：<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y/m/d'); ?></time></span>
	</div>


	<!-- 2カラム（親カラム） -->
	<div class="parent-column u-clearfix">
		<!-- 左カラム -->
		<div class="left-column">

			<article>
		<?php 
			if( !empty( get_post_meta($post->ID , 'youtubeId' ,true) ) ): 
		?>
				<div class="wrap-youtube">
					<div id="js-youtube" class="youtube" data-youtube-id="<?php echo get_post_meta($post->ID , 'youtubeId' ,true); ?>"></div>
				</div>
		<?php 
			endif;
		?>

				<h2 class="single-title u-mtl2"><?php echo get_the_title(); ?></h2>

				<div class="wrap_koma">
					<div class="koma_left">
						<img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%">
					</div>
					<div class="koma_right">
						<?php echo get_post_meta($post->ID , 'lead' ,true); ?>
					</div>
				</div>

				<div class="wrap_topic--single u-clearfix">
					<span>最新トピックス</span>
					<div class="time"><time datetime="<?php echo $topics_update_date_replace; ?>"><?php echo $topics_update_date; ?></time></div>
					<p><?php echo get_post_meta($post->ID, 'topicsText', true); ?></p>
				</div>

				<a href="<?php echo $game_link ?>" class="btn_offical">「<?php echo $game_name; ?>」<?php echo $link_to_official; ?></a>

				<div class="mokuji_sp">
					<h3>目次</h3>
					<ul class="wrap_mokuji">
						<li><a href="#">概要について</a></li>
						<li><a href="#">スペック/動作環境</a></li>
						<li><a href="#">物語と世界観について</a></li>
						<li><a href="#">獣神キャラクター</a></li>
						<li><a href="#">バトルシステム</a></li>
						<li><a href="#">採集などの生活系コンテンツ</a></li>
						<li><a href="#">生活などのハウジングシステム</a></li>
					</ul>
				</div>

				<!-- ここにメイン編集が入ります -->
				<?php the_content(); ?>

				<a href="<?php echo $game_link ?>" class="btn_offical">「<?php echo $game_name; ?>」<?php echo $link_to_official; ?></a>
				<address class="address_game"><?php echo get_post_meta($post->ID, 'copy', true); ?></address>
			</article>

<?php 
endwhile;
wp_reset_postdata();

// 関連記事取得
include_once('inc/related-article.php');
?>

		</div><!-- /left-column -->

		<!-- 右カラム -->
		<div class="right-column">
			<section class="mokuji_pc">
				<h2>目次</h2>
				<ul class="wrap_mokuji">
					<li><a href="#">概要について</a></li>
					<li><a href="#">スペック/動作環境</a></li>
					<li><a href="#">物語と世界観について</a></li>
					<li><a href="#">獣神キャラクター</a></li>
					<li><a href="#">バトルシステム</a></li>
					<li><a href="#">採集などの生活系コンテンツ</a></li>
					<li><a href="#">生活などのハウジングシステム</a></li>
				</ul>
				<a href="<?php echo $game_link ?>" class="btn_offical">「<?php echo $game_name; ?>」公式サイトへ</a>
			</section>
		</div><!-- /right-column -->
	</div><!-- /parent-column -->


</main>

<?php get_footer(); ?>