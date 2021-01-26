#!/bin/sh

echo "Composer install"
composer install --no-interaction

echo "Database creation"
php bin/console doctrine:database:create --if-not-exists

echo "Updating database"
php bin/console doctrine:schema:update --force

echo "clearing cache"
php bin/console cache:clear --no-warmup

echo "Creating user.."
php bin/console app:create-user