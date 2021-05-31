@props(['for'])

@error($for)
  <strong
    {{ $attributes->merge(['class' => 'input-error invalid-feedback d-block', 'role' => 'alert']) }}>{{ $message }}</strong>
@enderror
