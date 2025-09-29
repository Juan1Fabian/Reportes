# Reportes-Superhero

Proyecto en CodeIgniter 4 para generar reportes y gráficos de superhéroes.

## Requisitos
- PHP
- Base de datos configurada en `.env`
- Servidor web apuntando a `public/` (Laragon/XAMPP)

## Puesta en marcha (local)
1) Copia `envCopy` a `.env` y configura:
   - `app.baseURL = http://localhost/Reportes-Superhero/public` (ajusta a tu entorno)
   - Conexión BD (por ejemplo):
     - `database.default.hostname = localhost`
     - `database.default.database = superhero`
     - `database.default.username = root`
     - `database.default.password = ''`
     - `database.default.DBDriver = MySQLi`
2) Ejecuta con tu stack local (Laragon/XAMPP) apuntando `DocumentRoot` a `public/`.
   - Alternativa (si usas spark): `php spark serve` (asegúrate de que tu baseURL corresponda).

## Rutas clave
- UI gráficos:

## Exportar PDF (rápido)
1. Abre `/dashboard/genderReporte`.
2. Marca uno o más géneros (opcional: nombre y límite).
3. Enviar → descarga/visualiza el PDF (`genderReporte.php`).

## Archivos clave
- Vistas: `app/Views/dashboard/PublisherCont.php`, `PublisherWeight.php`, `getGenero.php`, `genderReporte.php`
- Controlador: `app/Controllers/DashboardController.php`

## Autor
JUAN FABIAN TRUCIOS QUISPE