<?php
//utilisation d'un namespace - permet d'utiliser use sans connaitre l'emplacement de la classe
namespace Model;

//création de la classe connect - Connexion à la base de donnée
abstract class Connect  {
    const HOST = "localhost";
    const DB = "cinema";
    const USER = "root";
    const PASS = "";

    public static function seConnecter(){
        try {
            return new \PDO(
                "mysql:host=" . self::HOST . ";dbname=".  self::DB.";charset=utf8", self::USER, self::PASS);
        } catch (\PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
?>