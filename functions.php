<?php
// アイキャッチ画像を有効にする。
add_theme_support('post-thumbnails');
// アイキャッチ画像を新しく生成（横438px,縦328px）
add_image_size("thumbnails_438x328", "438px", "328px", false);
// srcset属性が無効化（削除）
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
// adminber削除
add_filter('show_admin_bar', '__return_false');
/**
 * スマートフォンを判別
 * @return スマホならtrue それ以外false
*/
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser

    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

/**
 * iOS Mobileを判別
 * @return iOSならtrue それ以外false
*/
function is_iosMobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod' // iPod touch
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}


/**
 * カスタムフィールドから「メインカテゴリを取得」を取得
 * @param 記事ID
 * @return メインカテゴリ
*/
function get_main_category($post_id){
	$cat_obj = get_category_by_slug( get_post_meta($post_id, 'mainCategory', true) );
	return  $cat_obj->cat_name;
}

/**
 * カスタムフィールドから「PC or スマホ」を取得
 * @param 記事ID
 * @return デバイス名称
*/
function get_link_to_official($post_id){
	$link_to_official = get_post_meta($post_id , 'LinkToOfficial' ,true);

	if( $link_to_official == '1' ){
		return '公式サイトへ';
	}
	else if( $link_to_official == '2' ){
		return 'の事前登録に参加する';
	}
	else if( $link_to_official == '3' ){
		return 'をさっそくプレイしてみる！';
	}
	else if( $link_to_official == '3' ){
		return 'のβテストに参加する！！';
	}

	return "";
}


/**
 * カスタムフィールドから「PC or スマホ」を取得
 * @param 記事ID
 * @return デバイス名称
*/
function get_pc_sp($post_id){
	$device = get_post_meta($post_id , 'pcSp' ,true);

	if( $device == '1' ){
		return 'PC';
	}
	else if( $device == '2' ){
		return 'スマホ';
	}
	else if( $device == '3' ){
		return 'PC/スマホ';
	}

	return null;
}

/**
 * カスタムフィールドから「基本無料or有料or無料体験可アイコン」を取得
 * @param 記事ID
 * @return 料金体系名称
*/
function get_price_tag($post_id){
	$price = get_post_meta($post_id , 'freeOrPaid' ,true);

	if( $price == '1' ){
		return '基本無料';
	}
	else if( $price == '2' ){
		return '有料';
	}
	else if( $price == '3' ){
		return '無料体験可';
	}

	return null;
}

/**
 * カスタムフィールドから「リリースステータス」を取得
 * @param 記事ID
 * @return リリースステータス
*/
function get_release_status($post_id){
	$release_status = get_post_meta($post_id , 'releaseStatus' ,true);

	//echo $release_status.'<br>';

	if( $release_status == '1' ){
		// リリース日
		$release_date = get_post_meta($post_id , 'gameRelease' ,true);
		//echo $release_date.'<br>';
		// 半年前
		$six_months_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-6 month"));
		//echo $six_months_ago.'<br>';
		// 一年前
		$one_year_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-12 month"));
		//echo $one_year_ago.'<br>';

		// リリース日が半年以内
		if(strtotime($release_date) > strtotime($six_months_ago)){
			return '<a class="label_small label_new">新作</a>';
		}
		// リリース日が1年以内
		else if(strtotime($release_date) > strtotime($one_year_ago)){
			return '<a class="label_small label_new">準新作</a>';
		}
	}
	else if( $release_status == '2' ){
		return '<span class="label_small label_pre">βテスト中</span>';
	}
	else if( $release_status == '3' ){
		return '<span class="label_small label_pre">事前登録中</span>';
	}
	else if( $release_status == '4' ){
		return '<span class="label_small label_pre">サービス終了</span>';
	}
	else if( $release_status == '5' ){
		return '<span class="label_small label_pre">休止中</span>';
	}
	else if( $release_status == '6' ){
		return '<span class="label_small label_pre">リリース予定</span>';
	}

	return "";
}

/**
 * カスタムフィールドから「リリースステータス」を取得
 * @param 記事ID
 * @return リリースステータス
*/
function get_release_status2($post_id){
	$release_status = get_post_meta($post_id , 'releaseStatus' ,true);

	if( $release_status == '2' ){
		return '<div class="label_topic_beta">βテスト中</div>';
	}
	else if( $release_status == '3' ){
		return '<div class="label_topic_jizen">事前登録中</div>';
	}
	

	return "";
}

/**
 * カスタムフィールドから「リリースステータス」を取得（記事用）
 * @param 記事ID
 * @return リリースステータス
*/
function get_release_status_post($post_id){
	$release_status = get_post_meta($post_id , 'releaseStatus' ,true);

	//echo $release_status.'<br>';

	if( $release_status == '1' ){
		// リリース日
		$release_date = get_post_meta($post_id , 'gameRelease' ,true);
		//echo $release_date.'<br>';
		// 半年前
		$six_months_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-6 month"));
		//echo $six_months_ago.'<br>';
		// 一年前
		$one_year_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-12 month"));
		//echo $one_year_ago.'<br>';

		// リリース日が半年以内
		if(strtotime($release_date) > strtotime($six_months_ago)){
			return '<span class="label_large label_new">新作</span>';
		}
		// リリース日が1年以内
		else if(strtotime($release_date) > strtotime($one_year_ago)){
			return '<span class="label_large label_new">準新作</span>';
		}
	}
	else if( $release_status == '2' ){
		return '<span class="label_large label_pre">βテスト中</span>';
	}
	else if( $release_status == '3' ){
		return '<span class="label_large label_pre">サービス終了</span>';
	}
	else if( $release_status == '4' ){
		return '<span class="label_large label_pre">休止中</span>';
	}
	else if( $release_status == '5' ){
		return '<span class="label_large label_pre">リリース予定</span>';
	}

	return "";
}

/**
 * カスタムフィールドから「リリースステータス」を取得（カテゴリ用）
 * @param 記事ID
 * @return リリースステータス
*/
function get_release_status_cat($post_id){
	$release_status = get_post_meta($post_id , 'releaseStatus' ,true);


	if( $release_status == '1' ){
		// リリース日
		$release_date = get_post_meta($post_id , 'gameRelease' ,true);
		//echo $release_date.'<br>';
		// 半年前
		$six_months_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-6 month"));
		//echo $six_months_ago.'<br>';
		// 一年前
		$one_year_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-12 month"));
		//echo $one_year_ago.'<br>';

		// リリース日が半年以内
		if(strtotime($release_date) > strtotime($six_months_ago)){
			return '<span class="u-mlm label_large label_new">新作</span>';
		}
		// リリース日が1年以内
		else if(strtotime($release_date) > strtotime($one_year_ago)){
			return '<span class="u-mlm label_large label_new">準新作</span>';
		}
	}
	else if( $release_status == '2' ){
		return '<span class="u-mlm label_large label_pre">βテスト中</span>';
	}
	else if( $release_status == '3' ){
		return '<span class="u-mlm label_large label_pre">サービス終了</span>';
	}
	else if( $release_status == '4' ){
		return '<span class="u-mlm label_large label_pre">休止中</span>';
	}
	else if( $release_status == '5' ){
		return '<span class="u-mlm label_large label_pre">リリース予定</span>';
	}

	return "";
}

/**
 * 記事が所属しているカテゴリを取得
 * @param kind 1=すべて、2=ブラウザゲーム以外、3=ブラウザゲームのみ
 * @return 料金体系名称
*/
function get_categorys_link($kind){

	$categorys = get_the_category();
	$cat_return = "";

	foreach ($categorys as $category){
		if ($kind == 2) {
			if($category->slug == "browser-games"){
				continue;
			}
		}
		else if ($kind == 3) {
			if($category->slug != "browser-games"){
				continue;
			}
		}
		$cat_return = $cat_return.'<a href="'.get_category_link( $category->term_id ).'" class="label_large">'.$category->cat_name.'</a>';

	}

	//echo htmlspecialchars($cat_return);
	
	return $cat_return;
}


/**
 * カスタムフィールドから「最近のトピックスステータス」を取得
 * @param 記事ID
 * @return 最近のトピックスステータス
*/
function get_topics_status($post_id){
	$topics_status = get_post_meta($post_id , 'topicsStatus' ,true);

	if( $topics_status == '1' ){
		return '正式サービス開始';
	}
	else if( $topics_status == '2' ){
		return '事前登録中';
	}
	else if( $topics_status == '3' ){
		return 'βテスト中';
	}
	else if( $topics_status == '4' ){
		return 'アップデート';
	}
	else if( $topics_status == '5' ){
		return 'イベント';
	}
	else if( $topics_status == '6' ){
		return 'キャンペーン';
	}

	return null;
}

/**
 * カスタムフィールドから「ゲームリンク」を取得
 * @param 記事ID
 * @return ゲームリンク
*/
function get_game_link($post_id){

	if (is_iosMobile()): /* iphoneだったら */
		if (get_post_meta($post_id, 'gameLink-iphone', true)): /* gameLink-iOSに値が入っていたら */
			return get_post_meta($post_id, 'gameLink-iphone', true);
		elseif (get_post_meta($post_id, 'gameLinkSP', true)): /* gameLinkSPに値が入っていたら */
			return get_post_meta($post_id, 'gameLinkSP', true);
		else: /* どちらも空だったら */
			return get_post_meta($post_id, 'gameLink', true);
		endif;
	elseif (is_mobile()): /* Androidだったら */
		if (get_post_meta($post_id, 'gameLinkSP', true)): /* gameLinkSPに値が入っていたら */
			return get_post_meta($post_id, 'gameLinkSP', true);
		else: /* どちらも空だったら */
			return get_post_meta($post_id, 'gameLink', true);
		endif;
	else: /* PC・Tabletだったら */
		return get_post_meta($post_id, 'gameLink', true);
	endif;


}

/**
 * ゲットパラメータで、適したタイトルを返却する
 * sort popullar=閲覧数, new=新着 指定なし=おすすめ
*/
function get_cat_title(){

	$sort = (isset($_GET["sort"]) && $_GET["sort"] != '') ? $_GET["sort"] : '';
	$sort = htmlspecialchars($sort, ENT_QUOTES);

	$title = "";

	// 閲覧数順
	if($sort == "popular"){
		$title = "閲覧数";
	}
	// 新作順
	else if($sort == "new"){
		$title = "新着";
	}
	else{
		$title = "おすすめ";
	}

	return $title;

}

/**
 * ゲットパラメータで、適したタブにクラスを付与
 * active popullar=閲覧数, new=新着 recommend=おすすめ
*/
function get_cat_active_class($active){

	$sort = (isset($_GET["sort"]) && $_GET["sort"] != '') ? $_GET["sort"] : '';
	$sort = htmlspecialchars($sort, ENT_QUOTES);

	$class = 'class="tab_active"';

	// 閲覧数順
	if($sort == "popular" && $active == "popular"){
		return $class;
	}
	// 新作順
	else if($sort == "new" && $active == "new"){
		return $class;
	}
	// おすすめ順
	else if($sort == "" && $active == "recommend"){
		return $class;
	}

	return "";

}

/**
 * 各順位の更新日を返却
 * todo:ID決め打ち
*/
function get_rank_update_date(){

	$sort = (isset($_GET["sort"]) && $_GET["sort"] != '') ? $_GET["sort"] : '';
	$sort = htmlspecialchars($sort, ENT_QUOTES);

	// 閲覧数順
	if($sort == "popular"){
		return get_post_meta(32717, 'popularRankUpdateDate', true);
	}
	// 新作順
	else if($sort == "new"){
		return get_post_meta(32717, 'newRankUpdateDate', true);
	}
	
	// おすすめ順
	return get_post_meta(32717, 'recommendRankUpdateDate', true);

}


/**
 * カテゴリ一覧 sort popullar=閲覧数, new=新着 指定なし=おすすめ
*/
function pre_get_cat_list($query){

	if ( is_admin() || ! $query->is_main_query() ){
		return;
	}

	if ( $query->is_category() ) {

		$sort = (isset($_GET["sort"]) && $_GET["sort"] != '') ? $_GET["sort"] : '';
		$sort = htmlspecialchars($sort, ENT_QUOTES);

		// 新作カテゴリ
		if($query->is_category('new')){
			// 一年前日付を取得
			$one_year_ago = date("Y/m/d",strtotime(date("Y/m/d") . "-12 month"));
			$query->set('meta_query',
				array(
					'relation' => 'OR',
					array(
						'key' => 'releaseStatus',
						'value' => array('2','3','4','5','6',),
						'compare' => 'IN',
					),
					array(
						'relation' => 'AND',
						array(
							'key' => 'releaseStatus',
							'value' => '1',
							'compare' => '=',
						),
						array(
							'key' => 'gameRelease',
							'value' => $one_year_ago,
							'compare' => '>=',
						)
					)
				)
			);
		}


		// 閲覧数順
		if($sort == "popular"){
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'meta_key', 'recommendRank' );
			$query->set( 'order', 'ASC' );
			$query->set( 'meta_value', 'null' );
			$query->set( 'meta_compare', '!=' );
		}
		// 新作順
		else if($sort == "new"){
			$query->set( 'orderby', 'meta_value' );
			$query->set( 'meta_key', 'gameRelease' );
			$query->set( 'order', 'DESC' );
			$query->set( 'meta_value', 'null' );
			$query->set( 'meta_compare', '!=' );
		}
		else{
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'meta_key', 'popularRank' );
			$query->set( 'order', 'ASC' );
			$query->set( 'meta_value', 'null' );
			$query->set( 'meta_compare', '!=' );
		}

		
		return;
	}
}


add_action( 'pre_get_posts', 'pre_get_cat_list' );


/**
 * 開始日と終了日を取得する
 * @param 記事ID
*/
function get_start_end_date($post_id){

	// 開始日（表示用）
	$start_date = get_post_meta($post_id, 'preStartDate', true);
	// 開始日（タグ用）
	$start_date_replace = str_replace('/', '-',$start_date);
	// 終了日（表示用）
	$end_date = get_post_meta($post_id, 'preEndDate', true);
	// 終了日（タグ用）
	$end_date_replace = str_replace('/', '-',$end_date);

	// 開始日と終了日のどちらも入力されていた場合
	if($start_date && $end_date){
		return '<time datetime="'.$start_date_replace.'">'.$start_date.'</time>〜<time datetime="'.$end_date_replace.'">'.$end_date.'</time>';
	}
	else{
		return '<time datetime="'.$start_date_replace.'">'.$start_date.'</time>';
	}

}


/**
 * 閲覧数を保存する
*/
// function update_custom_meta_views() {
//     global $post;
//     if ( 'publish' === get_post_status( $post ) && is_single() ) {
//     	$views = intval( get_post_meta( $post->ID, 'custom_meta_views', true ) );
//     	update_post_meta( $post->ID, 'custom_meta_views', ( $views + 1 ) );
//     }
// }
// add_action( 'wp_head', 'update_custom_meta_views' );


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_shortlink_wp_head');

remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');

remove_action('wp_head', 'rsd_link');
remove_action('wp_head','wlwmanifest_link');

remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_generator');

add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );


function my_scripts_method() {
  wp_deregister_script('jquery');
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );


///////////////////////////////////////
// Wordpressデフォルトのnext/prev出力動作を停止
///////////////////////////////////////
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

///////////////////////////////////////
//ページネーション（一覧ページ）と分割ページ（マルチページ）タグを出力
///////////////////////////////////////
function rel_next_prev_link_tags() {
  if(is_single() || is_page()) {
      //1ページを複数に分けた分割ページ（マルチページ）でのタグ出力
    global $wp_query;
    $multipage = check_multi_page();
    if($multipage[0] > 1) {
      $prev = generate_multipage_url('prev');
      $next = generate_multipage_url('next');
      if($prev) {
        echo '<link rel="prev" href="'.$prev.'" />'.PHP_EOL;
      }
      if($next) {
        echo '<link rel="next" href="'.$next.'" />'.PHP_EOL;
      }
    }
  } else{
    //トップページやカテゴリページなどのページネーションでのタグ出力
    global $paged;
    if ( get_previous_posts_link() ){
      echo '<link rel="prev" href="'.get_pagenum_link( $paged - 1 ).'" />'.PHP_EOL;
    }
    if ( get_next_posts_link() ){
      echo '<link rel="next" href="'.get_pagenum_link( $paged + 1 ).'" />'.PHP_EOL;
    }
  }
}
//適切なページのヘッダーにnext/prevを表示
add_action( 'wp_head', 'rel_next_prev_link_tags' );

//分割ページ（マルチページ）URLの取得
//参考ページ：http://seophp.net/wordpress-fix-rel-prev-and-rel-next-without-plugin/
function generate_multipage_url($rel='prev') {
  global $post;
  $url = '';
  $multipage = check_multi_page();
  if($multipage[0] > 1) {
    $numpages = $multipage[0];
    $page = $multipage[1] == 0 ? 1 : $multipage[1];
    $i = 'prev' == $rel? $page - 1: $page + 1;
    if($i && $i > 0 && $i <= $numpages) {
      if(1 == $i) {
        $url = get_permalink();
      } else {
        if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending'))) {
          $url = add_query_arg('page', $i, get_permalink());
        } else {
          $url = trailingslashit(get_permalink()).user_trailingslashit($i, 'single_paged');
        }
      }
    }
  }
  return $url;
}

//分割ページ（マルチページ）かチェックする
function check_multi_page() {
  $num_pages    = substr_count(
      $GLOBALS['post']->post_content,
      '<!--nextpage-->'
  ) + 1;
  $current_page = get_query_var( 'page' );
  return array ( $num_pages, $current_page );
}

/**
 * 検索対象にカスタムフィールドを含める
 */
function custom_search($search, $wp_query) {
	global $wpdb;

	if (!$wp_query->is_search)
		return $search;
	if (!isset($wp_query->query_vars))
		return $search;

	$search_words = $wp_query->query_vars['search_terms'];
	if ( count($search_words) > 0 ) {
		$search = '';
		$search .= "AND post_type = 'post'";
		foreach ( $search_words as $word ) {
			if ( !empty($word) ) {
				$search_word = '%' . esc_sql( $word ) . '%';
				$search .= " AND (
					{$wpdb->posts}.post_title LIKE '{$search_word}'
					OR {$wpdb->posts}.post_content LIKE '{$search_word}'
					OR {$wpdb->posts}.ID
					IN (
						SELECT distinct post_id
						FROM {$wpdb->postmeta}
						WHERE meta_value LIKE '{$search_word}'
						AND meta_key = 'gameName'
					)
				) ";
			}
		}
	}
	return $search;
}
add_filter('posts_search','custom_search', 10, 2);

?>
<?php
/**
 * 管理画面、カテゴリへカスタムフィールドを追加する
 * @return iOSならtrue それ以外false
*/
add_action ( 'edit_category_form_fields', 'extra_category_fields');
function extra_category_fields( $tag ) {
    $t_id = $tag->term_id;
    $cat_meta = get_option( "cat_$t_id");
    $cat_title = get_option( "catTitle_$t_id");
?>
<tr class="form-field">
    <th><label for="extra_text">サイト表示用テキスト</label></th>
    <td><input type="text" name="Cat_meta[extra_text]" id="extra_text" size="25" value="<?php if(isset ( $cat_meta['extra_text'])) echo esc_html($cat_meta['extra_text']) ?>" /></td>
</tr>
<tr class="form-field">
    <th><label for="title_text">タイトル</label></th>
    <td><input type="text" name="Cat_title[title_text]" id="title_text" size="25" value="<?php if(isset ( $cat_title['title_text'])) echo esc_html($cat_title['title_text']) ?>" /></td>
</tr>
<?php
}
?>
