<?php

namespace App\Http\Controllers;

use App\Repositories\LogRepository;
use App\ViewModels\LogViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LogController extends BaseController
{
    private LogRepository $LogRepository;

    function __construct(LogRepository $LogRepo)
    {
        $this->LogRepository = $LogRepo;
    }

    public function index()
    {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new LogViewModel();
        $viewModel->pageId = 1;
        $viewModel->pageSize = 20;
        $viewModel->resourceLink = 'Logs';

        $logs = $this->LogRepository->listAllPaging($viewModel->pageId, $viewModel->pageSize);
        $viewModel->totalItems = $logs->total;
        $viewModel->objectReturn = $logs->objectResult;

        return view('Logs/index', compact('viewModel'));
    }

    public function indexPage($pageId)
    {
        if (!Auth::check())
            return Redirect::to('login');

        $viewModel = new LogViewModel();
        $viewModel->pageId = $pageId;
        $viewModel->pageSize = 20;
        $viewModel->resourceLink = 'Logs';

        $logs = $this->LogRepository->listAllPaging($viewModel->pageId, $viewModel->pageSize);
        $viewModel->totalItems = $logs->total;
        $viewModel->objectReturn = $logs->objectResult;

        return view('Logs/index', compact('viewModel'));
    }
}
