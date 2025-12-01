# Bons-AI - Sistema de Gestión de Bonsáis

Sistema web completo con CRUD para gestión de usuarios, cotizaciones y administración de un negocio de bonsáis.

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

## Descripción

**Bons-AI** es una aplicación web completa desarrollada con tecnologías web fundamentales (HTML, CSS, JavaScript, PHP y MySQL) que permite gestionar un negocio de bonsáis con las siguientes características:

- Landing page moderno y responsive
- Sistema de autenticación (registro e inicio de sesión)
- Formulario de cotizaciones con validación completa
- Panel de administración CRUD
- Diseño profesional y UX optimizada
- Seguridad implementada (encriptación, SQL injection prevention)

## Características Principales

### Frontend
- Landing page con video hero
- Galería de productos
- Testimonios de clientes
- Diseño responsive para móviles y tablets
- Validación de formularios en tiempo real con JavaScript

### Backend
- Sistema de registro con contraseñas seguras
- Inicio de sesión con sesiones PHP
- Sistema de roles (Administrador/Usuario)
- CRUD completo de usuarios
- Gestión de cotizaciones
- Respuestas a cotizaciones desde el panel admin

### Seguridad
- Contraseñas encriptadas con bcrypt
- Protección contra SQL injection (PDO preparado)
- Sanitización de datos de salida
- Validación dual (cliente + servidor)
- Control de acceso por roles

## Tecnologías Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Backend:** PHP 8.0+
- **Base de Datos:** MySQL 8.0+
- **Servidor Local:** XAMPP (Apache + MySQL)

## Estructura del Proyecto

```
proyecto-final-AW-Copy/
│
├── admin/                      # Panel de administración
│   ├── index.php              # Dashboard con CRUD
│   └── user_edit.php          # Editar usuarios
│
├── controllers/               # Controladores PHP
│   ├── login.php             # Procesar login
│   ├── logout.php            # Cerrar sesión
│   ├── user_store.php        # Crear usuario
│   ├── user_update.php       # Actualizar usuario
│   ├── user_delete.php       # Eliminar usuario
│   ├── quote_store.php       # Guardar cotización
│   └── quote_response.php    # Responder cotización
│
├── includes/                  # Funciones PHP
│   ├── init.php              # Inicialización
│   ├── auth.php              # Autenticación
│   ├── db.php                # Conexión BD
│   └── helpers.php           # Funciones auxiliares
│
├── css/                       # Estilos
│   └── styles.css            # CSS personalizado (1500+ líneas)
│
├── img/                       # Imágenes
├── video/                     # Videos
├── bonsai.sql                # Script de base de datos
├── config.php                # Configuración
├── index.php                 # Landing page
├── login.php                 # Página de login
├── register.php              # Página de registro
├── catalogo.php              # Catálogo con formulario
└── mis-cotizaciones.php      # Cotizaciones del usuario
```

## Instalación

### Requisitos Previos
- XAMPP instalado (Apache + MySQL + PHP)
- Navegador web moderno

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/FRQ23/proyecto-AW.git
```

2. **Mover a htdocs de XAMPP**
```bash
# Windows
Copiar a: C:\xampp\htdocs\proyecto-AW

# Mac/Linux
Copiar a: /Applications/XAMPP/htdocs/proyecto-AW
```

3. **Iniciar XAMPP**
- Abrir XAMPP Control Panel
- Iniciar **Apache**
- Iniciar **MySQL**

4. **Crear Base de Datos**
- Ir a: `http://localhost/phpmyadmin`
- Hacer clic en **"Importar"**
- Seleccionar el archivo `bonsai.sql`
- Hacer clic en **"Continuar"**

5. **Configurar Conexión (si es necesario)**
Editar `config.php` si tus credenciales son diferentes:
```php
'host' => '127.0.0.1',
'port' => 3306,
'name' => 'bonsai',
'user' => 'root',
'password' => '',
```

6. **Acceder al Proyecto**
```
http://localhost/proyecto-AW/
```

## Credenciales de Acceso

### Usuario Administrador (Panel CRUD)
```
Email: admin@bonsai.com
Contraseña: Admin@123
```

### Usuario Normal (Solo cotizaciones)
```
Email: usuario@bonsai.com
Contraseña: Usuario@123
```

## Capturas de Pantalla

### Landing Page
![Landing Page](docs/screenshots/landing.png)

### Panel de Administración
![Panel Admin](docs/screenshots/admin-panel.png)

### Formulario de Registro con Validación
![Registro](docs/screenshots/register.png)

### Mis Cotizaciones
![Cotizaciones](docs/screenshots/cotizaciones.png)

## Funcionalidades CRUD

| Operación | Descripción | Quién puede |
|-----------|-------------|-------------|
| **CREATE** | Registrar usuarios, crear cotizaciones | Todos |
| **READ** | Ver usuarios, ver cotizaciones | Solo Admin |
| **UPDATE** | Editar usuarios, responder cotizaciones | Solo Admin |
| **DELETE** | Eliminar usuarios (CASCADE a cotizaciones) | Solo Admin |

## Validaciones Implementadas

### Registro de Usuario
- Nombre completo (mínimo 3 caracteres)
- Email válido (regex)
- Contraseña segura:
  - Mínimo 8 caracteres
  - Al menos 1 mayúscula
  - Al menos 1 minúscula
  - Al menos 1 número
  - Al menos 1 carácter especial
- Confirmación de contraseña
- Checkbox de términos obligatorio
- Validación en tiempo real (JavaScript)
- Validación del lado del servidor (PHP)

### Formulario de Cotización
- Tipo de bonsái (requerido)
- Tamaño (requerido)
- Teléfono con formato válido (opcional)
- Mensaje con contador de caracteres (máx. 500)
- Feedback visual inmediato

## Base de Datos

### Tabla: `users`
```sql
- id (PK)
- full_name
- email (UNIQUE)
- password_hash
- is_admin (0=usuario, 1=admin)
- accepted_terms
- created_at
```

### Tabla: `quotes`
```sql
- id (PK)
- user_id (FK → users.id) CASCADE
- full_name
- email
- phone
- bonsai_type
- size
- budget
- message
- response_message
- response_sent_at
- created_at
```

**Relación:** Un usuario puede tener múltiples cotizaciones (1:N)

## Acceso desde Red Local

Para acceder desde tu celular en la misma red WiFi:

1. Encuentra tu IP:
```bash
# Windows
ipconfig

# Mac/Linux
ifconfig
```

2. Accede desde el celular:
```
http://TU_IP/proyecto-AW/
Ejemplo: http://192.168.1.100/proyecto-AW/
```

3. Configurar Firewall (Windows):
```powershell
New-NetFirewallRule -DisplayName "Apache" -Direction Inbound -Action Allow -Protocol TCP -LocalPort 80
```

## Solución de Problemas

### Error: "No se puede conectar a la base de datos"
- Verificar que MySQL esté corriendo en XAMPP
- Importar el archivo `bonsai.sql`
- Verificar credenciales en `config.php`

### Error: "Unknown column 'is_admin'"
```sql
ALTER TABLE users ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0 AFTER password_hash;
```

### Error: "Unknown column 'user_id' in quotes"
```sql
ALTER TABLE quotes ADD COLUMN user_id INT(10) UNSIGNED NOT NULL DEFAULT 1 AFTER id;
ALTER TABLE quotes ADD CONSTRAINT quotes_user_id_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
```

## Autor

**Fernando Rosales**
- Email: fernando.rosales59@uabc.edu.mx
- Universidad Autónoma de Baja California
- Materia: Aplicaciones Web

## Licencia

Este proyecto es académico y fue desarrollado como proyecto final para la materia de Aplicaciones Web.

## Agradecimientos

- Universidad Autónoma de Baja California
- Profesor de Aplicaciones Web
- Comunidad de desarrolladores PHP

---

Copyright 2025 Bons-AI. Proyecto Académico - Aplicaciones Web

