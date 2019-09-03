<?php

namespace AppBundle\Service;


class TestDataStorage implements DataStorageInterface
{
    /** @var int */
    protected $testIndex = 0;
    /** @var array */
    protected static $testFiles = null;

    protected $testFilesDirectory;

    protected $input;
    protected $output;
    protected $stored;

    public function __construct(?string $testFilesDirectory = null)
    {
        $this->testFilesDirectory = $testFilesDirectory;
    }

    public function init(): void
    {
        if (self::$testFiles) {
            return;
        }

        self::$testFiles = array_values(array_diff(scandir($this->testFilesDirectory), ['.', '..']));
    }

    public function set(int $dataSourceId, string $entityClass, array $selector, string $feedType, array $propertyMap): bool
    {
        return false;
    }

    public function get(int $dataSourceId, string $entityClass, array $selector, string $feedType): ?array
    {
        return $this->stored[self::encodeSelector($selector)]['propertyMap'] ?? null;
    }

    public function delete(int $dataSourceId, string $entityClass, array $selector, string $feedType): bool
    {
        return false;
    }

    public function getInput(): ?array
    {
        return $this->input;
    }

    public function getExpectedOutput(): ?array
    {
        return $this->output;
    }

    public function readAndDecodeJsonFile(string $type): ?array
    {
        return json_decode(file_get_contents($this->testFilesDirectory . self::$testFiles[$this->testIndex] . '/' . $type . ".json"), true);
    }

    public function setTestIndex(int $index): void
    {
        $this->testIndex = $index;
        $this->input     = $this->readAndDecodeJsonFile('input');
        $this->output    = $this->readAndDecodeJsonFile('output');

        $stored = $this->readAndDecodeJsonFile('stored');
        foreach ($stored['entities'] as $entity) {
            $this->stored[self::encodeSelector($entity['selector'])] = $entity;
        }
    }

    public function getTestCount(): int
    {
        return count(self::$testFiles);
    }

    public function getTestIndex(): int
    {
        return $this->testIndex;
    }

    public function getCurrentFileName(): string
    {
        return self::$testFiles[$this->testIndex];
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