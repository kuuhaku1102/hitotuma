<?php
/**
 * 都道府県別ページテンプレート
 */

$prefecture_slug = get_query_var( 'prefecture_page' );

// スラッグから都道府県名を取得
$slug_map = array(
    'hokkaido' => '北海道', 'aomori' => '青森県', 'iwate' => '岩手県', 'miyagi' => '宮城県',
    'akita' => '秋田県', 'yamagata' => '山形県', 'fukushima' => '福島県',
    'ibaraki' => '茨城県', 'tochigi' => '栃木県', 'gunma' => '群馬県', 'saitama' => '埼玉県',
    'chiba' => '千葉県', 'tokyo' => '東京都', 'kanagawa' => '神奈川県',
    'niigata' => '新潟県', 'toyama' => '富山県', 'ishikawa' => '石川県', 'fukui' => '福井県',
    'yamanashi' => '山梨県', 'nagano' => '長野県',
    'gifu' => '岐阜県', 'shizuoka' => '静岡県', 'aichi' => '愛知県', 'mie' => '三重県',
    'shiga' => '滋賀県', 'kyoto' => '京都府', 'osaka' => '大阪府', 'hyogo' => '兵庫県',
    'nara' => '奈良県', 'wakayama' => '和歌山県',
    'tottori' => '鳥取県', 'shimane' => '島根県', 'okayama' => '岡山県', 'hiroshima' => '広島県',
    'yamaguchi' => '山口県',
    'tokushima' => '徳島県', 'kagawa' => '香川県', 'ehime' => '愛媛県', 'kochi' => '高知県',
    'fukuoka' => '福岡県', 'saga' => '佐賀県', 'nagasaki' => '長崎県', 'kumamoto' => '熊本県',
    'oita' => '大分県', 'miyazaki' => '宮崎県', 'kagoshima' => '鹿児島県', 'okinawa' => '沖縄県'
);
$prefecture_name = isset( $slug_map[ $prefecture_slug ] ) ? $slug_map[ $prefecture_slug ] : '';

if ( ! $prefecture_name ) {
    // 都道府県が見つからない場合は404
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    get_template_part( 404 );
    exit;
}

// 女性データを取得
$girls = mama_gen_get_girls_by_prefecture( $prefecture_name );

// SEOコンテンツを取得
$seo_contents = mama_gen_get_seo_contents_by_prefecture( $prefecture_slug );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo esc_html( $prefecture_name ); ?>の人妻出会い掲示板 | <?php bloginfo('name'); ?></title>
  <meta name="description" content="<?php echo esc_attr( $prefecture_name ); ?>で人妻と出会える掲示板。地域の人妻の特徴や出会い方、おすすめスポットなどを紹介。">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrap">
  <header class="site-header">
    <h1 class="site-title">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a>
    </h1>
    <p class="site-description"><?php bloginfo('description'); ?></p>
  </header>

  <!-- パンくずリスト -->
  <nav class="breadcrumb">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a>
    <span class="separator">›</span>
    <span class="current"><?php echo esc_html( $prefecture_name ); ?></span>
  </nav>

  <!-- ページタイトル -->
  <div class="prefecture-header">
    <h1 class="prefecture-title"><?php echo esc_html( $prefecture_name ); ?>の人妻出会い掲示板</h1>
    <p class="prefecture-intro">
      <?php echo esc_html( $prefecture_name ); ?>エリアで出会いを探している人妻の一覧です。
      地域の特徴や出会い方のコツもご紹介しています。
    </p>
  </div>

  <!-- SEOコンテンツセクション -->
  <?php if ( $seo_contents->have_posts() ) : ?>
    <section class="seo-contents">
      <h2 class="section-title"><?php echo esc_html( $prefecture_name ); ?>の人妻出会い情報</h2>
      <div class="seo-contents-grid">
        <?php while ( $seo_contents->have_posts() ) : $seo_contents->the_post(); ?>
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

  <!-- 女性一覧セクション -->
  <?php if ( ! empty( $girls ) ) : ?>
    <section class="girls-section">
      <h2 class="section-title"><?php echo esc_html( $prefecture_name ); ?>の女性一覧（<?php echo count( $girls ); ?>名）</h2>
      <div class="girls-list">
        <?php foreach ( $girls as $girl ) :
          // サムネイルURL
          $thumb = '';
          if ( ! empty( $girl->samune ) ) {
            if ( strpos( $girl->samune, 'http' ) === 0 ) {
              $thumb = esc_url( $girl->samune );
            } else {
              $thumb = esc_url( home_url( $girl->samune ) );
            }
          }
        ?>
        <article class="girl">
          <?php if ( $thumb ) : ?>
            <div class="girl-thumb">
              <img src="<?php echo $thumb; ?>" alt="<?php echo esc_attr( $girl->name ); ?>">
            </div>
          <?php endif; ?>
          <div class="girl-body">
            <h3 class="girl-name"><?php echo esc_html( $girl->name ); ?></h3>

            <div class="girl-meta">
              <?php if ( $girl->age !== null && $girl->age !== '' ) : ?>
                <span><span class="girl-meta-label">年齢</span><?php echo esc_html( $girl->age ); ?></span>
              <?php endif; ?>
              <?php if ( $girl->figure !== null && $girl->figure !== '' ) : ?>
                <span><span class="girl-meta-label">体型</span><?php echo esc_html( $girl->figure ); ?></span>
              <?php endif; ?>
              <?php if ( $girl->character !== null && $girl->character !== '' ) : ?>
                <span><span class="girl-meta-label">性格</span><?php echo esc_html( $girl->character ); ?></span>
              <?php endif; ?>
            </div>

            <?php if ( $girl->comment !== null && $girl->comment !== '' ) : ?>
              <p class="girl-comment"><?php echo esc_html( $girl->comment ); ?></p>
            <?php endif; ?>

            <?php if ( $girl->url !== null && $girl->url !== '' ) : ?>
              <p class="girl-link">
                <a href="<?php echo esc_url( $girl->url ); ?>" target="_blank" rel="noopener">プロフィールを見る</a>
              </p>
            <?php endif; ?>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </section>
  <?php else : ?>
    <section class="girls-section">
      <h2 class="section-title"><?php echo esc_html( $prefecture_name ); ?>の女性一覧</h2>
      <p class="no-data">現在、<?php echo esc_html( $prefecture_name ); ?>の女性データはありません。</p>
    </section>
  <?php endif; ?>

  <!-- 他の都道府県へのリンク -->
  <section class="other-prefectures">
    <h2 class="section-title">他の都道府県を見る</h2>
    <div class="prefecture-links">
      <?php
      $prefectures = mama_gen_get_prefectures();
      foreach ( $prefectures as $pref ) :
        if ( $pref === $prefecture_name ) continue;
        $pref_slug = mama_gen_prefecture_to_slug( $pref );
      ?>
        <a href="<?php echo esc_url( home_url( '/prefecture/' . $pref_slug . '/' ) ); ?>" class="prefecture-link">
          <?php echo esc_html( $pref ); ?>
        </a>
      <?php endforeach; ?>
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
