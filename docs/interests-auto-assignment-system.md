# Lead Auto Assignment System (Interests)

## Overview

This document describes the automatic lead (interests) assignment system that distributes leads fairly across Sales admins, while still allowing manual assignment from the CRM.

The system is **event-driven** (triggered immediately on interest creation) and currently runs **without any cron jobs**.

---

## Database Structure

A new column was added to the `interests` table:

- `assigned_at` (timestamp, nullable)  
  - Purpose: track when an interest was assigned to a sales admin, and enable future analytics, reporting, or redistribution logic.

Main related tables:

- `admins`
  - `type` enum: `admin`, `sales`
  - `is_available` boolean: whether this sales admin can receive new leads
  - `status` enum `[1, 0]`: active vs banned/deactivated

- `interests`
  - `assigned_to` (nullable foreign key to `admins`)
  - `status` (string): `new`, `assigned`, `contacted`, `closed`, etc.
  - `assigned_at` (timestamp, nullable)

---

## Assignment Rules

When a new interest is created, the system tries to auto-assign it to a Sales admin according to the following rules:

1. Eligible Sales admins:
   - `type = 'sales'`
   - `is_available = 1`
   - `status = 1` (active account, not banned)

2. Fair distribution:
   - The system should assign the interest to the sales admin with the **lowest current load**.
   - Load can be defined as:
     - The total number of active/open interests assigned to this admin, and/or
     - A time-based window (e.g. today/this week) if needed in future versions.

3. Tie-breaking (when multiple admins have the same load):
   - Possible strategies (implementation choice):
     - The oldest joining date.
     - The admin with the earliest last `assigned_at`.
     - A simple deterministic ordering (e.g. by `id`).

4. No available sales admins:
   - If no eligible sales admin is found:
     - `assigned_to` remains `null`.
     - `status` stays `new`.
   - This allows manual assignment later from the CRM.

After a successful automatic assignment, we typically:
- Set `assigned_to` to the chosen admin.
- Set `assigned_at` to the current timestamp.
- Optionally update `status` from `new` to `assigned`.

---

## Event-Driven Architecture (No Cron)

The system does **not** rely on cron jobs for lead distribution in the current version.

Instead, it uses a centralized event-driven approach:

- Whenever an `Interest` record is created anywhere in the codebase, the assignment logic is triggered automatically.
- This avoids having to manually call assignment methods in every controller or form that creates interests.

---

## Centralized Logic via Model Observer

To keep the logic in one place and ensure it works from all entry points (web forms, API, imports, etc.), a model observer is used for the `Interest` model.

Conceptually:

- An `InterestObserver` listens for the `created` event of the `Interest` model.
- On `created(Interest $interest)`:
  - The observer runs the selection logic for the best available Sales admin.
  - If an admin is found, it updates:
    - `assigned_to`
    - `assigned_at`
    - (Optionally) `status` → `assigned`

Benefits:

- **Centralized**: one place to maintain and update assignment rules.
- **Consistent**: any `Interest::create()` call triggers the same logic.
- **Extensible**: easy to add extra conditions later (by type, project, region, etc.).

This observer-based approach means:

- Interests created from:
  - Multiple frontend pages.
  - Different controllers.
  - API endpoints.
  - Import scripts or console commands.
- All go through the same automatic assignment pipeline without duplicating logic.

---

## Future Extensions

Potential future improvements:

- Admin settings to:
  - Enable/disable automatic assignment globally.
  - Set a maximum number of active leads per sales admin.
  - Filter which interest types are auto-assigned (e.g. only `type = 'property'`).

- Cron-based features (if needed later):
  - Rebalancing old uncontacted leads.
  - Reassigning leads from unavailable or inactive sales admins.
  - Periodic cleanup, analytics, or notifications.

For now, the system is intentionally kept **simple and synchronous**:  
**real-time assignment on interest creation, with no scheduled tasks.**
