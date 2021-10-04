<?php

require_once __DIR__ . '/vendor/autoload.php';

session_start();

use App\Router;

$router = new Router();

$router->get('/', "MainController#getHome")
  ->get('/connexion', "AuthController#getConnection")
  ->get('/deconnexion', 'AuthController#logout')
  ->get('/achat', 'EstateController#getBuyingEstates')
  ->get('/achat/[i:estate_id]', 'EstateController#getBuyingEstateById')
  ->get('/location', 'EstateController#getRentingEstates')
  ->get('/location/[i:estate_id]', 'EstateController#getRentingEstateById')
  ->get('/admin/accueil', "AdminController#getHome")
  ->get('/admin/biens', 'EstateController#getAdminEstates')
  ->get('/admin/biens/ajouter', 'EstateController#getAddAdminEstate')
  ->get('/admin/biens/modifier/[i:estate_id]', 'EstateController#getEditAdminEstate');

$router->post('/connexion', "AuthController#postConnection")
  ->post('/admin/biens/ajouter', "EstateController#postAddAdminEstate")
  ->post('/admin/biens/modifier/[i:estate_id]', "EstateController#postEditAdminEstate")
  ->post('/admin/biens/supprimer/[i:estate_id]', "EstateController#deleteAdminEstate");

$router->start();