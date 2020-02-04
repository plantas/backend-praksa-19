<?php


namespace AppBundle\Service;


use AppBundle\Service\DataStorageInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class FilesystemDataStorage implements DataStorageInterface
{
    private $storageDirectory;

    public function __construct($storageDirectory)
    {
        $this->storageDirectory = $storageDirectory;
    }

    /**
     * @inheritDoc
     */
    public function set(int $dataSourceId, string $entityClass, array $selector, string $feedType, array $propertyMap): bool
    {
        $filename = $this->getFilePath($dataSourceId, $entityClass, $selector, $feedType);
        return (bool) file_put_contents($filename, serialize($propertyMap));
    }

    /**
     * @inheritDoc
     */
    public function get(int $dataSourceId, string $entityClass, array $selector, string $feedType): ?array
    {
        $filename = $this->getFilePath($dataSourceId, $entityClass, $selector, $feedType);
        if (file_exists($filename)) {
            return unserialize(file_get_contents($filename));
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $dataSourceId, string $entityClass, array $selector, string $feedType): bool
    {
        $filename = $this->getFilePath($dataSourceId, $entityClass, $selector, $feedType);
        if (file_exists($filename)) {
            return unlink($filename);
        }
    }

    private function getFilePath(int $dataSourceId, string $entityClass, array $selector, string $feedType)
    {
        return $this->storageDirectory . '/' . md5($dataSourceId . $entityClass . self::encodeSelector($selector) . $feedType);
    }

    private static function encodeSelector(array $selector): string
    {
        $data = [];

        ksort($selector);
        foreach ($selector as $key => $value) {
            //entity can be selected by entities which also need to be selected, e.g. event player statistics by event, player and team
            $valueString = is_array($value) ? self::encodeSelector($value['selector']) : $value;
            $data[]      = sprintf('%s:%s', $key, $valueString);
        }

        return '{' . implode(",", $data) . '}';
    }
}