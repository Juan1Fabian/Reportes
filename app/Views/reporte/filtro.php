<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Filtro de Superhéroes</title>
</head>
<body>
    <form method="get" action="<?= base_url('reporte/r4') ?>">
    <label for="publisher">Selecciona un editor:</label>
    <select name="publisher" id="publisher" required>
        <option value="">-- Seleccione --</option>
        <?php foreach($publishers as $publisher): ?>
            <option value="<?= esc($publisher['publisher_name']) ?>">
                <?= esc($publisher['publisher_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Generar PDF</button>
</form>
</body>
</html>
