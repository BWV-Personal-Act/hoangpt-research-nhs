@if ($paginator->total() >= 1)
    <div class="row" style="width: 100%">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="table1_info" role="status" aria-live="polite">
                {{ $paginator->total() }} 件中 {{ $paginator->firstItem() }} から {{ $paginator->lastItem() }} まで表示
            </div>
        </div>

        <div class="col-sm-12 col-md-7">
            <ul class="pagination" style="justify-content: right">
                <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                    <a style="color: black" class="page-link" href="{{ $paginator->url(1) }}">先頭</a>
                </li>

                <li class="page-item {{ $paginator->currentPage() == 1 ? ' disabled' : '' }}">
                    <a style="color: black" class="page-link" href="{{ $paginator->url($paginator->currentPage() - 1) }}">前</a>
                </li>

                @php
                    $firstPage = 1;
                    $pageLimit = 9;
                    $lastPage = $paginator->lastPage() > $pageLimit ? $pageLimit : $paginator->lastPage();
                    $diff = $lastPage - $firstPage;
                    $half = floor($pageLimit / 2);
                    $currentPage = $paginator->currentPage();

                    if ($currentPage - $half > 0) {
                        if ($currentPage < $paginator->lastPage() && $currentPage + $half < $paginator->lastPage()) {
                            $lastPage = $currentPage + $half;
                        } else {
                            $lastPage = $paginator->lastPage();
                        }

                        $firstPage = $lastPage - $diff;
                    }
                @endphp
                @for ($i = $firstPage; $i <= $lastPage; $i++)
                    <li class="page-item {{ $paginator->currentPage() == $i ? ' active not-click' : '' }}">
                        <a style="color: black" class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                    <a style="color: black" class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}">次</a>
                </li>

                <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                    <a style="color: black" class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">最終</a>
                </li>
            </ul>
        </div>
    </div>
@endif
