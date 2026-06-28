<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->admin = User::factory()->create()->assignRole('admin');
    $this->customer = User::factory()->create()->assignRole('customer');
});

test('admin can view roles list', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.roles.index'))
        ->assertOk()
        ->assertSee('admin')
        ->assertSee('customer');
});

test('customer cannot view roles list', function () {
    $this->actingAs($this->customer)
        ->get(route('admin.roles.index'))
        ->assertForbidden();
});

test('admin can create a role', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.roles.store'), ['name' => 'editor'])
        ->assertRedirect(route('admin.roles.index'));

    $this->assertDatabaseHas('roles', ['name' => 'editor']);
});

test('admin can update a role', function () {
    $role = Role::create(['name' => 'old-name']);

    $this->actingAs($this->admin)
        ->put(route('admin.roles.update', $role), ['name' => 'new-name'])
        ->assertRedirect(route('admin.roles.index'));

    $this->assertDatabaseHas('roles', ['name' => 'new-name']);
});

test('admin can delete a role', function () {
    $role = Role::create(['name' => 'deletable']);

    $this->actingAs($this->admin)
        ->delete(route('admin.roles.destroy', $role))
        ->assertRedirect(route('admin.roles.index'));

    $this->assertDatabaseMissing('roles', ['name' => 'deletable']);
});

test('admin can view permissions list', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.permissions.index'))
        ->assertOk()
        ->assertSee('manage products');
});

test('admin can create a permission', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.permissions.store'), ['name' => 'manage reviews'])
        ->assertRedirect(route('admin.permissions.index'));

    $this->assertDatabaseHas('permissions', ['name' => 'manage reviews']);
});

test('admin can assign permissions to a role', function () {
    $role = Role::create(['name' => 'test-role']);
    $permission = Permission::create(['name' => 'test-permission']);

    $this->actingAs($this->admin)
        ->put(route('admin.roles.permissions.update', $role), [
            'permissions' => [$permission->name],
        ])
        ->assertRedirect(route('admin.roles.index'));

    $this->assertTrue($role->fresh()->hasPermissionTo($permission->name));
});

test('admin can assign roles to a user', function () {
    $user = User::factory()->create();
    $role = Role::create(['name' => 'test-user-role']);

    $this->actingAs($this->admin)
        ->put(route('admin.users.roles.update', $user), [
            'roles' => [$role->name],
        ])
        ->assertRedirect(route('admin.users.index'));

    $this->assertTrue($user->fresh()->hasRole($role->name));
});
