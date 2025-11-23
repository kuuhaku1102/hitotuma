<?php
/**
 * 管理画面カスタマイズ
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// SEOコンテンツ投稿画面にヘルプテキストを追加
function mama_gen_seo_content_help() {
    $screen = get_current_screen();
    
    if ( $screen->post_type === 'seo_content' ) {
        ?>
        <div class="notice notice-info">
            <h3>📝 SEOコンテンツの作成ガイド</h3>
            <ul>
                <li><strong>タイトル:</strong> 「〇〇県の人妻の特徴」「〇〇県で人妻と出会う方法」など、具体的なタイトルを設定してください。</li>
                <li><strong>本文:</strong> 地域の特徴、出会いのコツ、おすすめスポットなど、ユーザーに役立つ情報を記載してください。</li>
                <li><strong>都道府県:</strong> 右側のサイドバーから対象の都道府県を選択してください。選択しない場合はトップページに表示されます。</li>
                <li><strong>アイキャッチ画像:</strong> 地域のイメージ画像を設定すると、より魅力的なコンテンツになります。</li>
            </ul>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'mama_gen_seo_content_help' );

// 管理画面メニューのカスタマイズ
function mama_gen_admin_menu() {
    // テーマ設定ページを追加
    add_theme_page(
        'テーマ設定',
        'テーマ設定',
        'manage_options',
        'mama-gen-settings',
        'mama_gen_settings_page'
    );
}
add_action( 'admin_menu', 'mama_gen_admin_menu' );

// テーマ設定ページの内容
function mama_gen_settings_page() {
    ?>
    <div class="wrap">
        <h1>Mama Gen Theme 設定</h1>
        
        <div class="card" style="max-width: 800px;">
            <h2>📊 データベース情報</h2>
            <p>このテーマは <code>wp_mama_gen</code> テーブルから女性データを取得します。</p>
            
            <h3>必要なカラム:</h3>
            <ul>
                <li><code>id</code> - ID</li>
                <li><code>name</code> - 名前</li>
                <li><code>age</code> - 年齢</li>
                <li><code>prefecture</code> - 都道府県（例: 東京都、大阪府）</li>
                <li><code>figure</code> - 体型</li>
                <li><code>character</code> - 性格</li>
                <li><code>comment</code> - コメント</li>
                <li><code>samune</code> - サムネイル画像URL</li>
                <li><code>url</code> - プロフィールURL</li>
                <li><code>post_status</code> - 公開ステータス（publish = 公開）</li>
            </ul>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2>🗺️ 都道府県別ページ</h2>
            <p>都道府県別ページは以下のURLでアクセスできます:</p>
            <p><code><?php echo home_url('/prefecture/'); ?>[都道府県スラッグ]/</code></p>
            
            <h3>例:</h3>
            <ul>
                <li>東京都: <a href="<?php echo home_url('/prefecture/tokyo/'); ?>" target="_blank"><?php echo home_url('/prefecture/tokyo/'); ?></a></li>
                <li>大阪府: <a href="<?php echo home_url('/prefecture/osaka/'); ?>" target="_blank"><?php echo home_url('/prefecture/osaka/'); ?></a></li>
                <li>北海道: <a href="<?php echo home_url('/prefecture/hokkaido/'); ?>" target="_blank"><?php echo home_url('/prefecture/hokkaido/'); ?></a></li>
            </ul>
            
            <p><strong>注意:</strong> パーマリンク設定を更新してください。</p>
            <p>
                <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button button-primary">
                    パーマリンク設定を更新
                </a>
            </p>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2>📝 SEOコンテンツの作成方法</h2>
            <ol>
                <li>左メニューから「SEOコンテンツ」→「新規追加」をクリック</li>
                <li>タイトルと本文を入力</li>
                <li>右サイドバーの「都道府県」から対象地域を選択</li>
                <li>アイキャッチ画像を設定（任意）</li>
                <li>「公開」ボタンをクリック</li>
            </ol>
            
            <p>
                <a href="<?php echo admin_url('post-new.php?post_type=seo_content'); ?>" class="button button-primary">
                    SEOコンテンツを作成
                </a>
            </p>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2>🔧 トラブルシューティング</h2>
            
            <h3>都道府県別ページが404エラーになる場合:</h3>
            <ol>
                <li>「設定」→「パーマリンク設定」を開く</li>
                <li>何も変更せずに「変更を保存」ボタンをクリック</li>
                <li>リライトルールがリセットされ、正常に動作するようになります</li>
            </ol>

            <h3>女性データが表示されない場合:</h3>
            <ul>
                <li><code>wp_mama_gen</code> テーブルの <code>prefecture</code> カラムに正しい都道府県名が入っているか確認してください</li>
                <li><code>post_status</code> が <code>publish</code> になっているか確認してください</li>
            </ul>
        </div>
    </div>
    <?php
}

// カスタム投稿タイプのカラム追加
function mama_gen_seo_content_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['prefecture'] = '都道府県';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter( 'manage_seo_content_posts_columns', 'mama_gen_seo_content_columns' );

// カスタムカラムの内容を表示
function mama_gen_seo_content_column_content( $column, $post_id ) {
    if ( $column === 'prefecture' ) {
        $terms = get_the_terms( $post_id, 'prefecture' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $prefecture_names = array();
            foreach ( $terms as $term ) {
                $prefecture_names[] = $term->name;
            }
            echo implode( ', ', $prefecture_names );
        } else {
            echo '全国（トップページ）';
        }
    }
}
add_action( 'manage_seo_content_posts_custom_column', 'mama_gen_seo_content_column_content', 10, 2 );
