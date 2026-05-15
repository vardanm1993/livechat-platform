# ADR 0002: Application Architecture

## Status

Accepted

## Context

The platform needs a maintainable architecture that can support web UI, realtime communication, future mobile clients, billing, security, administration, and production operations.

## Decision

Laravel will be the central application server and source of truth.

The web application will use Laravel, Inertia.js, Vue, and TypeScript.

PostgreSQL will be used as the primary relational database.

Redis will support cache, queues, sessions, and realtime infrastructure.

Laravel Reverb and Laravel Echo will be used for WebSocket-based realtime features.

A dedicated API layer may be introduced later for mobile applications.

## Consequences

Positive:

- Strong Laravel ecosystem support
- Clear backend source of truth
- Clean web-first path
- Future API/mobile path remains possible
- Good fit for events, queues, broadcasting, billing, and admin tooling

Tradeoffs:

- Realtime and mobile architecture must be introduced carefully
- API contracts should be versioned when public clients appear
- Inertia should not be treated as the mobile routing solution
