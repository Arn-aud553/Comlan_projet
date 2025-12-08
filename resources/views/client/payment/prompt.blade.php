@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Paiement sécurisé</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Détails de l'achat</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span><strong>Média :</strong></span>
                            <span>{{ $media->titre ?? $media->nom_fichier }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Type :</strong></span>
                            <span class="badge bg-secondary">{{ $media->type_fichier }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Prix :</strong></span>
                            <span class="fw-bold text-primary">{{ number_format($media->prix ?: 1000, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    <form action="{{ route('client.payment.process', $media->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Méthode de paiement</label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-check card-select">
                                        <input class="form-check-input" type="radio" name="payment_method" id="mtn" value="mtn" required>
                                        <label class="form-check-label card-option" for="mtn">
                                            <div class="card border">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-mobile-alt fa-2x text-warning"></i>
                                                    <p class="mt-2 mb-0">MTN Mobile Money</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check card-select">
                                        <input class="form-check-input" type="radio" name="payment_method" id="moov" value="moov">
                                        <label class="form-check-label card-option" for="moov">
                                            <div class="card border">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-mobile-alt fa-2x text-danger"></i>
                                                    <p class="mt-2 mb-0">Moov Money</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check card-select">
                                        <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                                        <label class="form-check-label card-option" for="card">
                                            <div class="card border">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-credit-card fa-2x text-success"></i>
                                                    <p class="mt-2 mb-0">Carte bancaire</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" id="phone-field" style="display: none;">
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text">+229</span>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       placeholder="XX XX XX XX" pattern="[0-9]{8,10}" 
                                       title="Entrez 8 à 10 chiffres">
                            </div>
                            <small class="text-muted">Exemple: 97 12 34 56</small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-lock me-2"></i>Payer maintenant
                            </button>
                            <a href="{{ route('client.media.detail', $media->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                        </div>
                    </form>

                    <div class="mt-4">
                        <div class="alert alert-light border">
                            <h6 class="mb-2"><i class="fas fa-shield-alt me-2 text-success"></i>Paiement 100% sécurisé</h6>
                            <p class="small mb-0">
                                <i class="fas fa-check-circle text-success me-1"></i> Transactions cryptées SSL<br>
                                <i class="fas fa-check-circle text-success me-1"></i> Aucune donnée bancaire stockée<br>
                                <i class="fas fa-check-circle text-success me-1"></i> Service certifié FedaPay
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-select .form-check-input {
    position: absolute;
    opacity: 0;
}

.card-select .form-check-input:checked + .card-option .card {
    border-color: #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.05);
}

.card-option .card {
    cursor: pointer;
    transition: all 0.3s;
}

.card-option .card:hover {
    border-color: #0d6efd !important;
    transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const phoneField = document.getElementById('phone-field');
    const phoneInput = document.getElementById('phone');
    
    function togglePhoneField() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (selectedMethod && (selectedMethod.value === 'mtn' || selectedMethod.value === 'moov')) {
            phoneField.style.display = 'block';
            phoneInput.required = true;
        } else {
            phoneField.style.display = 'none';
            phoneInput.required = false;
        }
    }
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', togglePhoneField);
    });
    
    // Initial state
    togglePhoneField();
});
</script>
@endsection