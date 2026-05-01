<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\PostRepository;
use App\Repositories\LabelRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\MediaRepository;
use App\ViewModels\PostViewModel;
use Exception;

class PostController extends BaseController
{
    private PostRepository $postRepository;
    private LabelRepository $labelRepository;
    private CategoryRepository $categoryRepository;
    private MediaRepository $mediaRepository;

    function __construct(
        PostRepository $postRepo,
        LabelRepository $labelRepo,
        CategoryRepository $categoryRepo,
        MediaRepository $mediaRepo
    ) {
        $this->postRepository = $postRepo;
        $this->labelRepository = $labelRepo;
        $this->categoryRepository = $categoryRepo;
        $this->mediaRepository = $mediaRepo;
    }

    public function index(Request $request) {
        if (!Auth::check()) return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Posts";
        $viewModel->labels = $this->labelRepository->listAll()->objectResult ?? [];
        $viewModel->categories = $this->categoryRepository->listAll()->objectResult ?? [];

        $filters = $this->extractFilters($request);
        $posts = $this->postRepository->listAllPaging($viewModel->pageId, $viewModel->pageSize, $filters);
        $viewModel->filters = $filters;
        $viewModel->totalItems = $posts->total;
        $viewModel->objectReturn = $posts->objectResult;
        return view('Posts/index', compact('viewModel'));
    }

    public function indexPage($pageId, Request $request) {
        if (!Auth::check()) return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "Posts";
        $viewModel->labels = $this->labelRepository->listAll()->objectResult ?? [];
        $viewModel->categories = $this->categoryRepository->listAll()->objectResult ?? [];

        $filters = $this->extractFilters($request);
        $posts = $this->postRepository->listAllPaging($viewModel->pageId, $viewModel->pageSize, $filters);
        $viewModel->filters = $filters;
        $viewModel->totalItems = $posts->total;
        $viewModel->objectReturn = $posts->objectResult;
        return view('Posts/index', compact('viewModel'));
    }

    public function create() {
        if (!Auth::check()) return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->isEditing = false;
        $this->loadFormOptions($viewModel);
        return view('Posts/create', compact('viewModel'));
    }

    public function doCreation(Request $request) {
        $validator = Validator::make($request->all(), $this->checkRules());
        $viewModel = new PostViewModel();

        if ($validator->fails()) {
            LogHelper::write("Erro na validação dos dados: " . $validator->errors(), LogType::Warn);
            $viewModel->message = "Preencha corretamente todos os campos.";
            return Redirect::to('Posts/create')->withErrors($validator)->withInput()->withModel($viewModel);
        }

        try {
            $entity = $this->populate($request);
            $result = $this->postRepository->add($entity);

            if ($result->success) {
                $this->postRepository->syncRelations(
                    $result->id,
                    $request->get('label_ids', []),
                    $request->get('category_ids', [])
                );

                LogHelper::write("Post ID:[".$result->id."] incluido com sucesso", LogType::Info);
                return Redirect::to('Posts');
            }

            $viewModel->message = $result->messages;
            $this->loadFormOptions($viewModel);
            return view('Posts/create', compact('viewModel'));
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Posts/create')
                ->withErrors("Erro ao tentar criar a pagina. Verifique o log.")
                ->withInput();
        }
    }

    public function edit($id) {
        if (!Auth::check()) return Redirect::to('login');

        $viewModel = new PostViewModel();
        $viewModel->editId = $id;
        $viewModel->isEditing = true;
        $post = $this->postRepository->getById($id);
        $viewModel->objectReturn = $post->objectResult;

        $this->loadFormOptions($viewModel);
        $viewModel->selectedMediaId = $viewModel->objectReturn?->cover_media_id;
        $viewModel->selectedLabels = $viewModel->objectReturn?->labels?->pluck('id')->toArray() ?? [];
        $viewModel->selectedCategories = $viewModel->objectReturn?->categories?->pluck('id')->toArray() ?? [];

        return view('Posts/edit', compact('viewModel'));
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), $this->checkRules());

        if ($validator->fails()) {
            LogHelper::write("Erro na validação dos dados: " . $validator->errors(), LogType::Warn);
            return Redirect::to('Posts/edit/'. $id)->withErrors($validator)->withInput();
        }

        try {
            $id = $request->get('txtId');
            $entity = $this->populate($request);

            $result = $this->postRepository->update($id, $entity);
            if ($result->success) {
                $this->postRepository->syncRelations(
                    $id,
                    $request->get('label_ids', []),
                    $request->get('category_ids', [])
                );

                LogHelper::write("Post ID:[".$id."] atualizado com sucesso.", LogType::Info);
                return Redirect::to('Posts');
            }

            return Redirect::to('Posts/edit/'. $id)->withErrors($result->messages)->withInput();
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
            return Redirect::to('Posts/edit/'. $id)->withErrors("Erro ao tentar editar. Verifique o log.")->withInput();
        }
    }

    private function loadFormOptions(PostViewModel $viewModel): void {
        $viewModel->labels = $this->labelRepository->listAll()->objectResult ?? [];
        $viewModel->categories = $this->categoryRepository->listAll()->objectResult ?? [];
        $viewModel->medias = $this->mediaRepository->listAll()->objectResult ?? [];

        $viewModel->selectedMediaId = old('cover_media_id', $viewModel->selectedMediaId);
        $viewModel->selectedLabels = old('label_ids', $viewModel->selectedLabels ?? []);
        $viewModel->selectedCategories = old('category_ids', $viewModel->selectedCategories ?? []);
    }

    private function extractFilters(Request $request): array {
        return [
            'title' => trim((string) $request->get('title', '')),
            'category_id' => $request->get('category_id'),
            'label_id' => $request->get('label_id'),
        ];
    }

    private function populate(Request $request): Array{
        return [
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'author' => $request->get('author'),
            'slug' => $request->get('slug'),
            'publish_date' => $request->get('publish_date'),
            'is_published' => $request->boolean('is_published'),
            'cover_media_id' => $request->get('cover_media_id') ?: null
        ];
    }

    private function checkRules(): Array {
        return [
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'slug' => 'required',
            'publish_date' => 'required|date',
            'is_published' => 'required|boolean',
            'cover_media_id' => 'nullable|exists:medias,id',
            'label_ids' => 'nullable|array',
            'label_ids.*' => 'exists:labels,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id'
        ];
    }

    public function delete($id, Request $request) {
        try {
            $result = $this->postRepository->delete($id);
            LogHelper::write("Post ID:[".$result->id."] removido com sucesso", LogType::Info);

            if ($result->success) return Redirect::to('Posts');
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }
}
