<?php
// アイキャッチ画像を有効にする。
add_theme_support('post-thumbnails');
// アイキャッチ画像を新しく生成（横438px,縦328px）
add_image_size("thumbnails_438x328", "438px", "328px", false);
// srcset属性が無効化（削除）
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
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
		return '<a class="label_small label_pre">βテスト中</a>';
	}
	else if( $release_status == '3' ){
		return '<span class="label_small label_pre">事前登録中</span>';
	}
	else if( $release_status == '4' ){
		return '<span class="label_small label_pre">サービス終了</span>';
	}
	else if( $release_status == '5' ){
		return '<a class="label_small label_pre">休止中</a>';
	}
	else if( $release_status == '6' ){
		return '<a class="label_small label_pre">リリース予定</a>';
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
// /**
//  * カスタムフィールドから「youtube ID」を取得
//  * @param 記事ID
//  * @return youtube ID
// */
// function get_youtube_id($post_id){
// 	$youtube_id = get_post_meta($post_id , 'youtubeId' ,true);

// 	if(empty($imgid)){
// 		return null;
// 	}

// 	return $youtube_id;
// }
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
