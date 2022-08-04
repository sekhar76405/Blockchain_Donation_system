This is the final version of the code that can be run on localhost with 
already setup environment of Xampp server along with sql tables inside it.

Note: 
1. this version will connect to localhost sql DB with username, pass, DB name listed in config.php
2. the donate now button will display posts that are exsisting in realtime using sql query.
3. Remember to connect the metamask from register pager before doing transactions, automatic connection with metamask before donating money is not yet implemented


Additonal Points:
If you are planning to deploy this to any server, here are some points to keep in mind:
1. You will have to setup the entire environment of sql and its tables and remeber to update the info in config.php, 
   to achieve this you can use the DB_script.sql script file with all the sql commands.
2. 