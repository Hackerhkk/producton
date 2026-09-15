# Laravel Admin - Deployment Guide

## Hostinger Cron Job

Command:
php /home/USERNAME/domains/YOURDOMAIN/public_html/artisan schedule:run

Frequency:
Every Minute

## Laravel Scheduler

routes/console.php

Schedule::command('fees:process')
    ->dailyAt('09:00');

## Fee Processing

Command:
php artisan fees:process

Purpose:
Automatically deduct student fees from wallet.

## Local Testing

php artisan schedule:work