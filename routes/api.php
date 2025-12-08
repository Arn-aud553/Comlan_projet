// API pour les contenus
Route::get('/contenus', function() {
    return \App\Models\Contenu::select('id_contenu', 'titre')
                              ->orderBy('titre')
                              ->get();
});

// API pour les utilisateurs
Route::get('/utilisateurs', function() {
    return \App\Models\User::select('id', 'name', 'email')
                           ->orderBy('name')
                           ->get();
});