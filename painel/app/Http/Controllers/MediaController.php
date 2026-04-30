<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\MediaRepository;
use App\ViewModels\MediaViewModel;
use Exception;

class MediaController extends BaseController
{
    private MediaRepository $MediaRepository;

    function __construct(
        MediaRepository $MediaRepo
    ) {
        $this->MediaRepository = $MediaRepo;
    }

    public function index() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new MediaViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Medias";

        $medias = $this->MediaRepository->listAllPaging($viewModel->pageId,
            $viewModel->pageSize);
        $viewModel->totalItems = $medias->total;
        $viewModel->objectReturn = $medias->objectResult;
        return view('Medias/index', compact('viewModel'));
    }

    public function indexPage($pageId) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new MediaViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Medias";

        $medias = $this->MediaRepository->listAllPaging($viewModel->pageId,
            $viewModel->pageSize);
        $viewModel->totalItems = $medias->total;
        $viewModel->objectReturn = $medias->objectResult;
        return view('Medias/index', compact('viewModel'));
    }

    public function create() {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new MediaViewModel();
        $viewModel->isEditing = false;
        return view('Medias/create', compact('viewModel'));
    }

    public function doCreation(Request $request) {
        $rules = $this->checkRules(true);
        $validator = Validator::make($request->all(), $rules);
        $viewModel = new MediaViewModel();

        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Medias/create')
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel);
        }

        try {
            $entity = $this->populate($request);
            $result = $this->MediaRepository->add($entity);
            LogHelper::write("Media ID:[".$result->id."] incluido com sucesso", LogType::Info);

            if ($result->success)
                return Redirect::to('Medias');

            $viewModel->message = $result->messages;
            return view('Medias/create', compact('viewModel'));
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Medias/create')
                ->withErrors("Erro ao tentar criar a pagina. Verifique o log.")
                ->withModel($viewModel);
        }
    }

    public function edit($id) {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new MediaViewModel();
        $viewModel->editId = $id;
        $viewModel->isEditing = true;
        $media = $this->MediaRepository->getById($id);
        $viewModel->objectReturn = $media->objectResult;
        return view('Medias/edit', compact('viewModel'));
    }

    public function update($id, Request $request) {
        $rules = $this->checkRules(false);
        $validator = Validator::make($request->all(), $rules);

        $viewModel = new MediaViewModel();
        if ($validator->fails()) {
            $logEntry = "Erro na validação dos dados: " . $validator->errors();
            LogHelper::write($logEntry, LogType::Warn);

            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Medias/edit/'. $id)
                ->withErrors($validator)
                ->withInput()
                ->withModel($viewModel);
        }

        try {
            $id = $request->get('txtId');
            $entity = $this->populate($request, true);

            $result = $this->MediaRepository->update($id, $entity);
            LogHelper::write("Media ID:[".$id."] atualizado com sucesso.", LogType::Info);

            if ($result->success)
                return Redirect::to('Medias');

            $viewModel->message = $result->messages;
            return view('Medias/edit', compact('viewModel'));
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Medias/edit/'. $id)
                ->withErrors("Erro ao tentar editar. Verifique o log.")
                ->withModel($viewModel);
        }
    }

    private function populate(Request $request, bool $isUpdate = false): Array{
        $entity = [
            'slug' => $request->get('slug')
        ];

        $imageFile = $request->file('image_file');
        if ($imageFile) {
            $filename = $entity['slug'] . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $destinationPath = public_path('uploads/medias');

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            $imageFile->move($destinationPath, $filename);
            $entity['filename'] = $filename;

            if (empty($entity['path'])) {
                $entity['path'] = '/uploads/medias/' . $filename;
            }
        }

        return $entity;
    }

    private function checkRules(bool $isCreation): Array {
        $imageRule = $isCreation ? 'required' : 'nullable';

        return [
            'image_file' => $imageRule . '|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'path' => 'nullable|max:100',
            'slug' => 'required|max:250'
        ];
    }

    public function delete($id, Request $request) {
        try {
            $result = $this->MediaRepository->delete($id);
            LogHelper::write("Media ID:[".$result->id."] removido com sucesso", LogType::Info);

            if ($result->success) {
                return Redirect::to('Medias');
            }
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }
}
