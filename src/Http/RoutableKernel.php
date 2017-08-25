<?php

namespace Askaoru\Routable\Http;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Router;

class RoutableKernel extends HttpKernel
{
    /**
     * Start the kernel instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Routing\Router                   $router
     *
     * @return void
     */
    public function __construct(Application $app, Router $router)
    {
        $this->checkLocale();
        parent::__construct($app, $router);
    }

    /**
     * Determine whether or not the locale should be filtered.
     *
     * @return void
     */
    public function checkLocale()
    {
        $config = [
            'enable_locale_append' => false,
            'enabled_locales'      => [],
        ];

        if (file_exists($config_file = base_path('config/routable.php'))) {
            $config = include $config_file;
        }

        if (!$config['enable_locale_append']) {
            return;
        }

        $request_segments = explode('/', $_SERVER['REQUEST_URI']);
        $intersect = array_intersect($request_segments, $config['enabled_locales']);

        if ($intersect) {
            $locale = array_values($intersect)[0];
            $this->filterAndDefineLocale($locale, $request_segments);
        }
    }

    /**
     * Filter the locale from the request uri and define it globally.
     *
     * @param string $locale
     * @param array  $request_segments
     *
     * @return void
     */
    public function filterAndDefineLocale($locale, $request_segments)
    {
        // Let's get the project base path segments and compare it with the request segments.
        $base_path_segments = explode('/', str_replace('index.php', '', $_SERVER['PHP_SELF']));
        $base_and_request_comparison = array_diff($request_segments, $base_path_segments);

        // Remove the locale from the base and request segments comparison result.
        $locale_removed = array_diff($base_and_request_comparison, [$locale]);

        // Rebuild the resulting array with the original project base path segments.
        $uri_segments = array_merge($base_path_segments, $locale_removed);
        $uri = implode('/', $uri_segments);

        // Set the new uri and define the locale globally so we can pick it up later.
        $_SERVER['REQUEST_URI'] = $uri;

        define('ROUTABLE_LOCALE', $locale);
    }
}
