<?php
declare(strict_types = 1);

namespace Embed\Adapters\Github\Detectors;

use Embed\Detectors\Code as Detector;
use Embed\EmbedCode;
use function Embed\html;
use function Embed\matchPath;

class Code extends Detector
{
    public function detect(): ?EmbedCode
    {
        return $this->fallback();
    }

    private function fallback(): ?EmbedCode
    {
        $uri = $this->extractor->getUri();
      
        $metas = $this->extractor->getMetas();

        $url = $metas->url('twitter:player');

        if (!$url) {
            return null;
        }

        $width = $metas->int('twitter:player:width');
        $height = $metas->int('twitter:player:height');

        $code = html('iframe', [
            'src' => $url,
            'frameborder' => 0,
            'width' => $width,
            'height' => $height,
            'allowTransparency' => 'true',
        ]);

        return new EmbedCode($code, $width, $height);
    }
}
