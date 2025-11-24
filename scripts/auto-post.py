#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
自動投稿統合スクリプト
記事生成からWordPress投稿までを一括実行
"""

import sys
import os
import subprocess
import json

def main():
    """メイン処理"""
    print("=" * 50)
    print("AI記事自動投稿システム")
    print("=" * 50)
    
    try:
        # スクリプトのディレクトリに移動
        script_dir = os.path.dirname(os.path.abspath(__file__))
        os.chdir(script_dir)
        
        # 1. 記事を生成
        print("\n【ステップ1】記事生成")
        print("-" * 50)
        result = subprocess.run(
            ['python3', 'generate-article.py'],
            capture_output=True,
            text=True,
            check=True
        )
        print(result.stdout)
        
        # 生成された記事ファイルを取得（最新のarticle_*.jsonファイル）
        article_files = sorted([f for f in os.listdir('.') if f.startswith('article_') and f.endswith('.json')])
        if not article_files:
            raise Exception("記事ファイルが見つかりません")
        
        latest_article = article_files[-1]
        print(f"生成された記事ファイル: {latest_article}")
        
        # 2. WordPressに投稿
        print("\n【ステップ2】WordPress投稿")
        print("-" * 50)
        result = subprocess.run(
            ['python3', 'post-to-wordpress.py', latest_article],
            capture_output=True,
            text=True,
            check=True
        )
        print(result.stdout)
        
        # 投稿結果を取得
        # 記事ファイルから情報を読み取る
        with open(latest_article, 'r', encoding='utf-8') as f:
            article_data = json.load(f)
        
        # 3. 完了報告
        print("\n" + "=" * 50)
        print("✓ すべての処理が完了しました")
        print("=" * 50)
        print(f"記事タイトル: {article_data['title']}")
        print(f"キーワード: {article_data['main_keyword']} × {article_data['sub_keyword']} × {article_data['article_type']}")
        # 文字数を計算
        word_count = len(article_data.get('content', ''))
        print(f"文字数: {word_count}文字")
        if 'post_id' in article_data:
            print(f"投稿ID: {article_data['post_id']}")
        if 'post_url' in article_data:
            print(f"記事URL: {article_data['post_url']}")
        print("=" * 50)
        
        return 0
    
    except subprocess.CalledProcessError as e:
        print(f"\n✗ コマンド実行エラー: {e.cmd}", file=sys.stderr)
        print(f"標準出力: {e.stdout}", file=sys.stderr)
        print(f"標準エラー: {e.stderr}", file=sys.stderr)
        return 1
    
    except Exception as e:
        print(f"\n✗ エラーが発生しました: {str(e)}", file=sys.stderr)
        import traceback
        traceback.print_exc()
        return 1

if __name__ == '__main__':
    sys.exit(main())
