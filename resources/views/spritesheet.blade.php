@if ($svgs->isNotEmpty())
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        @foreach ($svgs as $svg)
            <symbol id="{{ $svg->id() }}" viewBox="{{ implode(' ', $svg->viewBox()) }}">
                {!! $svg->inner() !!}
            </symbol>
        @endforeach
    </svg>
    <style>.svg-auto-size {display: inline-block;font-size: inherit;height: 1em;overflow: visible;vertical-align: -.125em;}</style>
@endif
