<h2>Reporte personalizado</h2>
<?= $estilos ?>
<table class="table mb-3">
  <colgroup>
    <col style="width: 5%;">
    <col style="width: 25%;">
    <col style="width: 30%;">
    <col style="width: 20%;">
    <col style="width: 20%;">
  </colgroup>
  <thead>
    <tr>
      <th>ID</th>
      <th>Super Hero</th>
      <th>Full name</th>
      <th>Race</th>
      <th>Alignment</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($superheros as $row): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['superhero_name'] ?></td>
        <td><?= $row['full_name'] ?></td>
        <td><?= $row['race'] ?></td>
        <td><?= $row['alignment'] ?></td>
      </tr> <?php endforeach; ?>
  </tbody>
</table>