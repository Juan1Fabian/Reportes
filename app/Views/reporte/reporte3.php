<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?= $estilos ?>
<page backtop="7mm" backbottom="7mm">
  <page_header>
    [[page_cu]]/[[page_nb]]
  </page_header>
  <page_footer>
    lista de super heroes
  </page_footer>
</page>

  <table class="table mb-2">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Alias</th>
        <th>Casa</th>
        <th>Bando</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($rows as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= $r['superhero_name'] ?></td>
        <td><?= $r['full_name'] ?></td>
        <td><?= $r['publisher_name'] ?></td>
        <td><?= $r['alignment'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>