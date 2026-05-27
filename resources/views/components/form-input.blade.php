@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'error' => false,
])

<div class="mb-6">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input 
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        class="form-input @error($name) border-red-500 focus:ring-red-500 @enderror"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >

    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
