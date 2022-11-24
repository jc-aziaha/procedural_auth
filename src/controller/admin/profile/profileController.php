<?php
declare(strict_types=1);

require AUTH_MIDDLEWARE;
require ABSTRACT_CONTROLLER;

    /**
     * Cette fonction modifie le profil de l'administrateur
     *
     * @return string
     */
    function edit() :  string
    {
        require USER;
        $user = get_user_info();

        if ( $_SERVER['REQUEST_METHOD'] === "POST" ) 
        {
            // Appel du validateur
            require VALIDATOR;

            $errors = make_validation(
                $_POST, 
                [
                    "first_name"            => ["required", "string", "max::255"],
                    "last_name"             => ["required", "string", "max::255"],
                    "email"                 => ["required", "string", "min::5", "max::255", "email", "uniqueOnUpdate::admin,email," . $user['id']],
                    "password"              => ["required", "string", "min::8", "max::255", "regex::/(?=(?:.*[A-Z]){1,255})(?=(?:.*[a-z]){1,255})(?=(?:.*\d){1,255})(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]){1,255})(.{8,255})/"],
                    "confirm_password"      => ["required", "string", "min::8", "max::255", "regex::/(?=(?:.*[A-Z]){1,255})(?=(?:.*[a-z]){1,255})(?=(?:.*\d){1,255})(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]){1,255})(.{8,255})/", "same::password"],
                ], 
                [
                    "first_name.required"           => "Le prénom est obligatoire.",
                    "first_name.string"             => "Veuillez entrer une chaîne de caractères.",
                    "first_name.max"                => "Le prénom doit contenir au maximum 255 caractères.",

                    "last_name.required"            => "Le nom est obligatoire.",
                    "last_name.string"              => "Veuillez entrer une chaîne de caractères.",
                    "last_name.max"                 => "Le nom doit contenir au maximum 255 caractères.",

                    "email.required"                => "L'email est obligatoire.",
                    "email.string"                  => "Veuillez entrer une chaîne de caractères.",
                    "email.min"                     => "L'email doit contenir au minimum 5 caractères.",
                    "email.max"                     => "L'email doit contenir au maximum 255 caractères.",
                    "email.email"                   => "Veuillez entrer un email valide.",
                    "email.uniqueOnUpdate"          => "Impossible de créer un compte avec cet email.",

                    "password.required"             => "Le mot de passe est obligatoire.",
                    "password.string"               => "Veuillez entrer une chaîne de caractères.",
                    "password.min"                  => "Le mot de passe doit contenir au minimum 8 caractères.",
                    "password.max"                  => "Le mot de passe doit contenir au maximum 255 caractères.",
                    "password.regex"                => "Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un caractère spécial et un chiffre.",

                    "confirm_password.required"     => "La confirmation du mot de passe est obligatoire.",
                    "confirm_password.string"       => "Veuillez entrer une chaîne de caractères.",
                    "confirm_password.min"          => "La confirmation du mot de passe doit contenir au minimum 8 caractères.",
                    "confirm_password.max"          => "La confirmation du mot de passe doit contenir au maximum 255 caractères.",
                    "confirm_password.regex"        => "La confirmation du mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un caractère spécial et un chiffre.",
                    "confirm_password.same"         => "La mot de passe doit être identique à sa confirmation.",
                ]
            );

            if ( count($errors) > 0 ) 
            {
                $_SESSION['errors'] = $errors;
                $_SESSION['old']    = old_values($_POST);
                return redirect_back();
            }

            // Appel du manager de la table "user" 

            $post_clean = old_values($_POST);
            updateUser($post_clean, $user['id']);

            $_SESSION['success'] = "Votre profil a été modifié avec succès";
            
            return redirect_to_url("/admin/home");
        }

        return render("pages/admin/profile/edit.html.php", [
            "user" => $user
        ]);
    }