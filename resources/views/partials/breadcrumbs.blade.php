@if (count($breadcrumbs))

    <div class="breadcrumbs-area clearfix">

        <ul class="breadcrumbs pull-left">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li><span>{{ $breadcrumb->title }}</span></li>
                @endif

            @endforeach
        </ul>
    </div>

@endif