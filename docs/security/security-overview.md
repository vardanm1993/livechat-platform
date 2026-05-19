# Security Overview

## Security Principles

Livechat Platform is designed as a trusted communication system.

The project follows defensive security principles and must avoid offensive or abusive functionality.

Security work in this repository should focus on protecting users, accounts, conversations, sessions, files, and platform integrity.

## Core Security Areas

- password hashing
- secure session handling
- email verification
- password reset flow
- rate limiting
- CSRF protection
- XSS prevention
- authorization policies
- sensitive action confirmation
- active session management
- device awareness
- audit logs
- security events
- file upload validation
- API throttling
- billing webhook verification

## Authentication Foundation

The authentication foundation design is documented in [Authentication Foundation](authentication-foundation.md).

It defines the planned approach for first-party Laravel authentication, session protection, password handling, email verification, password reset, rate limiting, authentication-related security events, authorization boundaries, and testing expectations before implementation begins.

This design document does not claim that authentication runtime behavior is already implemented.

## Communication Security

The platform may introduce message and media encryption through a separate architecture decision.

Encryption must be designed carefully to balance usability, search, moderation, recovery, and privacy requirements.

Any future encryption design must clearly define what is encrypted, where keys are stored, what metadata remains visible, how abuse reporting works, and how account recovery affects encrypted data.

## Incident Response Direction

Security-related events should be recorded and reviewable.

When suspicious activity is detected, the platform should support evidence collection, session revocation, and responsible reporting.

The platform must never encourage retaliation, unauthorized access, hacking back, or abusive investigation behavior.
