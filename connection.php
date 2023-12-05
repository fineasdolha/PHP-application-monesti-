<?php


class DAO {

	
	private $host="127.0.0.1";
	private $user="usermonestie";
	private $password="1234";
	private $database="monestie";
	private $charset="utf8";
	
	//instance courante de la connexion
	private $connection;
	
	//stockage de l'erreur éventuelle du serveur mysql
	private $error;
	
	public function __construct() {
	
	}
	
	/* méthode de connexion à la base de donnée */
	public function connection() {
		
		try
		{
			// On se connecte à MySQL
			$this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset='.$this->charset, $this->user, $this->password);
		}
		catch(Exception $e)
		{
			// En cas d'erreur, on affiche un message et on arrête tout
				$this->error='Erreur : '.$e->getMessage();
		}
	}

    public function disconnection() {
        $this->connection = null;
    }

    public function getAssociations(){
        $sqlassoc = 'SELECT `id_association`, `name_association`  FROM `association`';
        return $sqlassoc;
    }

    public function queryRequest($sql) {
        $query = $this->connection->prepare($sql);
        $query->execute();
        $fetch = $query->fetchAll();
        return $fetch;
    }
    
    public function prepExec($testsql) {
        $query = $this->connection->prepare($testsql);
        $query -> execute();

    }

    public function getUserInfo($useremail) {
         
        $sqluser = "SELECT * FROM `person` WHERE `user_email`=?";
        $query = $this->connection->prepare($sqluser);
        $query->execute(array($useremail));
        $fetch = $query->fetchAll();
        return $fetch;
        
    }

    //je creer une fonction pour recuperer info de la BDD en passant par la class dao, le parametre va permettre 
    //de prendre l'adresse mail de la personne qui s'est connéctée et de venir dans la BDD recuperer son user id
    //en cherchant l'adresse mail de la personne concernée
    public function getCleaningStaff($useremail) {  
        $sqluser = 'SELECT * FROM `person` LEFT JOIN comments ON(person.id_user=comments.id_user) WHERE `user_email` LIKE "'.$useremail.'"';
        $query = $this->connection->prepare($sqluser);
        $query->execute();
        $fetch = $query->fetchAll();
        return $fetch;
        
    }

    //pour les admins je recupere les information dans la bdd, je sépare la requetedu cleaning au cas ou il me faudrait d'autre elements
    public function getAdminInfo($useremail) {  
        $sqluser = 'SELECT * FROM `person` LEFT JOIN comments ON(person.id_user=comments.id_user) WHERE `user_email` LIKE "'.$useremail.'"';
        $query = $this->connection->prepare($sqluser);
        $query->execute();
        $fetch = $query->fetchAll();
     
        return $fetch;
        
    }

    public function getAssocInfo($useremail) {  
        $sqluser = 'SELECT * FROM `person` LEFT JOIN comments ON(person.id_user=comments.id_user) WHERE `user_email` LIKE "'.$useremail.'"';
        $query = $this->connection->prepare($sqluser);
        $query->execute();
        
        $fetch = $query->fetchAll();
        return $fetch;
        
    }

    //je recupere les informations de commentaires posté pour les afficher sur les pages si la personne appartient au nettoyage.
    public function getCommentsCleaning($destination) {
        $sqluser = 'SELECT * FROM `comments` LEFT JOIN person ON(person.id_user=comments.id_user) WHERE destination IN("'.$destination.'") ORDER BY time_stamp DESC';
        // $query = $this->connection->prepare($sqluser);
        // $query->execute();
        // $fetch = $query->fetchAll();
        return $sqluser;
    }

    //je recupere les informations de commentaires posté pour les afficher sur les pages si la personne est un admin.
    public function getCommentsAdmin() {
        $sqluser = 'SELECT * FROM `comments`LEFT JOIN person ON(person.id_user=comments.id_user) ORDER BY time_stamp DESC';
        // $query = $this->connection->prepare($sqluser);
        // $query->execute();
        // $fetch = $query->fetchAll();
        return $sqluser;
    }

     //je recupere les informations de commentaires posté pour les afficher sur les pages si la personne appartient au nettoyage.
     public function getCommentsAsso($destination) {
        $sqluser = 'SELECT * FROM `comments` LEFT JOIN person ON(person.id_user=comments.id_user) WHERE destination IN("'.$destination.'") ORDER BY time_stamp DESC';
        // $query = $this->connection->prepare($sqluser);
        // $query->execute();
        // $fetch = $query->fetchAll();
        var_dump($sqluser);
        return $sqluser;
    }

    // public function getPassword($fetchuser){
    //     $email = $fetchuser[0]['user_email'];
    //     $sql = 'SELECT `user_password` from `person` WHERE `user_email` LIKE "'.$email.'"';
    //     $query = $this ->connection->prepare($sql);
    //     $query->execute();
    //     $fetchpassword = $query -> fetch();
    //     return $fetchpassword;
    // }

    public function getUserAsociation($id_association, $id_user){
        $sql = 'SELECT * FROM association JOIN person WHERE association.id_association = person.id_association AND association.id_association ='.$id_association.' AND person.id_user ='.$id_user.'';
        $query = $this ->connection->prepare($sql);
        $query->execute();
        return $query -> fetch();
    }
}

?>