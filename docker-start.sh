#!/bin/bash
L_GREEN='\033[1;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

git --version

read -p "Git Branch Name (default: develop): " BRANCH_NAME
if [ "${BRANCH_NAME}" == "" ]; then
    BRANCH_NAME=develop
fi

# Update remote repository
MGS_FETCH=`git fetch 2>&1 `
if [[ $MGS_FETCH == *"fatal:"* ]]; then
  echo -e "${RED}${MGS_FETCH}${NC}";
  exit 0;
fi

MGS=`git switch ${BRANCH_NAME} 2>&1 `
# Check branch_name is correct
if [[ $MGS == *"fatal:"* ]]; then
  echo -e "${RED}${MGS}${NC}";
  exit 0;
fi

# Pull
echo -e "${L_GREEN}Pull from branch ${BRANCH_NAME}${NC}"
MGS_PULL=`git pull 2>&1 `
echo -e "${MGS_PULL}"
if [[ $MGS_PULL == *"fatal:"* ]]; then
  echo -e "${RED}${MGS_PULL}${NC}";
  exit 0;
fi

# Choose docker service
LIST=("nhs-ihs-admin exit")
echo -e "${L_GREEN}Please choose docker service: ?${NC}"
select docker_service in $LIST
do
  if [ "$docker_service" == "" ]; then
    echo -e "${RED}Please choose!!!${NC}";
  else
    break
  fi
done

if [ "$docker_service" = "exit" ]; then
    exit 0;
fi

# remove <none> images
docker rmi $(docker images --filter "dangling=true" -q --no-trunc) 2>/dev/null

# start docker
docker-compose up --build -d ${docker_service}

# start crontab
echo -e "${L_GREEN} Starting cron... ${NC}"
docker exec ${docker_service} crontab /var/www/html/docker/cron/batch
docker exec --user root ${docker_service} service cron start

# run pm2 to start queue worker
docker exec ${docker_service} pm2 start /var/www/html/docker/pm2/pm2-queue-worker.yml
