<?php

namespace App\Actions\Advisers;

use App\Models\Adviser;
use Illuminate\Support\Facades\Validator;

class CreateAdviser
{
    public function create($input)
    {
        $data = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'fsp_no' => ['required', 'integer', 'min:1', 'max:999999999'],
        ], [], [
            'name' => 'Name',
            'fsp_no' => 'FSP Number',
        ])->validate();

        $data['status'] = 'Active';

        $adviser = Adviser::create($data);

        return $adviser;
    }
}
