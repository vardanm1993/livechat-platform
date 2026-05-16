# Livechat Platform

![CI](https://img.shields.io/github/actions/workflow/status/vardanm1993/livechat-platform/ci.yml?branch=develop&label=CI&logo=githubactions&logoColor=white&style=for-the-badge)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-ready-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-ready-DC382D?style=for-the-badge&logo=redis&logoColor=white)
![Docker](https://img.shields.io/badge/Laravel%20Sail-Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-ready-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![Pest](https://img.shields.io/badge/Tests-Pest-3EBC93?style=for-the-badge)
![Pint](https://img.shields.io/badge/Code%20Style-Pint-FF2D20?style=for-the-badge)
![PHPStan](https://img.shields.io/badge/Static%20Analysis-PHPStan%20%2F%20Larastan-4F5D95?style=for-the-badge)
![Rector](https://img.shields.io/badge/Refactoring-Rector-6F42C1?style=for-the-badge)

Laravel-based communication platform foundation with Dockerized local development, PostgreSQL, Redis, automated tests, static analysis, refactoring checks, and CI-backed quality gates.

## Overview

Livechat Platform is a Laravel application foundation for a trusted communication platform.

The repository currently contains the application base, development environment, database service setup, testing setup, CI workflow, documentation structure, and backend quality tooling required to continue development in a controlled and reviewable way.

## Current Status

The current codebase includes:

- Laravel 13 application foundation
- Laravel Sail / Docker local development environment
- PostgreSQL database service
- Redis service
- Mailpit local mail testing
- Pest testing foundation
- Vite frontend build foundation
- GitHub Actions CI
- Laravel Pint code style checks
- Larastan / PHPStan static analysis
- Rector dry-run refactoring checks
- Composer quality scripts
- Repository documentation baseline
- Security and architecture documentation
- Pull request workflow with required CI checks

## Technology Stack

Current stack:

- Laravel 13
- PHP 8.5
- PostgreSQL
- Redis
- Laravel Sail
- Docker Compose
- Mailpit
- Pest
- Laravel Pint
- Larastan / PHPStan
- Rector
- Vite
- GitHub Actions

## Requirements

Recommended local requirements:

- Git
- Docker
- Docker Compose
- PHP 8.5 compatible local environment
- Composer
- Node.js
- npm

The application runtime is designed to run through Laravel Sail.

## Installation

Clone the repository:

```bash
git clone git@github.com:vardanm1993/livechat-platform.git
cd livechat-platform
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm ci --ignore-scripts
```

Create the local environment file:

```bash
cp .env.example .env
```

Start the Docker/Sail environment:

```bash
./vendor/bin/sail up -d
```

Generate the application key:

```bash
./vendor/bin/sail artisan key:generate
```

Run database migrations:

```bash
./vendor/bin/sail artisan migrate
```

Build frontend assets:

```bash
npm run build
```

## Start the Application

Start the local environment:

```bash
./vendor/bin/sail up -d
```

Open the application:

```text
http://localhost
```

Stop the local environment:

```bash
./vendor/bin/sail down
```

## Verify the Setup

Run the backend quality gate:

```bash
./vendor/bin/sail composer quality
```

Run the frontend production build:

```bash
npm run build
```

The project is correctly set up when both commands pass.

## Optional Sail Alias

For local convenience, developers may define a shell alias:

```bash
alias sail='[ -f sail ] && sh sail || ./vendor/bin/sail'
```

After that, local commands can be shortened:

```bash
sail artisan test
sail composer quality
```

This README uses the full `./vendor/bin/sail` form so commands work for every developer without requiring shell customization.

## Useful Local Services

When Sail is running:

- Application: `http://localhost`
- Mailpit dashboard: `http://localhost:8025`
- PostgreSQL: forwarded to local port `5432`
- Redis: forwarded to local port `6379`

## Testing

Run backend tests:

```bash
./vendor/bin/sail composer test
```

Equivalent Artisan command:

```bash
./vendor/bin/sail artisan test
```

## Code Quality

Run the full backend quality gate:

```bash
./vendor/bin/sail composer quality
```

This runs:

- Laravel Pint style check
- Larastan / PHPStan static analysis
- Rector dry-run refactoring check
- Pest tests

Individual commands:

```bash
./vendor/bin/sail composer lint
./vendor/bin/sail composer lint:fix
./vendor/bin/sail composer analyse
./vendor/bin/sail composer refactor:dry
./vendor/bin/sail composer refactor
./vendor/bin/sail composer test
```

`composer refactor` is intended for local developer use only. CI uses Rector in dry-run mode.

## Continuous Integration

GitHub Actions runs automated checks for pull requests and pushes targeting `develop` and `main`.

Current CI checks include:

- Composer validation
- PHP dependency installation
- Laravel Pint code style checks
- Larastan / PHPStan static analysis
- Rector dry-run checks
- PostgreSQL-backed database migrations
- Pest backend tests
- npm clean install
- Vite production build

Required CI checks:

- `Backend Quality and Tests`
- `Frontend Build`

## Documentation

Project documentation:

- [Architecture Overview](docs/architecture/overview.md)
- [Database Blueprint](docs/database/database-blueprint.md)
- [Security Overview](docs/security/security-overview.md)
- [Repository Standards](docs/development/repository-standards.md)
- [Code Quality](docs/development/code-quality.md)
- [Architecture Decisions](docs/architecture/decisions)

## Security

Livechat Platform is designed with a security-first development approach.

Current security documentation covers the project security direction, reporting expectations, and baseline security considerations.

Security concerns should be reported privately according to the project security policy.

See:

- [Security Policy](SECURITY.md)
- [Security Overview](docs/security/security-overview.md)

## Branching and Pull Requests

This repository uses a pull request based workflow.

Recommended branch prefixes:

- `feat/`
- `fix/`
- `docs/`
- `test/`
- `refactor/`
- `ci/`
- `chore/`
- `security/`

Pull requests should include a clear summary, list of changes, verification steps, and relevant security or database impact notes.

The `develop` and `main` branches are intended to be protected by required CI checks.
