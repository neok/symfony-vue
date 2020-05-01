./bin/console do:sc:cr
./bin/console doctrine:fixtures:load
docker exec -it db sh -c "mysql -u root -psymfonypassword -e 'create database symfony_test'"
./bin/console do:sc:cr -e test
