<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Superhéroes</title>
</head>
<body>
    <?= $estilos ?>
    <h1>Reporte de Superhéroes - <?= esc($publisherName) ?></h1>
    <table class="table mb-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Superhéroe</th>
                <th>Nombre Completo</th>
                <th>Editor</th>
                <th>Alineación</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($superheroes)): ?>
                <?php foreach($superheroes as $hero): ?>
                    <tr>
                        <td><?= esc($hero['id']) ?></td>
                        <td><?= esc($hero['superhero_name']) ?></td>
                        <td><?= esc($hero['full_name']) ?></td>
                        <td><?= esc($hero['publisher_name']) ?></td>
                        <td><?= esc($hero['alignment']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center;">No hay datos para mostrar.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
              