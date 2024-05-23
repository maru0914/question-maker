![ci](https://github.com/maru0914/question-maker/actions/workflows/laravel.yml/badge.svg)

# Question-Maker 

## アプリケーション概要

問題集・問題の作成や問題へのチャレンジができるWebアプリケーション

## 機能例

### 作成された問題集の確認

<img src="https://github.com/maru0914/question-maker/assets/56859729/b0017bb3-0a81-480d-a041-59823c154678" width=600px>


### 問題集へチャレンジ

<img src="https://github.com/maru0914/question-maker/assets/56859729/0b57b587-db5a-450c-bb68-bcfa6fe6d0e1" width=600px>


### チャレンジ結果の管理

<img src="https://github.com/maru0914/question-maker/assets/56859729/3197cde8-0fe3-4702-9daf-e6c0d36126ee" width=600px>


## 公開URL
https://question-maker.net

## 技術スタック

- バックエンド: [Laravel 11](https://laravel.com/docs/11.x)
- フロント: [Vue.js 3](https://vuejs.org/guide/introduction)
- バックエンド/フロント結合: [Inertia.js](https://inertiajs.com/)
- CSSフレームワーク: [Tailwind CSS](https://tailwindcss.com/)
- PHPテストフレームワーク: [Pest](https://pestphp.com/)
- フロントビルド: [Vite](https://ja.vitejs.dev/)
- CI/CD: [GitHub Actions](https://docs.github.com/ja/actions)


## 開発環境構築

- [Laravel Herd](https://herd.laravel.com/)をインストール
- `~/Herd`で`git clone`

```bash
> cd question-maker

> cp .env.example .env

> composer install

> php artisan key:generate

> php artisan migrate fresh --seed // プロンプトでデータベースの作成を選択

> npm install

> npm run dev // 初回構築時に限らず、開発時は常に実行しておく
```

http://question-maker.test へアクセスして問題集ページが表示されればOK

## テスト実行

```bash
> php artisan test
```
