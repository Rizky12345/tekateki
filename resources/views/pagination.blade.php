@if ($paginator->hasPages())
    <ul class="pager has-text-centered">
       
        @if ($paginator->onFirstPage())
            <li class="disabled paginate-width"><span>← Previous</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="paginate-width">← Previous</a></li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled paginate-width-small"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active my-active paginate-width-small"><span>{{ $page }}</span></li>
                    @else
                        <li class="paginate-width-small"><a href="{{ $url }}" >{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="paginate-width">Next →</a></li>
        @else
            <li class="disabled paginate-width"><span>Next →</span></li>
        @endif
    </ul>
@endif 