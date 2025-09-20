<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Poderes del Héroe</title>
    <?= $estilos ?>
</head>
<body>
    <h2 class="text-center">Poderes del <?= esc($hero['superhero_name']) ?></h2>

    <?php if (!empty($powers)): ?>
        <ul>
            <?php foreach ($powers as $p): ?>
                <li><?= esc($p['power_name']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No se encontraron poderes para este héroe.</p>
    <?php endif; ?>
</body>
</html>