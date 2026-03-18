<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour voir vos favoris.');
        }
        
        $favorites = Favorite::where('user_id', $user->id)
            ->with('property.images')
            ->latest()
            ->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }
    
    public function toggle(Property $property)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour ajouter aux favoris.');
        }
        
        $existingFavorite = Favorite::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->first();
        
        if ($existingFavorite) {
            $existingFavorite->delete();
            $message = 'Propriété retirée des favoris.';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'property_id' => $property->id
            ]);
            $message = 'Propriété ajoutée aux favoris !';
        }
        
        return back()->with('success', $message);
    }
    
    public function remove(Favorite $favorite)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }
        
        if ($favorite->user_id !== $user->id) {
            return back()->with('error', 'Action non autorisée.');
        }
        
        $favorite->delete();
        
        return back()->with('success', 'Propriété retirée des favoris.');
    }
}