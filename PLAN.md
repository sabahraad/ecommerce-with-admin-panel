# Role & Permission Implementation Plan

## Goal
Add a full role-and-permission system to the ecommerce app using **Spatie Laravel Permission**.

## What Will Change
- Replace the single `role` column on `users` with Spatie's role/permission tables.
- Create roles: `admin`, `manager`, `support`, `customer`.
- Create permissions: `view admin dashboard`, `manage products`, `manage categories`, `manage orders`, `manage users`, `view orders`, `update order status`.
- Protect admin routes with Spatie middleware.
- Update navigation and dashboard to show/hide admin links based on permissions.
- Seed default accounts:
  - `admin@example.com` / `password` → `admin`
  - `customer@example.com` / `password` → `customer`

## Implementation Steps

1. **Install Spatie**
   - `composer require spatie/laravel-permission`
   - Publish config and migrations
   - Run migrations

2. **Update `User` model**
   - Add `HasRoles` trait
   - Remove `role` from fillable
   - Keep `isAdmin()` / `isCustomer()` as wrappers

3. **Drop old `role` column**
   - Create migration to remove `role` from `users`

4. **Create `RolePermissionSeeder`**
   - Define roles and permissions
   - Assign permissions to roles

5. **Update `DatabaseSeeder`**
   - Call `RolePermissionSeeder`
   - Assign `admin` and `customer` roles to default users

6. **Register Spatie middleware aliases** in `bootstrap/app.php`
   - `role`, `permission`, `role_or_permission`

7. **Update routes**
   - Replace custom `admin` middleware with `permission:view admin dashboard`

8. **Update views**
   - Use `@can('view admin dashboard')` for admin links

9. **Remove custom `Admin` middleware**

10. **Add tests**
    - Admin can access dashboard
    - Customer cannot access dashboard
    - Guest is redirected to login

11. **Verify**
    - `php artisan migrate:fresh --seed`
    - `php artisan test`
    - `npm run build`
