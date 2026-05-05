<?php

namespace App\Http\Controllers;

use App\ViewModels\DashboardViewModel;
use App\Repositories\CategoryRepository;
use App\Repositories\LabelRepository;
use App\Repositories\LogRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends BaseController
{
    private CategoryRepository $categoryRepository;
    private LabelRepository $labelRepository;
    private PostRepository $postRepository;
    private LogRepository $logRepository;

    public function __construct(
        CategoryRepository $categoryRepo,
        LabelRepository $labelRepo,
        PostRepository $postRepo,
        LogRepository $logRepo
    )
    {
        $this->categoryRepository = $categoryRepo;
        $this->labelRepository = $labelRepo;
        $this->postRepository = $postRepo;
        $this->logRepository = $logRepo;
    }

    public function index()
    {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new DashboardViewModel(); 
        $viewModel->totalCategories = $this->categoryRepository->total()->total;
        $viewModel->totalLabels = $this->labelRepository->total()->total;
        $viewModel->totalPosts = $this->postRepository->total()->total;
        $viewModel->totalErrors = $this->logRepository->total()->total;
        return view('index', compact('viewModel'));
    }
}
