# agHome - SF4 Project

Skeleton - Install
========
- composer create-project symfony/skeleton _name_

Base
========
- composer require annotations symfony/security-bundle
- composer require --dev maker profiler sensiolabs/security-checker reqcheck

Test
========
- composer require --dev test-pack

Front
========
- composer require twig asset form symfony/validator

BDD
========
- composer require doctrine
- composer require --dev doctrine/doctrine-fixtures-bundle fzaninotto/faker

Specific
========
- composer require curl/curl
- composer require symfony/swiftmailer-bundle

API
========
- composer require overblog/graphql-bundle
- composer require cors
- composer require --dev overblog/graphiql-bundle

Run
========
chown nobody:nobody -R .
chmod -R 777 .

php -S 192.168.1.17:8000 -t public
php -S 127.0.0.1:8000 -t public