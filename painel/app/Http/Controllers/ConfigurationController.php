<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\ConfigurationRepository;
use App\ViewModels\ConfigurationViewModel;
use Exception;

class ConfigurationController extends BaseController
{
    private ConfigurationRepository $ConfigurationRepository;

    function __construct(
        ConfigurationRepository $ConfigurationRepo
    ) { 
        $this->ConfigurationRepository = $ConfigurationRepo;
    }

    public function index() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new ConfigurationViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Configurations";

        $Configurations = $this->ConfigurationRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Configurations->total;
        $viewModel->objectReturn = $Configurations->objectResult;
        return view('Configurations/index', compact('viewModel'));
    }

    public function indexPage($pageId) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new ConfigurationViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Configurations";

        $Configurations = $this->ConfigurationRepository->listAllPaging($viewModel->pageId, 
            $viewModel->pageSize);
        $viewModel->totalItems = $Configurations->total;
        $viewModel->objectReturn = $Configurations->objectResult;
        return view('Configurations/index', compact('viewModel'));
    }

    public function edit($id) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new ConfigurationViewModel();
        $viewModel->editId = $id;
        $viewModel->isEditing = true;
        $administrator = $this->ConfigurationRepository->getById($id);
        $viewModel->objectReturn = $administrator->objectResult;
        return view('Configurations/edit', compact('viewModel'));
    }

    public function update($id, Request $request) {
        $rules = $this->checkRules();
        $validator = Validator::make($request->all() , $rules);

        $viewModel = new ConfigurationViewModel();
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Configurations/edit/'. $id)
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel); 
        }
        
        try {
            $id = $request->get('txtId');
            $entity = $this->populate($request);

            $result = $this->ConfigurationRepository->update($id, $entity);
            LogHelper::write("Configuration ID:[".$id."] atualizado com sucesso.", LogType::Info);

            if ($result->success)
                return Redirect::to('Configurations');
            else {
                $viewModel->message = $result->messages;
                return view('Configurations/edit', compact('viewModel'));
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Configurations/edit/'. $id)
                ->withErrors("Erro ao tentar editar. Verifique o log.")
                ->withModel($viewModel); 
        }
    }

    private function populate(Request $request): Array{
        $entity = array(
            'key' => $request->get('key'),
            'value' => $request->get('value')
        );

        return $entity;
    }

    private function checkRules(): Array {
        return array(
            'key' => 'required',
            'value' => 'required'
        );
    }
}
