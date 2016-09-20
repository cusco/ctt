ctt
===

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

You will have to run getGeo.php several times until your table is populated.


* new - added file CTT.sql which contains structure and data generated from these scripts. This is probably what everybody wants.
