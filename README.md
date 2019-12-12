# EP0 


## 日本語
------
Laravelフレームワークを使用して、脆弱性を作り込んだプロジェクト
演習などに


EP1 などは製作中


### 想定脆弱性
・ XSS
・ SQLi


## 環境
1. PHP 7.x  
2. Mariadb or MySQL

## Install
```
cd project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install

