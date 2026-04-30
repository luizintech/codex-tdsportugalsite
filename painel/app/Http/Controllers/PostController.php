<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\PostRepository;
use App\ViewModels\PostViewModel;
use Exception;

class PostController extends BaseController
{
    private PostRepository $PostRepository;

    function __construct(
        PostRepository $PostRepo
    ) { 
        $this->PostRepository = $PostRepo;
    }

    public function index() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Posts";

        $Posts = $this->PostRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Posts->total;
        $viewModel->objectReturn = $Posts->objectResult;
        return view('Posts/index', compact('viewModel'));
    }

    public function indexPage($pageId) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Posts";

        $Posts = $this->PostRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Posts->total;
        $viewModel->objectReturn = $Posts->objectResult;
        return view('Posts/index', compact('viewModel'));
    }

    public function create() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->isEditing = false;
        return view('Posts/create', compact('viewModel'));
    }

    public function doCreation(Request $request) {
        $rules = $this->checkRules();
        $validator = Validator::make($request->all() , $rules);
        $viewModel = new PostViewModel();
        
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Posts/create')
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel); 
        }
        
        try {
            $entity = $this->populate($request);
            $result = $this->PostRepository->add($entity);
            LogHelper::write("Post ID:[".$result->id."] incluido com sucesso", LogType::Info);

            if ($result->success)
                return Redirect::to('Posts');
            else {
                $viewModel->message = $result->messages;
                return view('Posts/create', compact('viewModel'));
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Posts/create')
                ->withErrors("Erro ao tentar criar a pagina. Verifique o log.")
                ->withModel($viewModel); 
        }
    }

    public function edit($id) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->editId = $id;
        $viewModel->isEditing = true;
        $administrator = $this->PostRepository->getById($id);
        $viewModel->objectReturn = $administrator->objectResult;
        return view('Posts/edit', compact('viewModel'));
    }

    public function update($id, Request $request) {
        $rules = $this->checkRules();
        $validator = Validator::make($request->all() , $rules);

        $viewModel = new PostViewModel();
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Posts/edit/'. $id)
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel); 
        }
        
        try {
            $id = $request->get('txtId');
            $entity = $this->populate($request);

            $result = $this->PostRepository->update($id, $entity);
            LogHelper::write("Post ID:[".$id."] atualizado com sucesso.", LogType::Info);

            if ($result->success)
                return Redirect::to('Posts');
            else {
                $viewModel->message = $result->messages;
                return view('Posts/edit', compact('viewModel'));
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Posts/edit/'. $id)
                ->withErrors("Erro ao tentar editar. Verifique o log.")
                ->withModel($viewModel); 
        }
    }

    private function populate(Request $request): Array{
        $entity = array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'author' => $request->get('author'),
            'slug' => $request->get('slug')
        );

        return $entity;
    }

    private function checkRules(): Array {
        return array(
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'slug' => 'required'
        );
    }

    public function delete($id, Request $request) {
        try {
            $result = $this->PostRepository->delete($id);
            LogHelper::write("Post ID:[".$result->id."] removido com sucesso", LogType::Info);

            if ($result->success) {
                return Redirect::to('Posts');
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }
}
