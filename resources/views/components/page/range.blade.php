@props(['ranges' => [10, 25, 50, 100]])

<div>
  <label class="d-flex align-items-center">
    <span>Show&nbsp;</span>
    <select {{ $attributes->merge(['class' => 'form-control']) }}>
      @foreach ($ranges as $range)
        <option value="{{ $range }}">{{ number_format($range) }}
        </option>
      @endforeach
    </select>
    <span>&nbsp;Entries</span>
  </label>
</div>
