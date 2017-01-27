<?php

namespace PN\Assets\Http\Requests;

use PN\Http\Requests\Request;

class SelectModRequest extends Request
{
    public function authorize()
    {
        return \Auth::check();
    }

    public function rules()
    {
        return [
            'resource' => 'required|max:50000',
            'terms' => 'accepted'
        ];
    }
}
