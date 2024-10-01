<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Parameter;

class ParameterComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Fetch the first Parameter entry
        $parameter = Parameter::first();

        // Pass the parameter to the view
        $view->with('parameter', $parameter);
    }
}
