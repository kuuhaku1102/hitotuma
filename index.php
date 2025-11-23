<?php
/**
 * Mama Gen Theme - メインテンプレート
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrap">
  <header class="site-header">
    <h1 class="site-title"><?php bloginfo('name'); ?></h1>
    <p class="site-description"><?php bloginfo('description'); ?></p>
  </header>

  <?php
  global $wpdb;
  $table = $wpdb->prefix . 'mama_gen';

  // wp_mama_gen テーブルから公開データを取得
  $girls = $wpdb->get_results( "SELECT * FROM {$table} WHERE post_status = 'publish' ORDER BY id ASC" );

  if ( ! empty( $girls ) ) : ?>
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
    </section>
  <?php else : ?>
    <p>表示できるデータがありません。</p>
  <?php endif; ?>

  <footer class="footer">
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo('name'); ?></p>
  </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
