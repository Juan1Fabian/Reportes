<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
<div class="container py-4">
  <h4 class="mb-3">Exportar Héroes por Género</h4>
  <form method="get" action="<?= base_url('dashboard/pdf') ?>" class="row g-3">
  <div class="col-12">
    <label class="form-label d-block mb-1">Géneros</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="genders[]" id="genderMale" value="Male">
      <label class="form-check-label" for="genderMale">Male</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="genders[]" id="genderFemale" value="Female">
      <label class="form-check-label" for="genderFemale">Female</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="genders[]" id="genderNA" value="N/A">
      <label class="form-check-label" for="genderNA">N/A</label>
    </div>
  </div>

  <div class="col-md-6">
    <label for="filename" class="form-label">Nombre del PDF</label>
    <input type="text" id="filename" name="filename" class="form-control" placeholder="Nombre del PDF">
  </div>

  <div class="col-md-3">
    <label for="limit" class="form-label">Límite (1-200)</label>
    <input type="number" id="limit" name="limit" class="form-control" value="50" min="1" max="200">
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Exportar a PDF</button>
  </div>
  </form>
</div>
<!-- Bootstrap JS (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>