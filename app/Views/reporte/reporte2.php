<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reporte 2</title>
</head>
<body>

  <?= $estilos ?>


  <div class="text-center">
    <h1>Reporte de ventas</h1>
    <h2>Area <?= $area ?></h2>
  </div>

  <table class="table mb-2">
    <colgroup>
      <col style="width: 10%;">
      <col style="width: 60%;">
      <col style="width: 30%;">
  </colgroup>
    <thead>
      <tr class="">
        <th>#</th>
        <th>Producto</th>
        <th>Precio</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($productos as $p): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['nombre'] ?></td>
        <td><?= $p['precio'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>

</html>