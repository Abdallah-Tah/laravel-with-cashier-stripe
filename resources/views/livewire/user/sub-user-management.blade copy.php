@extends('layouts.master')

@section('tab_tittle', '')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="flex flex-row justify-between p-4">
                        <div class="flex flex-row">
                            <x-text-input wire:model="search" type="text" placeholder="Search..." wire:model="search"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-800 focus:border-blue-800 sm:text-sm" />
                        </div>
                        <div class="ml-4">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Add New
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden overflow-x-auto mb-4 sm:rounded-lg shadow-lg border border-gray-200 bg-white">
                <table class="w-full table-auto border divide-y divide-gray-200 divide-solid rounded-lg">
                    <thead class="bg-gray-50 divide-y divide-gray-200 divide-solid rounded-lg">
                        <tr class="bg-gray-50">
                            <th wire:click="sortByColumn('name')" class="px-6 py-3 text-left bg-gray-50">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{ __('Name') }}</span>
                                @if ($sortColumn == 'name')
                                    @include('svg.sort-' . $sortDirection)
                                @else
                                    @include('svg.sort')
                                @endif
                            </th>
                            <th wire:click="sortByColumn('email')" class="px-6 py-3 text-left bg-gray-50">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{ __('Email') }}</span>
                                @if ($sortColumn == 'email')
                                    @include('svg.sort-' . $sortDirection)
                                @else
                                    @include('svg.sort')
                                @endif
                            </th>
                            <th wire:click="sortByColumn('role')" class="px-6 py-3 text-left bg-gray-50">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{ __('Role') }}</span>
                                @if ($sortColumn == 'role')
                                    @include('svg.sort-' . $sortDirection)
                                @else
                                    @include('svg.sort')
                                @endif
                            </th>
                            <th wire:click="sortByColumn('created_at')" class="px-6 py-3 text-left bg-gray-50">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{ __('Created At') }}</span>
                                @if ($sortColumn == 'created_at')
                                    @include('svg.sort-' . $sortDirection)
                                @else
                                    @include('svg.sort')
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left bg-gray-50">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{ __('Action') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900">{{ $user->role }}</td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900">{{ $user->created_at }}</td>
                                <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                    <div class="flex justify-center">
                                        <div class="flex justify-center">
                                            <x-primary-button wire:click="edit({{ $user->id }})"
                                                class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ __('Edit') }}
                                            </x-primary-button>
                                        </div>
                                        <div class="flex justify-center ml-4">
                                            <x-danger-button wire:click="delete({{ $user->id }})"
                                                class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        {{-- {{ $users->links() }} --}}
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
