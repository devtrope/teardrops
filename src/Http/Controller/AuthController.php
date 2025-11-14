<?php

namespace App\Http\Controller;

use App\Http\Model\User;
use Ludens\Http\Request;
use Ludens\Http\Response;
use Ludens\Database\ModelManager;
use Ludens\Http\Support\SessionBag;

class AuthController extends BaseController
{
    public function login(): Response
    {
        return $this->render('auth/login');
    }

    public function sign(ModelManager $modelManager, Request $request): Response
    {
        $this->validator()->fields($request, [
            'email' => $this->validator()->rule()->required(),
            'password' => $this->validator()->rule()->required()
        ]);

        if (! $modelManager->get(User::class)::query()->where('mail', $request->email)->exists()) {
            return $this->redirect('/login')->withFlash('error', 'Invalid credentials');
        }

        $session = new SessionBag();
        $session->set('user_id', 1);
        return $this->redirect('/');
    }

    public function register(): Response
    {
        return $this->render('auth/register');
    }

    public function add(Request $request): Response
    {
        $this->validator()->fields($request, [
            'email' => $this->validator()->rule()->required()->email(),
            'password' => $this->validator()->rule()->required()->minLength(6)
        ]);

        $user = new User();
        $user->mail = $request->email;
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);
        $user->save();

        $session = new SessionBag();
        $session->set('user_id', $user->id);
        
        return $this->redirect('/')->withFlash('success', 'Your account has been successfully created.');
    }

    public function logout(): Response
    {
        $session = new SessionBag();
        $session->remove('user_id');

        return $this->redirect('/');
    }
}
