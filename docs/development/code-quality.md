# Code Quality

## Purpose

Livechat Platform uses automated quality tools to keep the codebase consistent, reviewable, and safer to change.

## PHP Code Style

Laravel Pint is used for PHP code style checks.

Commands:

- composer lint
- composer lint:fix

composer lint checks formatting without changing files.

composer lint:fix applies formatting fixes locally.

## Static Analysis

Larastan and PHPStan are used for static analysis of Laravel and PHP code.

Command:

- composer analyse

Static analysis helps detect type issues, invalid method calls, and framework-specific mistakes before runtime.

## Automated Refactoring

Rector is used for safe refactoring and upgrade readiness.

Commands:

- composer refactor:dry
- composer refactor

composer refactor:dry reports proposed changes without modifying files.

composer refactor applies changes locally and should be followed by tests and review.

## Tests

Pest is used for automated tests.

Command:

- composer test

## Full Quality Check

Command:

- composer quality

This command runs code style checks, static analysis, Rector dry-run, and tests.

## CI

GitHub Actions runs backend quality checks on pull requests and protected branches.
