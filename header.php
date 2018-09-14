<!DOCTYPE html>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<?php if(is_home()): ?>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<?php endif; ?>



<?php if(is_home()): ?>
<title>【2018おすすめ】PCオンラインゲーム人気ランキング！無料ネトゲを紹介！｜オンラインゲームPLANET</title>
<meta property="og:url" content="<?php echo home_url(); ?>">
<meta name="keywords" content="">
<meta name="description" content="無料で遊べるPCオンラインゲームの2018年最新おすすめランキングや、実際にプレイしてレビュー紹介記事を掲載しています。新作や人気タイトルを中心にMMORPGやFPS／TPS、ブラウザゲームなど協力や対戦が楽しめるネトゲを紹介しているサイトです。">
<?php else: ?>
<title><?php wp_title(''); ?>｜オンラインゲームPLANET</title>
<meta property="og:url" content="<?php echo get_permalink(); ?>">
<meta name="keywords" content="<?php echo get_post_meta($post->ID, 'metaKeyword', true);?>">
<meta name="description" content="<?php echo get_post_meta($post->ID, 'metaDescription', true);?>">
<?php endif; ?>


<meta name="author" content="プラネットメディア株式会社">

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- <link rel="shortcut icon" href="favicon.ico"> -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/slick/slick.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/slick/slick-theme.css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/reset.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/utility.css">
<link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="container">

<!-- ヘッダー -->
<header>
	<div class="ad-header"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/img_ad_header.jpg" width="100%" /></a></div>
	<p>プレイしたいゲームがみつかる。新しいゲームに出会える！</p>
	<nav id="js-nav" class="u-clearfix">
		<a href="#" class="logo">オンラインゲーム PLANET</a>
		<ul id="js-main-cat" class="global-nav">
			<li><a href="#">新作</a></li>
			<li><a href="#">ブラウザゲーム</a></li>
			<li><a href="#">MMORPG</a></li>
			<li><a href="#">FPS/TPS</a></li>
			<li><a href="#">アクションゲーム</a></li>
			<li id="js-btn_other" class="cat_other">
				<a class="menu_other">その他</a>
				<ul id="js-sub-cat">
				<li><a href="#">MOBA</a></li>
				<li><a href="#">RTS</a></li>
				<li><a href="#">TCG／カード</a></li>
				<li><a href="#">野球ゲーム</a></li>
				<li><a href="#">HTML5ゲーム</a></li>
				<li><a href="#">ハクスラ</a></li>
				<li><a href="#">女性向けゲーム</a></li>
				<li><a href="#">スマホゲーム</a></li>
				<li><a href="#">VR</a></li>
				<li><a href="#">steam</a></li>
				</ul>
			</li>
		</ul>
		<div id="js-btn_search" class="search"><span>検索</span></div>
		<form id="js-search">
			<input type="text" placeholder="検索するキーワードを入力">
			<input type="submit" id="search_submit" value="検索">
		</form>
		<button id="js-btn_hamburger" class="hamburger">
			<span class="line_top"></span>
			<span class="line_middle"></span>
			<span class="line_bottom"></span>
		</button>
	</nav>
</header>