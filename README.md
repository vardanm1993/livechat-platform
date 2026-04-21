# livechat-platform

[![CI](https://github.com/vardanm1993/livechat-platform/actions/workflows/ci.yml/badge.svg?branch=develop)](https://github.com/vardanm1993/livechat-platform/actions/workflows/ci.yml)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&logoColor=white)](#tech-stack)
[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)](#tech-stack)
[![Vue](https://img.shields.io/badge/Vue-3-42b883?logo=vue.js&logoColor=white)](#tech-stack)
[![TypeScript](https://img.shields.io/badge/TypeScript-5-3178C6?logo=typescript&logoColor=white)](#tech-stack)
[![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?logo=docker&logoColor=white)](#tech-stack)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Modern live chat platform built with Laravel, Docker, and a scalable application architecture.

## Overview
`livechat-platform` is a modern chat application built on Laravel with a clean core architecture, strict engineering workflow, and a long-term modularization strategy.

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
- backend CI
- frontend CI when relevant
- documentation-first decisions for version-sensitive implementation

## Roadmap
Short-term priorities:
- CI expansion
- frontend foundation
- application architecture baseline

Long-term direction:
- stable module extraction into reusable packages where justified

## Security
Please do not report security issues publicly.

See [SECURITY.md](SECURITY.md).

## Contributing
See [CONTRIBUTING.md](CONTRIBUTING.md).

## License
This project is released under the [MIT License](LICENSE).
