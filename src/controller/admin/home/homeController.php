<?php
declare(strict_types=1);

require ABSTRACT_CONTROLLER;
require AUTH_MIDDLEWARE;

    /**
     * Cette fonction retourne la page d'accueil de l'espace d'administration
     *
     * @return string
     */
    function index() : string
    {
        return render("pages/admin/home/index.html.php");
    }