
<?php
// 「amp」フォルダ内の「header.php」を読み込む
include ( TEMPLATEPATH . '/amp/header.php'); ?>


<main>

<?php
if(have_posts()) : while (have_posts()) : the_post();
  
  // 投稿ID保持
  $post_id = get_the_ID();

  // 更新日（表示用）
  $topics_update_date = get_post_meta($post_id, 'topicsUpdateDate', true);
  // 更新日（タグ用）
  $topics_update_date_replace = str_replace('/', '-',$topics_update_date);
  // ゲームリンク
  $game_link = get_game_link($post_id);
  // ゲーム名
  $game_name = get_post_meta($post_id, 'gameName', true); 
  // 公式サイト・リンク
  $link_to_official = get_link_to_official($post_id);

  // カテゴリID保存用
  $cat_ids = [];
?>


<!-- パンくず -->
  <ul class="breadcrumb u-clearfix">
    <li><a href="<?php echo esc_url( get_home_url() ); ?>">オンラインゲームPLANET</a></li>
    <li><a href="<?php echo get_category_url($post_id); ?>"><?php echo get_main_category($post_id); ?></a></li>
    <li><a href="#"><?php echo $game_name; ?></a></li>
  </ul>

<!-- タイトル -->
  <h1 class="cat-title"><?php echo $game_name; ?></h1>
  <div class="wrap-release-date">
    <span class="time">リリース日：<time datetime="<?php echo $topics_update_date_replace; ?>"><?php echo $topics_update_date; ?></time></span>
    <span class="label_large label_new">新作</span>
  </div>
  <div class="wrap-label u-mts">
    <?php if( get_pc_sp($post_id) != null): ?>
    <a href="#" class="label_large label_device"><?php echo get_pc_sp($post_id); ?></a>
    <?php endif; ?>
    <?php if( get_price_tag($post_id) != null): ?>
    <a href="#" class="label_large label_fee"><?php echo get_price_tag($post_id); ?></a>
    <?php endif; ?>
    <?php 
      $categorys = get_the_category();
      foreach ($categorys as $category):
        
        if($category->slug == "new")
          continue;

        array_push($cat_ids,$category->term_id);
    ?>
    <a class="label_large" href="<?php echo get_category_link( $category->term_id ); ?>" class="label_large"><?php echo $category->cat_name; ?></a>
    <?php 
      endforeach;
    ?>
  </div>
  <div class="wrap-post-date">
    <span class="time">最終更新日：<time datetime="<?php the_modified_date('Y-m-d') ?>"><?php the_modified_date('Y/m/d') ?></time></span>
    <span class="time">投稿日：<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y/m/d'); ?></time></span>
  </div>

<!-- ページトップ -->
<amp-animation id="showBtn" layout="nodisplay">
    <script type="application/json">
        {
        "duration":"400ms",
        "fill":"both",
        "iterations":"1",
        "direction":"alternate",
        "animations":[
            {
                "selector":"#js-page-top",
                "keyframes":[
                    {"transform":"translateY(0)"}
                    ]
                }
            ]
        }
    </script>
</amp-animation>
<amp-animation id="hideBtn" layout="nodisplay">
    <script type="application/json">
        {
        "duration":"200ms",
        "fill":"both",
        "iterations":"1",
        "direction":"alternate",
        "animations":[
            {
                "selector":"#js-page-top",
                "keyframes":[
                    {"transform":"translateY(400px)"}
                    ]
                }
            ]
        }
    </script>
</amp-animation>
<div>
    <amp-position-observer on="enter:hideBtn.start; exit:showBtn.start" layout="nodisplay"></amp-position-observer>
</div>


<!-- 2カラム（親カラム） -->
  <div class="parent-column u-clearfix">

<!-- 左カラム -->
    <div class="left-column">

      <article>
        <?php if( get_post_meta($post_id , 'youtubeId' ,true) ): ?>
        <amp-youtube
      	data-videoid="<?php echo get_post_meta($post_id , 'youtubeId' ,true); ?>"
      	width="800"
      	height="450"
      	layout="responsive">
        </amp-youtube>
        <?php endif; ?>

        <h2 class="single-title u-mtl2"><?php echo get_the_title(); ?></h2>

        <div class="wrap_koma">
          <div class="koma_left">
              <amp-img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" layout="responsive" width="438" height="328"></amp-img>
          </div>
          <div class="koma_right">
            <?php echo get_post_meta($post_id , 'lead' ,true); ?>
          </div>
        </div>

        <div class="wrap_topic--single u-clearfix">
          <span>最新トピックス</span>
          <div class="time"><time datetime="<?php echo $topics_update_date_replace; ?>"><?php echo $topics_update_date; ?></time></div>
          <p><?php echo get_post_meta($post_id, 'topicsText', true); ?></p>
        </div>

        <a href="<?php echo $game_link ?>" class="btn_offical">「<?php echo $game_name; ?>」<?php echo $link_to_official; ?></a>

        <!-- <div class="mokuji_sp">
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
        </div> -->

        <!-- ここにメイン編集が入ります -->
        <?php
          echo $this->get( 'post_amp_content' ); //個別投稿の本文を表示する
        ?>

        <a href="<?php echo $game_link ?>" class="btn_offical">「<?php echo $game_name; ?>」<?php echo $link_to_official; ?></a>
        <address class="address_game"><?php echo get_post_meta($post_id, 'copy', true); ?></address>
      </article>
<?php 
endwhile; endif;
?>
      <section class="wrap_recommend">
        <h2>このゲームに興味のある方におすすめオンラインゲーム</h2>
<?php
$related_query_args = Array(
  'post_type' => 'post',
  'category' => $cat_ids,
  'tag' => 'related',
  'posts_per_page' => 6,
  'orderby' => 'rand'
);
$related_query = new WP_Query($related_query_args);


$cnt=1;
while($related_query->have_posts()): $related_query->the_post();
  if($cnt == 1) 
    echo '<ul class="wrap_top3">';
  else if($cnt == 4)
    echo '<ul class="wrap_top3 u-mtl2">';
?>
            <li>
              <div class="top3_wrap_koma">
                <a href="<?php the_permalink() ?>" class="top3_thumb"><amp-img src="<?php the_post_thumbnail_url('thumbnails_438x328'); ?>" layout="responsive" width="438" height="328"></amp-img></a>
                <div class="top3_koma_right">
                  <h4><a href="<?php the_permalink() ?>"><?php echo get_post_meta($post_id, 'gameName', true); ?></a></h4>
                  <div>
                    <?php echo get_release_status($post_id,"1"); ?>
                    <?php if( get_pc_sp($post_id) != null): ?>
                      <a href="#" class="label_small label_device"><?php echo get_pc_sp($post_id); ?></a>
                    <?php endif; ?>
                    <?php if( get_price_tag($post_id) != null): ?>
                      <a href="#" class="label_small"><?php echo get_price_tag($post_id); ?></a>
                    <?php endif; ?>
                    <a href="<?php echo get_category_url($post_id); ?>" class="label_small"><?php echo get_category_name($post_id); ?></a>
                  </div>
                </div>
              </div>
              <p><a href="<?php the_permalink() ?>"><?php echo get_post_meta($post_id, 'metaDescription', true);?></a></p>
            </li>
            <?php
  if($cnt == 3 || $cnt == 6)
    echo '</ul>';

  $cnt++;
endwhile;
?>   
      </section>

    </div><!-- /left-column -->

  </div><!-- /parent-column -->

</main>
<?php
// 「amp」フォルダー内の「footer.php」を読み込む
include ( TEMPLATEPATH . '/amp/footer.php'); ?>
