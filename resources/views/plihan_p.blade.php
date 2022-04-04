@if ($paginator->hasPages())
<div class="columns">
    <div class="column" style="text-align: right;">
        @if ($paginator->onFirstPage())
            <label class="disabled paginate-width mr-4">← sebelumnya</label>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="paginate-width mr-4">← sebelumnya</a>
        @endif
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="paginate-width ml-4">berikutnya →</a>
        @else
            <label class="disabled paginate-width ml-4">berikutnya →</label>
        @endif
    </div>
</div>
        

        
        
    
@endif 