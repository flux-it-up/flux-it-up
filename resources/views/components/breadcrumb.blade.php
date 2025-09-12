@if(count($crumbs))
<nav class="mb-4 text-sm text-dark-500">
    <ol class="flex flex-wrap space-x-2">
        @foreach($crumbs as $crumb)
            <li>
                @if($crumb['url'])
                    <a href="{{ $crumb['url'] }}" class="hover:underline">{{ $crumb['title'] }}</a>
                @else
                    <span class="font-semibold">{{ $crumb['title'] }}</span>
                @endif
                @if(!$loop->last)
                    <span>/</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif