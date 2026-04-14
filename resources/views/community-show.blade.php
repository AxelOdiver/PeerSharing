@extends('layouts.dashboard')

@section('title', 'Community')
@section('page-title', 'Community')

@section('content')
<div class="container-fluid py-4">
  <a href="{{ route('community') }}" class="btn btn-primary mb-4">
    <i class="bi bi-arrow-left"></i> Back to Communities
  </a>
  
  <!-- Main content area with community details -->
  <div class="row align-items-stretch g-3 mb-4">
    <div class="col-12 col-xl-8">
      <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <h3 class="fw-bold mb-2">{{ $community->name }}</h3>
          @if(auth()->check() && auth()->id() === $community->user_id)
          <button type="button" id="editDescriptionBtn" data-id="{{ $community->id }}" class="btn btn-sm btn-primary justify-content-end d-flex align-items-center ms-auto">Edit</button>
          @endif
        </div>
        
        <div id="descriptionViewMode">
          <p class="lead mb-0" id="descriptionText">{{ $community->description }}</p>
        </div>
        @if(auth()->check() && auth()->id() === $community->user_id)
        <div id="descriptionEditMode" style="display:none;">
          <textarea name="description" 
          id="descriptionInput"
          class="form-control form-control-lg" 
          rows="8" 
          placeholder="Enter your description">{{ old('description', $community->description) }}</textarea>
          <div class="d-flex justify-content-end gap-2">
            <button type="button" id="cancelEditBtn" class="btn btn-sm btn-secondary mt-2 px-4">Cancel</button>
            <button type="button" id="saveEditBtn" class="btn btn-sm btn-primary mt-2 px-4">Save</button>
          </div>
        </div>
        @endif  
        
        <div class="d-flex align-items-center mt-auto pt-2 flex-wrap gap-2">
          <span class="text-muted small me-1">Tags:</span>
          <span class="badge rounded-pill px-3 py-2 fw-normal bg-secondary">Study-group</span>
          <span class="badge rounded-pill px-3 py-2 fw-normal bg-secondary">Share-insight</span>
          
          @if(auth()->check() && auth()->id() === $community->user_id)
          <button class="btn btn-dark rounded-pill px-3 py-1 d-flex align-items-center gap-1 fw-bold border-0">
            <i class="bi bi-plus-lg fs-5"></i> Add tags
          </button>
          @endif
        </div>
      </div>
    </div>
    
    <!-- Right column with community details -->
    <div class="col-12 col-xl-4">
      <div class="card border-0 shadow-sm rounded-4 p-4">
        <h3 class="fw-bold">{{ $community->name }}</h3>
        <div class="text-muted mb-3">
          <i class="bi bi-person-circle me-1"></i> Created by {{ $community->user?->first_name }} {{ $community->user?->last_name ?? 'Unknown' }}
          <span class="mx-2">|</span>
          <i class="bi bi-people-fill me-1"></i> Member Limit: {{ $community->member_limit }}
        </div>
      </div>
    </div>
  </div>
    
    <!-- Full-width section for posts, files, or chat features -->
  <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
    <h3 class="text-muted">Welcome to the {{ $community->name }} community!</h3>
    <p class="text-muted mb-0">This is where you will add posts, files, or chat features later.</p>
  </div>
  
</div>
@endsection
