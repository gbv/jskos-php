<?php declare(strict_types=1);

namespace JSKOS;

use Symfony\Component\Yaml\Yaml;

/**
 * This subclass of JSKOS\Service automatically loads service configuration
 * from a YAML file to configure an URISpaceService among other settings.
 *
 * Subclasses MUST override static class property `$CONFIG_DIR`.
 *
 * Configuration is available in member `$config`.
 */
class ConfiguredService extends Service
{

    // subclass MUST override this, e.g. with __DIR__:
    public static $CONFIG_DIR = ".";

    protected $config = [];
    private $uriSpaceService;

    public function __construct()
    {
        parent::__construct();
        $class = join('', array_slice(explode('\\', get_class($this)), -1));
        $file = static::$CONFIG_DIR."/$class.yaml";
        $this->config = Yaml::parse(file_get_contents($file));

        if (isset($this->config['_uriSpace'])) {
            $this->uriSpaceService = new URISpaceService($this->config['_uriSpace']);
        }
    }

    public function queryURISpace($query)
    {
        return $this->uriSpaceService ? $this->uriSpaceService->query($query) : null;
    }
}
