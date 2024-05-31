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

[Laravel Sail](https://laravel.com/docs/11.x/sail#main-content)を使った環境構築を想定しています。
PCはMacを想定していますが、Windowsでも構築可能です。
適宜読み替えて構築してください。

### 1. Docker Desktopの準備

[Docker Desktop](https://www.docker.com/ja-jp/products/docker-desktop/)をインストールして起動しておく

### 2. sailコマンドのエイリアス設定

`~/.bashrc`や`~/.zshrc`に以下のように`alias`登録しておく

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

### 3. プロジェクトの作成

ターミナルで以下コマンドを順に実行

```bash
> git clone git@github.com:maru0914/question-maker.git
> cd question-maker
> bash sail-install.sh
> cp .env.example .env
> sail up -d
> sail artisan key:generate
> sail artisan migrate:fresh --seed
> sail artisan storage:link 
> sail npm install
> sail npm run dev 
```

http://localhost へアクセスして問題集ページが表示されればOK

## テスト実行

```bash
> sail artisan test
```
