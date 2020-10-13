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
    public function testValid(string $file): void
    {
        $this->assertIsValid($file);
    }

    public function valid(): array
    {
        return $this->gatherFiles(__DIR__ . '/fixtures/valid');
    }

    /**
     * @dataProvider invalid
     */
    public function testInvalid(string $file): void
    {
        $this->assertIsInvalid($file);
    }

    public function invalid(): array
    {
        return $this->gatherFiles(__DIR__ . '/fixtures/invalid');
    }

    private function assertIsValid(string $file): void
    {
        $command = sprintf('%s/../vendor/bin/phpcs --standard=Eventjet %s', __DIR__, $file);
        exec($command, $output, $return);
        $lines = array_merge(
            [sprintf('Failed asserting that %s is valid.', $file)],
            $output
        );
        $message = implode("\n", $lines);
        self::assertSame(0, $return, $message);
    }

    private function assertIsInvalid(string $file): void
    {
        $command = sprintf('%s/../vendor/bin/phpcs --standard=Eventjet %s', __DIR__, $file);
        exec($command, $output, $return);
        self::assertNotSame(0, $return, sprintf('Failed asserting that %s is invalid.', $file));
    }

    private function gatherFiles(string $directory): array
    {
        $files = [];
        foreach (new DirectoryIterator($directory) as $file) {
            if (!$file->isFile()) {
                continue;
            }
            $files[$file->getFilename()] = [$file->getPathname()];
        }
        return $files;
    }
}
