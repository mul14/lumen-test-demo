<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends BaseController
{
    public function postRegister(Request $request)
    {
        if (! $request->input('email') || ! $request->input('password'))
        {
            return new JsonResponse([
                'status'  => 'error',
                'message' => 'Fail to validate.',
                'data' => '',
            ], 400);
        }

        $user = User::whereEmail($request->input('email'))->first();

        if ($user)
        {
            return new JsonResponse([
                'status'  => 'error',
                'message' => 'Fail to validate.',
                'data' => '',
            ], 400);
        }

        User::register($request->input('email'), $request->input('password'));

        return [
            'status'  => 'success',
            'message' => '',
            'data' => '',
        ];

    }

    public function postLogin()
    {
        return new JsonResponse([
            'status'  => 'error',
            'message' => 'Fail to validate'
        ]);
    }
}
