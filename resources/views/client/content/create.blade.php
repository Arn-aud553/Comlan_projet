@extends('layouts.client')

@section('content')
<div class="culture-container" style="margin-top: 20px; padding: 40px; max-width: 800px;">
    
    <div style="margin-bottom: 30px;">
        <a href="{{ route('client.contenus.manage') }}" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: var(--text-light); font-weight: 500; transition: color 0.3s;">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <h2 class="section-title" style="margin-bottom: 30px; text-align: center; border: none;">Proposer un contenu</h2>

    {{-- Messages de succès/erreur --}}
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fef3c7; color: #92400e; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #f59e0b;">
            <strong><i class="fas fa-exclamation-triangle"></i> Erreurs de validation :</strong>
            <ul style="margin: 10px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: var(--shadow-soft);">
        <form action="{{ route('client.content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Title -->
            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--chic-primary);">Titre du contenu <span style="color: #ef4444;">*</span></label>
                <input type="text" id="title" name="title" required 
                       value="{{ old('title') }}"
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; transition: border-color 0.3s;"
                       placeholder="Ex: L'histoire des Rois d'Abomey">
            </div>

            <!-- Category -->
            <div style="margin-bottom: 20px;">
                <label for="category" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--chic-primary);">Catégorie <span style="color: #ef4444;">*</span></label>
                <select id="category" name="category" required 
                        style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background: white;">
                    <option value="">Sélectionnez une catégorie</option>
                    <option value="histoire" {{ old('category') == 'histoire' ? 'selected' : '' }}>Histoire & Traditions</option>
                    <option value="art" {{ old('category') == 'art' ? 'selected' : '' }}>Art & Artisanat</option>
                    <option value="musique" {{ old('category') == 'musique' ? 'selected' : '' }}>Musique & Danse</option>
                    <option value="langue" {{ old('category') == 'langue' ? 'selected' : '' }}>Langues & Proverbes</option>
                    <option value="cuisine" {{ old('category') == 'cuisine' ? 'selected' : '' }}>Gastronomie</option>
                </select>
            </div>

            <!-- Description/Content -->
            <div style="margin-bottom: 20px;">
                <label for="content" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--chic-primary);">Description détaillée <span style="color: #ef4444;">*</span></label>
                <textarea id="content" name="content" rows="6" required 
                          style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; font-family: inherit;"
                          placeholder="Rédigez votre contenu ici...">{{ old('content') }}</textarea>
            </div>

            <!-- Multiple Files Upload -->
            <div style="margin-bottom: 30px;">
                <label for="files" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--chic-primary);">
                    Fichiers (Images, Vidéos, Documents, Livres) <span style="color: #64748b; font-weight: 400; font-size: 13px;">- Optionnel</span>
                </label>
                <input type="file" id="files" name="files[]" accept="image/*,video/*,.pdf,.doc,.docx,.txt,.epub,.mobi" multiple
                       style="width: 100%; padding: 10px; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                <p style="color: #64748b; font-size: 12px; margin-top: 8px;">
                    <i class="fas fa-info-circle"></i> Formats acceptés : Images (JPG, PNG, GIF, etc.), Vidéos (MP4, AVI, MOV, etc.), Documents (PDF, DOC, TXT, etc.), Livres (EPUB, MOBI). Max 500MB par fichier.
                </p>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    style="width: 100%; padding: 14px; background: var(--chic-primary); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; transition: background 0.3s;">
                <i class="fas fa-paper-plane"></i> Soumettre le contenu
            </button>
            
            <p style="text-align: center; color: #64748b; font-size: 13px; margin-top: 15px;">
                <i class="fas fa-clock"></i> Votre contenu sera examiné par un modérateur avant publication
            </p>
        </form>
    </div>
</div>

<style>
    input:focus, select:focus, textarea:focus {
        border-color: var(--chic-secondary) !important;
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1);
    }
    
    button[type="submit"]:hover {
        background: #0f172a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection
