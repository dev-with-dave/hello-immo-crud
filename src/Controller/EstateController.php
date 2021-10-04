<?php

namespace App\Controller;

use App\Model\Estate;

class EstateController extends Controller {

  public function getBuyingEstates() {
    $estates = Estate::find(['acquisition_type' => "achat"]);
    $this->render('estates.twig', [
      'estates' => $estates,
    ]);
  }

  public function getBuyingEstateById(int $estate_id) {
    $estate = Estate::findOne(['acquisition_type' => "achat", 'id' => $estate_id]);
    $this->render('estate.twig', [
      'estate' => $estate,
    ]);
  }

  public function getRentingEstates() {
    $estates = Estate::find(['acquisition_type' => "location"]);
    $this->render('estates.twig', [
      'estates' => $estates,
    ]);
  }

  public function getRentingEstateById(int $estate_id) {
    $estate = Estate::findOne(['acquisition_type' => "location", 'id' => $estate_id]);
    $this->render('estate.twig', [
      'estate' => $estate,
    ]);
  }

  /**
   *
   * Méthode permettant d'afficher tous les biens sur l'interface admin aprèès avoir récupérer les données en base de donnée
   *
   */
  public function getAdminEstates() {
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour voir cette page."; // TODO: A supprimer
  }

  /**
   *
   * Méthode permettant d'afficher la page pour l'ajout de biens
   *
   */
  public function getAddAdminEstate() {
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour voir cette page."; // TODO: A supprimer
  }

  /**
   *
   * Méthode permettant de gérer l'ajout de biens, c'est cette méthode qui traite les données envoyées via le formulaire
   *
   */
  public function postAddAdminEstate() {
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour voir cette page."; // TODO: A supprimer
  }

  /**
   *
   * Méthode permettant d'afficher la page de modification d'un bien
   *
   */
  public function getEditAdminEstate(int $estate_id) {
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour voir cette page."; // TODO: A supprimer
  }

  /**
   *
   * Méthode permettant de gérer la modification d'un bien, c'est cette méthode qui traite les données envoyées via le formulaire
   *
   */
  public function postEditAdminEstate(int $estate_id) {
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour voir cette page."; // TODO: A supprimer
  }

  /**
   *
   * Méthode permettant de gérer la suppression d'un bien
   *
   */
  public function deleteAdminEstate(int $estate_id) {
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour voir cette page."; // TODO: A supprimer
  }
}