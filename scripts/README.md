# AI記事自動投稿システム

このディレクトリには、AI記事自動投稿システムのスクリプトが含まれています。

## 概要

このシステムは以下の機能を提供します:

1. **キーワード管理**: 未使用のキーワード組み合わせを自動選択
2. **AI記事生成**: OpenAI APIを使用して高品質な記事を自動生成
3. **WordPress投稿**: 生成した記事を自動的にWordPressに投稿
4. **GitHub Actions連携**: 毎日自動実行

## ファイル構成

```
scripts/
├── README.md                    # このファイル
├── requirements.txt             # Python依存パッケージ
├── keywords.json                # キーワードデータベース
├── keyword-manager.py           # キーワード管理スクリプト
├── generate-article.py          # AI記事生成スクリプト
├── post-to-wordpress.py         # WordPress投稿スクリプト
├── auto-post.py                 # 統合自動投稿スクリプト
└── article_*.json               # 生成された記事データ（自動生成）
```

## セットアップ

### 1. 依存パッケージのインストール

```bash
pip install -r requirements.txt
```

### 2. 環境変数の設定

以下の環境変数を設定してください:

```bash
export OPENAI_API_KEY="your-openai-api-key"
export WP_URL="https://www.reach4d.jp"
export WP_USERNAME="your-wordpress-username"
export WP_APP_PASSWORD="your-wordpress-app-password"
```

### 3. WordPressアプリケーションパスワードの作成

1. WordPressダッシュボードにログイン
2. ユーザー → プロフィール
3. 「アプリケーションパスワード」セクションで新しいパスワードを作成
4. 生成されたパスワードを `WP_APP_PASSWORD` に設定

### 4. GitHub Secretsの設定

GitHub リポジトリの Settings → Secrets and variables → Actions で以下のシークレットを追加:

- `OPENAI_API_KEY`: OpenAI APIキー
- `WP_URL`: WordPressサイトURL（例: https://www.reach4d.jp）
- `WP_USERNAME`: WordPressユーザー名
- `WP_APP_PASSWORD`: WordPressアプリケーションパスワード

## 使用方法

### 手動実行

#### 方法1: 統合スクリプトで一括実行（推奨）

```bash
cd scripts
python3 auto-post.py
```

#### 方法2: 個別に実行

```bash
cd scripts

# 1. 記事を生成
python3 generate-article.py

# 2. 生成された記事をWordPressに投稿
python3 post-to-wordpress.py article_20240101_120000.json
```

### 自動実行

GitHub Actionsにより、毎日午前10時（日本時間）に自動実行されます。

手動で実行する場合:
1. GitHubリポジトリの「Actions」タブを開く
2. 「AI記事自動投稿」ワークフローを選択
3. 「Run workflow」ボタンをクリック

## キーワード管理

### keywords.json の構造

```json
{
  "main_keywords": [
    "不倫募集掲示板",
    "セカンドパートナー探し",
    ...
  ],
  "sub_keywords": [
    "40代",
    "50代",
    "安全性",
    ...
  ],
  "article_types": [
    {
      "type": "usage",
      "title_pattern": "{main_keyword}の賢い使い方｜{sub_keyword}向け完全ガイド"
    },
    ...
  ],
  "used_combinations": [
    "不倫募集掲示板_40代_usage",
    ...
  ]
}
```

### キーワードの追加方法

1. `keywords.json` を開く
2. `main_keywords` または `sub_keywords` に新しいキーワードを追加
3. 保存してコミット

### 使用済みキーワードのリセット

すべてのキーワード組み合わせを使い切った場合、自動的にリセットされます。

手動でリセットする場合:
```bash
# keywords.json の used_combinations を空配列にする
```

## トラブルシューティング

### エラー: WordPress投稿に失敗

- `WP_URL`, `WP_USERNAME`, `WP_APP_PASSWORD` が正しく設定されているか確認
- WordPressアプリケーションパスワードが有効か確認
- WordPressサイトがREST APIを有効にしているか確認

### エラー: AI記事生成に失敗

- `OPENAI_API_KEY` が正しく設定されているか確認
- OpenAI APIの利用制限に達していないか確認
- ネットワーク接続を確認

### GitHub Actionsが実行されない

- リポジトリの Actions が有効になっているか確認
- GitHub Secrets が正しく設定されているか確認
- ワークフローファイルの cron 設定を確認

## ライセンス

このプロジェクトは MIT ライセンスの下で公開されています。
