# Database Blueprint

## Purpose

This document tracks the planned database direction for the platform.

The actual database structure must follow real migrations, models, indexes, relations, and tests.

## Design Rule

Planned tables are not final until implemented, reviewed, and tested.

## Identity and Account

Planned areas:

- users
- profiles
- user_phone_numbers
- sessions
- devices
- two_factor_settings
- personal_access_tokens

Phone numbers should be modeled separately instead of being stored as a simple `users.phone` column by default.

## Spaces, Rooms, and Membership

Planned areas:

- spaces or workspaces
- rooms
- memberships
- invitations
- roles
- permissions

These tables define how users organize communication and access control.

## Messaging

Planned areas:

- conversations
- conversation_participants
- messages
- message_reads
- message_reactions
- message_edits
- attachments or media files
- presence sessions

Emoji reactions should be represented through message reaction data.

## Calls

Planned areas:

- calls
- call_participants
- call_events

Audio and video media transport requires a separate architecture decision.

## Security and Audit

Planned areas:

- security_events
- audit_logs
- login_attempts
- session_revocations

## Billing

Planned areas:

- plans
- subscriptions
- invoices
- usage_records
- feature_entitlements

Billing is expected to be connected to organization/team-level usage rather than individual messages.

## Multilingual and AI

Planned areas:

- user preferences
- workspace or space settings
- message translations
- conversation summaries
- AI requests
- AI results

AI-assisted features must be privacy-aware, permission-controlled, auditable, and optional.
