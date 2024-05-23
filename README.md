![ci](https://github.com/maru0914/question-maker/actions/workflows/laravel.yml/badge.svg)


# アプリケーション概要

問題集・問題の作成や問題へのチャレンジができるWebアプリケーション


## 公開URL
https://question-maker.net

## 技術スタック

- バックエンド: [Laravel 11](https://laravel.com/docs/11.x)
- フロント: [Vue.js 3](https://vuejs.org/guide/introduction)
- バックエンド/フロント結合: [Inertia.js](https://inertiajs.com/)
- CSSフレームワーク: [Tailwind CSS](https://tailwindcss.com/)
- PHPテストフレームワーク: [Pest](https://pestphp.com/)
- フロントビルド: [Vite](https://ja.vitejs.dev/)


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

http://question-maker.test/ へアクセスして問題集ページが表示されればOK

## テスト実行

```bash
> php artisan test
```
