<div class="login-container" style="text-align: center; padding: 20px;">
    <img src="{{ asset('admin/img/ballon-benin.jpg') }}" alt="Logo" style="width: 150px; margin-bottom: 20px;">
    <h1>Connexion</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="email">Adresse Email</label>
            <input id="email" type="email" name="email" required autofocus>
        </div>
        <div style="margin-bottom: 15px;">
            <label for="password">Mot de Passe</label>
            <input id="password" type="password" name="password" required>
        </div>
        <button type="submit" style="padding: 10px 20px; background-color: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            Connexion
        </button>
    </form>
</div>