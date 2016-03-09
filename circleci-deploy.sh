#!/usr/bin/env bash

echo " "
echo "Pulling Latest Changes"
ssh $DEPLOY_USER@$DEPLOY_HOST "cd ~/Class/CSC190; git reset --hard HEAD; git pull --rebase origin master"

echo " "
echo "Docker-compose pulling"
ssh $DEPLOY_USER@$DEPLOY_HOST "cd ~/Class/CSC190/source/backend; docker-compose pull"

echo " "
echo "Docker-compose running"
ssh $DEPLOY_USER@$DEPLOY_HOST "cd ~/Class/CSC190/source/backend; docker-compose build; MYSQLPASS=$DEPLOY_MYSQL_PASS docker-compose up -d"