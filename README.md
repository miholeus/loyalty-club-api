api
===

A Symfony project created on July 27, 2017, 9:19 am.

Testing
===

* createuser `zenomania_test`
* Set permissions to user
`psql -c "alter role zenomania_test with createdb" -d test`
* Run command 
`bin/console doctrine:database:create --env=test`
* Run migrations
`bin/console doctrine:migrations:migrate --env=test`
* Run fixtures command
`bin/console doctrine:fixtures:load --env=test`
* Run unit tests
`phpunit -c .`