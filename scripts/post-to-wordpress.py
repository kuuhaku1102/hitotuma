#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
WordPress投稿スクリプト
生成した記事をWordPressに投稿する
"""

import os
import sys
import json
import requests
from requests.auth import HTTPBasicAuth
from datetime import datetime

# WordPress設定（環境変数から取得）
WP_URL = os.getenv('WP_URL', 'https://www.reach4d.jp')
WP_USERNAME = os.getenv('WP_USERNAME', '')
WP_APP_PASSWORD = os.getenv('WP_APP_PASSWORD', '')

def load_article(filename):
    """記事JSONファイルを読み込む"""
    filepath = os.path.join(os.path.dirname(__file__), filename)
    
    if not os.path.exists(filepath):
        print(f"エラー: ファイルが見つかりません - {filepath}", file=sys.stderr)
        sys.exit(1)
    
    with open(filepath, 'r', encoding='utf-8') as f:
        return json.load(f)

def post_to_wordpress(article_data):
    """WordPressに記事を投稿"""
    api_url = f"{WP_URL}/wp-json/wp/v2/posts"
    
    # 投稿データを準備
    post_data = {
        'title': article_data['title'],
        'content': article_data['content'],
        'status': 'publish',  # 公開状態で投稿
        'categories': [],  # 必要に応じてカテゴリーIDを追加
        'tags': [],  # 必要に応じてタグIDを追加
    }
    
    # 認証情報を確認
    if not WP_USERNAME or not WP_APP_PASSWORD:
        print("エラー: WordPress認証情報が設定されていません", file=sys.stderr)
        print("環境変数 WP_USERNAME と WP_APP_PASSWORD を設定してください", file=sys.stderr)
        sys.exit(1)
    
    try:
        # WordPressに投稿
        response = requests.post(
            api_url,
            json=post_data,
            auth=HTTPBasicAuth(WP_USERNAME, WP_APP_PASSWORD),
            timeout=30
        )
        
        response.raise_for_status()
        
        result = response.json()
        return result
    
    except requests.exceptions.RequestException as e:
        print(f"エラー: WordPress投稿に失敗しました - {str(e)}", file=sys.stderr)
        if hasattr(e, 'response') and e.response is not None:
            print(f"レスポンス: {e.response.text}", file=sys.stderr)
        sys.exit(1)

def update_article_status(filename, post_id, post_url):
    """記事JSONファイルのステータスを更新"""
    filepath = os.path.join(os.path.dirname(__file__), filename)
    
    with open(filepath, 'r', encoding='utf-8') as f:
        article_data = json.load(f)
    
    article_data['status'] = 'published'
    article_data['post_id'] = post_id
    article_data['post_url'] = post_url
    article_data['published_at'] = datetime.now().isoformat()
    
    with open(filepath, 'w', encoding='utf-8') as f:
        json.dump(article_data, f, ensure_ascii=False, indent=2)

def main():
    """メイン処理"""
    if len(sys.argv) < 2:
        print("使用方法: python3 post-to-wordpress.py <article_file.json>", file=sys.stderr)
        sys.exit(1)
    
    filename = sys.argv[1]
    
    print("=== WordPress投稿スクリプト ===")
    
    # 1. 記事を読み込む
    print("\n[1/3] 記事を読み込み中...")
    article_data = load_article(filename)
    print(f"  タイトル: {article_data['title']}")
    print(f"  文字数: {len(article_data['content'])}文字")
    
    # 2. WordPressに投稿
    print("\n[2/3] WordPressに投稿中...")
    print(f"  投稿先: {WP_URL}")
    result = post_to_wordpress(article_data)
    print(f"  投稿完了（ID: {result['id']}）")
    
    # 3. ステータスを更新
    print("\n[3/3] 記事ステータスを更新中...")
    update_article_status(filename, result['id'], result['link'])
    print(f"  更新完了")
    
    print("\n=== 投稿が完了しました ===")
    print(f"記事URL: {result['link']}")
    
    return result

if __name__ == '__main__':
    main()
