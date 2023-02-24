<svg xmlns="http://www.w3.org/2000/svg" id="svg-spritesheet" @if (config('svg.inline_style', true))style="display: none;"@else class="{{ config('svg.hidden_class', 'hidden') }}" hidden @endif>
    @foreach ($spritesheet as $svg)
        <symbol id="{{ $svg->id() }}" viewBox="{{ implode(' ', $svg->viewBox()) }}">
            {!! $svg->inner() !!}
        </symbol>
    @endforeach
</svg>
