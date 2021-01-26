<?php

declare(strict_types=1);

namespace Eventjet\CodingStandard\Test;

use DirectoryIterator;
use PHPUnit\Framework\TestCase;

use function array_merge;
use function exec;
use function implode;
use function sprintf;

final class RulesTest extends TestCase
{
    /**
     * @dataProvider valid
     */
    public function testValid(string $file, string $standard): void
    {
        $this->assertIsValid($file, $standard);
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public function valid(): iterable
    {
        foreach ($this->gatherFiles(__DIR__ . '/fixtures/valid') as $key => $file) {
            yield $key => [$file, 'Eventjet'];
        }
        foreach ($this->gatherFiles(__DIR__ . '/fixtures/valid-strict') as $key => $file) {
            yield $key => [$file, 'EventjetStrict'];
        }
    }

    /**
     * @dataProvider invalid
     */
    public function testInvalid(string $file, string $standard): void
    {
        $this->assertIsInvalid($file, $standard);
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public function invalid(): iterable
    {
        foreach ($this->gatherFiles(__DIR__ . '/fixtures/invalid') as $key => $file) {
            yield $key => [$file, 'Eventjet'];
        }
        foreach ($this->gatherFiles(__DIR__ . '/fixtures/invalid-strict') as $key => $file) {
            yield $key => [$file, 'EventjetStrict'];
        }
    }

    private function assertIsValid(string $file, string $standard): void
    {
        $command = sprintf('%s/../vendor/bin/phpcs --standard=%s %s', __DIR__, $standard, $file);
        exec($command, $output, $return);
        $lines = array_merge(
            [sprintf('Failed asserting that %s is valid.', $file)],
            $output
        );
        $message = implode("\n", $lines);
        self::assertSame(0, $return, $message);
    }

    private function assertIsInvalid(string $file, string $standard): void
    {
        $command = sprintf('%s/../vendor/bin/phpcs --standard=%s %s', __DIR__, $standard, $file);
        exec($command, $output, $return);
        self::assertNotSame(0, $return, sprintf('Failed asserting that %s is invalid.', $file));
    }

    /**
     * @return array<string, string>
     */
    private function gatherFiles(string $directory): array
    {
        $files = [];
        foreach (new DirectoryIterator($directory) as $file) {
            if (!$file->isFile()) {
                continue;
            }
            $files[$file->getFilename()] = $file->getPathname();
        }
        return $files;
    }
}
