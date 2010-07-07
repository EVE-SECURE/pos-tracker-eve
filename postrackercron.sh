#!/bin/sh
#cd ~/your_path_to_tracker
cd /home/madhat/sd/pos/www
#/usr/local/bin/php mail.php
/usr/local/bin/php5 cron_updateallianceinfo.php
/usr/local/bin/php5 cron_updatesov.php

