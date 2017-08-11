Zenomania
===
Zenomania API

Installation
===
Run docker
* `docker-compose up -d`
* Apply migrations
`bin/console doctrine:migrations:migrate`
* Run fixtures command
`bin/console doctrine:fixtures:load`

Testing
===

* Create user `createuser zenomania_test`
* Set permissions to user
`psql -c "alter role zenomania_test with createdb" -d test`
* Run command 
`bin/console doctrine:database:create --env=test`
* Apply migrations
`bin/console doctrine:migrations:migrate --env=test`
* Run fixtures command
`bin/console doctrine:fixtures:load --env=test`
* Run unit tests
`phpunit -c .`