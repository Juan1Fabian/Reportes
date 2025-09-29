<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'Reporte por Género') ?></title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color:#212529; }
    .container { padding: 16px 20px; }
    h2 { margin: 0 0 8px 0; font-size: 18px; color:#0d6efd; }
    .muted { color:#6c757d; font-size: 11px; margin: 0 0 12px 0; }
    table { width:100%; border-collapse: collapse; table-layout: fixed; }
    th, td { border:1px solid #dee2e6; padding:8px; }
    th { background:#f8f9fa; text-align:left; }
    tbody tr:nth-child(odd) { background:#fcfcfd; }
    .text-end { text-align: right; }
    .text-center { text-align: center; }
    .w-5 { width: 5%; }
    .w-55 { width: 55%; }
    .w-40 { width: 40%; }
    .footer { margin-top: 10px; font-size: 10px; color:#6c757d; }
  </style>
</head>
<body>
  <div class="container">
    <h2><?= esc($title ?? 'Reporte por Género') ?></h2>
    <p class="muted">Límite aplicado: <?= isset($limit) ? intval($limit) : 0 ?> · Fecha: <?= date('Y-m-d H:i') ?></p>
    <table>
    <thead>
      <tr>
        <th class="w-5">#</th>
        <th class="w-55">Nombre</th>
        <th class="w-40">Género</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)): $i=1; foreach ($rows as $r): ?>
        <tr>
          <td class="text-center"><?= $i++ ?></td>
          <td><?= esc($r['superhero_name'] ?? '') ?></td>
          <td><?= esc($r['gender'] ?? '') ?></td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="3">Sin resultados</td></tr>
      <?php endif; ?>
    </tbody>
    </table>
    <p class="footer">Generado por Reportes-Superhero · Página 1</p>
  </div>
</body>
</html>