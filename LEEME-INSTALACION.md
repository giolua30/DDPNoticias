# Cómo instalar el sistema en tu computadora (XAMPP)

Sigue estos pasos EN ORDEN. No necesitas escribir código, solo copiar archivos
y hacer clic en algunos botones.

---

## 1. Instalar XAMPP (si no lo tienes)

1. Descarga XAMPP desde https://www.apachefriends.org/es/index.html (elige la
   versión con PHP 8.x).
2. Instálalo dejando todo por defecto.
3. Abre el programa **"XAMPP Control Panel"**.
4. Dale click en **Start** en las filas de **Apache** y **MySQL**. Ambas
   deben quedar en verde.

---

## 2. Copiar el proyecto a la carpeta de XAMPP

1. Abre la carpeta donde instalaste XAMPP. Normalmente es:
   `C:\xampp\htdocs`
2. Copia toda la carpeta **`dyd-cms`** (la que te acabo de entregar) dentro
   de `htdocs`. Debe quedar así:
   `C:\xampp\htdocs\dyd-cms`

---

## 3. Copiar tus imágenes, jQuery, Bootstrap, etc.

Yo no tengo tus archivos de imágenes/JS actuales (logo.png, video.jpg,
jquery, owl.carousel, etc.), solo el código HTML y el CSS que me pasaste.
Así que:

1. Ve a tu sitio actual (la carpeta donde tienes tu `index.html` original).
2. Copia toda tu carpeta `assets` completa (con `css`, `js`, `images`,
   `fonts` adentro) y pégala dentro de `dyd-cms`, reemplazando la carpeta
   `assets` que ya viene (que solo tiene una carpeta `images` vacía).
3. Verifica que quede así:
   `C:\xampp\htdocs\dyd-cms\assets\css\style-starter.css`
   `C:\xampp\htdocs\dyd-cms\assets\images\logo.png`
   `C:\xampp\htdocs\dyd-cms\assets\js\jquery-3.3.1.min.js`
   (etc. — todo lo que ya tenías)

---

## 4. Crear la base de datos

1. Abre tu navegador y entra a: **http://localhost/phpmyadmin**
2. Click en la pestaña **"Importar"** (arriba).
3. Click en **"Seleccionar archivo"** y elige:
   `C:\xampp\htdocs\dyd-cms\database\dyd_database.sql`
4. Baja hasta el final y dale click a **"Continuar"** / **"Importar"**.
5. Debe aparecer un mensaje verde de éxito y a la izquierda debe aparecer
   una nueva base de datos llamada **`revista_digital`** con 7 tablas.

Esto ya te deja un usuario administrador creado:

- **Correo:** `admin@dialogoydesarrollo.com.pe`
- **Contraseña:** `admin123`

(la puedes cambiar más adelante directamente en la tabla `usuarios` de
phpMyAdmin, o dime y te preparo una pantalla de "cambiar contraseña").

---

## 5. Revisar la configuración de conexión

Abre el archivo `dyd-cms/config.php` con el Bloc de notas o VS Code. En
XAMPP normalmente **no hay que cambiar nada**, ya viene listo:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'revista_digital');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', 'http://localhost/dyd-cms');
```

Solo cambia `BASE_URL` si pusiste la carpeta con otro nombre distinto a
`dyd-cms`.

---

## 6. Dar permisos de escritura a la carpeta uploads

Esta carpeta es donde se guardan las fotos y PDFs que subas desde el panel.
En Windows con XAMPP normalmente ya funciona sin hacer nada. Si al subir una
imagen te sale error, click derecho sobre la carpeta `uploads` →
Propiedades → Seguridad → dale permiso de "Control total" a "Todos".

---

## 7. Probar que todo funcione

1. **Sitio público:** entra a `http://localhost/dyd-cms/index.php`
   (verás la página vacía porque aún no cargaste contenido, eso es normal).
2. **Panel de administración:** entra a
   `http://localhost/dyd-cms/admin/login.php`
   - Correo: `admin@dialogoydesarrollo.com.pe`
   - Contraseña: `admin123`
3. Dentro del panel, ve a **Reportajes → Nuevo reportaje** y crea uno de
   prueba con foto y fecha de hoy.
4. Vuelve a `http://localhost/dyd-cms/index.php` y refresca: el reportaje
   que acabas de crear ya debería aparecer en la portada. 🎉

---

## 8. Cómo se usa el panel día a día

Desde `http://localhost/dyd-cms/admin/login.php` puedes administrar:

| Sección          | Para qué sirve                                                |
|-------------------|----------------------------------------------------------------|
| Reportajes        | Las notas largas con foto y desarrollo completo                |
| Noticias          | Notas cortas que enlazan a Facebook u otro medio                |
| Boletín NTEP      | Cada número del boletín (PDF + portada)                         |
| Podcast           | Enlaces a episodios (Spotify, YouTube, etc.)                     |
| Videos            | Enlaces embebidos de YouTube                                    |
| Autores           | Para asignar quién escribió cada reportaje                      |

Marca la casilla **"Mostrar como destacado en portada"** en el reportaje que
quieras que aparezca grande arriba de todo en el home.

---

## 9. Cuando quieras subirlo a tu hosting real (dialogoydesarrollo.com.pe)

Cuando ya lo hayas probado en tu computadora y quieras subirlo al hosting de
verdad, avísame y te explico paso a paso cómo:
1. Exportar la base de datos de tu XAMPP e importarla en el phpMyAdmin de tu
   hosting (cPanel).
2. Subir los archivos por FTP o el Administrador de archivos de cPanel.
3. Cambiar `config.php` con los datos de la base de datos de tu hosting
   (te los da tu proveedor) y poner `BASE_URL` en
   `https://www.dialogoydesarrollo.com.pe`.

Es un proceso parecido a este, con datos distintos: te acompaño cuando
llegues a ese paso.
