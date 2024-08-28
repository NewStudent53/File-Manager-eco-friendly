<?php
session_start();
include("connect.php");
?>
<html>
<head>
  <title>File Manager - Dashboard</title>
  <link rel="stylesheet" type="text/css" href="styles/home.css">
</head>
<body>
  <div class="dashboard">
    <div class="sidebar">
      <svg class="logo" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="leafGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#4CAF50;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#81C784;stop-opacity:1" />
          </linearGradient>
          <linearGradient id="folderGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#2196F3;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#64B5F6;stop-opacity:1" />
          </linearGradient>
        </defs>
        
        <!-- Folder shape -->
        <path d="M50,80 L250,80 L250,250 L50,250 Z" fill="url(#folderGradient)" />
        <path d="M50,80 L130,80 L150,50 L250,50 L250,80" fill="url(#folderGradient)" />
        
        <!-- Leaf shape -->
        <path d="M150,100 Q200,150 150,200 Q100,150 150,100" fill="url(#leafGradient)" />
        
        <!-- Recycling arrows -->
        <path d="M140,170 A30,30 0 1,1 170,140" fill="none" stroke="#FFC107" stroke-width="10" stroke-linecap="round" />
        <path d="M170,200 A30,30 0 1,1 140,170" fill="none" stroke="#FFC107" stroke-width="10" stroke-linecap="round" />
        <path d="M200,170 A30,30 0 1,1 170,200" fill="none" stroke="#FFC107" stroke-width="10" stroke-linecap="round" />
        
        <!-- Arrow tips -->
        <polygon points="137,168 143,162 149,174" fill="#FFC107" />
        <polygon points="172,203 166,197 178,191" fill="#FFC107" />
        <polygon points="203,168 197,174 191,162" fill="#FFC107" />
      </svg>
      <div class="nav-item active">Homepage</div>
      <div class="nav-item" id="myfiles">My Files</div>
      <div class="nav-item" id="trash">Trash</div>
    </div>
    <div class="main-content">
  <div class="file-grid">
        <?php 
        if(isset($_SESSION['email'])){
          $email=$_SESSION['email'];
          $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
          while($row=mysqli_fetch_array($query)){
            echo "username: ";  
            echo $row['username'];
          }
        }
        ?>
            <div style="text-align:center; padding:15%;">
      <p style="font-size:50px; font-weight:bold; display: inline;">
        Welcome!  
      </p>
    </div>
  </div>

  <!-- Descripción del Proyecto -->
  <div class="project-description">
    <h2>Proyecto: File Manager App</h2>
    <p><strong>Descripción del Proyecto:</strong> El <em>File Manager</em> es una aplicación web diseñada para facilitar la gestión y organización de archivos de los usuarios. Permite a los usuarios subir, eliminar y buscar archivos de manera eficiente y segura. Además, incluye características avanzadas como la protección contra archivos no permitidos.</p>
    
    <h3>Características Principales</h3>
    <ul>
      <li><strong>Subida de Archivos:</strong> Los usuarios pueden subir archivos a su espacio personal en el servidor.</li>
      <li><strong>Eliminación de Archivos:</strong> Los usuarios pueden eliminar archivos, tanto del servidor como de la base de datos.</li>
      <li><strong>Búsqueda de Archivos:</strong> Los usuarios pueden buscar archivos por nombre, tipo, tamaño y fecha de modificación.</li>
      <li><strong>Protección de Seguridad:</strong> Se implementan medidas para evitar la subida de archivos peligrosos (como `.exe`) y proteger contra inyecciones SQL.</li>
      <li><strong>Mensajes de Confirmación:</strong> El sistema muestra mensajes de éxito o error al realizar acciones como subir, eliminar o modificar archivos.</li>
    </ul>
    
    <h3>Seguridad y Validaciones</h3>
    <ul>
      <li><strong>Validación de Archivos:</strong> Se verifica que los archivos subidos no sean de tipo `.exe`.</li>
      <li><strong>Mensajes de Confirmación:</strong> Se muestran mensajes claros al usuario sobre el éxito o fracaso de las operaciones realizadas.</li>
    </ul>
    
    <h3>Flujo de Trabajo</h3>
    <ol>
      <li><strong>Inicio de Sesión:</strong> El usuario inicia sesión en la aplicación.</li>
      <li><strong>Subida de Archivos:</strong> El usuario selecciona y sube archivos a su espacio personal.</li>
      <li><strong>Gestión de Archivos:</strong> El usuario puede buscar, descargar o eliminar archivos.</li>
      <li><strong>Mensajes de Confirmación:</strong> El sistema informa al usuario sobre el estado de las operaciones.</li>
    </ol>
  </div>
</div>


  <script>

    document.querySelectorAll('.file-item').forEach(item => {
      item.addEventListener('click', () => {
        alert(`Opening ${item.querySelector('.file-name').textContent}`);
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      const filesElement = document.getElementById('myfiles');
      if (filesElement) {
        filesElement.addEventListener('click', function() {
          window.location.href = 'myfiles.php';
        });
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      const trashElement = document.getElementById('trash');
      if (trashElement) {
        trashElement.addEventListener('click', function() {
          window.location.href = 'Mytrashfiles.php';
        });
      }
    });
    
  </script>
</body></html>