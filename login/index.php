<html><head>
    <title>File Manager - Eco-Friendly Cloud Storage for 2024</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
      <div class="container">
        <div class="content-wrapper neumorphic">
          <div class="hero-section">
            <div class="logo-container">
              <svg class="logo" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient id="leafGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#10B981;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#34D399;stop-opacity:1" />
                  </linearGradient>
                  <linearGradient id="folderGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#60A5FA;stop-opacity:1" />
                  </linearGradient>
                </defs>
                
                <!-- Folder shape -->
                <path d="M50,80 L250,80 L250,250 L50,250 Z" fill="url(#folderGradient)" />
                <path d="M50,80 L130,80 L150,50 L250,50 L250,80" fill="url(#folderGradient)" />
                
                <!-- Leaf shape -->
                <path d="M150,100 Q200,150 150,200 Q100,150 150,100" fill="url(#leafGradient)" />
                
                <!-- Recycling arrows -->
                <path d="M140,170 A30,30 0 1,1 170,140" fill="none" stroke="#F59E0B" stroke-width="10" stroke-linecap="round" />
                <path d="M170,200 A30,30 0 1,1 140,170" fill="none" stroke="#F59E0B" stroke-width="10" stroke-linecap="round" />
                <path d="M200,170 A30,30 0 1,1 170,200" fill="none" stroke="#F59E0B" stroke-width="10" stroke-linecap="round" />
                
                <!-- Arrow tips -->
                <polygon points="137,168 143,162 149,174" fill="#F59E0B" />
                <polygon points="172,203 166,197 178,191" fill="#F59E0B" />
                <polygon points="203,168 197,174 191,162" fill="#F59E0B" />
              </svg>
            </div>
            <h1>File Manager</h1>
            <p class="hero-text">Experience the future of cloud storage. Seamlessly manage your files with our eco-friendly, AI-powered platform designed for the modern digital age.</p>
            <div class="eco-badge glass">
              🌿 Zero Carbon • Smart Storage • Secure
            </div>
          </div>
          <div class="form-section">
            <div id="loginForm">
              <h2>Welcome Back</h2>
              
              <form method="post" action="checkuser.php">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn" name="signIn">Login</button>
    </form>
              <p class="switch-form" onclick="switchForm('register')">New to File Manager? Join us!</p>
            </div>
            <div id="registerForm" style="display: none;">
              <h2>Join File Manager</h2>
              <form method="post" action="register.php" id="registerForm">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" id="username" placeholder="User name" required>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm password" required>
        </div>
        <button type="submit" class="btn" value="Register" name="signUp">Create an Account</button>
    </form>              <p class="switch-form" onclick="switchForm('login')">Already a member? Log in</p>
            </div>
          </div>
        </div>
      </div>
    
      <script>
        function switchForm(formType) {
          const loginForm = document.getElementById('loginForm');
          const registerForm = document.getElementById('registerForm');
          if (formType === 'login') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
          } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
          }
        }
      </script>
    </body></html>