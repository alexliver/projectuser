The sqlite DB and .env/.env.testing files are included in the repo, to make setting up easier.

* to install

composer install

I faced error when installing on ec2 linux. Fixed by running:

sudo yum install  php-sodium

* to run the project: 

php artisan serve

* to run the tests: 

php artisan test

* to generate swagger documents:

php artisan l5-swagger:generate

