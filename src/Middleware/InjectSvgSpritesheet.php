<?php

namespace Enflow\Svg\Middleware;

use Closure;
use Enflow\Svg\Spritesheet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyBaseResponse;

class InjectSvgSpritesheet
{
    public function __construct(private Spritesheet $spritesheet)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->spritesheet->injected) {
            return $response;
        }

        if (
            $response instanceof RedirectResponse
            || ($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') === false)
            || $request->getRequestFormat() !== 'html'
            || $response->getContent() === false
            || $request->isXmlHttpRequest()
        ) {
            return $response;
        }

        $this->spritesheet->injected = true;

        if ($this->spritesheet->isEmpty()) {
            return $response;
        }

        return $this->injectStylesheet($this->injectSpritesheet($response));
    }

    private function injectStylesheet(SymfonyBaseResponse $response): SymfonyBaseResponse
    {
        if (Str::contains($content = $response->getContent(), '<head>') && ! Str::contains($content, 'svg-stylesheet')) {
            // We insert it in the top part of the <head> as then custom CSS will overrule ours
            $response->setContent(str_replace('<head>', '<head>' . $this->stylesheet(), $content));
        }

        return $response;
    }

    private function injectSpritesheet(SymfonyBaseResponse $response): SymfonyBaseResponse
    {
        if (Str::contains($content = $response->getContent(), '<body') && ! Str::contains($content, 'svg-spritesheet')) {
            // Ported from https://stackoverflow.com/questions/2216224/php-inject-iframe-right-after-body-tag
            $matches = preg_split('/(<body.*?>)/i', $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            if (! empty($matches[0]) && ! empty($matches[1]) && ! empty($matches[2])) {
                // We insert it in the top part of the <body> as then the CSS can load first before the SVG body is sent.
                $response->setContent($matches[0] . $matches[1] . $this->spritesheet->toHtml() . $matches[2]);
            }
        }

        return $response;
    }

    private function stylesheet(): HtmlString
    {
        return $this->spritesheet->toStylesheet();
    }
}
