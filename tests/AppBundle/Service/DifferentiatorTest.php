<?php

namespace AppBundle\Service;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class DifferentiatorTest extends KernelTestCase
{
    /** @var Differentiator */
    protected static $differ;
    /** @var TestDataStorage */
    protected static $testDataStorage;

    protected function setUp(): void
    {
        self::$testDataStorage = new TestDataStorage(getcwd() . '/tests/resources/SofaSON/DifferentiatorTests/');
        self::$testDataStorage->init();

        self::$differ = new Differentiator(self::$testDataStorage);
    }

    public function testDiffer()
    {
        for ($i = 0; $i < self::$testDataStorage->getTestCount(); $i++) {
            self::$testDataStorage->setTestIndex($i);
            self::assertEqualsRecursively(self::$testDataStorage->getExpectedOutput(), self::$differ->diff(self::$testDataStorage->getInput()));
        }
    }

    public static function assertEqualsRecursively(array $expected, array $actual, int $level = 0): void
    {
        foreach ($expected as $expectedKey => $expectedValue) {
            self::assertArrayHasKey($expectedKey, $actual, "Missing key $expectedKey in actual values");
            if (is_array($expectedValue)) {
                //this test assumes the same sort, if the logic of differ changes, there is some chance it will break
                self::assertTrue(is_array($actual[$expectedKey]), var_export($actual[$expectedKey], true) . " is not array with the same offset $expectedKey in expected SofaSON is");
                self::assertEqualsRecursively($expectedValue, $actual[$expectedKey], $level + 1);
            } else {
                self::assertEquals($expectedValue, $actual[$expectedKey], "Not equal of $expectedValue and " . var_export($actual[$expectedKey], true));
            }
            unset($actual[$expectedKey]);
        }
        self::assertEmpty($actual, "Actual values have additional keys which expected do not " . implode(", ", array_keys($actual)));
    }
}
