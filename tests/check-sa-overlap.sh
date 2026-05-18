#!/usr/bin/env bash
# CI gate: assert that PHPStan ∩ Psalm (over fixtures) equals exactly the set
# of fixtures registered below as "dropped-rule canaries".
#
# Each entry in EXPECTED_REL is a fixture demonstrating a pattern whose CS
# rule we dropped because lint already catches it. Two invariants:
#   1. Each canary MUST be flagged by both PHPStan and Psalm. Missing entries
#      mean SA configs drifted, a tool crashed, or the JSON schema changed —
#      fail loudly rather than silently letting fixtures through.
#   2. NO other fixture may appear in the intersection. A new fixture flagged
#      by both SAs is "lint territory" — drop or rewrite it instead of adding
#      a CS rule.
#
# Each canary also lives in tests/fixtures/valid/ so RulesTest::valid asserts
# the CS side: phpcs and php-cs-fixer must NOT flag it (= the CS rule really
# is disabled).
set -uo pipefail

if ! command -v jq >/dev/null 2>&1; then
    echo "ERROR: jq is required but was not found in PATH." >&2
    echo "Install jq (e.g., 'apt-get install jq' or 'brew install jq')." >&2
    exit 1
fi

cd "$(dirname "$0")/.."

EXPECTED_REL=(
    tests/fixtures/valid/inline-doc-comment.php
    tests/fixtures/valid/loose-comparison.php
    tests/fixtures/valid/ThisInStatic.php
)

for f in "${EXPECTED_REL[@]}"; do
    if [ ! -f "$f" ]; then
        echo "ERROR: registered canary fixture does not exist: $f" >&2
        echo "Update EXPECTED_REL in $(basename "$0") if the fixture was renamed or removed." >&2
        exit 1
    fi
done

expected="$(for f in "${EXPECTED_REL[@]}"; do realpath "$f"; done | sort -u)"

phpstan_stderr="$(mktemp "${TMPDIR:-/tmp}/check-sa-overlap.phpstan.XXXXXX")"
psalm_stderr="$(mktemp "${TMPDIR:-/tmp}/check-sa-overlap.psalm.XXXXXX")"
trap 'rm -f "$phpstan_stderr" "$psalm_stderr"' EXIT

phpstan_json="$(vendor/bin/phpstan analyse \
    --configuration tests/phpstan.neon \
    --error-format=json \
    --no-progress 2>"$phpstan_stderr" || true)"

psalm_json="$(vendor/bin/psalm \
    --config tests/psalm.xml \
    --output-format=json \
    --no-progress 2>"$psalm_stderr" || true)"

phpstan_files="$(printf '%s' "$phpstan_json" | jq -r '.files? | keys[]?' 2>>"$phpstan_stderr" | sort -u)"
psalm_files="$(printf '%s' "$psalm_json" | jq -r '.[]?.file_path // empty' 2>>"$psalm_stderr" | sort -u)"

intersection="$(comm -12 <(printf '%s\n' "$phpstan_files") <(printf '%s\n' "$psalm_files") | sed '/^$/d')"

missing="$(comm -23 <(printf '%s\n' "$expected") <(printf '%s\n' "$intersection"))"
extra="$(comm -13 <(printf '%s\n' "$expected") <(printf '%s\n' "$intersection"))"

if [ -n "$missing" ]; then
    echo "ERROR: expected canary fixtures missing from PHPStan ∩ Psalm:"
    printf '%s\n' "$missing" | sed 's/^/  - /'
    echo
    echo "PHPStan flagged:"
    printf '%s\n' "${phpstan_files:-(nothing)}"
    echo
    echo "Psalm flagged:"
    printf '%s\n' "${psalm_files:-(nothing)}"
    echo
    echo "PHPStan stderr:"
    cat "$phpstan_stderr" 2>/dev/null || echo "(empty)"
    echo
    echo "Psalm stderr:"
    cat "$psalm_stderr" 2>/dev/null || echo "(empty)"
    echo
    echo "SA configs may have drifted too lax, a tool may have crashed, or the JSON schema changed."
    exit 1
fi

if [ -n "$extra" ]; then
    echo "ERROR: the following fixtures are flagged by BOTH PHPStan and Psalm:"
    printf '%s\n' "$extra" | sed 's/^/  - /'
    echo
    echo "Both major static analyzers already catch these patterns. A CS rule for"
    echo "them duplicates lint work users already have. Drop the fixture (and any"
    echo "corresponding CS rule), or rewrite it so only one SA catches it."
    echo
    echo "If this is a deliberate rule drop, also register the fixture in"
    echo "EXPECTED_REL in this script."
    exit 1
fi

echo "OK: PHPStan ∩ Psalm matches the registered canary set exactly."
