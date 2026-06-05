{{--
    Props:
      $name        = string  — field name & id
      $label       = string
      $type        = string  — 'text'|'email'|'tel'|'password'|'select'|'textarea' (default: 'text')
      $value       = mixed   — current value (use old() or model value before passing)
      $placeholder = string|null
      $required    = bool    (default: false)
      $rows        = int     — for textarea (default: 3)
      $options     = array   — for select: ['value' => 'Label', ...] (default: [])

    Usage examples:
      — text/email/tel:
        <x-form-field name="nim" label="NIM" :value="old('nim')" placeholder="04112021001" required />

      — select:
        <x-form-field name="jurusan" label="Jurusan" type="select" :value="old('jurusan')" required
            :options="['Informatika' => 'Informatika', 'Sistem Informasi' => 'Sistem Informasi']" />

      — textarea:
        <x-form-field name="alamat" label="Alamat" type="textarea" :value="old('alamat')" :rows="4" />
--}}
@props([
    'name',
    'label',
    'type'        => 'text',
    'value'       => '',
    'placeholder' => null,
    'required'    => false,
    'rows'        => 3,
    'options'     => [],
])

<div>
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if ($required)
            <span class="text-red-400 ml-0.5">*</span>
        @endif
    </label>

    @if ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}"
            class="form-input @error($name) border-red-400 bg-red-50 @enderror"
            {{ $required ? 'required' : '' }}>
            <option value="">-- Pilih {{ $label }} --</option>
            @foreach ($options as $optVal => $optLabel)
                <option value="{{ $optVal }}" {{ (string) $value === (string) $optVal ? 'selected' : '' }}>
                    {{ $optLabel }}
                </option>
            @endforeach
        </select>

    @elseif ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            class="form-input @error($name) border-red-400 bg-red-50 @enderror"
            {{ $required ? 'required' : '' }}>{{ $value }}</textarea>

    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="form-input @error($name) border-red-400 bg-red-50 @enderror"
            {{ $required ? 'required' : '' }}>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
            <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126Z"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
