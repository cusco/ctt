CTT database with Lat Lng
===

#### update: upon much requested, added a csv export: https://github.com/cusco/ctt/raw/master/ctt-lat-lng-csv.zip
#### this file already has the scanned address and found address viaq google.
___

ctt postal codes into MySQL with latitude and longitude from google


external - files downloaded from CTT ( http://www.ctt.pt/feapl_2/app/restricted/postalCodeSearch/feapl_2_31-postalCodeDownloadFiles.jspx )

basically:
- download files from http://www.ctt.pt/feapl_2/app/restricted/postalCodeSearch/feapl_2_31-postalCodeDownloadFiles.jspx
- put them in the folder external
- create database, user, password in MySQL
- change user/password in import.php and getGeo.php
- run php -q import.php
- run php -q updateGeo.php (this is slow.. and is restricted to 2500 (google limit per day?))

updateGeo.php uses google to get latitude and longitude.

Google has some daily usage restrictions ..
There is a piece of code commented to use a different IP when the limit is reached (in my case I have several internal IP's on the operating system, that will be NAT'ed to different public IP's)

You will have to run getGeo.php several times until your table is populated, or remove the initial select limit.


*new* - added file CTT.sql which contains structure and data generated from these scripts. This is probably what everybody wants.

*new* - updated CTT.sql with new latitudes and longitudes based on feedback from: http://www.portugal-a-programar.pt/forums/topic/74313-pesquisa-por-latitude-e-longitude-por-c%C3%B3digos-postais/?do=findComment&comment=599669
