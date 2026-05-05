<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogHelper;
use App\Enums\LogType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\PostCommentRepository;
use App\Repositories\LabelRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\MediaRepository;
use App\ViewModels\PostCommentViewModel;
use Exception;

class PostCommentController extends BaseController
{
    private PostCommentRepository $PostCommentRepository;
    private LabelRepository $labelRepository;
    private CategoryRepository $categoryRepository;
    private MediaRepository $mediaRepository;

    function __construct(
        PostCommentRepository $PostCommentRepo,
        LabelRepository $labelRepo,
        CategoryRepository $categoryRepo,
        MediaRepository $mediaRepo
    ) {
        $this->PostCommentRepository = $PostCommentRepo;
        $this->labelRepository = $labelRepo;
        $this->categoryRepository = $categoryRepo;
        $this->mediaRepository = $mediaRepo;
    }

    public function index($postId, Request $request) {
        if (!Auth::check()) return Redirect::to('login');

        $viewModel = new PostCommentViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "PostComments";
        $viewModel->labels = $this->labelRepository->listAll()->objectResult ?? [];
        $viewModel->categories = $this->categoryRepository->listAll()->objectResult ?? [];

        $PostComments = $this->PostCommentRepository->listAllFromPost($postId, $viewModel->pageId, $viewModel->pageSize);
        $viewModel->totalItems = $PostComments->total;
        $viewModel->objectReturn = $PostComments->objectResult;
        return view('PostComments/index', compact('viewModel'));
    }

    public function indexPage($postId, $pageId, Request $request) {
        if (!Auth::check()) return Redirect::to('login');

        $viewModel = new PostCommentViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 10;
        $viewModel->resourceLink = "PostComments";
        $viewModel->labels = $this->labelRepository->listAll()->objectResult ?? [];
        $viewModel->categories = $this->categoryRepository->listAll()->objectResult ?? [];

        $PostComments = $this->PostCommentRepository->listAllFromPost($postId, $viewModel->pageId, $viewModel->pageSize);
        $viewModel->totalItems = $PostComments->total;
        $viewModel->objectReturn = $PostComments->objectResult;
        return view('PostComments/index', compact('viewModel'));
    }

    public function delete($id, Request $request) {
        try {
            $result = $this->PostCommentRepository->delete($id);
            LogHelper::write("PostComment ID:[".$result->id."] removido com sucesso", LogType::Info);

            if ($result->success) return Redirect::to('PostComments');
        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }

    public function approveComment($commentId, $postId, Request $request) {
        try {
            $entity = [
                'approved' => true,
                'updated_at' => date("Y-M-d")
            ];
            $result = $this->PostCommentRepository->update($commentId, $entity);
            LogHelper::write("PostComment ID:[".$result->id."] aprovado com sucesso", LogType::Info);

            if ($result->success) 
                return Redirect::to('PostComments/' . $postId);

        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }

    public function rejectComment($commentId, $postId, Request $request) {
        try {
            $entity = [
                'approved' => false,
                'updated_at' => date("Y-M-d")
            ];
            $result = $this->PostCommentRepository->update($commentId, $entity);
            LogHelper::write("PostComment ID:[".$result->id."] reprovado com sucesso", LogType::Info);

            if ($result->success) 
                return Redirect::to('PostComments/' . $postId);

        } catch (Exception $e) {
            LogHelper::write($e, LogType::Error);
        }
    }
}
