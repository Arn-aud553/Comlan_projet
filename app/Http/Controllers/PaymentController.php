<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Paiement;
use App\Models\Contenu;
use App\Models\Media;

class PaymentController extends Controller
{
    public function show($type, $id)
    {
        if ($type === 'contenu') {
            $item = Contenu::findOrFail($id);
        } else {
            $item = Media::findOrFail($id);
        }
        
        return view('client.paiement.show', compact('item', 'type'));
    }

    public function process(Request $request, $id, $type = 'contenu')
    {
        try {
            $user = Auth::user();
            
            if ($type === 'contenu') {
                $item = Contenu::findOrFail($id);
                $itemType = 'contenu';
            } else {
                $item = Media::findOrFail($id);
                $itemType = 'media';
            }
            
            // Vérifier si déjà payé
            $existingPayment = Paiement::where('user_id', $user->id)
                ->where($type . '_id', $id)
                ->where('statut', 'completed')
                ->first();
            
            if ($existingPayment) {
                return redirect()->route('client.' . $itemType . 's.detail', $id)
                    ->with('info', 'Vous avez déjà acheté ce ' . $itemType . '.');
            }
            
            // Simuler un paiement (à remplacer par votre logique de paiement réelle)
            $payment = Paiement::create([
                'user_id' => $user->id,
                $type . '_id' => $id,
                'montant' => $item->prix,
                'statut' => 'completed',
                'transaction_id' => 'PAY_' . strtoupper(uniqid()),
                'payment_method' => $request->input('payment_method', 'simulated'),
                'payment_details' => json_encode($request->all()),
            ]);
            
            Log::info('Paiement réussi', [
                'user_id' => $user->id,
                'item_id' => $id,
                'item_type' => $type,
                'payment_id' => $payment->id,
            ]);
            
            return redirect()->route('client.' . $itemType . 's.paiement.success', $id);
            
        } catch (\Exception $e) {
            Log::error('Erreur de paiement: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du paiement: ' . $e->getMessage());
        }
    }
    
    public function success($id, $type = 'contenu')
    {
        if ($type === 'contenu') {
            $item = Contenu::findOrFail($id);
            return view('client.contenus.paiement-success', compact('item'));
        } else {
            $item = Media::findOrFail($id);
            return view('client.media.paiement-success', compact('item'));
        }
    }

    public function cancel($type, $id)
    {
        return redirect()->route('client.' . $type . 's.detail', $id)
            ->with('warning', 'Le paiement a été annulé.');
    }
}