<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## TP - Quizz

> Membres : Romain MOLINA & Dimitri ROMANO

# 1. Installation back

- composer : `composer install`

# 2. Installation Front

- Installation packages : `npm install`
- Lancement du front : `npm run dev`

[![Image](https://i.goopics.net/r91as8.png)](https://goopics.net/i/r91as8)

- Remplacer BASE_URL par votre URL d'API

# 3. Database

- `php artisan migrate:fresh`

# 4. Middleware

## IsAdmin

Ce middleware permet de vérifier qu'un utilisateur est administrateur, cela permet par exemple de publier ou non des quizz ainsi que de les modifiers et les créer.

## IsLoggedIn

Ce middleware permet de vérifier qu'un utilisateur est connecté ce qui lui permet de répondre à un quiz par exemple

# 5. Code of Conduct

## Security Vulnerabilities

## License
