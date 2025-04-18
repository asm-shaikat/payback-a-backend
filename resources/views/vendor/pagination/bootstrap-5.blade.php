@if ($paginator->hasPages())
<nav aria-label="Page navigation">
    <ul class="pagination">
        {{-- First Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item first disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left bx-sm"></i></a>
        </li>
        @else
        <li class="page-item first">
            <a class="page-link" href="{{ $paginator->url(1) }}"><i class="tf-icon bx bx-chevrons-left bx-sm"></i></a>
        </li>
        @endif

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item prev disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-left bx-sm"></i></a>
        </li>
        @else
        <li class="page-item prev">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="tf-icon bx bx-chevron-left bx-sm"></i></a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{{ $element }}</a></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active"><a class="page-link" href="javascript:void(0);">{{ $page }}</a></li>
        @else
        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item next">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="tf-icon bx bx-chevron-right bx-sm"></i></a>
        </li>
        @else
        <li class="page-item next disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-right bx-sm"></i></a>
        </li>
        @endif

        {{-- Last Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item last">
            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}"><i class="tf-icon bx bx-chevrons-right bx-sm"></i></a>
        </li>
        @else
        <li class="page-item last disabled">
            <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right bx-sm"></i></a>
        </li>
        @endif
    </ul>
</nav>
@endif