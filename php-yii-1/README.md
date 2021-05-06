# PHP Agent and yii 1 Reproduction

This repo contains a Dockerfile that will build an apache/mod_php/MySQL envionrmnt and install a simple yii application that reads/writes information to/from a database.  It's intent is to confirm that, under normal operation, the agent is not leaking memory with yii and MySQL via PDO. 

## To Use

To use this repository, you will need to 

0. Configure a php.ini for the PHP APM Agent
1. Build the docker image
2. Run the docker image
3. Shell into the running docker image in order to run top
4. Exercise the application's endpoints

### Configure Credentials

To configure your APM Credentials, copy the `php.ini.dist` file and then add your own credentials.

    $ cp html/php.ini.dist html/php.ini
    
    $ cat html/php.ini.dist
    elastic_apm.server_url='... apm server url ...'
    elastic_apm.secret_token='... apm secret token ...'
    elastic_apm.service_name='Test Yii Application'
    
The docker build step will copy this file to the correct directory.

### Build and Run your Docker Image

To build and tag your docker image, run the following    

    $ docker build . -t php-repro

After building your image, you can run it with the following

    $ docker run -p 8080:80 php-repro
    
After running the above the current terminal window will be tailing the apache log.  If you open a second terminal window you should be able to access the installed PHP/yii application via port `8080`. 

    $ curl http://localhost:8080/    
    $ curl http://localhost:8080/yii-1.1.23.445827/testdrive/index.php
    
### Monitor Memory use via top

The easiest way to monitor memory use in the container by shelling in and running `top`

    # get the ID of your running container
    $ docker ps | grep php-repro       
    cf3ed4f00166   php-repro ...
    
    # shell in using the container id (cf3ed4f00166 above, yours will be different)     
    $ docker exec -it cf3ed4f00166 bash

    # once shelled in, run top and look at the free memory number
    root@cf3ed4f00166:/# top
    top - 23:27:35 up 9 days,  2:09,  0 users,  load average: 0.88, 0.93, 0.83
    Tasks:  17 total,   1 running,  16 sleeping,   0 stopped,   0 zombie
    %Cpu(s):  8.8 us,  6.3 sy,  0.0 ni, 83.8 id,  1.0 wa,  0.0 hi,  0.0 si,  0.0 st
    KiB Mem :  3066488 total,    82688 free,  2774328 used,   209472 buff/cache
    KiB Swap:  1572860 total,        0 free,  1572860 used.    96768 avail Mem 

### Exercise the Endpoints

This repo contains a small bash script that will exercise a few data creating/fetching/updating/deleting endpoints over and over until a requests fails due to an error. 

    ./bin/curl-until-fail.bash
    //...

**IMPORTANT** -- if you're using a port other than `8080`, be sure to update the URLs in `./bin/curl-until-fail.bash`.

