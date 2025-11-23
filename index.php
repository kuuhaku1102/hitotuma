<?php
/**
 * Mama Gen Theme - トップページ
 */

// トップページ用のSEOコンテンツを取得（都道府県に紐付いていないもの）
$args = array(
    'post_type'      => 'seo_content',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'prefecture',
            'operator' => 'NOT EXISTS',
        ),
    ),
);
$top_seo_contents = new WP_Query( $args );

// 都道府県一覧を取得
$prefectures = mama_gen_get_prefectures();

// 地域別にグループ化
$regions = array(
    '北海道・東北' => array('北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'),
    '関東' => array('茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県'),
    '中部' => array('新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県'),
    '近畿' => array('三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県'),
    '中国' => array('鳥取県', '島根県', '岡山県', '広島県', '山口県'),
    '四国' => array('徳島県', '香川県', '愛媛県', '高知県'),
    '九州・沖縄' => array('福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'),
);

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>
  <meta name="description" content="全国の人妻と出会える掲示板。都道府県別に人妻の特徴や出会い方、おすすめスポットなどを詳しく紹介しています。">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrap">
  <header class="site-header">
    <h1 class="site-title"><?php bloginfo('name'); ?></h1>
    <p class="site-description"><?php bloginfo('description'); ?></p>
  </header>

  <!-- メインビジュアル・キャッチコピー -->
  <section class="hero-section">
    <div class="hero-content">
      <h2 class="hero-title">全国の人妻と出会える掲示板</h2>
      <p class="hero-description">
        あなたの地域で素敵な人妻との出会いを見つけませんか？<br>
        都道府県別に厳選された女性をご紹介しています。
      </p>
    </div>
  </section>

  <!-- トップページ用SEOコンテンツ -->
  <?php if ( $top_seo_contents->have_posts() ) : ?>
    <section class="top-seo-contents">
      <h2 class="section-title">人妻出会い掲示板について</h2>
      <div class="seo-contents-grid">
        <?php while ( $top_seo_contents->have_posts() ) : $top_seo_contents->the_post(); ?>
          <article class="seo-content-card">
            <?php if ( has_post_thumbnail() ) : ?>
              <div class="seo-content-thumb">
                <?php the_post_thumbnail( 'medium' ); ?>
              </div>
            <?php endif; ?>
            <div class="seo-content-body">
              <h3 class="seo-content-title"><?php the_title(); ?></h3>
              <div class="seo-content-excerpt">
                <?php 
                $content = get_the_content();
                $excerpt = wp_trim_words( $content, 50, '...' );
                echo wp_kses_post( $excerpt );
                ?>
              </div>
              <?php if ( strlen( get_the_content() ) > 200 ) : ?>
                <button class="read-more-btn" onclick="toggleContent(this)">続きを読む</button>
                <div class="seo-content-full" style="display: none;">
                  <?php the_content(); ?>
                </div>
              <?php else : ?>
                <div class="seo-content-full">
                  <?php the_content(); ?>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- 地域別都道府県一覧 -->
  <section class="regions-section">
    <h2 class="section-title">地域から探す</h2>
    <p class="section-description">お住まいの地域を選択して、近くの人妻を探しましょう。</p>
    
    <div class="regions-container">
      <?php foreach ( $regions as $region_name => $region_prefs ) : ?>
        <div class="region-block">
          <h3 class="region-title"><?php echo esc_html( $region_name ); ?></h3>
          <div class="prefecture-links">
            <?php foreach ( $region_prefs as $pref ) :
              $pref_slug = mama_gen_prefecture_to_slug( $pref );
              
              // 各都道府県の女性数を取得
              global $wpdb;
              $table = $wpdb->prefix . 'mama_gen';
              $count = $wpdb->get_var( 
                $wpdb->prepare( 
                  "SELECT COUNT(*) FROM {$table} WHERE post_status = 'publish' AND prefecture = %s",
                  $pref
                )
              );
            ?>
              <a href="<?php echo esc_url( home_url( '/prefecture/' . $pref_slug . '/' ) ); ?>" class="prefecture-link">
                <?php echo esc_html( $pref ); ?>
                <?php if ( $count > 0 ) : ?>
                  <span class="prefecture-count">(<?php echo esc_html( $count ); ?>)</span>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- 特徴・メリットセクション -->
  <section class="features-section">
    <h2 class="section-title">当サイトの特徴</h2>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">📍</div>
        <h3 class="feature-title">地域密着型</h3>
        <p class="feature-description">
          都道府県別に細かく分類されているので、あなたの地域で出会いを探せます。
        </p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💝</div>
        <h3 class="feature-title">厳選された女性</h3>
        <p class="feature-description">
          プロフィールが充実した、本気で出会いを求めている女性のみを掲載しています。
        </p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <h3 class="feature-title">安心・安全</h3>
        <p class="feature-description">
          プライバシーに配慮した運営で、安心してご利用いただけます。
        </p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📱</div>
        <h3 class="feature-title">スマホ対応</h3>
        <p class="feature-description">
          スマートフォンからでも快適に閲覧・利用できるレスポンシブデザインです。
        </p>
      </div>
    </div>
  </section>

  <!-- よくある質問 -->
  <section class="faq-section">
    <h2 class="section-title">よくある質問</h2>
    <div class="faq-list">
      <div class="faq-item">
        <h3 class="faq-question">Q. 利用料金はかかりますか？</h3>
        <p class="faq-answer">A. 基本的な閲覧は無料です。詳細なプロフィールの閲覧や連絡には各サービスの規約に従ってください。</p>
      </div>
      <div class="faq-item">
        <h3 class="faq-question">Q. 個人情報は守られますか？</h3>
        <p class="faq-answer">A. はい、プライバシーポリシーに基づき、厳重に管理しています。</p>
      </div>
      <div class="faq-item">
        <h3 class="faq-question">Q. どのような女性が登録していますか？</h3>
        <p class="faq-answer">A. 20代から40代の既婚女性が中心です。真剣な出会いを求めている方が多く登録しています。</p>
      </div>
    </div>
  </section>

  <footer class="footer">
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo('name'); ?></p>
  </footer>
</div>

<script>
function toggleContent(btn) {
  const card = btn.closest('.seo-content-card');
  const excerpt = card.querySelector('.seo-content-excerpt');
  const full = card.querySelector('.seo-content-full');
  
  if (full.style.display === 'none') {
    full.style.display = 'block';
    excerpt.style.display = 'none';
    btn.textContent = '閉じる';
  } else {
    full.style.display = 'none';
    excerpt.style.display = 'block';
    btn.textContent = '続きを読む';
  }
}
</script>

<?php wp_footer(); ?>
</body>
</html>
