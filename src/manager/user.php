<?php

    /**
     * ---------------------------------------------------------------------
     * Le manager de la table "user"
     * 
     * Le rôle du manager est d'effectuer toutes les requêtes prévues 
     * pour intéragir avec la base de données
     * ---------------------------------------------------------------------
    */

    /**
     * Grâce à cette fonction, le manager de la table "user" inscrit un nouvel utilisateur
     *
     * @return void
     */
    function createUser(array $data) : void
    {
        require DB;

        $req = $db->prepare("INSERT INTO admin (first_name, last_name, email, password, created_at, updated_at) VALUES (:first_name, :last_name, :email, :password, now(), now() ) ");

        $req->bindValue(":first_name", $data['first_name']);
        $req->bindValue(":last_name",  $data['last_name']);
        $req->bindValue(":email",      $data['email']);
        $req->bindValue(":password",   password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]));

        $req->execute();
        $req->closeCursor();
    }


    function get_user_info() : array
    {
        require DB;

        $id = (int) $_SESSION['auth']['id'];

        $req = $db->prepare("SELECT * FROM admin WHERE id=:id");
        $req->bindValue(":id", $id);
        $req->execute();
        $user = $req->fetch();
        $req->closeCursor();
        return $user;
    }


    /**
     * Cette fonction modifie le profil de l'administrateur
     *
     * @param array $post_clean
     * @param integer|string $id
     * 
     * @return void
     */
    function updateUser(array $post_clean, int|string $id) : void
    {
        require DB;

        $req = $db->prepare("UPDATE admin SET first_name=:first_name, last_name=:last_name, email=:email, password=:password, updated_at=now() WHERE id=:id");

        $req->bindValue(":first_name", $post_clean['first_name']);
        $req->bindValue(":last_name",  $post_clean['last_name']);
        $req->bindValue(":email",      $post_clean['email']);
        $req->bindValue(":password",   password_hash($post_clean['password'], PASSWORD_BCRYPT) );
        $req->bindValue(":id",         $id);

        $req->execute();
        $req->closeCursor();
    }