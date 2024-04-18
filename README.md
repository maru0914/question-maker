![ci](https://github.com/maru0914/question-maker/actions/workflows/laravel.yml/badge.svg)

## 環境構築

- Laravel Herdをインストール
- `~/Herd`で`git clone`
- `.env.example`

```bash
> cp .env.example .env

> composer install

> php artisan key:generate

> php artisan migrate --seed

> npm install
```

## 起動

```bash
> npm run dev
```

http://question-maker.test/ へGO!

## テスト

```bash
> php artisan test
```
