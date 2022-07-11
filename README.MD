# Crawler

## Requirements
- PHP 7.4
- Composer
- Redis Server


## Install

Install Composer packages

    composer install

Create & change your .env file

    cd src
    cp .env.example .env

**.env.example** file contains all settings that you need to run parser but script uses **.env** file. So just copy it and update with you settings.


## Run script

This command is used to run script from scratch

    php parser.php init

Notice: If you want to use filter for zipcodes then use **byZip** instead of **init** as parametr for parser.php. Change zipcodes.json for specify zipcodes.

If you need to restart script please use this command

    php parser.php

Notice: If you want to run script in the background mode you can use **nohup** tools for it.

    nohup php parser.php &

You can schedule you script with cronjob. Make sure that the script has enough time to grab all records within the time range set. If the command will restart script before the end of the previous session, the processes will overlap, and the limit of allowed threads in StormProxies will be reached and it will be blocked. If the command will start from scratch, the queue of urls in Redis will be cleaned up before the session starts. 

## The command for checking records:
    php parser.php deletions

This command checks existing record for availability on the original site and marks it as deleted if the link is not available on the site anymore.

