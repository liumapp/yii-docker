# yii-docker
Yii2的一个项目案例，用于演示在Docker环境（整合Nginx和Mysql）下如何运行Yii项目  A project example , which's backend using Yii2 and frontend using Vue2.0, demonstrating how to run Yii projects in Docker environment (integrating Nginx and Mysql).


docker logs -t -f --tail 100 php5.6

docker exec -it php5.6 /bin/bash

cd ./www/demo

./composer.phar update

zip -r ../yii-docker.zip ../yii-docker/*
