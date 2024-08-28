<?php
session_start();
include("connect.php");

?>
<html><head>
<title>File Manager - Dashboard</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

  :root {
    --primary-color: #4CAF50;
    --secondary-color: #2196F3;
    --accent-color: #FFC107;
    --background-color: #F1F8E9;
    --text-color: #333333;
    --sidebar-width: 250px;
  }

  body, html {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    height: 100%;
    background-color: var(--background-color);
    color: var(--text-color);
  }

  .dashboard {
    display: flex;
    height: 100vh;
  }

  .sidebar {
    width: var(--sidebar-width);
    background-color: #ffffff;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    padding: 20px;
  }

  .logo {
    width: 100px;
    height: 100px;
    margin-bottom: 20px;
  }

  .nav-item {
    padding: 10px 15px;
    margin: 5px 0;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .nav-item:hover {
    background-color: var(--background-color);
  }

  .nav-item.active {
    background-color: var(--primary-color);
    color: #ffffff;
  }

  .main-content {
    flex-grow: 1;
    padding: 20px;
    overflow-y: auto;
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .user-profile {
    display: flex;
    align-items: center;
  }

  .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .file-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
  }

  .file-item {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .file-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }

  .file-icon {
    font-size: 48px;
    margin-bottom: 10px;
  }

  .file-name {
    font-weight: 600;
    margin-bottom: 5px;
  }

  .file-info {
    font-size: 12px;
    color: #666;
  }

</style>
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
      <div class="header">
        <div class="user-profile">
          <img src="https://i.pravatar.cc/100" alt="User Avatar" class="user-avatar">
          <span>
          <?php 
       if(isset($_SESSION['email'])){
        $email=$_SESSION['email'];
        $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
        while($row=mysqli_fetch_array($query)){
            echo $row['username'];
        }
       }
       ?>
      </p>
          </span>
        </div>
      </div>
      <h1>Home</h1>
      <div class="file-grid">
      <div style="text-align:center; padding:15%;">
      <p  style="font-size:50px; font-weight:bold;">
       Hello  <?php 
       if(isset($_SESSION['email'])){
        $email=$_SESSION['email'];
        $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
        while($row=mysqli_fetch_array($query)){
            echo $row['username'];
        }
       }
       ?>
       :)
      </p>
      <a href="logout.php">Logout</a>
    </div>
      </div>
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
          window.location.href = 'trash.php';
        });
      }
    });
    
  </script>
</body></html>