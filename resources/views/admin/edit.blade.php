@extends('admin.layout')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-12 box_shadow p-3 rounded">
            <h4 class="text-capitalize">Profile information</h4>
            <p class="text-capitalize">Update your account's profile information and email address.</p>
            <form action="{{ route('admin.profile.update', ['guard' => 'admin']) }}" method="post">
                @csrf
                @method('patch')
                

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control">
                    @error('name')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-control">
                    @error('email')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                {{-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="btn btn-warning">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif --}}

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                @if (session('status') === 'profile-updated')
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Saved.') }}
                        </p>
                    </div>
                @endif

                {{-- <form id="send-verification" method="post" action="{{ route('admin.verification.send') }}">
                    @csrf
                </form> --}}

            </form>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 box_shadow p-3 rounded">
            <h4 class="text-capitalize">Update Password</h4>
            <p class="text-capitalize">Ensure your account is using a long, random password to stay secure.</p>
            <form action="{{ route('admin.password.update', ['guard' => 'admin']) }}" method="post">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" class="form-control">
                    @error('current_password')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password">New Password</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                    @error('password_confirmation')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                @if (session('status') === 'password-updated')
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            {{ __('Saved.') }}
                        </p>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <form action="{{ route('admin.profile.destroy', ['guard' => 'admin']) }}" method="post">
        @csrf
        @method('delete')
        <div class="row">
            <div class="col-12 box_shadow p-3 rounded">
                <h4 class="text-capitalize">Delete Account</h4>
                <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                @error('password')
                <div class="form-error">
                    <p class="text-danger mb-3">{{$message}}</p>
                </div>
                @enderror
                <div class="my-3">
                    

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete Account</button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Account</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Are you sure you want to delete your account?') }}
                                        </h4>
                            
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                        </p>
                                        <div class="mb-3 p-2">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control">
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
        </form>
    
</div>
@endsection
