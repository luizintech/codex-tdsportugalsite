<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\UserRepository;
use App\ViewModels\UserViewModel;
use Exception;

class UserController extends BaseController
{
    private UserRepository $UserRepository;

    function __construct(UserRepository $UserRepo)
    {
        $this->UserRepository = $UserRepo;
    }

    public function index() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new UserViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Users";

        $users = $this->UserRepository->listAllPaging($viewModel->pageId, $viewModel->pageSize);
        $viewModel->totalItems = $users->total;
        $viewModel->objectReturn = $users->objectResult;
        return view('Users/index', compact('viewModel'));
    }

    public function indexPage($pageId) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new UserViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Users";

        $users = $this->UserRepository->listAllPaging($viewModel->pageId, $viewModel->pageSize);
        $viewModel->totalItems = $users->total;
        $viewModel->objectReturn = $users->objectResult;
        return view('Users/index', compact('viewModel'));
    }

    public function create() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new UserViewModel();
        $viewModel->isEditing = false;
        return view('Users/create', compact('viewModel'));
    }

    public function doCreation(Request $request) {
        $rules = $this->checkRules(false);
        $validator = Validator::make($request->all(), $rules);
        $viewModel = new UserViewModel();

        if ($validator->fails()) {
            LogHelper::write("Erro na validação dos dados: " . $validator->errors(), LogType::Warn);
            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Users/create')->withErrors($validator)->withInput()->withModel($viewModel);
        }

        try {
            $entity = $this->populate($request, false);
            $result = $this->UserRepository->add($entity);
            LogHelper::write("User ID:[".$result->id."] incluido com sucesso", LogType::Info);

            if ($result->success)
                return Redirect::to('Users');

            $viewModel->message = $result->messages;
            return view('Users/create', compact('viewModel'));
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Users/create')->withErrors("Erro ao tentar criar. Verifique o log.")->withModel($viewModel);
        }
    }

    public function edit($id) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new UserViewModel();
        $viewModel->editId = $id;
        $viewModel->isEditing = true;
        $user = $this->UserRepository->getById($id);
        $viewModel->objectReturn = $user->objectResult;
        return view('Users/edit', compact('viewModel'));
    }

    public function update($id, Request $request) {
        $rules = $this->checkRules(true);
        $validator = Validator::make($request->all(), $rules);
        $viewModel = new UserViewModel();

        if ($validator->fails()) {
            LogHelper::write("Erro na validação dos dados: " . $validator->errors(), LogType::Warn);
            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Users/edit/'. $id)->withErrors($validator)->withInput()->withModel($viewModel);
        }

        try {
            $id = $request->get('txtId');
            $entity = $this->populate($request, true);
            $result = $this->UserRepository->update($id, $entity);
            LogHelper::write("User ID:[".$id."] atualizado com sucesso", LogType::Info);

            if ($result->success)
                return Redirect::to('Users');

            $viewModel->message = $result->messages;
            return view('Users/edit', compact('viewModel'));
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Users/edit/'. $id)->withErrors("Erro ao tentar editar. Verifique o log.")->withModel($viewModel);
        }
    }

    public function delete($id) {
        try {
            $result = $this->UserRepository->delete($id);
            LogHelper::write("User ID:[".$id."] removido com sucesso", LogType::Info);

            if ($result->success) {
                return Redirect::to('Users');
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }

    private function populate(Request $request, bool $isEditing): Array {
        $entity = [
            'fullname' => $request->get('fullname'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'activeted' => $request->get('activeted') ? 1 : 0,
            'attempts_logins' => $request->get('attempts_logins') ?? 0,
        ];

        $password = $request->get('password');
        if (!$isEditing || !empty($password)) {
            $entity['password'] = $password;
        }

        return $entity;
    }

    private function checkRules(bool $isEditing): Array {
        $rules = [
            'fullname' => 'required|max:80',
            'name' => 'required|max:20',
            'email' => 'required|email|max:100',
            'attempts_logins' => 'nullable|integer|min:0'
        ];

        if (!$isEditing) {
            $rules['password'] = 'required|min:6|max:255';
        } else {
            $rules['password'] = 'nullable|min:6|max:255';
        }

        return $rules;
    }
}
