</main>

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-content">
      <div class="footer-section">
        <h3>人妻出会い掲示板</h3>
        <p>全国の人妻と安心・安全に出会えるマッチングサービスです。</p>
      </div>
      
      <div class="footer-section">
        <h4>主要地域</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url( home_url( '/prefecture/tokyo/' ) ); ?>">東京都</a></li>
          <li><a href="<?php echo esc_url( home_url( '/prefecture/osaka/' ) ); ?>">大阪府</a></li>
          <li><a href="<?php echo esc_url( home_url( '/prefecture/kanagawa/' ) ); ?>">神奈川県</a></li>
          <li><a href="<?php echo esc_url( home_url( '/prefecture/aichi/' ) ); ?>">愛知県</a></li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h4>サイト情報</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">プライバシーポリシー</a></li>
          <li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">利用規約</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">お問い合わせ</a></li>
        </ul>
      </div>
    </div>
    
    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
