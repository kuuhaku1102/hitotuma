<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//matomo.sakura.ne.jp/matomo/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '11']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="header-container">
    <div class="site-branding">
      <h1 class="site-title">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <?php bloginfo( 'name' ); ?>
        </a>
      </h1>
    </div>

    <!-- ハンバーガーメニューボタン（スマホのみ表示） -->
    <button class="hamburger-menu" id="hamburger-menu" aria-label="メニュー">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- ナビゲーションメニュー -->
    <nav class="main-navigation" id="main-navigation">
      <ul class="nav-menu">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップ</a></li>
        <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">ブログ</a></li>
        
        <!-- 都道府県メニュー -->
        <li class="menu-item-has-children">
          <a href="#" class="dropdown-toggle">地域から探す <span class="arrow">▼</span></a>
          <ul class="sub-menu">
            <?php
            $regions = array(
              '北海道・東北' => array('北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'),
              '関東' => array('茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県'),
              '中部' => array('新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県'),
              '近畿' => array('三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県'),
              '中国' => array('鳥取県', '島根県', '岡山県', '広島県', '山口県'),
              '四国' => array('徳島県', '香川県', '愛媛県', '高知県'),
              '九州・沖縄' => array('福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県')
            );
            
            foreach ( $regions as $region_name => $prefs ) :
            ?>
              <li class="region-group">
                <span class="region-title"><?php echo esc_html( $region_name ); ?></span>
                <ul class="prefecture-list">
                  <?php foreach ( $prefs as $pref ) :
                    $pref_slug = mama_gen_prefecture_to_slug( $pref );
                  ?>
                    <li>
                      <a href="<?php echo esc_url( home_url( '/prefecture/' . $pref_slug . '/' ) ); ?>">
                        <?php echo esc_html( $pref ); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</header>

<main class="site-content">
