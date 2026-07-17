# Changelog


## [1.0.0] - 2026-07-17

### Added

- Optional TTL argument for `Service::generate()`
- `Service::getTTL()` for resolving the effective token lifetime
- Default TTL configuration via `ELIB_JWT_TTL` or `JWT_TTL`

### Changed

- Preserve the existing one-hour token lifetime when no TTL is configured
- Declare the existing `mikejw/elib-base` dependency (`^4.2.7`)
