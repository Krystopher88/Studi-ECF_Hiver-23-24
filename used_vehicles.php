<?php
require_once('templates/head.php');
require_once('lib/pdo.php');

$UsedVehiculeSliders = getImportUsedVehicle($pdo);

// Récupérer les marques distinctes depuis la base de données
$brandQuery = $pdo->query('SELECT DISTINCT brand FROM Used_Vehicles');
$brands = $brandQuery->fetchAll(PDO::FETCH_COLUMN);

// Récupérer les types de carburant distincts depuis la base de données
$fuelTypeQuery = $pdo->query('SELECT DISTINCT fuel_type FROM Used_Vehicles');
$fuelTypes = $fuelTypeQuery->fetchAll(PDO::FETCH_COLUMN);

$brand = $_GET['brand'] ?? null;
$fuel_type = $_GET['fuel_type'] ?? null;
$minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : '';
$maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : '';
$reset = isset($_GET['reset']);

// Réinitialiser les filtres si le bouton "Réinitialiser" est cliqué
if ($reset) {
  $brand = null;
  $fuel_type = null;
  $minPrice = '';
  $maxPrice = '';
}

// Modifier cette ligne pour utiliser la fonction de filtrage appropriée
if ($brand || $fuel_type || ($minPrice !== '' && $maxPrice !== '')) {
  $UsedVehiculeSliders = getFilterUsedVehicle($pdo, $brand, $fuel_type, $minPrice, $maxPrice);
}
?>


<body class="container">
  <!-- HEADER START -->
  <?php
  require_once('templates/header.php');
  ?>
  <!-- HEADER END -->

  <!-- MAIN START -->
  <div class="row justify-content-center">
    <div class="col-3 p-4">
      <form action="" method="GET" class="form-control p-4">
        <select name="brand" id="" class="form-select mb-3">
          <option value="" selected>Marques</option>
          <?php foreach ($brands as $brandOption) { ?>
            <option value="<?= $brandOption ?>" <?= $brand === $brandOption ? 'selected' : '' ?>><?= $brandOption ?></option>
          <?php } ?>
        </select>
        <select name="fuel_type" id="fuel-type" class="form-select mb-3">
          <option value="" selected>Carburant</option>
          <?php foreach ($fuelTypes as $fuelTypeOption) { ?>
            <option value="<?= $fuelTypeOption ?>" <?= $fuel_type === $fuelTypeOption ? 'selected' : '' ?>><?= $fuelTypeOption ?></option>
          <?php } ?>
        </select>
        <label for="price">Prix :</label>
        <div id="price-slider" class="mb-3"></div>
        <input type="hidden" id="minPrice" name="minPrice" value="<?= $minPrice ?>">
        <input type="hidden" id="maxPrice" name="maxPrice" value="<?= $maxPrice ?>">
        <div id="price-values"></div>
        <button type="submit" class="btn btn-warning m-2" name="reset" value="true">Réinitialiser</button>
        <button type="submit" class="btn btn-primary m-2">Valider</button>
      </form>
    </div>
    <!-- USED_VEHICLE START -->
    <div class="col-8 p-3">
      <div class="row justify-content-around">
        <?php foreach ($UsedVehiculeSliders as $key => $UsedVehiculeSlider) { ?>
          <div class="card mb-2 usedVechicled" style="width: 16rem">
            <div class="card-header bg-transparent d-flex justify-content-between">
              <h6 class="card-title"><?= $UsedVehiculeSlider['brand']; ?></h6>
              <h6><?= $UsedVehiculeSlider['model']; ?></h6>
            </div>
            <img src="./uploads/img_used_vehicle/E111803730_STANDARD_0.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text">
              <ul class="list-group">
                <li class="list-group-item"><?= $UsedVehiculeSlider['mileage']; ?> km</li>
                <li class="list-group-item"><?= $UsedVehiculeSlider['fuel_type']; ?></li>
                <li class="list-group-item"><?= $UsedVehiculeSlider['year']; ?></li>
              </ul>
              </p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <!-- USED_VEHICLE END -->
  </div>

  <!-- MAIN END -->
  <!-- FOOTER START -->
  <?php
  require_once('templates/footer.php')
  ?>
  <!-- FOOTER END -->

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script src="./assets/JS/script.js"></script>

</html>