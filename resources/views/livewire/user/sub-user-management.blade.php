@extends('layouts.master')

@section('tab_tittle', '')

@section('content')
    <div class="py-3">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <input type="text" wire:model="search" class="form-control" placeholder="Search...">
                        </div>
                        <div class="ms-4">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Add New
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm my-3">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col" wire:click="sortByColumn('name')">Name @include('svg.sort-' . $sortDirection)</th>
                            <th scope="col" wire:click="sortByColumn('email')">Email @include('svg.sort-' . $sortDirection)</th>
                            <th scope="col" wire:click="sortByColumn('role')">Role @include('svg.sort-' . $sortDirection)</th>
                            <th scope="col" wire:click="sortByColumn('created_at')">Created At
                                @include('svg.sort-' . $sortDirection)</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button wire:click="edit({{ $user->id }})" class="btn btn-primary me-2">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button wire:click="delete({{ $user->id }})" class="btn btn-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-3">
                <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true close-btn">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model="name" class="form-control" id="name"
                                        placeholder="Enter name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" wire:model="email" class="form-control" id="email"
                                        placeholder="Enter email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" wire:model="password" class="form-control" id="password"
                                        placeholder="Enter password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select wire:model="role" class="form-control" id="role">
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close-btn"
                                    data-dismiss="modal">Cancel</button>
                                @if ($subUserId)
                                    <button type="button" wire:click="updateQuestion"
                                        class="btn btn-primary close-modal">Update</button>
                                @else
                                    <button type="button" wire:click="createQuestion"
                                        class="btn btn-primary close-modal">Create</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
