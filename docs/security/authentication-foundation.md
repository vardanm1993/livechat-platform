# Authentication Foundation

The authentication foundation defines how Livechat Platform will identify users, protect sessions, and prepare security-sensitive account workflows before implementation begins.

This document is intentionally design-focused. It does not describe completed runtime behavior until the related implementation is merged.

## Goals

- Provide a secure first-party authentication foundation.
- Avoid starter-kit lock-in while staying aligned with Laravel authentication primitives.
- Support browser-based login for the initial web application.
- Prepare the platform for future API and mobile authentication without overbuilding the first version.
- Keep account, session, and security-event behavior auditable.
- Establish clear test expectations before implementation.

## Non-Goals

- Do not implement OAuth or social login in the first authentication foundation.
- Do not implement passkeys in the first authentication foundation.
- Do not implement multi-factor authentication in the first authentication foundation.
- Do not introduce paid subscription or organization-level access rules in this step.
- Do not build mobile-specific authentication tokens until the mobile/API boundary is designed.

## Authentication Approach

Livechat Platform will use a first-party Laravel authentication flow rather than an application starter kit.

The initial web authentication flow should support:

- user registration
- user login
- user logout
- password hashing
- email verification planning
- password reset planning
- authenticated session protection
- rate limiting for sensitive endpoints
- security-event recording for important account actions

The implementation should use Laravel's built-in authentication, hashing, validation, middleware, session, and notification capabilities where appropriate.

## User Identity Model

The initial user identity should be based on the existing `users` table and should remain conservative until product requirements stabilize.

Expected identity fields:

| Field | Purpose |
| --- | --- |
| `id` | Primary user identifier. |
| `name` | Human-readable display name for the first web version. |
| `email` | Primary login identifier. |
| `email_verified_at` | Email verification state. |
| `password` | Hashed password only. |
| `remember_token` | Laravel remember-me token support if enabled. |
| `created_at` | Account creation timestamp. |
| `updated_at` | Account update timestamp. |

Phone number support is planned for later, but should not be added until the product decides how phone verification, country codes, uniqueness, privacy, and account recovery will work.

## Password Handling

Passwords must never be stored or logged in plain text.

Expected password rules:

- Store only framework-generated password hashes.
- Use Laravel hashing facilities.
- Validate minimum password strength during registration and password reset.
- Never expose password hashes in API responses, logs, events, broadcasts, or debug output.
- Allow future password rehashing behavior if hashing parameters change.
- Treat password updates as security-sensitive actions.

## Session Strategy

The initial web application should use Laravel's browser session authentication.

Expected session behavior:

- Regenerate the session after login.
- Invalidate the session on logout.
- Regenerate the CSRF token on logout.
- Protect authenticated routes with authentication middleware.
- Apply fresh-auth requirements later for sensitive actions such as password change, email change, MFA setup, and account deletion.
- Keep mobile/API token authentication as a separate future design.

## Email Verification

Email verification should be planned as part of the foundation even if the first implementation keeps access rules minimal.

Expected behavior:

- Store email verification state using `email_verified_at`.
- Send verification notifications when verification is enabled.
- Allow verified-only restrictions for future sensitive features.
- Record security events for email verification and email change workflows when implemented.

## Password Reset

Password reset should use Laravel-compatible reset-token behavior and notifications.

Expected behavior:

- Generate reset links through framework-supported mechanisms.
- Rate limit reset requests.
- Avoid revealing whether an email exists.
- Invalidate or rotate sensitive session state after password reset where appropriate.
- Record a security event after successful password reset.

## Security Events

Authentication-related actions should be auditable.

Initial security-event candidates:

| Event | Reason |
| --- | --- |
| `user.registered` | Account creation audit trail. |
| `auth.login.succeeded` | Successful login visibility. |
| `auth.login.failed` | Brute-force and account-risk visibility. |
| `auth.logout` | Session lifecycle visibility. |
| `auth.email.verified` | Trust-state change. |
| `auth.password.reset_requested` | Account recovery visibility. |
| `auth.password.reset_completed` | Credential change audit trail. |
| `auth.password.changed` | Sensitive account change audit trail. |

Security events should avoid storing secrets, raw passwords, reset tokens, full user agents when unnecessary, or excessive personal data.

## Rate Limiting

Authentication endpoints should be rate limited.

Initial rate-limit targets:

- login attempts
- registration attempts
- email verification notifications
- password reset requests
- password update attempts

Rate limits should be strict enough to reduce abuse but not so aggressive that normal users are blocked during common mistakes.

## Authorization Boundary

Authentication only proves identity. Authorization must remain separate.

The authentication foundation should not assume that every authenticated user can access every future feature.

Future authorization layers may include:

- account status
- verified email state
- roles and permissions
- room membership
- organization membership
- subscription capability
- moderation or trust status

## Testing Expectations

Authentication implementation PRs should include feature tests for successful and failed behavior.

Expected test areas:

- user can register with valid data
- user cannot register with invalid data
- email must be unique
- password is hashed
- user can log in with valid credentials
- user cannot log in with invalid credentials
- login regenerates session
- user can log out
- protected routes require authentication
- password reset request is rate limited
- security events are recorded for important authentication actions when implemented

Tests should avoid only covering happy paths. Failure behavior is part of the security boundary.

## Documentation Rules

Public documentation must describe only implemented behavior as complete.

Before implementation is merged:

- Use "planned", "expected", or "will" language.
- Do not claim authentication is complete.
- Do not add badges for features that are not enforced.
- Do not expose internal phase notes or learning-process notes.

After implementation is merged:

- Update public documentation only for behavior that is actually shipped.
- Keep setup instructions accurate.
- Keep security claims narrow and verifiable.

## Implementation Sequence

Recommended implementation order:

1. Authentication route and controller design.
2. Registration flow.
3. Login and logout flow.
4. Password hashing and validation tests.
5. Protected route tests.
6. Email verification support.
7. Password reset support.
8. Security-event model and recording.
9. Rate limiting hardening.
10. Fresh-auth planning for sensitive actions.

Each implementation PR should stay small enough to review safely.
