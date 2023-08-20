<?php

declare(strict_types=1);

namespace Eventjet\CodingStandard\PhpCsFixer;

use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;

use function debug_backtrace;
use function dirname;

final class Config
{
    public static function basic(Finder | null $finder = null): ConfigInterface
    {
        $finder ??= self::createFinder();
        return (new \PhpCsFixer\Config())
            ->setRules(self::basicRules())
            ->setFinder($finder)
            ->setRiskyAllowed(true);
    }

    public static function strict(Finder | null $finder = null): ConfigInterface
    {
        $finder ??= self::createFinder();
        return (new \PhpCsFixer\Config())
            ->setRules(self::strictRules())
            ->setFinder($finder)
            ->setRiskyAllowed(true);
    }

    /**
     * @return array<string, mixed>
     */
    private static function basicRules(): array
    {
        return require(__DIR__ . '/../../php-cs-fixer-rules.php');
    }

    /**
     * @return array<string, mixed>
     */
    private static function strictRules(): array
    {
        return require(__DIR__ . '/../../php-cs-fixer-rules.php');
    }

    private static function createFinder(): Finder
    {
        return Finder::create()->in(self::callingDir());
    }

    private static function callingDir(): string
    {
        $backtrace = debug_backtrace();
        return dirname($backtrace[2]['file']);
    }
}
