@if ($paginator->hasPages())

<div id="cars-pagination2-nav" class="pagination2-nav text-center">
    <ul class="pagination2">

         {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())

        @else
        <li >
            <a class="prev page-numbers"  href="{{ $paginator->previousPageUrl() }}" >{{ __('admin.Prev') }}</a>
        </li>
        @endif


    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
        <li><span aria-current="page" class="page-numbers ">{{ $element }}</span></li>

    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
        @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
                <li style="font-family: 'Source Sans Pro';"><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>

            @else
                <li><a class="page-numbers"  href="{{ $url }}">{{ $page }}</a>
            </li>
            @endif
        @endforeach
    @endif
    @endforeach


         {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li>
            <li><a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}">{{ __('admin.Next') }} </a></li>

        </li>
        @endif
</div>
@endif
