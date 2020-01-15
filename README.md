# Eventjet Coding Standard

## Basic Usage:
Add the following `phpcs.xml` file to your project's root:
```xml
<?xml version="1.0"?>
<ruleset>
    <rule ref="Eventjet"/>

    <file>src</file>
    <file>tests</file>
</ruleset>
```

## More strict rules:
There is also a more strict ruleset which forces type hints and return types to be set.

This sniff can be problematic: If you implement interfaces or have your own interfaces which don't have
parameter type hints and return types set or if you are on legacy code, enforcing this sniff would lead to a BC break.
This sniff is also set to `phpcs-only`, so `phpcbf` _won't_ fix errors automatically. 

To use this ruleset, just use the use the corresponding rule name in your phpcs rule ref instead of the default one:

```xml
<?xml version="1.0"?>
<ruleset>
    <rule ref="EventjetStrict"/>

    <file>src</file>
    <file>tests</file>
</ruleset>
```

## Excluding sniffs:
### For certain files:
To exclude a sniff for a certain set of files, reference  the rule explicitly and add an exclude pattern:

```xml
<rule ref="SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint">
    <exclude-pattern>*Interface.php</exclude-pattern>
</rule>
```
#### Suppressing sniffs locally
To suppress a sniff directly in the code, use the `@phpcsSuppress` annotation:
```php
/**
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
 * @param int $bar
 */
public function foo($bar = 0): int
{
}
```

More info on this can be found [here](https://github.com/slevomat/coding-standard#suppressing-sniffs-locally).
### Exclude a whole sniff:
It is also possible to exclude a sniff completely:
```xml
<?xml version="1.0"?>
<ruleset>
    <rule ref="Eventjet">
        <exclude name="SlevomatCodingStandard.Classes.ClassConstantVisibility"/>
    </rule>

    <file>src</file>
    <file>tests</file>
</ruleset>
```
