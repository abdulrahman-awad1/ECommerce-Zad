<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->register($request->validated());

        return redirect()->route('home');
    }

    public function login(LoginRequest $request)
    {
        $this->authService->login(
            $request->only('email', 'password'),
            $request->boolean('remember')
        );

        return redirect()->route('home');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect('/home');
    }
}
