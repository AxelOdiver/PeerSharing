@props([
    'id',
    'title',
    'dialogClass' => 'modal-dialog-centered',
    'size' => null,
])

@php
    $titleId = $id . 'Label';
    $dialogClasses = trim('modal-dialog ' . $dialogClass . ' ' . ($size ? 'modal-' . $size : ''));
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $titleId }}" aria-hidden="true">
    <div class="{{ $dialogClasses }}">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $titleId }}">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
