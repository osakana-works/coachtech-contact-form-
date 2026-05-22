# COACHTECH お問い合わせフォーム

○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

## 作成者

山口 琴音

## 使用技術

- ○○○○○ NN.NN
- ○○○○○ NN.NN
- ○○○○○ NN.NN
- ○○○○○ NN.NN
- ○○○○○ NN.NN

## ER図

```mermaid
erDiagram

    USERS {
        bigint_unsigned id PK
        varchar_255 name
        varchar_255 email UK
        timestamp email_verified_at "nullable"
        varchar_255 password
        varchar_100 remember_token "nullable"
        timestamp created_at
        timestamp updated_at
    }

    CATEGORIES {
        bigint_unsigned id PK
        varchar_255 content
        timestamp created_at
        timestamp updated_at
    }

    CONTACTS {
        bigint_unsigned id PK
        bigint_unsigned category_id FK
        varchar_255 first_name
        varchar_255 last_name
        tinyint gender "1:男性 2:女性 3:その他"
        varchar_255 email
        varchar_11 tel "ハイフンなし"
        varchar_255 address
        varchar_255 building "nullable"
        varchar_120 detail
        timestamp created_at
        timestamp updated_at
    }

    TAGS {
        bigint_unsigned id PK
        varchar_50 name UK
        timestamp created_at
        timestamp updated_at
    }

    CONTACT_TAG {
        bigint_unsigned id PK
        bigint_unsigned contact_id FK
        bigint_unsigned tag_id FK
        timestamp created_at
        timestamp updated_at
    }

    %% リレーション
    CATEGORIES ||--o{ CONTACTS : "has many (CASCADE)"
    CONTACTS ||--o{ CONTACT_TAG : "has many (CASCADE)"
    TAGS ||--o{ CONTACT_TAG : "has many (CASCADE)"
```


## 開発環境URL

http://○○○○○

## 動作環境

○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

## 環境構築手順

1. **リポジトリをクローン**

    ```bash
    git clone https://○○○○○○
    ```

2. **.envファイルの準備**

    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

3. **Composer依存パッケージのインストール**

    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

4. **Laravel Sailの起動**

    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

5. **アプリケーションキーの生成**

    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

6. **データベースのマイグレーションと初期データ投入**

    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

7. **フロントエンドのビルド**

    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

8. **アプリケーションへのアクセス**

    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
    ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

## テスト実行

○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○  
○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

## 機能一覧

- ○○○○○○ ○○○○○○
- ○○○○○○ ○○○○○○
- ○○○○○○ ○○○○○○
- ○○○○○○ ○○○○○○
- ○○○○○○ ○○○○○○
- ○○○○○○ ○○○○○○

## APIエンドポイント一覧

○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○ ○○○○○○

| HTTPメソッド | URI | 概要 |
|---|---|---|
| GET | /○○○○○○/○○○○○○/○○○○○○ | ○○○○○○ |
| GET | /○○○○○○/○○○○○○/○○○○○○ | ○○○○○○ |
| GET | /○○○○○○/○○○○○○/○○○○○○ | ○○○○○○ |
| GET | /○○○○○○/○○○○○○/○○○○○○ | ○○○○○○ |
| GET | /○○○○○○/○○○○○○/○○○○○○ | ○○○○○○ |
