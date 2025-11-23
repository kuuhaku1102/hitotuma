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
  <!-- 人妻と出会いたい人向けSEOコンテンツ -->
  <section class="main-content-section">
    <article class="main-content">
      <h2 class="content-main-title">💕 人妻と出会いたい人へ</h2>
      
      <div class="content-intro">
        <p>「落ち着いた女性と安心できる時間を過ごしたい」「同年代や年上女性と気を使わない関係を築きたい」<br>
        そんな男性の中には、<strong>"人妻カテゴリーに強い出会い系サービス"</strong>を探している方も多いはず。</p>
        
        <p>最近では、匿名で利用でき、近くに住む既婚女性・大人の女性と気軽にメッセージをやり取りできるマッチング系サービスの人気が急上昇しています。<br>
        本ページでは、<strong>人妻と出会いやすい理由・安全な使い方・出会いを増やすコツ</strong>を詳しく解説します。</p>
      </div>

      <h3 class="content-subtitle">🌟 なぜ「人妻カテゴリー」が人気なのか？</h3>
      
      <p>人妻・既婚女性との出会いが注目されている背景には、以下の3つがあります。</p>

      <div class="reason-cards">
        <div class="reason-card">
          <div class="reason-number">1</div>
          <h4 class="reason-title">落ち着いた大人の魅力がある</h4>
          <p>仕事にも生活にも余裕がある女性が多く、<br>
          「<strong>無理に背伸びしなくていい</strong>」「<strong>自然体でいられる</strong>」<br>
          という声が男性から多く寄せられています。</p>
        </div>

        <div class="reason-card">
          <div class="reason-number">2</div>
          <h4 class="reason-title">ガツガツしていない、自然なやり取り</h4>
          <p>「まずは話したい」「相談したい」など、軽いコミュニケーションから入る女性が多いのが特徴。<br>
          <strong>初対面でも構えずに会話できる点</strong>が男性人気の理由。</p>
        </div>

        <div class="reason-card">
          <div class="reason-number">3</div>
          <h4 class="reason-title">匿名で利用できるため、プライバシーが守られる</h4>
          <p>SNSとは違い<strong>個人情報が出ない</strong>ため、安心して使えるという声が多数。</p>
        </div>
      </div>

      <h3 class="content-subtitle">📝 人妻と出会うなら"掲示板 × マッチング型"が一番効率的</h3>
      
      <p>人妻カテゴリーは、実は一般マッチングアプリよりも<strong>出会い系掲示板・大人向けマッチングサービスの方が成功率が高い</strong>と言われています。</p>

      <div class="highlight-box">
        <p class="highlight-text">理由は簡単で、<br>
        <strong>「同じ目的の人が集まっている」</strong><br>
        から。</p>
      </div>

      <ul class="check-list">
        <li>「今から会える人」</li>
        <li>「メッセージで仲良くなりたい」</li>
        <li>「大人の関係を求めている」</li>
      </ul>

      <p>など、<strong>掲示板カテゴリーごとに目的が明確</strong>。<br>
      そのため、条件に合う人を見つけやすく、アプローチもスムーズです。</p>

      <h3 class="content-subtitle">✨ 人妻と出会うための"鉄板テクニック"3つ</h3>
      
      <p>目的に合う相手を見つけたら、ここを意識してください。</p>

      <div class="technique-section">
        <div class="technique-item">
          <h4 class="technique-title"><span class="technique-label">1</span>プロフィールは "爽やか × 丁寧" が鉄則</h4>
          <p>人妻ジャンルは<strong>"安心できる男性"が強い</strong>。<br>
          清潔感を感じさせる自己紹介が反応率を大きく上げます。</p>
          <ul class="sub-list">
            <li>✔ 年齢・住んでいるエリア</li>
            <li>✔ 平日の空き時間</li>
            <li>✔ 会話のペース</li>
            <li>✔ 趣味・価値観</li>
          </ul>
          <p>…などを簡潔にまとめると好印象。</p>
        </div>

        <div class="technique-item">
          <h4 class="technique-title"><span class="technique-label">2</span>最初のメッセージは短め＆誠実に</h4>
          <p>人妻カテゴリーでは<strong>長文より"丁寧で簡潔な文"が好反応</strong>。</p>
          <div class="example-box">
            <p class="example-label">例）</p>
            <p class="example-text">「はじめまして。落ち着いた雰囲気の方だと思いメッセージしました。よろしければ少しお話ししてみませんか？」</p>
          </div>
          <p>大人女性ほど、こうした<strong>常識のある文を好みます</strong>。</p>
        </div>

        <div class="technique-item">
          <h4 class="technique-title"><span class="technique-label">3</span>会う約束は急がない。コミュニケーション重視</h4>
          <p><strong>急な誘いは警戒されるためNG</strong>。<br>
          軽い相談・世間話などを交えて、<br>
          「<strong>この人は安心して話せる</strong>」<br>
          と思ってもらうことが最重要です。</p>
        </div>
      </div>

      <h3 class="content-subtitle">⚠️ 人妻と出会いたい人が注意すべきポイント</h3>
      
      <p>安心して利用するために、<strong>以下は必ず意識してください</strong>。</p>

      <div class="warning-list">
        <div class="warning-item">
          <span class="warning-icon">❌</span>
          <span>個人情報をすぐに教えない</span>
        </div>
        <div class="warning-item">
          <span class="warning-icon">❌</span>
          <span>危険な外部リンクを踏まない</span>
        </div>
        <div class="warning-item">
          <span class="warning-icon">❌</span>
          <span>金銭のやり取りをしない</span>
        </div>
        <div class="warning-item">
          <span class="warning-icon">❌</span>
          <span>会う場所は必ず人が多い場所にする</span>
        </div>
        <div class="warning-item">
          <span class="warning-icon">✅</span>
          <span>サイト内の通報機能を活用する</span>
        </div>
      </div>

      <p class="safety-note"><strong>安全に使えば、トラブルのリスクは大きく下がります。</strong></p>

      <div class="cta-box">
        <h3 class="cta-title">📍 あなたの地域で人妻を探す</h3>
        <p class="cta-text">下記からお住まいの都道府県を選んで、近くの人妻をチェックしてみましょう！</p>
      </div>
    </article>
  </section>
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
            ?>
              <a href="<?php echo esc_url( home_url( '/prefecture/' . $pref_slug . '/' ) ); ?>" class="prefecture-link">
                <?php echo esc_html( $pref ); ?>
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
