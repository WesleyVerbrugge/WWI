<?php
 $config = [
   "database" => array(
     "driver"   => "mysql",
     "host"     => "localhost",
     "username" => "root",
     "password" => "",
     "dbname"   => "wideworldimporters"
   )
 ];
 final class Database {
   private static $instance = null;
   public $db;
   private function __construct() {
     global $config;
     try {
       $dsn = sprintf("%s:hostname=%s;dbname=%s;", $config["database"]["driver"],
                                                   $config["database"]["host"],
                                                   $config["database"]["dbname"]);
       $this->db = new PDO($dsn, $config["database"]["username"], $config["database"]["password"]);
       $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
       $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
     } catch(PDOException $e) {
       exit("Error: " . $e->getMessage());
     }
   }
   public static function getDb() {
     if(is_null(Database::$instance)) Database::$instance = new Database();
     return Database::$instance->db;
   }
 }
 /*
<?php
 Gebruik verwijder wanneer je het gaat gebruiken//
Je gebruikt 'prepare' bij wanneer je bijvoorbeeld een textveld van een user in de database wil hebben
Of wanneer je een WHERE doet.
$q = Database::getDb()->prepare("SELECT * FROM table_name WHERE column_one = ? AND column_two =?");
$q->execute([$variable1, $variable2]);
 
Je gebruikt 'fetchAll' als je weet dat je meerdere dingen op haalt of als je het later in een -
foreach gaat doen.
$q = $q->fetchAll(PDO::FETCH_OBJ);
Je gebruikt 'fetch' wanneer je weet dat je 1 ding ophaald.
$q = $q->fetch(PDO::FETCH_OBJ);
 
insert voorbeeld bij insert GEEN FETCH je haald niets op :)
$q = Database::getDb()->prepare("INSERT INTO table_name (column_one, column_two) VALUES (?,?)");
$q->execute([$variable1, $variable2]);


 
Wat er gebeurd (DOE DIT NIET ZO, DIT IS EEN VOORBEELD HOE DE CODE HET DOET)
Dit is het resultaat nadat de execute gedaan is
$q = Database::getDb()->prepare("INSERT INTO table_name (column_one, column_two) VALUES ($variable1,$variable2)");
 
Je gebruikt 'query' wanneer je geen WHERE hoeft te doen. bijvoorbeeld alles uit een table.
Query is ook sneller dan prepare want hij hoeft geen dingen in de query te zetten.
$q = Database::getDb()->query("SELECT * FROM table_name");
$q = $q->fetchAll(PDO::FETCH_OBJ);
 
Als je het in een functie doet
return $q->fetchAll(PDO::FETCH_OBJ);
inplaats van
$q = $q->fetchAll(PDO::FETCH_OBJ);
return $q;
Het is gewoon sneller
 
Voorbeelden zonder comments
 
$q = Database::getDb()->prepare("SELECT * FROM table_name WHERE column_one = ? AND column_two =?");
$q->execute([$variable1, $variable2]);
$q = $q->fetchAll(PDO::FETCH_OBJ);
 
functie versie
$q = Database::getDb()->prepare("SELECT * FROM table_name WHERE column_one = ? AND column_two =?");
$q->execute([$variable1, $variable2]);
return $q->fetchAll(PDO::FETCH_OBJ);
 
query
$q = Database::getDb()->query("SELECT * FROM table_name");
$q = $q->fetchAll(PDO::FETCH_OBJ);
 
functie versie
$q = Database::getDb()->query("SELECT * FROM table_name");
return $q->fetchAll(PDO::FETCH_OBJ);
*/