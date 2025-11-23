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

// 女性データを取得（全データからランダムに8-12件）
$girls = mama_gen_get_girls_by_prefecture( $prefecture_name );

get_header();
?>

  <!-- ページタイトル -->
  <section class="page-hero">
    <div class="page-hero-content">
      <h1 class="page-title"><?php echo esc_html( $prefecture_name ); ?>の人妻出会い掲示板</h1>
      <p class="page-description">秘密の関係を求める既婚者が集まる、<?php echo esc_html( $prefecture_name ); ?>専用の出会いの場</p>
    </div>
  </section>

  <!-- 女性一覧セクション -->
  <?php if ( ! empty( $girls ) ) : ?>
    <section class="girls-list">
      <?php foreach ( $girls as $girl ) :
        // サムネイルURL（/images から始まるパス想定）
        $thumb = '';
        if ( ! empty( $girl->samune ) ) {
          // samune が /images/〜 のようなパスの場合、サイトURLを前に付ける
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
          <h2 class="girl-name"><?php echo esc_html( $girl->name ); ?></h2>

          <div class="girl-meta">
            <?php if ( isset( $girl->age ) && $girl->age !== null && $girl->age !== '' ) : ?>
              <span><span class="girl-meta-label">年齢</span><?php echo esc_html( $girl->age ); ?></span>
            <?php endif; ?>
            <?php if ( isset( $girl->figure ) && $girl->figure !== null && $girl->figure !== '' ) : ?>
              <span><span class="girl-meta-label">体型</span><?php echo esc_html( $girl->figure ); ?></span>
            <?php endif; ?>
            <?php if ( isset( $girl->character ) && $girl->character !== null && $girl->character !== '' ) : ?>
              <span><span class="girl-meta-label">性格</span><?php echo esc_html( $girl->character ); ?></span>
            <?php endif; ?>
          </div>

          <?php if ( isset( $girl->comment ) && $girl->comment !== null && $girl->comment !== '' ) : ?>
            <p class="girl-comment"><?php echo esc_html( $girl->comment ); ?></p>
          <?php endif; ?>

          <?php if ( isset( $girl->url ) && $girl->url !== null && $girl->url !== '' ) : ?>
            <p class="girl-link">
              <a href="<?php echo esc_url( $girl->url ); ?>" target="_blank" rel="noopener">プロフィールを見る</a>
            </p>
          <?php endif; ?>
        </div>
      </article>
      <?php endforeach; ?>
    </section>
  <?php else : ?>
    <p class="no-data-message">表示できるデータがありません。</p>
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

<?php get_footer(); ?>
