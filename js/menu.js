/**
 * ハンバーガーメニューとドロップダウンメニューの制御
 */

document.addEventListener('DOMContentLoaded', function() {
  // ハンバーガーメニューの制御
  const hamburger = document.getElementById('hamburger-menu');
  const navigation = document.getElementById('main-navigation');
  
  if (hamburger && navigation) {
    hamburger.addEventListener('click', function() {
      this.classList.toggle('active');
      navigation.classList.toggle('active');
      
      // ボディのスクロールを制御
      if (navigation.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    });
  }
  
  // スマホでのドロップダウンメニュー制御
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
  
  dropdownToggles.forEach(function(toggle) {
    toggle.addEventListener('click', function(e) {
      // スマホサイズの場合のみ
      if (window.innerWidth <= 768) {
        e.preventDefault();
        const parent = this.closest('.menu-item-has-children');
        parent.classList.toggle('active');
        
        // 矢印の向きを変更
        const arrow = this.querySelector('.arrow');
        if (arrow) {
          arrow.textContent = parent.classList.contains('active') ? '▲' : '▼';
        }
      }
    });
  });
  
  // メニュー外をクリックしたら閉じる
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.site-header')) {
      if (navigation && navigation.classList.contains('active')) {
        hamburger.classList.remove('active');
        navigation.classList.remove('active');
        document.body.style.overflow = '';
      }
    }
  });
  
  // ウィンドウリサイズ時の処理
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      // PCサイズに戻ったらメニューを閉じる
      if (window.innerWidth > 768) {
        if (hamburger) hamburger.classList.remove('active');
        if (navigation) navigation.classList.remove('active');
        document.body.style.overflow = '';
        
        // ドロップダウンの状態もリセット
        document.querySelectorAll('.menu-item-has-children').forEach(function(item) {
          item.classList.remove('active');
          const arrow = item.querySelector('.arrow');
          if (arrow) arrow.textContent = '▼';
        });
      }
    }, 250);
  });
});
