#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
AI記事生成スクリプト
OpenAI APIを使用してブログ記事を生成する
"""

import os
import sys
import json
from datetime import datetime
from openai import OpenAI

# 同じディレクトリのスクリプトをインポート
import importlib.util
import os as os_module

spec = importlib.util.spec_from_file_location("keyword_manager", os.path.join(os.path.dirname(__file__), "keyword-manager.py"))
keyword_manager = importlib.util.module_from_spec(spec)
spec.loader.exec_module(keyword_manager)

get_unused_combination = keyword_manager.get_unused_combination
generate_title = keyword_manager.generate_title
generate_prompt = keyword_manager.generate_prompt

# OpenAI APIクライアントの初期化（環境変数から自動設定）
client = OpenAI()

def generate_article_with_ai(prompt, model="gpt-4.1-mini"):
    """OpenAI APIを使用して記事を生成"""
    import time
    
    max_retries = 3
    retry_delay = 5
    
    for attempt in range(max_retries):
        try:
            print(f"  API呼び出し試行 {attempt + 1}/{max_retries}...", file=sys.stderr)
            
            response = client.chat.completions.create(
                model=model,
                messages=[
                    {
                        "role": "system",
                        "content": "あなたは経験豊富なSEOライターです。読者に価値を提供する高品質な記事を作成します。"
                    },
                    {
                        "role": "user",
                        "content": prompt
                    }
                ],
                temperature=0.7,
                max_tokens=4000,
                timeout=60.0
            )
            
            content = response.choices[0].message.content
            print(f"  API呼び出し成功", file=sys.stderr)
            return content
        
        except Exception as e:
            error_msg = str(e)
            print(f"  エラー ({attempt + 1}/{max_retries}): {error_msg}", file=sys.stderr)
            
            if attempt < max_retries - 1:
                print(f"  {retry_delay}秒後に再試行します...", file=sys.stderr)
                time.sleep(retry_delay)
            else:
                print(f"\nエラー: AI記事生成に失敗しました - {error_msg}", file=sys.stderr)
                print(f"\nデバッグ情報:", file=sys.stderr)
                print(f"  OPENAI_API_KEYの長さ: {len(os.getenv('OPENAI_API_KEY', ''))}", file=sys.stderr)
                print(f"  使用モデル: {model}", file=sys.stderr)
                import traceback
                traceback.print_exc()
                sys.exit(1)

def save_article(title, content, combination):
    """生成した記事をJSONファイルとして保存"""
    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
    filename = f"article_{timestamp}.json"
    filepath = os.path.join(os.path.dirname(__file__), filename)
    
    article_data = {
        'title': title,
        'content': content,
        'main_keyword': combination['main_keyword'],
        'sub_keyword': combination['sub_keyword'],
        'article_type': combination['article_type'],
        'generated_at': datetime.now().isoformat(),
        'status': 'draft'
    }
    
    with open(filepath, 'w', encoding='utf-8') as f:
        json.dump(article_data, f, ensure_ascii=False, indent=2)
    
    return filepath

def main():
    """メイン処理"""
    print("=== AI記事生成スクリプト ===")
    
    # 1. 未使用のキーワード組み合わせを取得
    print("\n[1/4] キーワード組み合わせを選択中...")
    combination = get_unused_combination()
    print(f"  メインキーワード: {combination['main_keyword']}")
    print(f"  サブキーワード: {combination['sub_keyword']}")
    print(f"  記事タイプ: {combination['article_type']}")
    
    # 2. タイトルとプロンプトを生成
    print("\n[2/4] タイトルとプロンプトを生成中...")
    title = generate_title(combination)
    prompt = generate_prompt(combination)
    print(f"  タイトル: {title}")
    
    # 3. AIで記事を生成
    print("\n[3/4] AIで記事を生成中...")
    print("  ※ この処理には数十秒かかる場合があります")
    content = generate_article_with_ai(prompt)
    print(f"  生成完了（文字数: {len(content)}文字）")
    
    # 4. 記事を保存
    print("\n[4/4] 記事を保存中...")
    filepath = save_article(title, content, combination)
    print(f"  保存完了: {filepath}")
    
    print("\n=== 記事生成が完了しました ===")
    print(f"次のステップ: python3 post-to-wordpress.py {os.path.basename(filepath)}")
    
    return filepath

if __name__ == '__main__':
    main()
