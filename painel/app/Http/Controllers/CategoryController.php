<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\CategoryRepository;
use App\ViewModels\CategoryViewModel;
use Exception;

class CategoryController extends BaseController
{
    private CategoryRepository $CategoryRepository;

    function __construct(
        CategoryRepository $CategoryRepo
    ) { 
        $this->CategoryRepository = $CategoryRepo;
    }

    public function index() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new CategoryViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Categories";

        $Categories = $this->CategoryRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Categories->total;
        $viewModel->objectReturn = $Categories->objectResult;
        return view('Categories/index', compact('viewModel'));
    }

    public function indexPage($pageId) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new CategoryViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Categories";

        $Categories = $this->CategoryRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Categories->total;
        $viewModel->objectReturn = $Categories->objectResult;
        return view('Categories/index', compact('viewModel'));
    }

    public function create() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new CategoryViewModel();
        $viewModel->isEditing = false;
        return view('Categories/create', compact('viewModel'));
    }

    public function doCreation(Request $request) {
        $rules = $this->checkRules();
        $validator = Validator::make($request->all() , $rules);
        $viewModel = new CategoryViewModel();
        
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Categories/create')
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel); 
        }
        
        try {
            $entity = $this->populate($request);
            $result = $this->CategoryRepository->add($entity);
            LogHelper::write("Category ID:[".$result->id."] incluido com sucesso", LogType::Info);

            if ($result->success)
                return Redirect::to('Categories');
            else {
                $viewModel->message = $result->messages;
                return view('Categories/create', compact('viewModel'));
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Categories/create')
                ->withErrors("Erro ao tentar criar a pagina. Verifique o log.")
                ->withModel($viewModel); 
        }
    }

    public function edit($id) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new CategoryViewModel();
        $viewModel->editId = $id;
        $viewModel->isEditing = true;
        $administrator = $this->CategoryRepository->getById($id);
        $viewModel->objectReturn = $administrator->objectResult;
        return view('Categories/edit', compact('viewModel'));
    }

    public function update($id, Request $request) {
        $rules = $this->checkRules();
        $validator = Validator::make($request->all() , $rules);

        $viewModel = new CategoryViewModel();
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Categories/edit/'. $id)
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel); 
        }
        
        try {
            $id = $request->get('txtId');
            $entity = $this->populate($request);

            $result = $this->CategoryRepository->update($id, $entity);
            LogHelper::write("Category ID:[".$id."] atualizado com sucesso.", LogType::Info);

            if ($result->success)
                return Redirect::to('Categories');
            else {
                $viewModel->message = $result->messages;
                return view('Categories/edit', compact('viewModel'));
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Categories/edit/'. $id)
                ->withErrors("Erro ao tentar editar. Verifique o log.")
                ->withModel($viewModel); 
        }
    }

    private function populate(Request $request): Array{
        $entity = array(
            'title' => $request->get('title'),
            'short_description' => $request->get('short_description'),
            'slug' => $request->get('slug')
        );

        return $entity;
    }

    private function checkRules(): Array {
        return array(
            'title' => 'required',
            'slug' => 'required'
        );
    }

    public function delete($id, Request $request) {
        try {
            $result = $this->CategoryRepository->delete($id);
            LogHelper::write("Category ID:[".$result->id."] removido com sucesso", LogType::Info);

            if ($result->success) {
                return Redirect::to('Categories');
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }
}
