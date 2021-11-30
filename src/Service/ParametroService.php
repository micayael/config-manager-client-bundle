<?php

namespace ConfigManager\Bundle\ClientBundle\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParametroService
{
    public const KEY = 'config_manager_configs';

    /** @required */
    public TagAwareCacheInterface $cache;

    /** @required */
    public HttpClientInterface $httpClient;

    /** @required */
    public array $bundleConfig;

    public function getParametros(): ?array
    {
        $parametros = $this->cache->get(ParametroService::KEY, function (ItemInterface $item) {
            $item->expiresAfter($this->bundleConfig['cache_timeout']);

            $uri = $this->bundleConfig['host'].$this->bundleConfig['entrypoint'];

            $response = $this->httpClient->request('GET', $uri, [
                'headers' => [
                    'X-TOKEN-APP' => $this->bundleConfig['app_token']
                ],
            ]);

            $params = json_decode($response->getContent(), true);

            $parametros = [];

            foreach ($params as $param) {
                $parametros[$param['dominio']][$param['codigo']] = $param['valor'];
            }

            return $parametros;
        });

        return $parametros;
    }

    /**
     * @return mixed
     */
    public function getParametro(string $dominio, ?string $codigo = null)
    {
        $parametros = $this->getParametros();

        $ret = $parametros[$dominio];

        if ($codigo) {
            $ret = $ret[$codigo];
        }

        return $ret;
    }

    public function clear()
    {
        $this->cache->delete(ParametroService::KEY);

        $this->getParametros();
    }

    public function delete()
    {
        $this->cache->delete(ParametroService::KEY);
    }
}
