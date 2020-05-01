#Test app

Symfony REST + webpack encore Typescript and Vue.js

Frontend located in assets folder.


#USAGE:

docker-compose up --build -d

docker exec -it app sh -c "./bin/console do:sc:dr --force && ./bin/console do:sc:cr && ./bin/console do:fi:lo --no-interaction"

##build assets

docker exec -it app sh -c "./bin/console assets:install"
docker-compose run --rm encore yarn build

##Access
127.0.0.1/ - app

127.0.0.1/swagger/doc - API (SWAGGER) documentation

#RUN UNIT TESTS

docker exec -it db sh -c "mysql -u root -psymfonypassword -e 'create database symfony_test'"

docker exec -it app sh -c "./bin/console do:sc:dr --force -e test && ./bin/console do:sc:cr -e test"

docker exec -it app sh -c "./bin/phpunit"
