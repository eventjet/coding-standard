#!/usr/bin/env bash
# CI gate: fail if any fixture is flagged by BOTH PHPStan and Psalm.
#
# Fixtures flagged by both major static analyzers are "lint territory" —
# patterns the analyzers already catch — so we must not add a CS rule for
# that pattern. This script implements that AND policy at the file level by
# intersecting the two tools' JSON output.
#
# The canary fixture (tests/sa-canary/loose-comparison.php) MUST always be
# in the intersection. If it isn't, the SA configs drifted, a tool crashed,
# or the JSON schema changed; fail loudly rather than silently passing every
# fixture.
set -uo pipefail

cd "$(dirname "$0")/.."

phpstan_json="$(vendor/bin/phpstan analyse \
    --configuration tests/phpstan.neon \
    --error-format=json \
    --no-progress 2>/dev/null || true)"

psalm_json="$(vendor/bin/psalm \
    --config tests/psalm.xml \
    --output-format=json \
    --no-progress 2>/dev/null || true)"

phpstan_files="$(printf '%s' "$phpstan_json" | jq -r '.files? | keys[]?' | sort -u)"
psalm_files="$(printf '%s' "$psalm_json" | jq -r '.[]?.file_path // empty' | sort -u)"

intersection="$(comm -12 <(printf '%s\n' "$phpstan_files") <(printf '%s\n' "$psalm_files") | sed '/^$/d')"

canary="$(realpath tests/sa-canary/loose-comparison.php)"

if ! printf '%s\n' "$intersection" | grep -qxF "$canary"; then
    echo "ERROR: canary fixture not in PHPStan ∩ Psalm."
    echo "Expected: $canary"
    echo
    echo "PHPStan flagged:"
    printf '%s\n' "${phpstan_files:-(nothing)}"
    echo
    echo "Psalm flagged:"
    printf '%s\n' "${psalm_files:-(nothing)}"
    echo
    echo "SA configs may have drifted too lax, a tool may have crashed, or the JSON schema changed."
    exit 1
fi

other="$(printf '%s\n' "$intersection" | grep -vxF "$canary" || true)"
if [ -n "$other" ]; then
    echo "ERROR: the following fixtures are flagged by BOTH PHPStan and Psalm:"
    printf '%s\n' "$other" | sed 's/^/  - /'
    echo
    echo "Both major static analyzers already catch these patterns. A CS rule for"
    echo "them duplicates lint work users already have. Drop the fixture (and any"
    echo "corresponding CS rule), or rewrite it so only one SA catches it."
    exit 1
fi

echo "OK: canary fired; no other fixtures flagged by both PHPStan and Psalm."
