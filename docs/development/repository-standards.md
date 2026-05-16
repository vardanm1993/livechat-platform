# Repository Standards

## Purpose

This document defines baseline repository standards for Livechat Platform.

These standards help keep the project consistent, reviewable, and maintainable as the application grows.

## Branch Naming

Recommended branch prefixes:

- feat/
- fix/
- docs/
- test/
- refactor/
- ci/
- chore/
- security/

Branch names should be lowercase and use hyphen-separated words.

Examples:

- feat/authentication
- fix/session-expiration
- docs/security-overview
- ci/backend-checks
- chore/repository-foundation

## Commit Messages

Commit messages should be short, clear, and action-oriented.

Recommended format:

type: short description

Examples:

- docs: update security overview
- chore: add repository standards
- ci: add backend quality checks
- feat: add profile settings
- fix: prevent duplicate workspace members

## Pull Requests

Pull requests should include:

- summary
- list of changes
- verification steps
- security impact when relevant
- database impact when relevant
- screenshots when UI changes
- notes about tradeoffs or follow-up work

## Files and Formatting

The repository uses:

- .editorconfig for editor consistency
- .gitattributes for line endings and binary file handling
- .gitignore for local, dependency, build, cache, and environment files

## Documentation

Architecture, database, security, and workflow decisions should be documented when they affect long-term maintenance.

Documentation should be written in a professional product/project style.

## Main Promotion Rule

Feature, fix, documentation, test, refactor, CI, chore, and security branches must target `develop` first.

The `main` branch receives only stable promotion pull requests from:

- `develop`
- `chore/promote-*`

Allowed examples:

```text
feat/authentication-foundation -> develop
fix/session-expiration -> develop
docs/security-overview -> develop
ci/backend-checks -> develop
develop -> main
chore/promote-develop-to-main -> main
```

Not allowed examples:

```text
feat/authentication-foundation -> main
fix/session-expiration -> main
docs/security-overview -> main
ci/backend-checks -> main
```

This keeps `develop` as the integration branch and `main` as the stable public branch.
