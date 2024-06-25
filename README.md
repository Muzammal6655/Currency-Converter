<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Task

I used the Laravel framework to complete this task, utilizing the Fixer.io exchange rate API. Since I'm using the unpaid version of the API, I set the base currency to Euro and used it to calculate the exchange rates for other currencies. The application is a currency converter built with PHP and Laravel.

## File structure
- currency_converter.blade.php inside the resources/view is used for frontend 
- CurrencyController app/Http/Controller/CurrencyController is used to call the APi and conversions main code controller.
- web.php is router file routes/web.ph
- I used an AJAX call with JavaScript, and the code is inside the currency_controller.php file. I did not use a separate file for JavaScript because it's a single-page application, so I defined the JavaScript at the bottom of the file. 
- .env file is used to define FIXER_API_KEY
- jquery 3.6.0
- bootstrap 4.5.2 with CDN link