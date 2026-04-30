<div class="pagination">
    <?php
        $totalPaginas = ($viewModel->totalItems / $viewModel->pageSize) + 1;
    ?>
    @if ($totalPaginas > 1) 
        <div class="col-12" aria-label="Page navigation">
            <ul class="pagination mt-5">
                @for($i = 1; $i <= $totalPaginas; $i++)
                    <?php
                        $isActive = $viewModel->pageId == $i;    
                    ?>
                    <li class="page-item">
                        <a class="page-link <?= $isActive ? "active" : "" ;?>" href="{{url('/painel')}}/{{$viewModel->resourceLink}}/page/{{$i}}">
                            {{$i}}
                        </a>
                    </li>   
                @endfor
            </ul>
        </div>
    @endif
</div>