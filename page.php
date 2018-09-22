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

<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>