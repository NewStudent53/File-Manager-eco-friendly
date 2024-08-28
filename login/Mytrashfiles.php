<?php
session_start();
include("connect.php");
?>

<html><head>
<title>File Manager - My Trash Files</title>
<link rel="stylesheet" href="styles/stylishA.css">
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
        <path d="M50,80 L250,80 L250,250 L50,250 Z" fill="url(#folderGradient)" />
        <path d="M50,80 L130,80 L150,50 L250,50 L250,80" fill="url(#folderGradient)" />
        <path d="M150,100 Q200,150 150,200 Q100,150 150,100" fill="url(#leafGradient)" />
        <path d="M140,170 A30,30 0 1,1 170,140" fill="none" stroke="#FFC107" stroke-width="10" stroke-linecap="round" />
        <path d="M170,200 A30,30 0 1,1 140,170" fill="none" stroke="#FFC107" stroke-width="10" stroke-linecap="round" />
        <path d="M200,170 A30,30 0 1,1 170,200" fill="none" stroke="#FFC107" stroke-width="10" stroke-linecap="round" />
        <polygon points="137,168 143,162 149,174" fill="#FFC107" />
        <polygon points="172,203 166,197 178,191" fill="#FFC107" />
        <polygon points="203,168 197,174 191,162" fill="#FFC107" />
      </svg>
      <div class="nav-item" id="dashboard">Homepage</div>
      <div class="nav-item" id="myfiles">My Files</div>
      <div class="nav-item active" id="trash">Trash</div>
    </div>
    <div class="main-content">
      <div class="header">
      <div class="search-bar">
    <input type="text" id="search-input" placeholder="Search in My Files...">
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
            $id = $row['Id'];
            $user_id = $row['Id'];
        }
       }
       ?>
      </p>
      <a href="index.php">Logout</a>
          </span>
        </div>
      </div>
      <h2>My Trash Files</h2>
      <div class="sort-options">
    <select id="sort-options">
        <option value="name">Sort by: Name</option>
        <option value="date">Sort by: Date Modified</option>
        <option value="type">Sort by: Type</option>
    </select>
</div>
<div class="file-grid" id="file-grid">
    <!-- File cards will be dynamically added here -->
</div>
</div>
</div>

<form action="subir-archivo.php" method="post" enctype="multipart/form-data">
    <div id="upload-modal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Upload File</h2>
            <input type="hidden" name="user_id" value="<?php echo $id; ?>">
            <input type="file" name="archivo_fls">
            <button id="upload-button" name="Upload">Upload</button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const userId = <?php echo $id; ?>; // Tu variable user_id
    fetch(`testing/find_trashfiles.php?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verifica los datos en la consola
            const filesFromServer = data.map(file => ({
                name: file.file_name,
                type: file.file_type, // Asegúrate de incluir el tipo de archivo
                path: file.file_path,
                uploadDate: file.upload_date,
                id: file.id
            }));
            console.log('antes', filesFromServer);
            // Iterar sobre el arreglo y imprimir solo el name
            filesFromServer.forEach(file => {
                console.log(file.name);
            });

            console.log('despues', data);

            let files = [
                ...filesFromServer
            ];

            renderFiles(files);

            // Add event listener for sorting
            document.getElementById('sort-options').addEventListener('change', (event) => {
                const sortBy = event.target.value;
                sortFiles(files, sortBy);
                renderFiles(files);
            });

            // Add event listener for search
            document.getElementById('search-input').addEventListener('input', (event) => {
                const searchTerm = event.target.value.toLowerCase();
                const filteredFiles = files.filter(file => file.name.toLowerCase().includes(searchTerm));
                renderFiles(filteredFiles);
            });
        })
        .catch(error => console.error('Error:', error));
});

function renderFiles(files) {
    const fileGrid = document.getElementById('file-grid');
    fileGrid.innerHTML = '';
    files.forEach(file => {
        const fileCard = document.createElement('div');
        fileCard.className = 'file-card';
        fileCard.innerHTML = `
            <div class="file-icon">${getFileIcon(file.type)}</div>
            <div class="file-name">${file.name}</div>
            <div class="file-info">Modified: ${file.uploadDate}</div>
            <div class="file-actions">
                <span class="file-action recover-action">🗃️ Recover</span>
                <form method="POST" action="delete_file.php" onsubmit="return confirmDelete('${file.name}')">
                    <input type="hidden" name="file_id" value="${file.id}">
                    <span class="file-action delete-action">🗑️ Delete</span>
                </form>
            </div>
        `;
        fileGrid.appendChild(fileCard);

        // Add event listeners for view and delete actions
        console.log("este es el file: ", file);
        fileCard.querySelector('.recover-action').addEventListener('click', () => recoverFile(file));
        fileCard.querySelector('.delete-action').addEventListener('click', () => {
            if (confirmDelete(file.name)) {
                fileCard.querySelector('form').submit();
            }
        });
    });
}

function confirmDelete(fileName) {
    return confirm(`Are you sure you want to permanently delete ${fileName}?`);
}

function getFileIcon(type) {
    console.log('!check this out', type);
    switch(type) {
        case 'pdf': return '📝'; // PDF
        case 'msword': return '📄'; // Word
        case 'vnd.ms-excel': return '📊'; // Excel
        case 'vnd.openxmlformats-officedocument.spreadsheetml.sheet': return '📊'; // Excel (xlsx)
        case 'jpeg': return '🖼️'; // JPEG
        case 'jpg': return '🖼️'; // JPG
        case 'png': return '🖼️'; // PNG
        case 'mp4': return '📽️'; // MP4
        case 'plain': return '📝'; // Text
        default: return '📄'; // Default icon
    }
}

function sortFiles(files, sortBy) {
    switch(sortBy) {
        case 'name':
            files.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'date':
            files.sort((a, b) => new Date(b.uploadDate) - new Date(a.uploadDate));
            break;
        case 'type':
            files.sort((a, b) => a.type.localeCompare(b.type));
            break;
    }
}

function recoverFile(file) {
    if (confirm(`Do you want to recover ${file.name}?`)) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_trash_indicator2.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                window.location.href = 'Mytrashfiles.php'; // Redirige a Mytrashfiles.php
            }
        };
        xhr.send(`file_id=${file.id}`);
    }
}

const uploadModal = document.getElementById('upload-modal');
const fileInput = document.getElementById('file-input');
const uploadButton = document.getElementById('upload-button');

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
    
    renderFiles(files);
    uploadModal.style.display = "none";
    fileInput.value = ''; // Clear the file input

    // Initial render
    renderFiles();
}

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
      const filesElement = document.getElementById('myfiles');
      if (filesElement) {
        filesElement.addEventListener('click', function() {
          window.location.href = 'myfiles.php';
        });
      }
    });

  </script>
</body></html>