<?php

declare(strict_types=1);

namespace Eventjet\CodingStandard\Test;

use DirectoryIterator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

use function array_merge;
use function basename;
use function implode;
use function in_array;
use function sprintf;

/**
 * @phpstan-type Tool 'phpcs' | 'php-cs-fixer' | 'mago'
 */
final class RulesTest extends TestCase
{
    private const SKIPPED_VALID = [];
    /** @var list<array{string, Tool}> */
    private const SKIPPED_INVALID = [
        // PHP CS Fixer has no rule for string[] vs array<array-key, string>
        ['wrong-array-typehint-syntax.php', 'php-cs-fixer'],
        // PHPCS doesn't seem to have a rule for heredoc/nowdoc indentation
        ['NowdocNotIndented.php', 'phpcs'],
        ['HeredocNotIndented.php', 'phpcs'],
        // PHPCS doesn't have a rule for this.
        ['nullable-parameter.php', 'phpcs'],
        ['nullable-return.php', 'phpcs'],
        // Mago doesn't have support for these yet
        ['global-constant-fully-qualified.php', 'mago'],
        ['global-constant-not-imported.php', 'mago'],
        ['global-function-fully-qualified.php', 'mago'],
        ['unnecessary-param-annotation.php', 'mago'],
        ['unnecessary-return-annotation.php', 'mago'],
        ['wrong-array-typehint-syntax.php', 'mago'],
    ];

    private static function phpCsFixerCommand(string $file): Process
    {
        $process = new Process([
            'vendor/bin/php-cs-fixer',
            'fix',
            '--dry-run',
            '--config',
            'tests/php-cs-fixer-config.php',
            $file,
        ]);
        $process->setWorkingDirectory(__DIR__ . '/../');
        $process->setEnv(['PHP_CS_FIXER_IGNORE_ENV' => '1']);
        return $process;
    }

    private static function magoCommand(string $file): Process
    {
        $process = Process::fromShellCommandline("vendor/bin/mago fmt --check $file && vendor/bin/mago lint $file");
        $process->setWorkingDirectory(__DIR__ . '/../');
        return $process;
    }

    private static function codeSnifferCommand(string $file): Process
    {
        $process = new Process(['vendor/bin/phpcs', '--standard=EventjetStrict', $file]);
        $process->setWorkingDirectory(__DIR__ . '/../');
        return $process;
    }

    /**
     * @param Tool $tool
     * @dataProvider valid
     */
    public function testValid(string $file, string $tool): void
    {
        if (in_array([basename($file), $tool], self::SKIPPED_VALID)) {
            $this->assertIsInvalid($file, $tool);
        } else {
            $this->assertIsValid($file, $tool);
        }
    }

    /**
     * @return iterable<string, array{string, Tool}>
     */
    public static function valid(): iterable
    {
        foreach (['mago', 'phpcs', 'php-cs-fixer'] as $tool) {
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
            $this->assertIsValid($file, $tool);
        } else {
            $this->assertIsInvalid($file, $tool);
        }
    }

    /**
     * @return iterable<string, array{string, Tool}>
     */
    public static function invalid(): iterable
    {
        foreach (['mago', 'phpcs', 'php-cs-fixer'] as $tool) {
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
        $command = match ($tool) {
            'mago' => self::magoCommand($file),
            'php-cs-fixer' => self::phpCsFixerCommand($file),
            default => self::codeSnifferCommand($file),
        };
        $command->run();
        $lines = array_merge([sprintf('Failed asserting that %s is valid.', $file)], [
            $command->getOutput(),
            $command->getErrorOutput(),
        ]);
        $message = implode("\n", $lines);
        self::assertTrue($command->isSuccessful(), $message);
    }

    /**
     * @param Tool $tool
     */
    private function assertIsInvalid(string $file, string $tool): void
    {
        $command = match ($tool) {
            'mago' => self::magoCommand($file),
            'php-cs-fixer' => self::phpCsFixerCommand($file),
            default => self::codeSnifferCommand($file),
        };
        $command->run();
        self::assertNotTrue($command->isSuccessful(), sprintf('Failed asserting that %s is invalid.', $file));
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
