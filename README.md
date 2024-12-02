
# OpenStore

OpenStore es una plataforma web para la distribución de aplicaciones, 
donde los desarrolladores pueden subir y compartir sus aplicaciones con los usuarios. 
La tienda permite a los usuarios explorar aplicaciones, descargarlas mediante enlaces directos y administrar sus perfiles. 
Además, los desarrolladores tienen un panel de control para gestionar las aplicaciones subidas, modificarlas y eliminarlas. 
El objetivo de OpenStore es proporcionar un entorno fácil de usar y accesible para todos, tanto para desarrolladores como para usuarios.

## Características

- **Registro de usuarios**: Los usuarios pueden registrarse, iniciar sesión y modificar sus perfiles.
- **Subida de aplicaciones**: Los desarrolladores pueden subir sus aplicaciones junto con un icono y una descripción.
- **Descarga de aplicaciones**: Los usuarios pueden explorar y descargar aplicaciones mediante enlaces directos proporcionados por los desarrolladores.
- **Panel de control**: Los desarrolladores tienen un panel donde pueden ver y gestionar las aplicaciones subidas, así como eliminarlas si es necesario.
- **Interfaz moderna**: Diseño responsivo y atractivo utilizando Tailwind CSS y Flowbite.

## Estructura del Proyecto

La estructura del proyecto está organizada de la siguiente manera:

```
OpenStore/
│
├── assets/                # Archivos estáticos, como imágenes, iconos, etc.
│
│
├── php/                   # Archivos PHP que gestionan la lógica del backend
│   ├── db.php             # Configuración de la base de datos
│   ├── login.php          # Página de inicio de sesión
│   ├── logout.php         # Lógica para cerrar sesión
│   ├── profile.php        # Página para modificar perfil de usuario
│   ├── upload_app.php     # Página para subir aplicaciones
│   ├── panel.php          # Panel de control de usuario
│   └── register.php       # Página para registrar nuevos usuarios
│
└── index.php              # Página principal de la tienda


```

### Descripción de los Archivos

- **`assets/`**: Contiene recursos estáticos como imágenes y archivos multimedia.
- **`css/`**: Carpeta con los archivos de estilo, incluyendo el archivo principal `styles.css`.
- **`js/`**: Carpeta con archivos JavaScript que implementan la lógica de interacción en la tienda.
- **`php/`**: Archivos PHP que gestionan la lógica del backend, incluidos los formularios de registro, inicio de sesión, subida de aplicaciones, modificación de perfil y administración del panel de usuario.
- **`index.php`**: La página principal donde los usuarios pueden explorar las aplicaciones disponibles en la tienda.
- **`README.md`**: Documentación del proyecto para proporcionar información sobre la estructura y funcionamiento.
- **`.gitignore`**: Archivos y carpetas que no deben ser versionados por Git (por ejemplo, archivos temporales o de configuración local).

## Requisitos

- **Servidor web**: Apache o Nginx.
- **PHP**: Versión 7.4 o superior.
- **Base de datos**: MySQL.
- **Extensiones PHP**: `mysqli`, `session`, `fileinfo` (para manejo de archivos y sesiones).

## Instalación

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/usuario/OpenStore.git
   ```

2. **Configurar la base de datos**:
   - Crea una base de datos MySQL llamada `app_store`.
   - Ejecuta el script SQL para crear las tablas necesarias (se puede agregar en la carpeta `php` un archivo de migración como `create_db.sql`).

3. **Configurar el archivo de conexión a la base de datos**:
   - Abre el archivo `php/db.php` y configura los detalles de conexión a tu base de datos.

4. **Subir el proyecto a tu servidor**:
   - Sube el proyecto a tu servidor web, asegurándote de que los permisos de los archivos sean correctos y de que el servidor pueda acceder a la base de datos.

5. **Accede a la tienda**:
   - Accede al proyecto a través de tu navegador (por ejemplo, `http://localhost/OpenStore/`).

## Uso

1. **Registro y inicio de sesión**:
   - Los usuarios pueden registrarse o iniciar sesión en la tienda mediante la página de registro e inicio de sesión.

2. **Subir aplicaciones**:
   - Los desarrolladores pueden acceder al panel de control para subir nuevas aplicaciones con un icono, nombre y descripción.

3. **Explorar y descargar aplicaciones**:
   - Los usuarios pueden explorar las aplicaciones disponibles en la tienda y descargarlas haciendo clic en el enlace de descarga.

4. **Modificar perfil**:
   - Los usuarios pueden modificar su nombre, correo electrónico y avatar desde la página de perfil.

5. **Eliminar aplicaciones**:
   - Los desarrolladores pueden eliminar aplicaciones desde su panel de control si ya no desean que estén disponibles.

## Contribución

¡Las contribuciones son bienvenidas! Si deseas colaborar en el proyecto, por favor sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una rama para tu nueva característica (`git checkout -b feature/nueva-caracteristica`).
3. Realiza tus cambios y haz commit de ellos (`git commit -am 'Añadir nueva característica'`).
4. Haz push a la rama (`git push origin feature/nueva-caracteristica`).
5. Abre un pull request.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.

---

Gracias por visitar **OpenStore**. Esperamos que disfrutes de la experiencia de compartir y descubrir aplicaciones.
