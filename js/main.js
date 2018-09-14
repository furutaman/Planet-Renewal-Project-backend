$(function(){


// スマホ用のメニュー作成
// $('#js-main-cat').clone().appendTo('#js-sp-menu');
// $('#js-sp-menu').find('ul').removeAttr('id');
// $('#js-sp-menu').find('ul').removeAttr('class').addClass('sp-menu');
// $('#js-sp-menu').find('li').removeAttr('id');
// $('#js-sp-menu').find('li').removeAttr('class');
// $('#js-sp-menu').find('a').removeAttr('class');


// ウインドウ幅の取得
$(window).on('load resize', function(){
  var $windowSize = $(window).width();

  // 処理（ウィンドウ）
  if($windowSize > 850){
    $('#js-main-cat').show();
    $('#js-sub-cat').slideUp(250);
  }else if($windowSize <= 850){
    $('#js-main-cat').hide();
  }

  $('#js-btn_hamburger').children().removeClass('on');

});


// ハンバーガーアイコンの開閉の関数
var hamburgerToggle = function(){

  var check = 0;

  $('#js-btn_hamburger').on('click', function(){
    $('#js-main-cat').slideToggle(0);
    $('#js-sub-cat').show(0);

    if(check == 0){
      $('#js-btn_hamburger').children().addClass('on');
      check = 1;
    } else {
      $('#js-btn_hamburger').children().removeClass('on');
      $('#js-main-cat').hide();
      check = 0;
    }

  });
}

// hamburgerToggleの実行
hamburgerToggle();


// サブメニューの表示非表示の関数
var submenuToggle = function(){

  $('#js-btn_other').on('mouseenter', function(){
    if($(window).width() > 850){
      $('#js-sub-cat').stop(true, false).slideDown(250);
    }
  });

  $('#js-btn_other').on('mouseleave', function(){
    if($(window).width() > 850){
      $('#js-sub-cat').stop(true, false).slideUp(250);
    }
  });

}

// submenuToggleの実行
submenuToggle();



// 検索窓の表示非表示

  $('#js-search').hide();
  $('#js-btn_search').on('click', function(){
    $('#js-search').stop(true, false).slideToggle(250);
  });


// ヘッダースクロール
  var documentElement = null; // スクロールを測定する要素
  var posY = 30; //高さ指定
  var nav = document.getElementById('js-nav');

  // スクロール位置を測定する要素を設定
  if (navigator.userAgent.toLowerCase().match(/webkit|msie 5/)) {
  // Webkit系（Safari, Chrome, iOS）判定
      if(navigator.userAgent.indexOf('Chrome') != -1){
        // Chromeはhtml要素
        documentElement = document.documentElement;
      } else {
        // Chrome以外はbody要素
        documentElement = document.body;
      }
  } else {
  // IE（6以上）、Firefox、Operaはhtml要素
      documentElement = document.documentElement;
  }

  window.addEventListener('load', function(){
      if(documentElement.scrollTop > posY){
          nav.classList.add('on_scroll');
      }else{
          nav.classList.remove('on_scroll');
      }
  });

  window.addEventListener('scroll', function(){
      if(documentElement.scrollTop > posY){
          nav.classList.add('on_scroll');
      }else{
          nav.classList.remove('on_scroll');
      }

  });


// slick
$(function() {
    $('.slider').slick({
          infinite: true,
          dots:true,
          slidesToShow: 1,
          centerMode: true, //要素を中央寄せ
          centerPadding:'100px', //両サイドの見えている部分のサイズ
          autoplay:false, //自動再生
          responsive: [{
               breakpoint: 700,
                  settings: {
                       centerMode: false,
                       slidesToShow: 1,
                       slidesToScroll: 1,
                       appendArrows: false,
                       autoplay: true,
                       autoplaySpeed: 2000
               }
          }]
     });
});


// toTop
    $(function() {
        var showFlag = false;
        var topBtn = $('#js-page-top');
        topBtn.css('bottom', '-100px');

        $(window).scroll(function(){
            if($(this).scrollTop() > 100) {
                if(showFlag == false) {
                    showFlag = true;
                    topBtn.stop().animate({'bottom':'20px'}, 200);
                }
            }else{
                if(showFlag == true){
                    showFlag = false;
                    topBtn.stop().animate({'bottom':'-100px'},200);
                }
            }
        });

        topBtn.on('click', function(){
            $('body, html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
    });

});


// APIの読み込み
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 要素と初期IDの登録
var ytArea = 'js-youtube';
var ytID = $('#js-youtube').data('youtube-id');

console.log(ytID);

function onYouTubeIframeAPIReady() {
    ytPlayer = new YT.Player(ytArea, {
        playerVars: {
                rel: 0, // 再生終了後に関連動画を表示するかどうか設定
                autoplay: 1, // 自動再生するかどうか設定
                controls: 1, // コントローラー非表示
                showinfo: 0
              },
        videoId: ytID,
        events: {
            'onReady': onPlayerReady
        }
    });
}

var ytReady = false;
function onPlayerReady(e) {
    ytReady = true;
}

$(function() {
    function ytCheck() {
        if(ytReady) {
            ytPlayer.setVolume(0);
            ytPlayer.playVideo();
        } else {
            setTimeout(ytCheck, 200);
        }
    }
    ytCheck();
});
