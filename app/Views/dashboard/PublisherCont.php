<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Héroes por Publisher</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
<body>
<div class="container py-4">
  <h4 class="mb-3">Gráfico: Héroes por Publisher</h4>
  
    <form id="frmPublishers" class="mb-3">
    <div class="row g-2">
        <div class="col-12">
        <?php if (!empty($publishers)): ?>
            <?php foreach ($publishers as $p): ?>
            <label class="form-check-label me-3">
                <input class="form-check-input me-1"
                    type="checkbox"
                    name="publishers[]"
                    value="<?= esc($p['publisher_name']) ?>">
                <?= esc($p['publisher_name']) ?>
            </label>
            <?php endforeach; ?>
        <?php else: ?>
            <em>No hay publishers</em>
        <?php endif; ?>
        </div>
    </div>
    <div class="mt-3">
        <button type="button" id="btnGenerar" class="btn btn-primary">Generar</button>
        <span id="aviso" class="ms-2 d-none">Por favor espere...</span>
    </div>
    </form>

  <canvas id="lienzo" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<script>
  const lienzo = document.getElementById("lienzo");
  const btnGenerar = document.getElementById("btnGenerar");
  const aviso = document.getElementById("aviso");
  const frm = document.getElementById("frmPublishers");
  let grafico = null;

  function renderGraphic() {
    const ctx = lienzo.getContext('2d');
    if (grafico) grafico.destroy();
    grafico = new Chart(ctx, {
      type: 'bar',
      data: { labels: [],
        datasets:[
          {
           label: '',
           data: [],
           backgroundColor: '#4e79a7'
          }] 
        },
      options: { responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  }

  function getSelectedPublishers() {
    const formData = new FormData(frm);
    return formData.getAll('publishers[]');
  }

  async function fetchData() {
    aviso.classList.remove('d-none');
    const selected = getSelectedPublishers();
    const params = new URLSearchParams();
    selected.forEach(v => params.append('publishers[]', v));
    const baseApi = '<?= base_url('public/api/publisherCounts') ?>';
    const url = baseApi + (selected.length ? ('?' + params.toString()) : '');

    const resp = await fetch(url, { method: 'GET' });
    aviso.classList.add('d-none');
    if (!resp.ok) throw new Error('No se puede conectar al servicio');
    return resp.json();
  }

  btnGenerar.addEventListener('click', async () => {
    try {
      const data = await fetchData();
      if (data.success) {
        grafico.data.labels = data.resumen.map(r => r.Marca);
        grafico.data.datasets[0].data = data.resumen.map(r => Number(r.Total_Heroes));
        grafico.data.datasets[0].label = data.message;
        grafico.update();
      } else {
        alert(data.message || 'Sin datos');
      }
    } catch (e) {
      console.error(e);
      alert('Error obteniendo datos');
    }
  });

  renderGraphic();
</script>
</body>
</html>