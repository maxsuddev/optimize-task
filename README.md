

git clone git@github.com:maxsuddev/optimize-task.git || https://github.com/maxsuddev/optimize-task.git

cd optimize-task

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

yarn install
yarn build

php artisan serve

php artisan test


