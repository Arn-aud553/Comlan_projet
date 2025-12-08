@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        Paiement pour : {{ $contenu->titre }}
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    <!-- Order Summary -->
                    <div class="alert alert-info mb-4">
                        <h5 class="alert-heading">
                            <i class="fas fa-receipt me-2"></i>
                            Récapitulatif de commande
                        </h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Contenu :</strong> {{ $contenu->titre }}</p>
                                <p><strong>Auteur :</strong> {{ $contenu->auteur->name ?? 'Auteur inconnu' }}</p>
                                <p><strong>Type :</strong> {{ $contenu->typeContenu->nom ?? 'Contenu' }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h3 class="text-primary">{{ $contenu->prix_formate }}</h3>
                                <p class="text-muted small">Prix TTC • Paiement unique</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('client.contenus.paiement.process', $contenu->id) }}" method="POST" id="paymentForm">
                        @csrf
                        
                        <!-- Customer Info -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="fas fa-user me-2"></i>
                                Vos informations
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="fas fa-credit-card me-2"></i>
                                Méthode de paiement
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="payment-method-option">
                                        <input type="radio" name="payment_method" id="mtn" value="mtn" class="d-none" checked>
                                        <label for="mtn" class="payment-method-label">
                                            <div class="text-center p-3 border rounded">
                                                <i class="fas fa-mobile-alt fa-2x text-warning mb-2"></i>
                                                <p class="mb-0">MTN Money</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-method-option">
                                        <input type="radio" name="payment_method" id="moov" value="moov" class="d-none">
                                        <label for="moov" class="payment-method-label">
                                            <div class="text-center p-3 border rounded">
                                                <i class="fas fa-mobile-alt fa-2x text-danger mb-2"></i>
                                                <p class="mb-0">Moov Money</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-method-option">
                                        <input type="radio" name="payment_method" id="card" value="card" class="d-none">
                                        <label for="card" class="payment-method-label">
                                            <div class="text-center p-3 border rounded">
                                                <i class="fas fa-credit-card fa-2x text-success mb-2"></i>
                                                <p class="mb-0">Carte bancaire</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone Number (conditional) -->
                        <div class="mb-4" id="phoneField">
                            <label class="form-label">
                                <i class="fas fa-phone me-1"></i>
                                Numéro de téléphone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">+229</span>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       placeholder="97 12 34 56" pattern="[0-9]{8,10}"
                                       title="Entrez 8 à 10 chiffres sans espaces">
                            </div>
                            <small class="text-muted">Nous vous enverrons une demande de paiement sur ce numéro</small>
                        </div>

                        <!-- Terms -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">conditions générales</a>
                                et la <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">politique de confidentialité</a>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="fas fa-lock me-2"></i>
                                Payer {{ $contenu->prix_formate }}
                            </button>
                            <a href="{{ route('client.contenus.detail', $contenu->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour au contenu
                            </a>
                        </div>
                    </form>

                    <!-- Security Info -->
                    <div class="mt-4">
                        <div class="alert alert-light border">
                            <h6 class="mb-2">
                                <i class="fas fa-shield-alt text-success me-2"></i>
                                Paiement sécurisé
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="small mb-1">
                                        <i class="fas fa-check text-success me-1"></i>
                                        Cryptage SSL 256-bit
                                    </p>
                                    <p class="small mb-1">
                                        <i class="fas fa-check text-success me-1"></i>
                                        Données bancaires protégées
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <img src="https://fedapay.com/img/logos/logo-blue.svg" alt="FedaPay" style="height: 30px;">
                                        <p class="small mb-0 mt-1">Paiement certifié FedaPay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conditions Générales de Vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Add your terms here -->
                <p>Contenu des conditions générales...</p>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-label .border {
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid transparent !important;
}

.payment-method-option input:checked + .payment-method-label .border {
    border-color: #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.05);
}

.payment-method-label:hover .border {
    border-color: #0d6efd !important;
    transform: translateY(-2px);
}

.btn-success {
    background: linear-gradient(135deg, #198754, #157347);
    border: none;
    transition: all 0.3s;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(25, 135, 84, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const phoneField = document.getElementById('phoneField');
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
    
    togglePhoneField();
    
    // Form validation
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        const terms = document.getElementById('terms');
        if (!terms.checked) {
            e.preventDefault();
            alert('Veuillez accepter les conditions générales.');
            return false;
        }
    });
});
</script>
@endsection