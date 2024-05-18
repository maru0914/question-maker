![ci](https://github.com/maru0914/question-maker/actions/workflows/laravel.yml/badge.svg)

## 環境構築

- [Laravel Herd](https://herd.laravel.com/)をインストール
- `~/Herd`で`git clone`

```bash
> cd question-maker

> cp .env.example .env

> composer install

> php artisan key:generate

> php artisan migrate fresh --seed

> npm install
```

## 起動

```bash
> npm run dev
```

http://question-maker.test/ へアクセス

## テスト実行

```bash
> php artisan test
```
