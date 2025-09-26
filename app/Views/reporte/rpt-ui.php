<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes personalizados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>

  <div class="container mt-3">
      <form action="<?= base_url() . "reporte/publisher" ?>" method="post">
          <div class="input-group">
              <div class="form-floating">
                  <select name="publisher_id" id="publisher_id" class="form-select">
                      <option value="">Seleccione</option>
                      <?php foreach($publishers as $row): ?>
                          <option value="<?= $row['id'] ?>"><?= $row['publisher_name'] ?></option>
                      <?php endforeach; ?>
                  </select>
                  <label for="publisher_id">Editora para generar</label>
              </div>
              <button class="btn btn-outline-success">Generar</button>
          </div>
      </form>

      <form action="<?= base_url() ?>reporte/racealignment" method="post" class="my-3">
        <h4>Filtrar por razas y alineaciones</h4>
        <div class="row g-2">
            <div class="col-md-6">
                <div class="form-floating">
                    <select name="race_id" id="race_id" class="form-select">
                        <option value="">Selección</option>
                        <?php foreach ($races as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['race'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="race_id">Razas</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select name="alignment_id" id="alignment_id" class="form-select">
                        <option value="">Selección</option>
                        <?php foreach ($alignment as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['alignment'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="alignment_id">Alineaciones</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Generar</button>
    </form>
  </div>
</body>
</html>