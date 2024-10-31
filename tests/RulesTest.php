<?php

declare(strict_types=1);

namespace Eventjet\CodingStandard\Test;

use DirectoryIterator;
use PHPUnit\Framework\TestCase;

use function array_merge;
use function basename;
use function exec;
use function implode;
use function in_array;
use function sprintf;

/**
 * @phpstan-type Tool 'phpcs' | 'php-cs-fixer'
 */
final class RulesTest extends TestCase
{
    /** @var list<array{string, Tool}> */
    private const SKIPPED_INVALID = [
        // PHP CS Fixer has no rule for string[] vs array<array-key, string>
        ['wrong-array-typehint-syntax.php', 'php-cs-fixer'],
        // PHP CS Fixer's rule seems to only care about qualified symbols. It adds an import for `\strlen()`, but not
        // for `strlen()`.
        ['global-function-not-imported.php', 'php-cs-fixer'],
        ['global-constant-not-imported.php', 'php-cs-fixer'],
    ];

    private static function phpCsFixerCommand(string $file): string
    {
        return sprintf(
            'PHP_CS_FIXER_IGNORE_ENV=1 %s/../vendor/bin/php-cs-fixer fix --dry-run --config %s/php-cs-fixer-config.php %s',
            __DIR__,
            __DIR__,
            $file
        );
    }

    /**
     * @param Tool $tool
     * @dataProvider valid
     */
    public function testValid(string $file, string $tool): void
    {
        $this->assertIsValid($file, $tool);
    }

    /**
     * @return iterable<string, array{string, Tool}>
     */
    public static function valid(): iterable
    {
        foreach (['phpcs', 'php-cs-fixer'] as $tool) {
            foreach (self::gatherFiles(__DIR__ . '/fixtures/valid') as $filename => $path) {
                yield $tool . ': ' . $filename => [$path[0], $tool];
            }
        }
    }

    /**
     * @param Tool $tool
     * @dataProvider invalid
     */
    public function testInvalid(string $file, string $tool): void
    {
        if (in_array([basename($file), $tool], self::SKIPPED_INVALID)) {
            self::markTestSkipped(sprintf('Skipping %s', $file));
        }

        $this->assertIsInvalid($file, $tool);
    }

    /**
     * @return iterable<string, array{string, Tool}>
     */
    public static function invalid(): iterable
    {
        foreach (['phpcs', 'php-cs-fixer'] as $tool) {
            foreach (self::gatherFiles(__DIR__ . '/fixtures/invalid') as $filename => $path) {
                yield $tool . ': ' . $filename => [$path[0], $tool];
            }
        }
    }

    /**
     * @param Tool $tool
     */
    private function assertIsValid(string $file, string $tool): void
    {
        $command = $tool === 'phpcs'
            ? sprintf('%s/../vendor/bin/phpcs --standard=EventjetStrict %s', __DIR__, $file)
            : self::phpCsFixerCommand($file);
        exec($command, $output, $return);
        $lines = array_merge(
            [sprintf('Failed asserting that %s is valid.', $file)],
            $output
        );
        $message = implode("\n", $lines);
        self::assertSame(0, $return, $message);
    }

    /**
     * @param Tool $tool
     */
    private function assertIsInvalid(string $file, string $tool): void
    {
        $command = $tool === 'phpcs'
            ? sprintf('%s/../vendor/bin/phpcs --standard=EventjetStrict %s', __DIR__, $file)
            : self::phpCsFixerCommand($file);
        exec($command, $output, $return);
        self::assertNotSame(0, $return, sprintf('Failed asserting that %s is invalid.', $file));
    }

    /**
     * @return array<string, array{string}>
     */
    private static function gatherFiles(string $directory): array
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
