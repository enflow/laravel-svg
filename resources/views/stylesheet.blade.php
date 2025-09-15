@if (config('svg.stylesheet') !== 'none')
<style id="svg-stylesheet">
    @if (config('svg.stylesheet', 'default') === 'default')
    .svg-auto-size {display: inline-block;font-size: inherit;height: 1em;overflow: visible;vertical-align: -.125em; }
    @elseif (config('svg.stylesheet') === 'layer-base')
    @layer base { .svg-auto-size {display: inline-block;font-size: inherit;height: 1em;overflow: visible;vertical-align: -.125em; } }
    @endif
</style>
@endif