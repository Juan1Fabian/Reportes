<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Promedio de Peso por Publisher</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
<body>
<div class="container py-4">
  <h4 class="mb-3">Gráfico: Promedio de Peso por Publisher</h4>

  <form id="frmAvgWeight" class="row g-2 align-items-center mb-3">
    <div class="col-auto">
      <button type="button" id="btnGenerar" class="btn btn-primary">Generar por Mayor</button>
      <span id="aviso" class="ms-2 d-none">Por favor espere...</span>
    </div>
  </form>

  <canvas id="lienzo" height="260"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<script>
  const lienzo = document.getElementById('lienzo');
  const btnGenerar = document.getElementById('btnGenerar');
  const aviso = document.getElementById('aviso');
  let grafico = null;
  let currentOrder = 'ASC'; // alterna en cada click


  function renderGraphic() {
    const ctx = lienzo.getContext('2d');
    if (grafico) grafico.destroy();
    grafico = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [],
        datasets: [
          {
            label: 'Peso Promedio (kg)',
            data: [],
            borderColor: '#2c7a3f',
            backgroundColor: 'rgba(44, 122, 63, 0.2)',
            pointRadius: 4,
            pointHoverRadius: 6,
            hitRadius: 8,
            borderWidth: 3,
            borderCapStyle: 'round',
            borderJoinStyle: 'round',
            clip: 0,
            tension: 0.25,
            fill: true
          }
        ]
      },
      options: {
        responsive: true,
        layout: { padding: { top: 36, right: 12, bottom: 12, left: 8 } },
        plugins: {
          legend: { display: true, position: 'top' },
          tooltip: {
            enabled: true,
            intersect: true,
            mode: 'nearest',
            displayColors: false,
            callbacks: {
              label: function(ctx) {
                const y = ctx.parsed.y;
                const val = (y >= 100 ? y.toFixed(0) : y.toFixed(1)) + ' kg';
                return val;
              },
              title: function(items) { return items && items[0] ? items[0].label : ''; }
            }
          }
        },
        animation: { duration: 300 },
        scales: {
          y: {
            type: 'linear',
            beginAtZero: true,
            grace: '15%',
            ticks: {
              // Formato con unidades
              autoSkip: true,
              maxTicksLimit: 6,
              callback: function(value) {
                const v = Number(value);
                return (v < 10 ? v.toFixed(1) : v.toFixed(0)) + ' kg';
              }
            },
            title: { display: true, text: 'Peso Promedio (KG)' },
            // asegúrate de recortar cualquier dibujo fuera del área de escala
            stacked: false
          },
          x: {
            title: { display: true, text: 'Editoras' }
          }
        }
      }
    });
  }

  async function fetchData() {
    aviso.classList.remove('d-none');
    const order = currentOrder;
    const baseApi = '<?= base_url('public/api/avgWeightByPublisher') ?>';
    const url = baseApi + '?order=' + encodeURIComponent(order);

    const resp = await fetch(url, { method: 'GET' });
    aviso.classList.add('d-none');
    if (!resp.ok) throw new Error('No se puede conectar al servicio');
    return resp.json();
  }

  btnGenerar.addEventListener('click', async () => {
    try {
      // alternar orden antes de solicitar
      currentOrder = (currentOrder === 'ASC') ? 'DESC' : 'ASC';
      btnGenerar.disabled = true;
      btnGenerar.textContent = (currentOrder === 'ASC')
        ? 'Generar por Mayor'
        : 'Generar por Menor';
      const data = await fetchData();
      if (data.success) {
        // redibujar como línea siempre
        renderGraphic();
        // Filtrar valores 0 como salvaguarda
        const rows = (data.resumen || []).filter(r => Number(r.Promedio_Peso) > 0);
        if (rows.length === 0) {
          alert('Sin datos > 0');
          grafico.update();
          return;
        }
        grafico.data.labels = rows.map(r => r.Marca);
        const values = rows.map(r => Number(r.Promedio_Peso));
        grafico.data.datasets[0].data = values;
        grafico.data.datasets[0].label = 'Peso Promedio (kg)';
        const maxVal = Math.max(...values);
        grafico.options.scales.y.type = 'linear';
        grafico.options.scales.y.min = 0;
        grafico.options.scales.y.suggestedMax = Math.max(10, Math.ceil(maxVal * 1.15));
        grafico.options.scales.y.grid = { color: 'rgba(0,0,0,0.08)' };
        grafico.update();
      } else {
        alert(data.message || 'Sin datos');
      }
    } catch (e) {
      console.error(e);
      alert('Error obteniendo datos');
    } finally {
      btnGenerar.disabled = false;
    }
  });

  renderGraphic();
</script>
</body>
</html>
