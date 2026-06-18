# Task Backlog

## Milestones
- [x] Phase 0: Initial repository and prototype structure
- [x] Phase 1: Core role pages and demo database
- [ ] Phase 2: Stabilization, validation, and security hardening
- [ ] Phase 3: Payment integration completion
- [ ] Phase 4: QA, documentation, and final project presentation

## Backlog / To-Do
- [ ] Audit all SQL queries and convert unsafe input handling to prepared statements.
- [ ] Review all private pages for strict role/session guards.
- [ ] Normalize duplicate assets between `src/assets` and `src/frontend/assets` if safe.
- [ ] Move database and Midtrans secret values to environment-based configuration.
- [ ] Complete Midtrans sandbox flow with robust notification verification.
- [ ] Add consistent flash message handling for form success/error states.
- [ ] Add manual QA checklist for admin, tutor, learner, and public flows.
- [ ] Add lightweight automated smoke tests if project structure allows.
- [ ] Improve error handling for booking conflicts and duplicate schedules.
- [ ] Verify registration flow creates matching records in `users`, `tutor`, or `mahasiswa`.

## Done
- [x] Setup repository awal.
- [x] Struktur frontend/backend PHP native tersedia.
- [x] Database `ruangajar.sql` tersedia dengan schema dan dummy data.
- [x] Role dasar tersedia: admin, tutor, learner, public visitor.
- [x] Dokumentasi context awal dibuat di folder `context/`.
