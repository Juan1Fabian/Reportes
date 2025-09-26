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
  document.addEventListener("DOMContentLoaded", () => {
    const lienzo = document.getElementById("lienzo");
    const btnDatos = document.getElementById("obtener-datos");
    const aviso = document.getElementById("aviso")
    let grafico = null

    function renderGraphic(){
      const backgroundColor = [
        'rgba(192, 57, 43,0.5)',
        'rgba(39, 174, 96,0.5)',
        'rgba(142, 68, 173,0.5)',
        'rgba(241, 196, 15,0.5)',
        'rgba(25, 42, 86,0.5)'
      ];

      const borderColor = [
        'rgba(192, 57, 43,1.0)',
        'rgba(39, 174, 96,1.0)',
        'rgba(142, 68, 173,1.0)',
        'rgba(241, 196, 15,1.0)',
        'rgba(25, 42, 86,1.0)'
      ];

      const borderWidth = 2;

      const options = {
        responsive: true,
        scales:{
          y:{beginAtZero: true}
        }
      }

      grafico = new Chart(lienzo, {
        type: 'bar',
        data: {
          labels: [],
          datasets: [
            { 
            label: '', 
            data: [],
            backgroundColor: backgroundColor,
            borderColor: borderColor,
            borderWidth: borderWidth
           }
         ]
        },
        options
      })
    }

    btnDatos.addEventListener("click", async () => {
      try {
        aviso.classList.remove("d-none")
        const response = await fetch('http://superhero.test/public/api/Informe2', {method: 'GET'});

        if (!response.ok) {
          throw new Error('No se pudo lograr comunicación');
        }

        const data = await response.json();
        aviso.classList.add("d-none")

        if(data.success){
          //console.log(data.resumen.map(row => row.superhero))
          //console.log(data.resumen.map(row => row.popularidad))

          grafico.data.labels = data.resumen.map(row => row.superhero)
          grafico.data.datasets[0].data = data.resumen.map(row => row.popularidad)

          grafico.update()
        }
      } catch (error) {
        console.error(error);
      }
    });

  renderGraphic()

  const amigos = [
    {nombre: 'Luis', edad: 25, ciudad: 'Lima'},
    {nombre: 'Hugo', edad: 15, ciudad: 'Ica'},
    {nombre: 'Juan', edad: 18, ciudad: 'Trujillo'},
    {nombre: 'Sofia', edad: 35, ciudad: 'Arequipa'},
    {nombre: 'Luis', edad: 30, ciudad: 'Tacna'}
  ]

  let nombres = []
  amigos.forEach(element => {
    nombres.push(element.nombre)
  });

  const edades = amigos.map(row => row.edad)
  const ciudades = amigos.map(row => row.ciudad)

  console.log(amigos)
  console.log(edades)
  console.log(nombres)
  console.log(ciudades)

  });
</script>

</body>
</html>