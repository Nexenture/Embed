<?php
declare(strict_types = 1);

namespace Embed\Adapters\Linkedin\Detectors;

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

        preg_match('/activity-(\d+)/', $uri->__toString(), $matches);

        if (empty($matches)) {
            return null;
        }

        $width = $height = 500;

        $url = 'https://www.linkedin.com/embed/feed/update/urn:li:activity:'.$matches[1];

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
