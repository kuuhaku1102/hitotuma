Mama Gen Theme
==============

wp_mama_gen テーブルに保存されたデータを一覧表示するための、極シンプルな WordPress テーマです。

■ 使い方
1. このテーマフォルダを ZIP にした状態で WordPress の「外観 > テーマ > 新規追加 > テーマのアップロード」からアップロードします。
2. 有効化すると、トップページで wp_mama_gen テーブルの内容（post_status = 'publish' の行）がカード一覧で表示されます。

■ 必須条件
- データベースに `${table_prefix}mama_gen` テーブルが存在すること
- カラム: post_type, post_status, post_title, name, age, figure, character, comment, samune, url, id

■ カスタマイズ
- デザインを変更したい場合は style.css を編集してください。
- 取得条件や並び順を変えたい場合は index.php 内の $wpdb->get_results() のクエリを変更してください。
