# Architecture Overview

## System Direction

Livechat Platform is a trusted realtime communication platform built around a central Laravel application.

The platform is designed to support web users first, with future API and mobile clients.

## High-Level Components

- Laravel application server
- Inertia.js web bridge
- Vue frontend
- PostgreSQL relational database
- Redis for cache, queues, sessions, and realtime support
- Laravel Reverb for WebSocket communication
- Queue workers for background processing
- File storage for attachments and media
- Notification channels
- Billing/subscription integration
- Future API and mobile clients

## Web Architecture

The web application is planned around Laravel, Inertia.js, Vue, and TypeScript.

Laravel owns routing, authorization, validation, business logic, events, queues, and persistence.

Vue owns interactive UI components and client-side experience.

## Realtime Architecture

Realtime features are planned around events, broadcasting, Laravel Reverb, Laravel Echo, Redis, and authorization rules.

Realtime areas include:

- message delivery
- presence
- read receipts
- typing indicators
- notifications
- call signaling events

## Mobile Direction

Mobile support may be added later through a dedicated API layer.

The mobile direction may include NativePHP or another app-store and Android-store path.

## Package Direction

Some parts of the platform may later be extracted into reusable packages when they become stable and generic enough.
