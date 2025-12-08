<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Contenu;
use App\Models\Media;
use App\Models\User;
use App\Models\Langue;
use App\Models\Region;

class ClientLayoutComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'user' => Auth::user(),
            'stats' => [
                'contents' => Contenu::count(),
                'medias' => Media::whereIn('type_fichier', ['image', 'video'])->count(),
                'users' => User::count(),
                'languages' => Langue::count(),
                'regions' => Region::count()
            ]
        ]);
    }
}
