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
        bigint id PK
        string name
        string email UNIQUE
        timestamp email_verified_at
        string password
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    CATEGORIES {
        bigint id PK
        string content
        timestamp created_at
        timestamp updated_at
    }

    CONTACTS {
        bigint id PK
        bigint category_id FK
        string first_name
        string last_name
        tinyint gender
        string email
        string tel
        string address
        string building
        string detail
        timestamp created_at
        timestamp updated_at
    }

    TAGS {
        bigint id PK
        string name UNIQUE
        timestamp created_at
        timestamp updated_at
    }

    CONTACT_TAG {
        bigint id PK
        bigint contact_id FK
        bigint tag_id FK
        timestamp created_at
        timestamp updated_at
    }

    %% リレーション
    CATEGORIES ||--o{ CONTACTS : "has many"
    CONTACTS ||--o{ CONTACT_TAG : ""
    TAGS ||--o{ CONTACT_TAG : ""
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
