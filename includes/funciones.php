<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual,string $proximo): bool{
    if($actual !== $proximo){
        return true;
    }
    return false;
}

//Funcion que revisa que el usuario este autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}

//Que sean adminsitradores no usuarios cualquiera
function isAdmin() : void{
    if(!isset($_SESSION['admin'])){//en LoginController creamos esta variable
        header('Location: /');//si abre un nuevo navegador o incognito redirige
    }
}