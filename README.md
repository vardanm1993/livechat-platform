# livechat-platform

[![CI](https://github.com/vardanm1993/livechat-platform/actions/workflows/ci.yml/badge.svg?branch=develop)](https://github.com/vardanm1993/livechat-platform/actions/workflows/ci.yml)
[![Branch Name Check](https://github.com/vardanm1993/livechat-platform/actions/workflows/branch-name-check.yml/badge.svg?branch=develop)](https://github.com/vardanm1993/livechat-platform/actions/workflows/branch-name-check.yml)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&logoColor=white)](#tech-stack)
[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)](#tech-stack)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/status-active%20bootstrap-blue)](#status)

Professional live chat platform with a modular, scalable architecture.

## Overview
`livechat-platform` is being built as a modern Laravel-based communication product with a clean application core, strict repository discipline, and a future-ready package extraction strategy.

## Status
The project is currently in the bootstrap phase.

## Tech stack
- PHP 8.5
- Laravel 13
- PostgreSQL
- Redis
- Docker / Sail
- Inertia.js
- Vue 3
- TypeScript
- Tailwind CSS
- Vite

## Local development

### Start services

```bash
sail up -d
```

### Stop services

```bash
sail down
```

### Application info

```bash
sail artisan about
```

### Run migrations

```bash
sail artisan migrate
```

## Git workflow
- `main` is the stable branch
- `develop` is the integration branch
- implementation work happens in dedicated working branches
- pull requests are required for protected branches

### Allowed branch prefixes
- `feat/*`
- `fix/*`
- `refactor/*`
- `docs/*`
- `chore/*`
- `test/*`
- `ci/*`
- `release/*`
- `hotfix/*`

## Quality standards
- GitHub Actions
- branch name validation
- backend CI expansion
- frontend CI checks when relevant
- documentation-first decisions for version-sensitive implementation

## Roadmap

### Short-term priorities
- repository normalization
- CI expansion
- frontend foundation
- application architecture baseline

### Long-term direction
- stable module extraction into reusable packages where justified

## Security
Please do not report security issues publicly.

See [SECURITY.md](SECURITY.md).

## Contributing
See [CONTRIBUTING.md](CONTRIBUTING.md).

## License
This project is released under the [MIT License](LICENSE).
