<svg xmlns="http://www.w3.org/2000/svg" style="display: none;" id="svg-spritesheet">
    @foreach ($spritesheet as $svg)
        <symbol id="{{ $svg->id() }}" viewBox="{{ implode(' ', $svg->viewBox()) }}">
            {!! $svg->inner() !!}
        </symbol>
    @endforeach
</svg>
