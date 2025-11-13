@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Role Management</h1>

    {{-- Role Table --}}
    <x-admin.role-table :roles="$roles" />

    {{-- Modals --}}
    <x-admin.role-modal-add />
    @foreach ($roles as $role)
        <x-admin.role-modal-edit :role="$role" />
        <x-admin.role-modal-view :role="$role" />
        <x-admin.role-modal-delete :role="$role" />
    @endforeach
@endsection
