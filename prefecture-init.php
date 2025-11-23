<?php
/**
 * 都道府県タクソノミーの初期データを登録
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 都道府県タームを自動登録する関数
function mama_gen_init_prefecture_terms() {
    // 既に登録済みかチェック
    $terms = get_terms( array(
        'taxonomy'   => 'prefecture',
        'hide_empty' => false,
    ) );
    
    // 既に都道府県が登録されている場合はスキップ
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        return;
    }
    
    // 都道府県一覧とスラッグのマッピング
    $prefectures = array(
        '北海道' => 'hokkaido',
        '青森県' => 'aomori',
        '岩手県' => 'iwate',
        '宮城県' => 'miyagi',
        '秋田県' => 'akita',
        '山形県' => 'yamagata',
        '福島県' => 'fukushima',
        '茨城県' => 'ibaraki',
        '栃木県' => 'tochigi',
        '群馬県' => 'gunma',
        '埼玉県' => 'saitama',
        '千葉県' => 'chiba',
        '東京都' => 'tokyo',
        '神奈川県' => 'kanagawa',
        '新潟県' => 'niigata',
        '富山県' => 'toyama',
        '石川県' => 'ishikawa',
        '福井県' => 'fukui',
        '山梨県' => 'yamanashi',
        '長野県' => 'nagano',
        '岐阜県' => 'gifu',
        '静岡県' => 'shizuoka',
        '愛知県' => 'aichi',
        '三重県' => 'mie',
        '滋賀県' => 'shiga',
        '京都府' => 'kyoto',
        '大阪府' => 'osaka',
        '兵庫県' => 'hyogo',
        '奈良県' => 'nara',
        '和歌山県' => 'wakayama',
        '鳥取県' => 'tottori',
        '島根県' => 'shimane',
        '岡山県' => 'okayama',
        '広島県' => 'hiroshima',
        '山口県' => 'yamaguchi',
        '徳島県' => 'tokushima',
        '香川県' => 'kagawa',
        '愛媛県' => 'ehime',
        '高知県' => 'kochi',
        '福岡県' => 'fukuoka',
        '佐賀県' => 'saga',
        '長崎県' => 'nagasaki',
        '熊本県' => 'kumamoto',
        '大分県' => 'oita',
        '宮崎県' => 'miyazaki',
        '鹿児島県' => 'kagoshima',
        '沖縄県' => 'okinawa',
    );
    
    // 各都道府県をタームとして登録
    foreach ( $prefectures as $name => $slug ) {
        $term = term_exists( $slug, 'prefecture' );
        
        if ( ! $term ) {
            wp_insert_term(
                $name,
                'prefecture',
                array(
                    'slug' => $slug,
                )
            );
        }
    }
}

// テーマ有効化時に実行
add_action( 'after_setup_theme', 'mama_gen_init_prefecture_terms' );

// 管理画面でも実行（念のため）
add_action( 'admin_init', 'mama_gen_init_prefecture_terms' );
