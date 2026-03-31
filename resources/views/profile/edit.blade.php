@extends('layouts.dashboard')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<h2 class="mb-3 fw-bold">Profile</h2>
<div class="row align-items-stretch">
  <div class="col-lg-6 d-flex mb-3 mb-lg-0"> 
    <div class="card w-100">     
      <div class="card-header d-flex justify-content-center">
        <div class="position-relative d-inline-block">          
          <img alt="Profile" id="profileImage" class="rounded-circle shadow-sm" width="150" height="150" style="object-fit: cover;">
          <label for="profilePictureUpload" class="btn btn-light btn-sm rounded-circle position-absolute bottom-0 end-0 d-flex align-items-center justify-content-center shadow-sm m-0" style="width: 40px; height: 40px; transform: translate(-10%, -10%); cursor: pointer;">
            <i class="bi bi-camera-fill fs-5 text-secondary"></i> 
            <input id="profilePictureUpload" type="file" class="d-none" accept="image/*">
          </label>
        </div>
      </div>
      <div class="card-body">
        <form id="form" action="{{ route('profile.update') }}" data-user-id="{{ auth()->user()->id }}" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input
            id="first_name"
            type="text"
            name="first_name"
            class="form-control"
            required
            >
            <div class="invalid-feedback" data-error-for="first_name"></div>
          </div>
          <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input
            id="middle_name"
            type="text"
            name="middle_name"
            class="form-control"
            >
            <div class="invalid-feedback" data-error-for="middle_name"></div>
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input
            id="last_name"
            type="text"
            name="last_name"
            class="form-control"
            required
            >
            <div class="invalid-feedback" data-error-for="last_name"></div>
          </div>
          
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
            id="email"
            type="email"
            name="email"
            class="form-control"
            required
            >
            <div class="invalid-feedback" data-error-for="email"></div>
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input
            id="password"
            type="password"
            name="password"
            class="form-control"
            autocomplete="new-password"
            >
            <div class="form-text">Leave blank to keep your current password.</div>
            <div class="invalid-feedback" data-error-for="password"></div>
          </div>
          <div id="confirmPasswordWrap" class="fade-field">
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm New Password</label>
              <input
              id="password_confirmation"
              type="password"
              name="password_confirmation"
              class="form-control"
              >
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6 d-flex flex-column gap-1">
    <div class="card flex-fill mb-3">
      <div class="card-body h-100">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
            <i class="bi bi-person-vcard fs-3"></i>
          </div>
          <div>
            <h3 class="h5 mb-1">Profile Summary</h3>
            <p class="text-body-secondary mb-0">This preview updates after you save your changes.</p>
          </div>
        </div>

        <dl class="row mb-0">
          <dt class="col-sm-4 text-body-secondary">Full Name</dt>
          <dd class="col-sm-8 fw-semibold" id="profileSummaryName">-</dd>

          <dt class="col-sm-4 text-body-secondary">Email</dt>
          <dd class="col-sm-8" id="profileSummaryEmail">-</dd>

          <dt class="col-sm-4 text-body-secondary">Account ID</dt>
          <dd class="col-sm-8" id="profileSummaryId">{{ auth()->id() }}</dd>
        </dl>
      </div>
    </div>
    <div class="card flex-fill">
      <div class="card-body h-100">
        <h3 class="h5 mb-3">Account Status</h3>
        <div class="d-flex justify-content-between align-items-center border rounded-3 px-3 py-2 mb-3">
          <span class="text-body-secondary">Password</span>
          <span class="badge text-bg-success" id="profilePasswordStatus">Unchanged</span>
        </div>
        <div class="d-flex justify-content-between align-items-center border rounded-3 px-3 py-2">
          <span class="text-body-secondary">Profile Photo</span>
          <span class="badge text-bg-secondary" id="profilePhotoStatus">No photo</span>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mt-3">
  <button type="submit" id="saveChangesBtn" class="btn btn-primary w-100">Save Changes</button>
</div>
@endsection
