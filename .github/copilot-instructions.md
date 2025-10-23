# AI Coding Guidelines - Laravel Education System

This Laravel 10 application is a comprehensive education management system with multi-tenant architecture, real-time chat, payment integration, and multi-language support.

## Architecture Overview

**Multi-User Authentication System:**
- 4 distinct user types: `User` (admin), `Teacher`, `StudentAcount`, `MyParent`
- Each has separate guards in `config/auth.php`: `web`, `teacher`, `student`, `parent`
- Models extend `Authenticatable` with different table structures and relationships

**Key Models & Relationships:**
- `Schools` → `Acadimy` → `User`/`Teacher`/`Student` (hierarchical structure)
- `Student` → `StudentAcount` (separate auth model via `hasOne` relationship)
- `Grade` → `Classes` → `Section` (academic organization)
- Real-time `Conversation` → `Message` system with LiveWire

**Critical Files:**
- `app/Helpers/settings_helper.php` - Global helper functions (auto-loaded)
- `routes/{web,teacher,school,acadimic}.php` - Role-based route organization
- `app/Livewire/Chat/` - Real-time messaging components

## Development Patterns

**Authentication Context:**
```php
// Always check current guard context
auth('teacher')->user()  // For teacher routes
Auth::guard('student')   // For student routes
```

**Multi-Language Support:**
- Using `mcamara/laravel-localization` with French as default (`'locale' => 'fr'`)
- Route groups wrap localized URLs: `LaravelLocalization::setLocale()`

**Payment Integration:**
- Chargily Pay integration in `ChargilyPayController`
- Custom payment models: `ChargilyPayment`, `Fee`, `FeePaid`

**Database Conventions:**
- Uses soft deletes extensively (`SoftDeletes` trait)
- Custom pivot tables: `FeesClass`, `SubjectTeacher`
- QR code generation for students (`'qr_code'` field)

## Critical Workflows

**Password Hashing Issue (Deployment):**
When deploying and seeing "This password does not use the Bcrypt algorithm":
1. Check `config/hashing.php` driver setting
2. Verify existing passwords in database are bcrypt-compatible
3. Re-hash existing passwords if migrating from different algorithm

**Development Setup:**
```bash
# After clone/deployment
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

**LiveWire Components:**
- Chat system uses real-time updates
- Counter component example in `app/Livewire/Counter.php`
- Always use `wire:` directives for reactive components

## Integration Points

**External Services:**
- PDF generation: `barryvdh/laravel-dompdf` + `mpdf/mpdf`
- Barcode: `milon/barcode` for student IDs
- Real-time: Pusher integration for chat
- Permissions: `spatie/laravel-permission` for role management

**File Structure Conventions:**
- Controllers organized by role: `Admin/`, `Schools/`, `Teachers/`
- Route files mirror controller organization
- Helper functions globally available via composer autoload

**Database Relationships:**
- Always use `with()` for eager loading in model relationships
- Scope methods prefixed with `scope` (e.g., `scopeInStudent`)
- Foreign key naming: `model_id` convention

## Testing & Debugging

**Environment:**
- Uses Laragon for local development (Windows)
- Debug mode controlled via `APP_DEBUG` in `.env`
- Timezone: UTC (change if needed for specific regions)

When working with this codebase:
1. Always consider the multi-tenant nature (school/academy context)
2. Check authentication guard before accessing user data
3. Use helper functions from `settings_helper.php` for common operations
4. Follow the established naming conventions for models and relationships
