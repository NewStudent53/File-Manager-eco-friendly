<?php
session_start();
include("connect.php");
//include("connectuser.php")
?>

<html><head>
<title>File Manager - My Files</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

  :root {
    --primary-color: #4CAF50;
    --secondary-color: #2196F3;
    --accent-color: #FFC107;
    --background-color: #F1F8E9;
    --text-color: #333333;
    --sidebar-bg: #E8F5E9;
    --hover-color: #81C784;
    --delete-color: #F44336;
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
    width: 250px;
    background-color: var(--sidebar-bg);
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
  }

  .logo {
    width: 100px;
    height: 100px;
    margin: 0 auto 20px;
    display: block;
  }

  .nav-item {
    padding: 10px 15px;
    margin: 5px 0;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .nav-item:hover {
    background-color: var(--hover-color);
  }

  .nav-item.active {
    background-color: var(--primary-color);
    color: white;
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

  .search-bar {
    display: flex;
    align-items: center;
    background-color: white;
    border-radius: 20px;
    padding: 5px 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .search-bar input {
    border: none;
    outline: none;
    padding: 5px;
    font-size: 16px;
    width: 300px;
  }

  .user-info {
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

  .file-card {
    background-color: white;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
  }

  .file-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
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

  .file-actions {
    display: flex;
    justify-content: space-around;
    margin-top: 10px;
  }

  .file-action {
    cursor: pointer;
    padding: 5px;
    border-radius: 5px;
    transition: background-color 0.3s;
  }

  .file-action:hover {
    background-color: var(--hover-color);
  }

  .delete-action:hover {
    background-color: var(--delete-color);
    color: white;
  }

  .upload-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: var(--accent-color);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
  }

  .upload-btn:hover {
    background-color: #FFA000;
    transform: scale(1.1);
  }

  .breadcrumb {
    margin-bottom: 20px;
    font-size: 14px;
  }

  .breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
  }

  .breadcrumb span {
    margin: 0 5px;
  }

  .sort-options {
    margin-bottom: 20px;
  }

  .sort-options select {
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: white;
    font-size: 14px;
  }

  #upload-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    border-radius: 10px;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  #file-input {
    margin: 20px 0;
  }

  #upload-button {
    background-color: var(--primary-color);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }

  #upload-button:hover {
    background-color: var(--hover-color);
  }
</style>
</head>
<body>
  <div class="dashboard">
    <div class="sidebar">
      <svg class="logo" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
        <!-- ... (SVG content remains the same) ... -->
      </svg>
      <div class="nav-item" id="dashboard">Homepage</div>
      <div class="nav-item active" id="myfiles">My Files</div>
      <div class="nav-item" id="trash">Trash</div>
    </div>
    <div class="main-content">
      <div class="header">
        <div class="search-bar">
          <input type="text" placeholder="Search in My Files...">
        </div>
        <div class="user-info">
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
      <div class="breadcrumb">
        <a href="/dashboard">Home</a> <span>></span> <strong>My Files</strong>
      </div>
      <h2>My Files</h2>
      <div class="sort-options">
        <select>
          <option>Sort by: Name</option>
          <option>Sort by: Date Modified</option>
          <option>Sort by: Size</option>
          <option>Sort by: Type</option>
        </select>
      </div>
      <div class="file-grid" id="file-grid">
        <!-- File cards will be dynamically added here -->
      </div>
    </div>
  </div>
  <div class="upload-btn" id="upload-btn">+</div>

  <div id="upload-modal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Upload File</h2>
      <input type="file" id="file-input" multiple>
      <button id="upload-button">Upload</button>
    </div>
  </div>

  <script>
    // Sample file data
    const files = [
      { name: "Project Proposal.docx", type: "document", modified: "2 days ago" },
      { name: "Q2 Report.xlsx", type: "spreadsheet", modified: "1 week ago" },
      { name: "Logo Design.png", type: "image", modified: "3 days ago" },
      { name: "Client Meetings", type: "folder", modified: "Yesterday" },
      { name: "Product Demo.mp4", type: "video", modified: "5 days ago" },
      { name: "Meeting Notes.txt", type: "text", modified: "4 hours ago" },
      { name: "Budget Forecast.xlsx", type: "spreadsheet", modified: "1 day ago" },
      { name: "Assets", type: "folder", modified: "2 weeks ago" }
    ];

    const fileGrid = document.getElementById('file-grid');
    const uploadBtn = document.getElementById('upload-btn');
    const uploadModal = document.getElementById('upload-modal');
    const closeBtn = document.getElementsByClassName('close')[0];
    const fileInput = document.getElementById('file-input');
    const uploadButton = document.getElementById('upload-button');

    function getFileIcon(type) {
      switch(type) {
        case 'document': return '📄';
        case 'spreadsheet': return '📊';
        case 'image': return '🖼️';
        case 'folder': return '📁';
        case 'video': return '📽️';
        case 'text': return '📝';
        default: return '📄';
      }
    }

    function renderFiles() {
      fileGrid.innerHTML = '';
      files.forEach(file => {
        const fileCard = document.createElement('div');
        fileCard.className = 'file-card';
        fileCard.innerHTML = `
          <div class="file-icon">${getFileIcon(file.type)}</div>
          <div class="file-name">${file.name}</div>
          <div class="file-info">Modified: ${file.modified}</div>
          <div class="file-actions">
            <span class="file-action view-action">👁️ View</span>
            <span class="file-action delete-action">🗑️ Delete</span>
          </div>
        `;
        fileGrid.appendChild(fileCard);

        // Add event listeners for view and delete actions
        fileCard.querySelector('.view-action').addEventListener('click', () => viewFile(file));
        fileCard.querySelector('.delete-action').addEventListener('click', () => deleteFile(file));
      });
    }

    function viewFile(file) {
      alert(`Viewing ${file.name}`);
      // Here you would implement the actual file viewing logic
    }

    function deleteFile(file) {
      if (confirm(`Are you sure you want to delete ${file.name}?`)) {
        const index = files.indexOf(file);
        if (index > -1) {
          files.splice(index, 1);
          renderFiles();
        }
      }
    }

    uploadBtn.onclick = function() {
      uploadModal.style.display = "block";
    }

    closeBtn.onclick = function() {
      uploadModal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == uploadModal) {
        uploadModal.style.display = "none";
      }
    }

    uploadButton.onclick = function() {
      const newFiles = fileInput.files;
      for (let i = 0; i < newFiles.length; i++) {
        const file = newFiles[i];
        files.push({
          name: file.name,
          type: file.type.split('/')[0],
          modified: 'Just now'
        });
      }
      renderFiles();
      uploadModal.style.display = "none";
      fileInput.value = ''; // Clear the file input
    }

    // Initial render
    renderFiles();

    // Other event listeners (sorting, navigation) remain the same
    document.querySelector('.sort-options select').addEventListener('change', function() {
      const sortBy = this.value.split(': ')[1].toLowerCase();
      files.sort((a, b) => {
        if (a[sortBy] < b[sortBy]) return -1;
        if (a[sortBy] > b[sortBy]) return 1;
        return 0;
      });
      renderFiles();
    });

    document.querySelectorAll('.nav-item').forEach(item => {
      item.addEventListener('click', function() {
        document.querySelector('.nav-item.active').classList.remove('active');
        this.classList.add('active');
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      const dashboardElement = document.getElementById('dashboard');
      if (dashboardElement) {
        dashboardElement.addEventListener('click', function() {
          window.location.href = 'dashboard.php';
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