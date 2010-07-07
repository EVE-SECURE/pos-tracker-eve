POS-Tracker Installation
--------------------------------------------

You must already have a MYSQL database.

Edit the eveconfig/config.php and eveconfig/dbconfig.php files
Upload to your host
Visit http://YOURPOSTRACKERURL/install.php
Follow the steps of the installation.

Delete the install.php file


By default, the installation creates an admin user.
Register your Character in-game and give that character access via the administration.






$Id: README.txt 51 2008-06-30 14:31:03Z eveoneway $


DEPRECATED! 3.x is not compatible with 2.x

Notes:
--------------------------------------------
Install Script does not take into account user-defined prefix, please use the defualt pos2_ or replace the pos2_ prefix with your own in the .sql files
Password.php file has changed, do not overwrite when upgrading if you have a working installation. If overwritten, all user accounts will need to be re-added.



POS-Tracker 2.1.0 Installation Instructions
--------------------------------------------

Step 1. Download and unpackage the files.

Step 2. Edit Config.dist.php and save as config.php
define('SQL_HOST','hostname'); #replace hostname with your database host name. This is usually localhost
define('SQL_USER','username'); #Database username
define('SQL_PASS','password'); # Database password
define('SQL_DB','database'); # Database to use (e.g. pos_tracker)
define('TBL_PREFIX', 'pos2_'); #Needs to be pos2_ if you do not edit the .sql files to reflect change.
define('REDIRECT_PATH', 'http://'.$_SERVER['HTTP_HOST'].'/pos/'); #Path to your postracker

There are other optional settings found in config.php

Step 3. Edit header.php, mail.php, postrackercron.sh, and poscron.sh

Step 4. Upload the tracker files.

Step 5. Browse to www.yourserver.com/postrackerpath/install/install.php It will display your database information and server information.
	Comfirm settings and PHP version 5.1.2 or greater with CURL, SimpleXML, Hash. Click Next to advance to the next step.

Step 6. The next page will create 23 tables in your database and populate the database. 
	Enter an email address and password to create an admin account and click 'Next' to continue.

Step 7. Comfirm that you have uploaded the correct .sql file(s) for the region your moons are in and click 'Install' next to the region your moons are in.

Step 6. Remove all the files in the /install subdirectory.
	If you want to install more moons at a later date, you will need to upload install3.php to the /install subdirectory with the approperate .sql file for the region.
	You can also us remove moons from the database using this page.

Step 7. (Optional) Create a cronjob pointed to postrackercron.sh and have it run at least every 24 hours for the AutoSov©, Mail Alert, and Alliance-Update. AutoSov© and Alliance Update will warn every 7 days if not updated.
	Create a second cronjob pointed to poscron.sh to update starbases using the eveapi.

Step 8. (Optional) Login to the tracker and browse to the Admin pannel. Click the Add API button.
	Enter the Full Access API key for a character that has the role director or CEO in the corporation for the starbases you want to track.
	Click the 'Select Character' button next to the approperate character then 'Done'. Note: Only one Key per corporation is needed.

Updated 30 January 2008, REV 116