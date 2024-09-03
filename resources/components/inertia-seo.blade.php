<title>{!! \Artesaos\SEOTools\Facades\SEOMeta::getTitle() !!}</title>

@if(!empty($meta['preload']))
    @foreach($meta['preload'] as $preload)
        @if($preload['href'])
            <link rel="preload" href="{{ $preload['href'] }}" as="{{ $preload['as'] }}" />
        @endif
    @endforeach
@endif

<link rel="canonical" href="{!! \Artesaos\SEOTools\Facades\SEOMeta::getCanonical() !!}" />
<meta name="description" content="{!! \Artesaos\SEOTools\Facades\SEOMeta::getDescription() !!}" />
<link rel="search" type="application/opensearchdescription+xml" href="{{ url('opensearch.xml') }}"
      title="{{ config('app.name') }}">

{!! OpenGraph::generate() !!}
{!! Twitter::generate() !!}
{!! JsonLd::generate() !!}

@if(!empty($meta['json']))
    @if(isset($meta['json'][1]))
        @foreach($meta['json'] as $json)
            <script type="application/ld+json">
                {!! json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
            </script>
        @endforeach
    @else
        <script type="application/ld+json">
            {!! json_encode($meta['json'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif
@endif

@isset($meta['feeds'])
    @foreach($meta['feeds'] as $name => $url)
        <link rel="alternate" type="application/rss+xml" title="{{ $name }}" href="{{ $url }}" />
    @endforeach
@endif
