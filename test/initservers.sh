php -S localhost:3000 website.php > ./website-log 2>&1 &
php -S localhost:3001 laravelWebsite.php  > ./laravelWebsite-log 2>&1 &
php -S localhost:3002 symfonyWebsite.php > ./symfonyWebsite-log 2>&1 &
