<?php /*
Template Name: 記事まとめ
Template Post Type: post
*/
 ?>
<?php get_header(); ?>
<main>

<?php
while (have_posts()) : the_post();
	// メインカテゴリ
	$cat_obj = get_category_by_slug( get_post_meta($post->ID, 'mainCategory', true));
	$cat_name = $cat_obj->cat_name;
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
		<li><a href="#">オンラインゲームPLANET</a></li>
		<li><a href="#"><?php echo get_main_category($post->ID); ?></a></li>
		<li><a href="#"><?php echo $game_name; ?></a></li>
	</ul>

<!-- タイトル -->
	<h1 class="cat-title"><?php echo $game_name; ?></h1>
	<div class="wrap-label u-mtl2">
	<?php if( get_pc_sp($post->ID) != null): ?>
		<a href="#" class="label_large label_device"><?php echo get_pc_sp($post->ID); ?></a>
	<?php endif; ?>
	<?php 
		$categorys = get_the_category();
		foreach ($categorys as $category):
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
		        <h2 class="single-title"><?php echo get_the_title(); ?></h2>

		        <div class="wrap_koma">
					<div class="koma_left">
						<img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" width="100%">
					</div>
					<div class="koma_right">
						<?php echo get_post_meta($post->ID , 'lead' ,true); ?>
					</div>
				</div>

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
			</section>

		</div><!-- /right-column -->
	</div><!-- /parent-column -->

</main>

<?php get_footer(); ?>