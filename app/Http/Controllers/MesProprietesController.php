<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesProprietesController extends Controller
{
    /**
     * Afficher les propriétés de l'utilisateur connecté
     */
    public function index()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = Auth::id();
        
        // Récupérer uniquement les propriétés de l'utilisateur connecté
        $properties = Property::where('owner_id', $userId)
            ->with('images') // Charger les images associées
            ->latest() // Trier par les plus récentes
            ->paginate(12); // Pagination (12 propriétés par page)
        
        return view('mes-proprietes.index', compact('properties'));
    }

    /**
     * Afficher une propriété spécifique de l'utilisateur
     */
    public function show($id)
    {
        // Vérifier que la propriété appartient bien à l'utilisateur connecté
        $property = Property::where('owner_id', Auth::id())
            ->with('images')
            ->findOrFail($id);
        
        return view('mes-proprietes.show', compact('property'));
    }

    /**
     * Supprimer une propriété
     */
    public function destroy($id)
    {
        // Vérifier que l'utilisateur peut supprimer
        if (!in_array(Auth::user()->role, ['owner', 'admin'])) {
            abort(403, 'Vous n\'avez pas la permission de supprimer cette propriété');
        }
        
        // Trouver la propriété qui appartient à l'utilisateur
        $property = Property::where('owner_id', Auth::id())->findOrFail($id);
        
        // Supprimer les images associées (si vous voulez aussi les supprimer du storage)
        foreach ($property->images as $image) {
            // Optionnel: Supprimer le fichier du storage
            \Storage::disk('public')->delete($image->image_url);
            $image->delete();
        }
        
        // Supprimer la propriété
        $property->delete();
        
        return redirect()->route('mes-proprietes.index')
            ->with('success', 'Propriété supprimée avec succès');
    }
}