@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
@endphp

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Trang đầu (chỉ hiện khi không liền kề) --}}
            @if ($current > 2)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>
                @if ($current > 3)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            {{-- 2 trang liên tiếp hiện tại --}}
            @for ($i = max(1, $current - 1); $i <= min($last, $current + 1); $i++)
                @if ($i == $current)
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            {{-- Trang cuối (luôn hiện nếu không liền kề) --}}
            @if ($current < $last - 1)
                @if ($current < $last - 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($last) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>