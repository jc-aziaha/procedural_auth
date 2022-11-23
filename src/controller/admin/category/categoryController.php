<?php
declare(strict_types=1);

require AUTH_MIDDLEWARE;
require ABSTRACT_CONTROLLER;


    /**
     * Cette méthode permet d'afficher la liste des catégories
     *
     * @return string
     */
    function index() : string
    {
        require CATEGORY;
        $categories = findAllCategories();

        return render("pages/admin/category/index.html.php", [
            "categories" => $categories
        ]);
    }


    /**
     * Cette méthode permet d'afficher le ofrmulaire de création d'une nouvelle catégorie
     *
     * @return string
     */
    function create() : string
    {
        if ( $_SERVER["REQUEST_METHOD"] === "POST" ) 
        {
            require VALIDATOR;

            $errors = make_validation(
                $_POST,
                [
                    "name" => ["required", "string", "max::255", "unique::category,name"]
                ],
                [
                    "name.required" => "Le nom est obligatoire.",
                    "name.string"   => "Veuillez entrer une chaîne de caractères.",
                    "name.max"      => "Veuillez entrer au maxim 255 caractères",
                    "name.unique"   => "Cette catégorie existe déjà. Veuillez en choisir une autre."
                ],
            );

            if (count($errors) > 0) 
            {
                $_SESSION['errors'] = $errors;
                $_SESSION['old']    = old_values($_POST);
                return redirect_back();
            }

            require CATEGORY;

            createCategory(old_values($_POST));

            $_SESSION['success'] = "La catégorie a été ajoutée avec succès";

            return redirect_to_url("/admin/category/list");
        }

        return render("pages/admin/category/create.html.php");
    }