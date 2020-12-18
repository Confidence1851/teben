@if ($paginator->hasPages())

<ul class="pagination mt-5 justify-content-center">
    <li class="page-item"></li>
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    
        <li class="page-item disabled"  >
            <a class="page-link"  href="#prev"> <span class="fa fa-angle-double-left"></span></a>
        </li>
    @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" > <span class="fa fa-angle-double-left"></span></a>
        </li>
    @endif

    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $more = 3;
        $pages = [];
        for($i = 1; $i < $current + $more; $i++){
            if($i >= 1 && $i <= $last){
                $pages[$i] = $i;
            }
        }

        $pages = array_slice($pages , -$more);        
    @endphp

    @foreach($pages as $page)
    <li class="page-item">
        <a class="page-link {{ $page == $current ? 'active' : ''  }}" href="{{ $paginator->url($page) }}">{{ $page }}</a>
    </li>
    @endforeach
    
    @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}"> <span class="fa fa-angle-double-right"></span></a>
                </li>
            @else
            <li class="page-item">
                <a class="page-link" href="#next"> <span class="fa fa-angle-double-right"></span></a>
            </li>            
    @endif
    <div class="clear"></div>
</ul>

@endif
