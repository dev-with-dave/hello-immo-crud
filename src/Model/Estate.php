<?php

namespace App\Model;

use App\Controller\ErrorController;
use App\Database;
use PDO;
use PDOException;

class Estate {
  private $id;
  private $title;
  private $type;
  private $acquisition_type;
  private $city;
  private $rooms;
  private $bedrooms;
  private $bathrooms;
  private $area;
  private $price;
  private $description;
  private $build_year;
  private $floor;
  private $max_floor;
  private $created_at;
  private $updated_at;

  private $images; // propriété disponible que en PHP (non présente en base de donnée)

  /**
   *
   * Cette méthode permet de récuperer UN enregistrement en base de donnée correspondant à cette class
   *
   *  @param array $params Un tableau contenant les paramètres de recherche sur les champs de la table `estates`
   *  @param string $word Le mot de liaison si plusieurs paramètres. e.g: AND - OR
   *
   *  @return Estate|null
   */
  public static function findOne(array $params = [], string $word = 'AND'): Estate | null {
    if (!in_array(strtolower($word), ['and', 'or'])) {
      echo '<pre>';
      print_r("$word non reconu pour la requete sql");
      echo '</pre>';
      die();
    }
    $pdo = Database::getConnection();

    $keys = array_keys($params);
    $paramNames = array_map(fn($key) => ":$key", $keys);
    $values = array_values($params);
    $values = array_map(fn($value) => htmlentities($value), $values);

    $sql = <<< EOL
    SELECT * FROM estates WHERE
    EOL;

    $sqlParams = [];

    for ($i = 0; $i < sizeof($keys); $i++) {
      array_push($sqlParams, "$keys[$i]=$paramNames[$i]");
    }

    $sqlParams = implode(" $word ", $sqlParams);

    $sql .= " $sqlParams";

    $statementParams = array_combine($paramNames, $values);

    try {
      $statement = $pdo->prepare($sql);
      $statement->execute($statementParams);
      $estates = $statement->fetchAll(PDO::FETCH_CLASS, Estate::class);
      if (!empty($estates)) {
        return $estates[0];
      }

    } catch (PDOException $e) {
      // TODO: remove for production
      echo '<pre>';
      print_r($e->getMessage());
      echo '</pre>';
      die();
      $errorController = new ErrorController();
      $errorController->get500();
    }
  }

  /**
   *
   * Cette méthode permet de récuperer tous les enregistrements en base de donnée correspondant à cette class
   *
   * @param array $params Un tableau contenant les paramètres de recherche sur les champs de la table `estates`
   * @param string $word Le mot de liaison si plusieurs paramètres. e.g: AND - OR
   *
   *  @return array|null
   */
  public static function find(array $params = [], string $word = 'AND'): array | false {
    if (!in_array(strtolower($word), ['and', 'or'])) {
      echo '<pre>';
      print_r("$word non reconu pour la requete sql");
      echo '</pre>';
      die();
    }
    $pdo = Database::getConnection();

    $sql = <<< EOL
    SELECT * FROM estates
    EOL;

    if (!empty($params)) {
      $sql .= " WHERE ";
      $keys = array_keys($params);
      $paramNames = array_map(fn($key) => ":$key", $keys);
      $values = array_values($params);
      $values = array_map(fn($value) => htmlentities($value), $values);

      $sqlParams = [];

      for ($i = 0; $i < sizeof($keys); $i++) {
        array_push($sqlParams, "$keys[$i]=$paramNames[$i]");
      }

      $sqlParams = implode(" $word ", $sqlParams);

      $sql .= " $sqlParams";

      $statementParams = array_combine($paramNames, $values);
    }

    try {
      $statement = $pdo->prepare($sql);
      $statement->execute($statementParams ?? []);
      return $statement->fetchAll(PDO::FETCH_CLASS, Estate::class);
    } catch (PDOException $e) {
      // TODO: remove for production
      echo '<pre>';
      print_r($e->getMessage());
      echo '</pre>';
      die();
      $errorController = new ErrorController();
      $errorController->get500();
    }
  }

  /**
   *
   * Cette méthode permet de créer ou de modifier un enregistrement en base de donnée en fonction de son id.
   * Si l'objet à un id il sera modifié, sinon il sera crée.
   *
   *  @return self Retourne l'objet Estate crée ou modifié
   */
  public function save() {
    // si l'id n'est pas renseigné cela veut dire que l'objet crée n'est pas encore en base de donnée
    if (!$this->id) {
      // donc on le crée et on renvoie une instance de l'objet
      return $this->create();
    }

    // sinon on le modifie et on renvoie une instance de l'objet
    return $this->update();
  }

  /**
   *
   * Cette méthode sert à créer un nouvel enregistrement d'une instance de cette classe
   *
   * @return self
   */
  public function create() {
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour rendre la méthode Estate::create fonctionnelle."; // TODO: A supprimer
  }

  /**
   *
   * Cette méthode sert à modifier un enregistrement d'une instance de cette classe
   *
   * @return self
   */
  public function update() {
    //? cette méthode devrait peut être accepter un paramètre id
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour rendre la méthode Estate::update fonctionnelle."; // TODO: A supprimer
  }

  /**
   *
   * Cette méthode permet de lier une image à une instance de cette class en base de donnée
   *
   * @param string $imagePath chemin de l'image à stocker en base de donnée
   *
   */
  public function addImage(string $imagePath): bool {
    $pdo = Database::getConnection();

    try {
      $statement = $pdo->prepare("INSERT INTO images (url, estate_id) VALUES (:url, :estate_id)");
      return $statement->execute([":url" => $imagePath, ":estate_id" => $this->id]);
    } catch (PDOException $e) {
      // TODO: remove for production
      echo '<pre>';
      print_r($e->getMessage());
      echo '</pre>';
      die();
      $errorController = new ErrorController();
      $errorController->get500();
    }
  }

  /**
   *
   * Cette méthode privée sert à remplir le tableau contenu dans la propriété privée images.
   * Une requête en base de donnée est effectuée pour récuperer toutes les images qui correspondent à une instance de cette class.
   *
   *
   */
  private function populateImages(): void {
    $pdo = Database::getConnection();

    try {
      $statement = $pdo->prepare("SELECT * FROM images WHERE estate_id=:estate_id");
      $statement->execute([":estate_id" => $this->id]);
      $imagesArr = $statement->fetchAll();
      $this->setImages(array_map(fn($image) => $image['url'], $imagesArr));
    } catch (PDOException $e) {
      echo '<pre>';
      print_r($e->getMessage());
      echo '</pre>';
      die();
      $errorController = new ErrorController();
      $errorController->get500();
    }
  }

  /**
   *
   * Cette méthode permet de supprimer un enregistrement de la base de donnée correspondant à cette class
   *
   *
   */
  public static function deleteOne() {
    //? cette méthode devrait peut être accepter un paramètre id
    /**
     *
     * code ...
     *
     */
    echo "Modifier " . __FILE__ . ' ligne ' . __LINE__ . " pour rendre la méthode Estate::deleteOne fonctionnelle."; // TODO: A supprimer
  }

  public function getId() {
    return $this->id;
  }

  public function setId(int $id): self {
    $this->id = $id;
    return $this;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle(string $title): self {
    $this->title = $title;
    return $this;
  }

  public function getType() {
    return $this->type;
  }

  public function setType(string $type): self {
    $this->type = $type;
    return $this;
  }

  public function getCity() {
    return $this->city;
  }

  public function setCity(string $city): self {
    $this->city = $city;
    return $this;
  }

  public function getAcquisitionType() {
    return $this->acquisition_type;
  }

  public function setAcquisitionType(string $acquisition_type): self {
    $this->acquisition_type = $acquisition_type;
    return $this;
  }

  public function getRooms() {
    return $this->rooms;
  }

  public function setRooms(int $rooms): self {
    $this->rooms = $rooms;
    return $this;
  }

  public function getBedrooms() {
    return $this->bedrooms;
  }

  public function setBedrooms(int $bedrooms): self {
    $this->bedrooms = $bedrooms;
    return $this;
  }

  public function getBathrooms() {
    return $this->bathrooms;
  }

  public function setBathrooms(int $bathrooms): self {
    $this->bathrooms = $bathrooms;
    return $this;
  }

  public function getArea() {
    return $this->area;
  }

  public function setArea(int $area): self {
    $this->area = $area;
    return $this;
  }

  public function getPrice() {
    return $this->price;
  }

  public function setPrice(int $price): self {
    $this->price = $price;
    return $this;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription(string $description): self {
    $this->description = $description;
    return $this;
  }

  public function getBuildYear() {
    return $this->build_year;
  }

  public function setBuildYear(int $build_year): self {
    $this->build_year = $build_year;
    return $this;
  }

  public function getFloor() {
    return $this->floor;
  }

  public function setFloor(int $floor): self {
    $this->floor = $floor;
    return $this;
  }

  public function getMaxFloor() {
    return $this->max_floor;
  }

  public function setMaxFloor(int $max_floor): self {
    $this->max_floor = $max_floor;
    return $this;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function setCreatedAt(string $created_at): self {
    $this->created_at = $created_at;
    return $this;
  }

  public function getUpdatedAt() {
    return $this->updated_at;
  }

  public function setUpdatedAt(string $updated_at): self {
    $this->updated_at = $updated_at;
    return $this;
  }

  public function getImages() {
    $this->populateImages();
    return $this->images;
  }

  public function setImages(array $images) {
    $this->images = $images;
    return $this;
  }
}