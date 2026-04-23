# Application Architecture Baseline

## Status
Accepted

## Context
The project already has:
- repository foundation
- Laravel application bootstrap
- CI baseline
- frontend foundation with Inertia, Vue 3, and TypeScript

Before implementing larger product features, the application needs a scalable architecture baseline that keeps domain logic organized and reduces structural drift over time.

## Decision
The project adopts a hybrid feature-first Laravel structure.

The backend will use domain-oriented grouping without introducing unnecessary complexity too early.

### Backend baseline
```text
app/
  Domains/
    Auth/
    Profile/
    Chat/
    Presence/
    Billing/
    Shared/
  Data/
  Http/
    Controllers/
    Middleware/
    Requests/
    Resources/
  Models/
  Policies/
  Providers/
  Support/
```

### Frontend baseline
```text
resources/js/
  Components/
  Composables/
  Layouts/
  Pages/
    Auth/
    Profile/
    Chat/
    Billing/
  Types/
  Utils/
  app.ts
  env.d.ts
```

## Conventions

### Domains
`app/Domains/*` contains feature-specific application logic.

As domains grow, they may introduce internal folders such as:
- `Actions`
- `Data`
- `Events`
- `Policies`
- `Queries`
- `Services`

These folders should be added when they become necessary, not pre-created everywhere without use.

### Http layer
`app/Http/*` is reserved for transport concerns:
- controllers
- requests
- middleware
- resources

Business logic should not accumulate in controllers.

### Models
`app/Models/*` contains Eloquent models.

### Policies
`app/Policies/*` contains authorization policies.

### Data
`app/Data/*` is reserved for shared application data objects that are not owned by a single domain.

### Support
`app/Support/*` contains cross-cutting support code, framework glue, shared utilities, and base abstractions.

### Frontend structure
- `Pages/*` contains route-level pages
- `Layouts/*` contains reusable layout shells
- `Components/*` contains reusable UI building blocks
- `Composables/*` contains reusable Vue composition logic
- `Types/*` contains shared frontend type definitions
- `Utils/*` contains frontend utility helpers

## Consequences

### Positive
- clearer feature boundaries
- better long-term scalability
- easier future extraction into reusable modules or packages
- less risk of turning the application into a large unstructured Laravel app folder

### Trade-offs
- requires discipline when adding new code
- introduces a small amount of architectural ceremony early
- conventions must be maintained consistently during future phases

## Follow-up
Future feature work should follow this structure, starting with:
- authentication foundation
- profile foundation
- chat domain foundation
