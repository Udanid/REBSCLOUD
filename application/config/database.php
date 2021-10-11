<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/
/*$efg="";
$data = explode('.',$_SERVER['SERVER_NAME']);
if (!empty($data[0])) {
    $efg = $data[0];
}
echo  $efg=1;
$dbh = new PDO('mysql:host=localhost;dbname=inventory_conn', 'root', '');

$sql = "SELECT database FROM userdata WHERE  id=?";

$sth = $dbh->prepare($sql);
$sth->execute(array($efg));
$d_result= $sth->fetchAll(PDO::FETCH_ASSOC);*/
//print_r($d_result[0]);





//echo $id;
$active_group = 'default';
$active_record = TRUE;
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = '';
$db['default']['database'] = 'beiterp';
//$db['default']['database'] = 'metrocredits_down';

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */











$db['ASD0001']['hostname'] = 'localhost';
$db['ASD0001']['username'] = 'root';
$db['ASD0001']['password'] = '';
$db['ASD0001']['database'] = 'asd0001';
$db['ASD0001']['dbdriver'] = 'mysqli';
$db['ASD0001']['dbprefix'] = '';
$db['ASD0001']['pconnect'] = TRUE;
$db['ASD0001']['db_debug'] = TRUE;
$db['ASD0001']['cache_on'] = FALSE;
$db['ASD0001']['cachedir'] = '';
$db['ASD0001']['char_set'] = 'utf8';
$db['ASD0001']['dbcollat'] = 'utf8_general_ci';
$db['ASD0001']['swap_pre'] = '';
$db['ASD0001']['autoinit'] = TRUE;
$db['ASD0001']['stricton'] = FALSE;





$db['ALM09002']['hostname'] = 'localhost';
$db['ALM09002']['username'] = 'root';
$db['ALM09002']['password'] = '';
$db['ALM09002']['database'] = 'alm09002';
$db['ALM09002']['dbdriver'] = 'mysqli';
$db['ALM09002']['dbprefix'] = '';
$db['ALM09002']['pconnect'] = TRUE;
$db['ALM09002']['db_debug'] = TRUE;
$db['ALM09002']['cache_on'] = FALSE;
$db['ALM09002']['cachedir'] = '';
$db['ALM09002']['char_set'] = 'utf8';
$db['ALM09002']['dbcollat'] = 'utf8_general_ci';
$db['ALM09002']['swap_pre'] = '';
$db['ALM09002']['autoinit'] = TRUE;
$db['ALM09002']['stricton'] = FALSE;



$db['SMD0001']['hostname'] = 'localhost';
$db['SMD0001']['username'] = 'root';
$db['SMD0001']['password'] = '';
$db['SMD0001']['database'] = 'smd0001';
$db['SMD0001']['dbdriver'] = 'mysqli';
$db['SMD0001']['dbprefix'] = '';
$db['SMD0001']['pconnect'] = TRUE;
$db['SMD0001']['db_debug'] = TRUE;
$db['SMD0001']['cache_on'] = FALSE;
$db['SMD0001']['cachedir'] = '';
$db['SMD0001']['char_set'] = 'utf8';
$db['SMD0001']['dbcollat'] = 'utf8_general_ci';
$db['SMD0001']['swap_pre'] = '';
$db['SMD0001']['autoinit'] = TRUE;
$db['SMD0001']['stricton'] = FALSE;



$db['ASD0002']['hostname'] = 'localhost';
$db['ASD0002']['username'] = 'root';
$db['ASD0002']['password'] = '';
$db['ASD0002']['database'] = 'asd0002';
$db['ASD0002']['dbdriver'] = 'mysqli';
$db['ASD0002']['dbprefix'] = '';
$db['ASD0002']['pconnect'] = TRUE;
$db['ASD0002']['db_debug'] = TRUE;
$db['ASD0002']['cache_on'] = FALSE;
$db['ASD0002']['cachedir'] = '';
$db['ASD0002']['char_set'] = 'utf8';
$db['ASD0002']['dbcollat'] = 'utf8_general_ci';
$db['ASD0002']['swap_pre'] = '';
$db['ASD0002']['autoinit'] = TRUE;
$db['ASD0002']['stricton'] = FALSE;



$db['NAL0721']['hostname'] = 'localhost';
$db['NAL0721']['username'] = 'root';
$db['NAL0721']['password'] = '';
$db['NAL0721']['database'] = 'nal0721';
$db['NAL0721']['dbdriver'] = 'mysqli';
$db['NAL0721']['dbprefix'] = '';
$db['NAL0721']['pconnect'] = TRUE;
$db['NAL0721']['db_debug'] = TRUE;
$db['NAL0721']['cache_on'] = FALSE;
$db['NAL0721']['cachedir'] = '';
$db['NAL0721']['char_set'] = 'utf8';
$db['NAL0721']['dbcollat'] = 'utf8_general_ci';
$db['NAL0721']['swap_pre'] = '';
$db['NAL0721']['autoinit'] = TRUE;
$db['NAL0721']['stricton'] = FALSE;

