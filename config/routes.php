<?php


    get("/",            ["visitor/welcome/welcomeController", "index"]);


    /* -------------------------Authentication-------------------- */
    get("/login",       ["visitor/authentication/loginController", "login"]);
    post("/login",      ["visitor/authentication/loginController", "login"]);
    get("/logout",      ["visitor/authentication/loginController", "logout"]);
    


    /* -------------------------Admin-------------------- */
    get("/admin/home",                  ["admin/home/homeController", "index"]);
    get("/admin/category/list",         ["admin/category/categoryController", "index"]);
    get("/admin/category/create",       ["admin/category/categoryController", "create"]);
    post("/admin/category/create",      ["admin/category/categoryController", "create"]);
    get("/admin/category/edit/{id}",    ["admin/category/categoryController", "edit"]);
    post("/admin/category/edit/{id}",   ["admin/category/categoryController", "edit"]);
    get("/admin/category/delete/{id}",  ["admin/category/categoryController", "delete"]);

    get("/admin/profile/edit",          ["admin/profile/profileController", "edit"]);
    post("/admin/profile/edit",          ["admin/profile/profileController", "edit"]);

    