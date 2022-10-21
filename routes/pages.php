<?php

use \App\Http\Response;
use \App\Controllers\Pages;


// Rota Dashboard [HOME]
$router->get('/', [
    function(){
        return new Response(200, Pages\Dashboard::getDashboard());
    }
]);

// Rota Products
$router->get('/products', [
    function(){
        return new Response(200, Pages\Products::getProducts());
    }
]);

// Products Create [GET]
$router->get('/products/create', [
    function($request){
        return new Response(200, Pages\Products::getNewProduct($request));
    }
]);

// Products Create [POST]
$router->post('/products/create', [
    function($request){
        return new Response(200, Pages\Products::setNewProduct($request));
    }
]);



// // Products Edit [GET]
$router->get('/products/{id}/edit', [
    function($request, $id){
        return new Response(200, Pages\Products::getEditProduct($request, $id));
    }
]);


// // Products Edit [POST]
$router->post('/products/{id}/edit', [
    function($request, $id){
        return new Response(200, Pages\Products::setEditProduct($request, $id));
    }
]);



// // Products Delete [GET]
$router->get('/products/{id}/delete', [
    function($request, $id){
        return new Response(200, Pages\Products::getDeleteProduct($request, $id));
    }
]);


// // Products Delete [POST]
$router->post('/products/{id}/delete', [
    function($request, $id){
        return new Response(200, Pages\Products::setDeleteProduct($request, $id));
    }
]);



// Rota Categories
$router->get('/categories', [
    function(){
        return new Response(200, Pages\Categories::getCategories());
    }
]);

// Categories Create [GET]
$router->get('/categories/create', [
    function($request){
        return new Response(200, Pages\Categories::getNewCategory($request));
    }
]);

// Categories Create [POST]
$router->post('/categories/create', [
    function($request){
        return new Response(200, Pages\Categories::setNewCategory($request));
    }
]);

// Categories Edit [GET]
$router->get('/categories/{id}/edit', [
    function($request, $id){
        return new Response(200, Pages\Categories::getEditCategory($request, $id));
    }
]);

// Categories Edit [POST]
$router->post('/categories/{id}/edit', [
    function($request, $id){
        return new Response(200, Pages\Categories::setEditCategory($request, $id));
    }
]);

// Categories Delete [GET]
$router->get('/categories/{id}/delete', [
    function($request, $id){
        return new Response(200, Pages\Categories::getDeleteCategory($request, $id));
    }
]);

// Categories Delete [POST]
$router->post('/categories/{id}/delete', [
    function($request, $id){
        return new Response(200, Pages\Categories::setDeleteCategory($request, $id));
    }
]);