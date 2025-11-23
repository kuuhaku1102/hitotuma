<?php
/**
 * Mama Gen Theme functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// CSSとJavaScriptの読み込み
function mama_gen_enqueue_scripts() {
    wp_enqueue_style( 'mama-gen-style', get_stylesheet_uri(), array(), '1.8' );
    wp_enqueue_script( 'mama-gen-menu', get_template_directory_uri() . '/js/menu.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'mama_gen_enqueue_scripts' );

// 管理画面カスタマイズを読み込む
if ( is_admin() ) {
    require_once get_template_directory() . '/admin-customization.php';
}

// 都道府県初期化を読み込む
require_once get_template_directory() . '/prefecture-init.php';

// 都道府県タクソノミーを登録
function mama_gen_register_prefecture_taxonomy() {
    $labels = array(
        'name'              => '都道府県',
        'singular_name'     => '都道府県',
        'search_items'      => '都道府県を検索',
        'all_items'         => 'すべての都道府県',
        'edit_item'         => '都道府県を編集',
        'update_item'       => '都道府県を更新',
        'add_new_item'      => '新しい都道府県を追加',
        'new_item_name'     => '新しい都道府県名',
        'menu_name'         => '都道府県',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'prefecture' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'prefecture', array(), $args );
}
add_action( 'init', 'mama_gen_register_prefecture_taxonomy' );

// SEOコンテンツ用カスタム投稿タイプを登録
function mama_gen_register_seo_content() {
    $labels = array(
        'name'               => 'SEOコンテンツ',
        'singular_name'      => 'SEOコンテンツ',
        'menu_name'          => 'SEOコンテンツ',
        'add_new'            => '新規追加',
        'add_new_item'       => '新しいSEOコンテンツを追加',
        'edit_item'          => 'SEOコンテンツを編集',
        'new_item'           => '新しいSEOコンテンツ',
        'view_item'          => 'SEOコンテンツを表示',
        'search_items'       => 'SEOコンテンツを検索',
        'not_found'          => 'SEOコンテンツが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にSEOコンテンツはありません',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => false,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'seo-content' ),
        'capability_type'    => 'post',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-edit-page',
        'taxonomies'         => array( 'prefecture' ),
    );

    register_post_type( 'seo_content', $args );
}
add_action( 'init', 'mama_gen_register_seo_content' );

// 都道府県一覧を取得する関数
function mama_gen_get_prefectures() {
    return array(
        '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
        '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
        '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県',
        '岐阜県', '静岡県', '愛知県', '三重県',
        '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県',
        '鳥取県', '島根県', '岡山県', '広島県', '山口県',
        '徳島県', '香川県', '愛媛県', '高知県',
        '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
    );
}

// 都道府県別の女性データを取得する関数（ランダムで8-12件）
function mama_gen_get_girls_by_prefecture( $prefecture_name ) {
    global $wpdb;
    $table = $wpdb->prefix . 'mama_gen';
    
    // ランダムで8-12件取得（都道府県条件なし）
    $random_count = rand(8, 12);
    $girls = $wpdb->get_results( 
        "SELECT * FROM {$table} WHERE post_status = 'publish' ORDER BY RAND() LIMIT {$random_count}"
    );
    
    return $girls;
}

// 都道府県別のSEOコンテンツを取得する関数
function mama_gen_get_seo_contents_by_prefecture( $prefecture_slug ) {
    $args = array(
        'post_type'      => 'seo_content',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'prefecture',
                'field'    => 'slug',
                'terms'    => $prefecture_slug,
            ),
        ),
    );
    
    return new WP_Query( $args );
}

// 都道府県名からスラッグを生成する関数
function mama_gen_prefecture_to_slug( $prefecture_name ) {
    $slug_map = array(
        '北海道' => 'hokkaido', '青森県' => 'aomori', '岩手県' => 'iwate', '宮城県' => 'miyagi',
        '秋田県' => 'akita', '山形県' => 'yamagata', '福島県' => 'fukushima',
        '茨城県' => 'ibaraki', '栃木県' => 'tochigi', '群馬県' => 'gunma', '埼玉県' => 'saitama',
        '千葉県' => 'chiba', '東京都' => 'tokyo', '神奈川県' => 'kanagawa',
        '新潟県' => 'niigata', '富山県' => 'toyama', '石川県' => 'ishikawa', '福井県' => 'fukui',
        '山梨県' => 'yamanashi', '長野県' => 'nagano',
        '岐阜県' => 'gifu', '静岡県' => 'shizuoka', '愛知県' => 'aichi', '三重県' => 'mie',
        '滋賀県' => 'shiga', '京都府' => 'kyoto', '大阪府' => 'osaka', '兵庫県' => 'hyogo',
        '奈良県' => 'nara', '和歌山県' => 'wakayama',
        '鳥取県' => 'tottori', '島根県' => 'shimane', '岡山県' => 'okayama', '広島県' => 'hiroshima',
        '山口県' => 'yamaguchi',
        '徳島県' => 'tokushima', '香川県' => 'kagawa', '愛媛県' => 'ehime', '高知県' => 'kochi',
        '福岡県' => 'fukuoka', '佐賀県' => 'saga', '長崎県' => 'nagasaki', '熊本県' => 'kumamoto',
        '大分県' => 'oita', '宮崎県' => 'miyazaki', '鹿児島県' => 'kagoshima', '沖縄県' => 'okinawa'
    );
    
    return isset( $slug_map[ $prefecture_name ] ) ? $slug_map[ $prefecture_name ] : '';
}

// リライトルールを追加
function mama_gen_add_rewrite_rules() {
    add_rewrite_rule(
        '^prefecture/([^/]+)/?$',
        'index.php?prefecture_page=$matches[1]',
        'top'
    );
}
add_action( 'init', 'mama_gen_add_rewrite_rules' );

// クエリ変数を追加
function mama_gen_query_vars( $vars ) {
    $vars[] = 'prefecture_page';
    return $vars;
}
add_filter( 'query_vars', 'mama_gen_query_vars' );

// テンプレートを読み込む
function mama_gen_template_include( $template ) {
    $prefecture_page = get_query_var( 'prefecture_page' );
    
    if ( $prefecture_page ) {
        $new_template = locate_template( array( 'prefecture-template.php' ) );
        if ( $new_template ) {
            return $new_template;
        }
    }
    
    return $template;
}
add_filter( 'template_include', 'mama_gen_template_include' );
