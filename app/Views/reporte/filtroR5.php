<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= $estilos ?>
    <div class="container mt-4">
        <h2 class="text-center">Buscar héroe</h2>
    
        <form method="get" action="<?= base_url('reporte/filtroR5') ?>">
            <input type="text" class="buscador" name="nombre" value="<?= esc($nombre ?? '') ?>" placeholder="Nombre del héroe" list="heroes">
                <datalist id="heroes">
                    <?php foreach ($heroes as $h): ?>
                        <option value="<?= esc($h['superhero_name']) ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            <button type="submit" class="boton mb-2">Buscar</button>
        </form>
    
        <?php if (!empty($heroes)): ?>
            <h3>Resultados:</h3>
            <table class="table-radio mb-2">
                <tr class="table th bg-primary text-center">
                    <th>ID</th>
                    <th>Superhéroe</th>
                    <th>Nombre real</th>
                    <th>Editorial</th>
                    <th>Alineación</th>
                    <th>Poderes</th>
                    <th>Acción</th>
                </tr>
                <?php foreach ($heroes as $hero): ?>
                    <tr class="table td">
                        <td><?= esc($hero['id']) ?></td>
                        <td><?= esc($hero['superhero_name']) ?></td>
                        <td><?= esc($hero['full_name']) ?></td>
                        <td><?= esc($hero['publisher_name']) ?></td>
                        <td><?= esc($hero['alignment']) ?></td>
                        <td><?= esc($hero['poderes']) ?></td>
                        <td>
                            <form method="post" action="<?= base_url('reporte/r5') ?>" target="_blank" onsubmit="return recargarPagina()">
                                <input type="hidden" name="id" value="<?= esc($hero['id']) ?>">
                                <button type="submit" class="boton" base_url="<?= base_url('reporte/filtroR5') ?>">Exportar PDF</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (!empty($nombre)): ?>
            <p>No se encontró héroe con el nombre <?= esc($nombre) ?></p>
        <?php endif; ?>
    </div>
    <script>
    function recargarPagina() {
        setTimeout(() => {
            window.location.href = "<?= base_url('reporte/filtroR5') ?>";
        }, 100);
        return true;
    }
</script>
</body>
</html>

