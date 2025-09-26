<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>

 <div class="container">
  <button class="btn btn-outline-primary" id="obtener-datos" type="button">obtener datos</button>
  <span id="aviso" class="d-none">Por favor espere...</span>
  <canvas id="lienzo"></canvas>
</div>
   
     <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>


     <script>
      const lienzo =  document.getElementById("lienzo")
      const btnDatos = document.getElementById("obtener-datos")

      let grafico = null

      function renderGraphic(){
        grafico = new Chart(lienzo,{
          type: 'bar',
          data: {
            labels: [],
            datasets: [{
              label: '',
              data: []
            }]
          }
        })
      }

      btnDatos.addEventListener("click", async () => {
        try{
          const response = await fetch('<?= base_url()?>/public/api/Informe3', {method: 'GET'})

          if(!response.ok){
            throw new Error('No se puede conectar al servicio')
          }

          const data = await response.json()
          if (data.success){
            grafico.data.labels = data.resumen.map(row => row.alignment)
            grafico.data.datasets[0].data = data.resumen.map(row => row.total)
            grafico.data.datasets[0].label = data.message
            grafico.update()
          }
        }
        catch(error){
          console.error(error)
        }
      })
      renderGraphic()
     </script>
</body>
</html>