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

get_header();
?>

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
    <section class="girls-list">
      <h2 class="section-title"><?php echo esc_html( $prefecture_name ); ?>の女性一覧</h2>
      <div class="girls-grid">
        <?php foreach ( $girls as $girl ) : ?>
          <article class="girl-card">
            <?php if ( ! empty( $girl->image_url ) ) : ?>
              <div class="girl-image">
                <img src="<?php echo esc_url( $girl->image_url ); ?>" alt="<?php echo esc_attr( $girl->name ); ?>">
              </div>
            <?php endif; ?>
            <div class="girl-info">
              <h3 class="girl-name"><?php echo esc_html( $girl->name ); ?></h3>
              <?php if ( ! empty( $girl->age ) ) : ?>
                <p class="girl-age">年齢: <?php echo esc_html( $girl->age ); ?>歳</p>
              <?php endif; ?>
              <?php if ( ! empty( $girl->area ) ) : ?>
                <p class="girl-area">エリア: <?php echo esc_html( $girl->area ); ?></p>
              <?php endif; ?>
              <?php if ( ! empty( $girl->comment ) ) : ?>
                <p class="girl-comment"><?php echo esc_html( wp_trim_words( $girl->comment, 30, '...' ) ); ?></p>
              <?php endif; ?>
              <?php if ( ! empty( $girl->profile_url ) ) : ?>
                <a href="<?php echo esc_url( $girl->profile_url ); ?>" class="girl-link" target="_blank" rel="noopener">プロフィールを見る</a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  <?php else : ?>
    <section class="no-girls">
      <p>現在、<?php echo esc_html( $prefecture_name ); ?>の女性情報はありません。</p>
      <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページに戻る</a></p>
    </section>
  <?php endif; ?>

  <!-- 他の都道府県へのリンク -->
  <section class="other-prefectures">
    <h2 class="section-title">他の都道府県から探す</h2>
    <div class="prefecture-links-grid">
      <?php
      $all_prefectures = mama_gen_get_prefectures();
      $random_prefs = array_rand( array_flip( $all_prefectures ), min( 12, count( $all_prefectures ) ) );
      if ( ! is_array( $random_prefs ) ) {
        $random_prefs = array( $random_prefs );
      }
      foreach ( $random_prefs as $pref ) :
        if ( $pref === $prefecture_name ) continue;
        $pref_slug = mama_gen_prefecture_to_slug( $pref );
      ?>
        <a href="<?php echo esc_url( home_url( '/prefecture/' . $pref_slug . '/' ) ); ?>" class="prefecture-link-item">
          <?php echo esc_html( $pref ); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

<script>
function toggleContent(button) {
  const card = button.closest('.seo-content-card');
  const excerpt = card.querySelector('.seo-content-excerpt');
  const full = card.querySelector('.seo-content-full');
  
  if (full.style.display === 'none') {
    excerpt.style.display = 'none';
    full.style.display = 'block';
    button.textContent = '閉じる';
  } else {
    excerpt.style.display = 'block';
    full.style.display = 'none';
    button.textContent = '続きを読む';
  }
}
</script>

<?php get_footer(); ?>
