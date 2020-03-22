<?php

namespace Enflow\Svg\Middleware;

use Closure;
use Enflow\Svg\Spritesheet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyBaseResponse;

class InjectSvgSpritesheet
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (
            $response instanceof RedirectResponse
            || ($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') === false)
            || $request->getRequestFormat() !== 'html'
            || $response->getContent() === false
            || $request->isXmlHttpRequest()
        ) {
            return $response;
        }

        return $this->injectSpritesheet($response);
    }

    private function injectSpritesheet(SymfonyBaseResponse $response): SymfonyBaseResponse
    {
        if (Str::contains($content = $response->getContent(), '<head>')) {
            // We insert it in the top part of the <head> as then custom CSS will overrule ours
            $content = str_replace('<head>', '<head>' . $this->spritesheet(), $content);
            $response->setContent($content);
        }

        return $response;
    }

    private function spritesheet(): string
    {
        return app(Spritesheet::class)->toHtml();
    }
}
