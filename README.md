# Eventjet Coding Standard

## Basic Usage:
Add the following `phpcs.xml` file to your project's root:
```xml
<?xml version="1.0"?>
<ruleset name="Eventjet Coding Standard">
    <rule ref="./vendor/eventjet/coding-standard/ruleset.xml"/>

    <file>src</file>
    <file>tests</file>
</ruleset>
```

## More strict rules:
There is also a `ruleset_strict.xml` which adds the
[SlevomatCodingStandard.TypeHints.TypeHintDeclaration](https://github.com/slevomat/coding-standard#slevomatcodingstandardtypehintstypehintdeclaration-) sniff.

This sniff can be problematic: If you implement interfaces or have your own interfaces which don't have
parameter type hints and return types set, enforcing this sniff would lead to a BC break.
This sniff is also set to `phpcs-only`, so `phpcbf` _won't_ fix errors automatically. 

To use this ruleset, just use the use the corresponding file in your phpcs rule ref:

```xml
<rule ref="./vendor/eventjet/coding-standard/ruleset_strict.xml"/>
```

## Excluding sniffs:
### For certain files:
To exclude a sniff for a certain set of files, reference  the rule explicitly and add an exclude pattern:

```xml
<rule ref="SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint">
    <exclude-pattern>*Interface.php</exclude-pattern>
</rule>
```
### Exclude a whole sniff:
It is also possible to exclude a sniff completely:
```xml
<?xml version="1.0"?>
<ruleset name="Eventjet Coding Standard">
    <rule ref="./vendor/eventjet/coding-standard/ruleset.xml">
        <exclude name="SlevomatCodingStandard.Classes.ClassConstantVisibility"/>
    </rule>

    <file>src</file>
    <file>tests</file>
</ruleset>
```
