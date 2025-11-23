#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
キーワード管理システム
未使用のキーワード組み合わせを選択し、使用済みとして記録する
"""

import json
import random
import os

KEYWORDS_FILE = os.path.join(os.path.dirname(__file__), 'keywords.json')

def load_keywords():
    """keywords.jsonを読み込む"""
    with open(KEYWORDS_FILE, 'r', encoding='utf-8') as f:
        return json.load(f)

def save_keywords(data):
    """keywords.jsonに保存する"""
    with open(KEYWORDS_FILE, 'w', encoding='utf-8') as f:
        json.dump(data, f, ensure_ascii=False, indent=2)

def get_unused_combination():
    """未使用のキーワード組み合わせを取得"""
    data = load_keywords()
    
    main_keywords = data['main_keywords']
    sub_keywords = data['sub_keywords']
    article_types = data['article_types']
    used_combinations = data['used_combinations']
    
    # すべての可能な組み合わせを生成
    all_combinations = []
    for main in main_keywords:
        for sub in sub_keywords:
            for article_type in article_types:
                combination = {
                    'main_keyword': main,
                    'sub_keyword': sub,
                    'article_type': article_type['type'],
                    'title_pattern': article_type['title_pattern']
                }
                # 使用済みでない組み合わせのみ追加
                combination_key = f"{main}_{sub}_{article_type['type']}"
                if combination_key not in used_combinations:
                    all_combinations.append(combination)
    
    if not all_combinations:
        print("警告: すべてのキーワード組み合わせが使用済みです。used_combinationsをリセットします。")
        data['used_combinations'] = []
        save_keywords(data)
        return get_unused_combination()
    
    # ランダムに1つ選択
    selected = random.choice(all_combinations)
    
    # 使用済みとして記録
    combination_key = f"{selected['main_keyword']}_{selected['sub_keyword']}_{selected['article_type']}"
    data['used_combinations'].append(combination_key)
    save_keywords(data)
    
    return selected

def generate_title(combination):
    """タイトルを生成"""
    title = combination['title_pattern'].format(
        main_keyword=combination['main_keyword'],
        sub_keyword=combination['sub_keyword']
    )
    return title

def generate_prompt(combination):
    """AIへのプロンプトを生成"""
    title = generate_title(combination)
    
    prompt = f"""あなたは経験豊富なSEOライターです。以下のタイトルで、高品質なブログ記事を作成してください。

タイトル: {title}

記事の要件:
1. 文字数: 2500文字以上
2. 形式: HTML形式（<h2>, <h3>, <p>, <ul>, <li>などを使用）
3. 構成: 導入→本文（複数セクション）→まとめ
4. SEO対策: キーワード「{combination['main_keyword']}」「{combination['sub_keyword']}」を自然に含める
5. 読者への価値: 実用的で具体的な情報を提供
6. 文体: 親しみやすく、人間味のある自然な文章

注意事項:
- HTMLタグのみを出力してください（<html>, <body>などは不要）
- 見出しは<h2>から始めてください
- 箇条書きは<ul><li>を使用してください
- 段落は<p>タグで囲んでください

それでは、記事の作成をお願いします。"""
    
    return prompt

if __name__ == '__main__':
    # テスト実行
    combination = get_unused_combination()
    print("選択されたキーワード組み合わせ:")
    print(f"  メインキーワード: {combination['main_keyword']}")
    print(f"  サブキーワード: {combination['sub_keyword']}")
    print(f"  記事タイプ: {combination['article_type']}")
    print(f"\n生成されたタイトル:")
    print(f"  {generate_title(combination)}")
    print(f"\n生成されたプロンプト:")
    print(f"  {generate_prompt(combination)[:200]}...")
