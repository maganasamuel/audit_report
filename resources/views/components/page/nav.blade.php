@props(['paginator', 'search', 'onEachSide' => null, 'entityName' => 'records'])

@php
if ($onEachSide != null) {
    $paginator->onEachSide($onEachSide);
}
@endphp

<div class="d-flex justify-content-between align-items-center pt-2">
  <div class="px-4 text-muted">
    <div class="mb-3">
      @if ($paginator->firstItem())
        <p class="small">
          Showing {{ number_format($paginator->firstItem()) }}
          to {{ number_format($paginator->lastItem()) }}
          of {{ number_format($paginator->total()) }} entries
        </p>
      @else
        <p class="small mt-3">
          {{ $search ? 'No ' . $entityName . ' found.' : 'No available ' . $entityName . '.' }}
        </p>
      @endif
    </div>
  </div>
  <div class="px-4 d-flex align-items-center">
    {{ $paginator->links() }}
  </div>
</div>
