<?php get_header(); ?>

<main>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

  <!-- パンくず -->
  <ul class="breadcrumb u-clearfix">
    <li><a href="<?php echo esc_url( get_home_url() ); ?>">オンラインゲームPLANET</a></li>
    <li><a href="<?php echo the_permalink($post->ID); ?>"><?php the_title(); ?></a></li>
  </ul>

  <!-- タイトル -->
  <h1 class="cat-title"><?php the_title(); ?></h1>
  <article class="wrap_page">
    <?php the_content(); ?>
  </article>

<?php endwhile; else: ?>
  
  <h1>お探しのページが見つかりませんでした。（HTTP Error 404）</h1>

  <article class="wrap_page">
    <div>お探しのページはURLが間違っているか、ページが移動又は削除等の理由により表示することができませんでした。<br>
      お手数ですが、<a href="<?php echo home_url(); ?>">トップページ</a>より、該当するページへ移動してください。<br>
      アドレス（URL）を直接入力された場合には、今一度、URLをお確かめのうえ、再度アクセスしてみてください。</div>
  </article>


<?php endif; ?>

</main>

<?php get_footer(); ?>