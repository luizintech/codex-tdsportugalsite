<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\ViewModels\LoginViewModel;
use Illuminate\Http\Request;

use Auth;

use App\Repositories\UserRepository;

class LoginController extends Controller {

    protected $redirectTo = '/';
    private UserRepository $userRepository;

    function __construct(UserRepository $userRepository) { 
        $this->userRepository = $userRepository;
    }

    public function index() {
        $viewModel = new LoginViewModel();
        return view('login/index', compact('viewModel'));
    }

    public function doLogin(Request $request) {
        $rules = $this->rulesToCheck();
        $validator = Validator::make($request->all() , $rules);

        $viewModel = new LoginViewModel();
        if ($validator->fails()) {
            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('login')
                ->withErrors($validator)
                ->withInput($request->except('password'))
                ->withModel($viewModel); 
        }

        $email = $request->get('email');
        $userInfo = $this->userRepository->getByEmail($email)->objectResult;

        if (!$userInfo) {
            $err = "E-mail não encontrado.";
            return Redirect::to('/login')
                ->withErrors($err)
                ->withInput($request->except('password'))
                ->withModel($viewModel);
        }

        if (!$userInfo->activeted) {
            $err = "Conta bloqueada. Tente recuperar sua senha.";
            return Redirect::to('/login')
                ->withErrors($err)
                ->withInput($request->except('password'))
                ->withModel($viewModel);
        }

        $userdata = array(
            'email' => $email,
            'password' => $request->get('password')
        );

        if (Auth::attempt($userdata)) {
            // LogHelper::write("Usuário autenticado -> " . $userdata["email"], LogType::Info);
            $request->session()->regenerate();
            $this->updateLoginAttemptsInfo($userInfo, 0);
            return Redirect::to('/')->withModel($viewModel);
        }

        $userInfo->attempts_logins++;
        $this->updateLoginAttemptsInfo($userInfo, $userInfo->attempts_logins);

        $err = "Ocorreu um erro ao tentar autenticar. Por favor, verifique suas credenciais. Esta é a sua ".$userInfo->attempts_logins.
            " tentativa. Lembrando que você tem apenas 3 tentativas antes de bloquear o seu login.";

        if ($userInfo->attempts_logins == 3) {
            $err = "Usuário bloqueado por enúmeras tentativas de login. Tente recuperar sua senha.";
            $this->blockUser($userInfo, $userInfo->attempts_logins);
        }

        return Redirect::to('/login')
            ->withErrors($err)
            ->withInput($request->except('txtPassword'))
            ->withModel($viewModel);
    }

    public function logout(Request $request) {
        Auth::logout(); 
        return Redirect::to('login'); 
    }

    private function updateLoginAttemptsInfo($userInfo, $number) {
        $userLogin = [
            "attempts_logins" => $number,
            "updated_at" => Date("Y-m-d H:i:s")
        ];
        $this->userRepository->update($userInfo->id, $userLogin);
    }

    private function blockUser($userInfo, $number) {
        $userLogin = [
            "attempts_logins" => $number,
            "activeted" => 0,
            "updated_at" => Date("Y-m-d H:i:s")
        ];
        $this->userRepository->update($userInfo->id, $userLogin);
    }

    public function rulesToCheck() {
        return array(
            'email' => 'required',
            'password' => 'required'
        );
    }

    protected function redirectTo() {
        return redirect('/');
    }

    

}