@extends('layouts.client')

@section('title', 'Paiement Réussi')

@push('styles')
<style>
    .success-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .success-container::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -250px;
        right: -250px;
        animation: float 6s ease-in-out infinite;
    }

    .success-container::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        bottom: -150px;
        left: -150px;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .success-card {
        background: white;
        border-radius: 24px;
        padding: 3rem;
        max-width: 600px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 10;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        position: relative;
        animation: scaleIn 0.5s ease-out 0.2s both;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-icon::before {
        content: '';
        position: absolute;
        width: 140px;
        height: 140px;
        border: 3px solid #10b981;
        border-radius: 50%;
        animation: pulse 2s ease-out infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(1.3);
            opacity: 0;
        }
    }

    .success-icon i {
        font-size: 4rem;
        color: white;
        animation: checkmark 0.8s ease-out 0.4s both;
    }

    @keyframes checkmark {
        0% {
            transform: scale(0) rotate(-45deg);
        }
        50% {
            transform: scale(1.2) rotate(10deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
        }
    }

    .success-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        text-align: center;
        margin-bottom: 0.5rem;
        animation: fadeIn 0.6s ease-out 0.6s both;
    }

    .success-subtitle {
        font-size: 1.125rem;
        color: #6b7280;
        text-align: center;
        margin-bottom: 2rem;
        animation: fadeIn 0.6s ease-out 0.8s both;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .content-preview {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        animation: fadeIn 0.6s ease-out 1s both;
    }

    .content-preview-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .content-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .content-title {
        flex: 1;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .content-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }

    .content-meta span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .unlock-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .btn-view-content {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.125rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        animation: fadeIn 0.6s ease-out 1.2s both;
    }

    .btn-view-content:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-back {
        width: 100%;
        padding: 0.875rem;
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        animation: fadeIn 0.6s ease-out 1.4s both;
    }

    .btn-back:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #374151;
    }

    .transaction-details {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f3f4f6;
        animation: fadeIn 0.6s ease-out 1.6s both;
    }

    .transaction-details h6 {
        font-size: 0.875rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }

    .transaction-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .transaction-item {
        text-align: center;
    }

    .transaction-label {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .transaction-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
    }

    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        background: #667eea;
        position: absolute;
        animation: confetti-fall 3s linear;
    }

    @keyframes confetti-fall {
        to {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <!-- Success Message -->
        <h1 class="success-title">Paiement réussi !</h1>
        <p class="success-subtitle">Votre contenu est maintenant débloqué</p>

        <!-- Content Preview -->
        <div class="content-preview">
            <div class="content-preview-header">
                <div class="content-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3 class="content-title">{{ $contenu->titre }}</h3>
            </div>

            <div class="content-meta">
                @if($contenu->auteur)
                <span>
                    <i class="fas fa-user"></i>
                    {{ $contenu->auteur->name }}
                </span>
                @endif
                @if($contenu->typeContenu)
                <span>
                    <i class="fas fa-tag"></i>
                    {{ $contenu->typeContenu->nom }}
                </span>
                @endif
            </div>

            <div class="text-center">
                <span class="unlock-badge">
                    <i class="fas fa-lock-open"></i>
                    Accès illimité
                </span>
            </div>
        </div>

        <!-- Action Buttons -->
        <a href="{{ route('client.contenus.detail', $contenu->id_contenu) }}" class="btn-view-content">
            <i class="fas fa-eye"></i>
            Voir le contenu
        </a>

        <a href="{{ route('client.contenus.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Retour aux contenus
        </a>

        <!-- Transaction Details -->
        <div class="transaction-details">
            <h6>Détails de la transaction</h6>
            <div class="transaction-grid">
                <div class="transaction-item">
                    <div class="transaction-label">Montant</div>
                    <div class="transaction-value">{{ number_format($contenu->prix, 0, ',', ' ') }} FCFA</div>
                </div>
                <div class="transaction-item">
                    <div class="transaction-label">Date</div>
                    <div class="transaction-value">{{ now()->format('d/m/Y') }}</div>
                </div>
                <div class="transaction-item">
                    <div class="transaction-label">Méthode</div>
                    <div class="transaction-value">FedaPay</div>
                </div>
                <div class="transaction-item">
                    <div class="transaction-label">Statut</div>
                    <div class="transaction-value" style="color: #10b981;">Complété</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Create confetti effect
function createConfetti() {
    const colors = ['#667eea', '#764ba2', '#10b981', '#f59e0b', '#ef4444'];
    const container = document.querySelector('.success-container');
    
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 0.5 + 's';
            container.appendChild(confetti);
            
            setTimeout(() => confetti.remove(), 3000);
        }, i * 30);
    }
}

// Trigger confetti on page load
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(createConfetti, 500);
});
</script>
@endpush
@endsection
