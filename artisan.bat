@echo off
REM Script helper para ejecutar artisan sin warnings de PHP
php -d display_startup_errors=off -d error_reporting=E_ERROR %*
