<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Apellidos</th>
      <th>Nombres</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>1</th>
      <th>Cardenas</th>
      <th>Luis</th>
    </tr>
    <tr>
      <th>2</th>
      <th>Pachas</th>
      <th>Jose</th>
    </tr>
    <tr>
      <th>3</th>
      <th>Miguel</th>
      <th>Rodrigo</th>
    </tr>
  </tbody>
</table>
<button></button>

<script type="text/javascript" src=""></script>

<script>
  document.addEventListener("DOMContentLoaded", ()=>{
    btn.addEventListener("click", () => {
      const tabla = document.getElementById('tabla-datos')
  
      const workBook = XLSX.utils.table_to_book(tabla,{sheet: 'Contactos'})
  
      XLSX.writeFile(workBook, "Repostea.xlsx")
    })
  })
</script>
</body>
</html>