#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
自動投稿統合スクリプト
記事生成からWordPress投稿までを一括実行
"""

import sys
import os

# 同じディレクトリのスクリプトをインポート
sys.path.insert(0, os.path.dirname(__file__))

from generate_article import main as generate_article
from post_to_wordpress import main as post_to_wordpress

def main():
    """メイン処理"""
    print("=" * 50)
    print("AI記事自動投稿システム")
    print("=" * 50)
    
    try:
        # 1. 記事を生成
        print("\n【ステップ1】記事生成")
        print("-" * 50)
        article_file = generate_article()
        article_filename = os.path.basename(article_file)
        
        # 2. WordPressに投稿
        print("\n【ステップ2】WordPress投稿")
        print("-" * 50)
        sys.argv = ['post-to-wordpress.py', article_filename]
        result = post_to_wordpress()
        
        # 3. 完了報告
        print("\n" + "=" * 50)
        print("✓ すべての処理が完了しました")
        print("=" * 50)
        print(f"記事タイトル: {result['title']['rendered']}")
        print(f"記事URL: {result['link']}")
        print(f"投稿ID: {result['id']}")
        print("=" * 50)
        
        return 0
    
    except Exception as e:
        print(f"\n✗ エラーが発生しました: {str(e)}", file=sys.stderr)
        return 1

if __name__ == '__main__':
    sys.exit(main())
