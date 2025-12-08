@extends('layouts.simple')

@section('title', 'Paiement Réussi - Culture Bénin')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden text-center p-8">
        <div class="mb-6">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                <i class="fas fa-check text-green-600 text-3xl"></i>
            </div>
        </div>
        
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Paiement Réussi !</h2>
        <p class="text-slate-500 mb-8">
            La transaction a été validée avec succès. Vous avez maintenant accès au contenu.
        </p>
        
        <div class="bg-slate-50 rounded-lg p-4 mb-8 text-left">
            <p class="text-xs text-slate-400 uppercase font-bold mb-1">Détails</p>
            <div class="flex justify-between mb-1">
                <span class="text-sm text-slate-600">Média</span>
                <span class="text-sm font-medium text-slate-900">{{ $media->titre ?? 'Document' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-slate-600">Montant payé</span>
                <span class="text-sm font-medium text-slate-900">1 000 FCFA</span>
            </div>
        </div>

        <a href="{{ route('client.media.detail', $media->id_media) }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
            Accéder au Média <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>
@endsection
