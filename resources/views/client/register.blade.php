<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CULTURE BENIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }
        
        .register-header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }
        
        .register-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .register-header p {
            opacity: 0.9;
        }
        
        .register-body {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #27ae60;
            outline: none;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }
        
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
        }
        
        .login-link {
            text-align: center;
            color: #7f8c8d;
        }
        
        .login-link a {
            color: #27ae60;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4f4dd;
            color: #27ae60;
            border: 1px solid #27ae60;
        }
        
        .errors {
            background: #ffe0e0;
            color: #e63946;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .errors ul {
            list-style: none;
        }
        
        .password-requirements {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
            font-size: 14px;
            color: #5d6d7e;
        }
        
        .password-requirements ul {
            list-style: none;
            margin-top: 5px;
        }
        
        .password-requirements li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .password-requirements li i {
            color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Rejoindre CULTURE BENIN</h1>
            <p>Contribuez à notre patrimoine culturel</p>
        </div>
        
        <div class="register-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-control" 
                           value="{{ old('name') }}"
                           placeholder="Votre nom"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control" 
                           value="{{ old('email') }}"
                           placeholder="votre@email.com"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="••••••••"
                           required>
                    
                    <div class="password-requirements">
                        <strong>Le mot de passe doit contenir :</strong>
                        <ul>
                            <li id="req-length"><i class="fas fa-circle" style="color: #ccc;"></i> Au moins 8 caractères</li>
                            <li id="req-uppercase"><i class="fas fa-circle" style="color: #ccc;"></i> Une majuscule</li>
                            <li id="req-number"><i class="fas fa-circle" style="color: #ccc;"></i> Un chiffre</li>
                        </ul>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="form-control" 
                           placeholder="••••••••"
                           required>
                    <small id="password-match" style="display: none; color: #27ae60;">
                        <i class="fas fa-check"></i> Les mots de passe correspondent
                    </small>
                </div>
                
                <button type="submit" class="btn-register" id="submitBtn">
                    <i class="fas fa-user-plus"></i> S'inscrire
                </button>
                
                <div class="login-link">
                    Déjà un compte ? 
                    <a href="{{ route('login') }}">Se connecter</a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const passwordMatch = document.getElementById('password-match');
            
            // Vérifier les exigences du mot de passe
            password.addEventListener('input', function() {
                const value = this.value;
                
                // Longueur
                const lengthReq = document.getElementById('req-length');
                lengthReq.querySelector('i').style.color = value.length >= 8 ? '#27ae60' : '#ccc';
                
                // Majuscule
                const uppercaseReq = document.getElementById('req-uppercase');
                uppercaseReq.querySelector('i').style.color = /[A-Z]/.test(value) ? '#27ae60' : '#ccc';
                
                // Chiffre
                const numberReq = document.getElementById('req-number');
                numberReq.querySelector('i').style.color = /[0-9]/.test(value) ? '#27ae60' : '#ccc';
            });
            
            // Vérifier la correspondance des mots de passe
            confirmPassword.addEventListener('input', function() {
                if (password.value && this.value) {
                    if (password.value === this.value) {
                        passwordMatch.style.display = 'block';
                        passwordMatch.style.color = '#27ae60';
                    } else {
                        passwordMatch.style.display = 'block';
                        passwordMatch.style.color = '#e63946';
                        passwordMatch.innerHTML = '<i class="fas fa-times"></i> Les mots de passe ne correspondent pas';
                    }
                } else {
                    passwordMatch.style.display = 'none';
                }
            });
            
            // Validation du formulaire
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Les mots de passe ne correspondent pas.');
                    return false;
                }
                
                if (password.length < 8) {
                    e.preventDefault();
                    alert('Le mot de passe doit contenir au moins 8 caractères.');
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>