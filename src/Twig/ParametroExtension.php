<?php

namespace ConfigManager\Bundle\ClientBundle\Twig;

use ConfigManager\Bundle\ClientBundle\Service\ParametroService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ParametroExtension extends AbstractExtension
{
    /** @required */
    public ParametroService $parametroService;

    public function getFunctions()
    {
        return [
            new TwigFunction('get_param', [$this, 'getParametro'], ['is_safe' => ['html']]),
        ];
    }

    public function getParametro(string $dominio, string $codigo = null)
    {
        $parametro = $this->parametroService->getParametro($dominio, $codigo);

        if (!$parametro) {
            return $dominio.' ('.$codigo.')';
        }

        return $parametro;
    }
}
