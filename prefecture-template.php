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
  <!-- 都道府県別SEOコンテンツ -->
  <section class="prefecture-seo-content">
    <h2 class="prefecture-seo-title">💕 <?php echo esc_html( $prefecture_name ); ?>で人妻と出会いたい男性へ</h2>
    
    <div class="prefecture-seo-intro">
      <p><?php echo esc_html( $prefecture_name ); ?>で落ち着いた大人の女性と自然な関係を築きたい—<br>
そんな男性に人気なのが、<strong>"人妻カテゴリーに特化したマッチング・掲示板サービス"</strong>です。</p>
      
      <p>このページでは、<?php echo esc_html( $prefecture_name ); ?>で人妻とつながりたい方へ向けて、</p>
      <ul class="intro-list">
        <li>どんな女性が多いか</li>
        <li>どのカテゴリを使えば出会いやすいか</li>
        <li>反応率が上がるメッセージ方法</li>
      </ul>
      <p>などをわかりやすく解説します。</p>
    </div>

    <h3 class="prefecture-seo-subtitle">📍 <?php echo esc_html( $prefecture_name ); ?>では「目的の合う人妻」を探しやすい</h3>
    
    <p>人妻カテゴリーが選ばれる理由は、地域に関係なくシンプルです。</p>

    <div class="feature-boxes">
      <div class="feature-box">
        <h4 class="feature-box-title">● 同じ目的の女性だけが集まっている</h4>
        <p>「まずは話したい」「大人の相談をしたい」など<br>
        目的が近い女性が多いため、自然な流れでやり取りが始められます。</p>
      </div>

      <div class="feature-box">
        <h4 class="feature-box-title">● 匿名で利用できて安心</h4>
        <p>本名や個人情報は公開されず、安心してメッセージを続けられます。</p>
      </div>

      <div class="feature-box">
        <h4 class="feature-box-title">● 生活スタイルに合う相手を探しやすい</h4>
        <p>昼・夜・土日など、自分の生活時間に合った女性と繋がりやすいのが特徴です。</p>
      </div>
    </div>

    <h3 class="prefecture-seo-subtitle">✨ <?php echo esc_html( $prefecture_name ); ?>で人妻と出会うコツ</h3>
    
    <p>どの地域でも共通して反応が良いアプローチ方法をご紹介します。</p>

    <div class="tips-section">
      <div class="tip-item">
        <h4 class="tip-title"><span class="tip-number">1</span>自己紹介は"シンプル & 丁寧"</h4>
        <p>人妻カテゴリでは派手さより安心感が重要。</p>
        <ul class="tip-list">
          <li>活動しやすい時間帯</li>
          <li>軽く話したい目的</li>
          <li>住んでいる大まかなエリア</li>
        </ul>
        <p>だけ書けば十分。</p>
      </div>

      <div class="tip-item">
        <h4 class="tip-title"><span class="tip-number">2</span>最初のメッセージは短めで誠実に</h4>
        <div class="message-example">
          <p class="example-label">例文：</p>
          <p class="example-text">「はじめまして。落ち着いた雰囲気の方だと思い、メッセージしました。よければ少しお話ししませんか？」</p>
        </div>
        <p>どの県でも共通して好印象を持たれる定番パターンです。</p>
      </div>

      <div class="tip-item">
        <h4 class="tip-title"><span class="tip-number">3</span>急な誘いは避け、会話の流れを大切に</h4>
        <p>人妻ユーザーは<strong>"安心できる男性"</strong>を重視するため、<br>
        焦らず、丁寧なコミュニケーションが成功率を高めます。</p>
      </div>
    </div>

    <h3 class="prefecture-seo-subtitle">📋 <?php echo esc_html( $prefecture_name ); ?>で人気の人妻向けカテゴリ</h3>
    
    <p>地域差が出ないように<strong>"全エリア共通で使えるカテゴリ名"</strong>に統一しています。</p>

    <div class="category-list">
      <div class="category-item">
        <span class="category-icon">💝</span>
        <span class="category-name">人妻・既婚女性掲示板</span>
      </div>
      <div class="category-item">
        <span class="category-icon">💬</span>
        <span class="category-name">大人の恋活・相談カテゴリ</span>
      </div>
      <div class="category-item">
        <span class="category-icon">✉️</span>
        <span class="category-name">雑談・メッセージ中心カテゴリ</span>
      </div>
      <div class="category-item">
        <span class="category-icon">⚡</span>
        <span class="category-name">すぐ話したい即レス掲示板</span>
      </div>
      <div class="category-item">
        <span class="category-icon">📍</span>
        <span class="category-name">地域別掲示板（<?php echo esc_html( $prefecture_name ); ?>版）</span>
      </div>
    </div>

    <p class="category-note"><?php echo esc_html( $prefecture_name ); ?>版の地域別掲示板から閲覧するだけでも、目的の近い女性を見つけやすくなります。</p>

    <div class="prefecture-summary">
      <h3 class="summary-title">📌 まとめ：<?php echo esc_html( $prefecture_name ); ?>でも人妻との出会いは十分可能</h3>
      <p><?php echo esc_html( $prefecture_name ); ?>で人妻との出会いを探す男性にとって、<br>
      <strong>"同じ目的の女性が集まる"掲示板・マッチングサービスは非常に効率的</strong>です。</p>
      <p>まずは気軽に掲示板をチェックして、<br>
      あなたのペースでやり取りを始めてみてください。</p>
    </div>
  </section>

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
