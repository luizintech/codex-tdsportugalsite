<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\LabelRepository;
use App\ViewModels\LabelViewModel;
use Exception;

class LabelController extends BaseController
{
    private LabelRepository $LabelRepository;

    function __construct(
        LabelRepository $LabelRepo
    ) { 
        $this->LabelRepository = $LabelRepo;
    }

    public function index() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new LabelViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Labels";

        $Labels = $this->LabelRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Labels->total;
        $viewModel->objectReturn = $Labels->objectResult;
        return view('Labels/index', compact('viewModel'));
    }

    public function indexPage($pageId) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new LabelViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Labels";

        $Labels = $this->LabelRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Labels->total;
        $viewModel->objectReturn = $Labels->objectResult;
        return view('Labels/index', compact('viewModel'));
    }

    public function create() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new LabelViewModel();
        $viewModel->isEditing = false;
        return view('Labels/create', compact('viewModel'));
    }

    public function doCreation(Request $request) {
        $rules = $this->checkRules();
        $validator = Validator::make($request->all() , $rules);
        $viewModel = new LabelViewModel();
        
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Labels/create')
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel); 
        }
        
        try {
            $entity = $this->populate($request);
            $result = $this->LabelRepository->add($entity);
            LogHelper::write("Label ID:[".$result->id."] incluido com sucesso", LogType::Info);

            if ($result->success)
                return Redirect::to('Labels');
            else {
                $viewModel->message = $result->messages;
                return view('Labels/create', compact('viewModel'));
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Labels/create')
                ->withErrors("Erro ao tentar criar a pagina. Verifique o log.")
                ->withModel($viewModel); 
        }
    }

    public function edit($id) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new LabelViewModel();
        $viewModel->editId = $id;
        $viewModel->isEditing = true;
        $administrator = $this->LabelRepository->getById($id);
        $viewModel->objectReturn = $administrator->objectResult;
        return view('Labels/edit', compact('viewModel'));
    }

    public function update($id, Request $request) {
        $rules = $this->checkRules();
        $validator = Validator::make($request->all() , $rules);

        $viewModel = new LabelViewModel();
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Labels/edit/'. $id)
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel); 
        }
        
        try {
            $id = $request->get('txtId');
            $entity = $this->populate($request);

            $result = $this->LabelRepository->update($id, $entity);
            LogHelper::write("Label ID:[".$id."] atualizado com sucesso.", LogType::Info);

            if ($result->success)
                return Redirect::to('Labels');
            else {
                $viewModel->message = $result->messages;
                return view('Labels/edit', compact('viewModel'));
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Labels/edit/'. $id)
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
            $result = $this->LabelRepository->delete($id);
            LogHelper::write("Label ID:[".$result->id."] removido com sucesso", LogType::Info);

            if ($result->success) {
                return Redirect::to('Labels');
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }
}
