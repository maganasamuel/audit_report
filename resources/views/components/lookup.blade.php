@props(['id', 'value-model', 'label-model', 'value-column', 'label-column', 'items'])

<div class="input-group dropdown d-flex">
  <input type="text" id="{{ $id }}" wire:model.debounce="{{ $labelModel }}"
    {{ $attributes->merge(['class' => 'form-control']) }}>
  <input type="hidden" wire:model.defer="{{ $valueModel }}" />
  <div class="input-group-append" wire:ignore.self>
    <div class="btn-group position-static" wire:ignore.self>
      <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false"
        style="border-top-left-radius: 0; border-bottom-left-radius: 0;" wire:ignore.self>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu dropdown-menu-right w-100" style="max-height: 25vh; overflow-y: auto;"
        wire:ignore.self>
        @foreach ($items as $item)
          <a href="javascript:void(0);" class="dropdown-item"
            data-value="{{ $item->$valueColumn }}">{{ $item->$labelColumn }}</a>
        @endforeach
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
    const handleLookup{{ $id }}Load = () => {
      const id = '#{{ $id }}';
      let dropdown = $(id).closest('.dropdown');
      let dropdownToggle = $(id).parent().find('.dropdown-toggle');
      let dropdownMenu = $(id).parent().find('.dropdown-menu');
      let inputMousedown = false;
      let dropdownToggleClicked = false;
      let dropdownHide = false;
      let hiddenInput = $(id).parent().find('input[type="hidden"]');
      let oldValue = hiddenInput.val();
      let oldLabel = $(id).val();

      $(id).on('mousedown', function() {
        inputMousedown = true;
      }).on('focus', function() {
        if (dropdownToggleClicked) {
          dropdownToggleClicked = false;

          return;
        }

        if (dropdownHide) {
          dropdownHide = false;

          return;
        }

        if (inputMousedown) {
          return;
        }

        setTimeout(function() {
          dropdownToggle.trigger('click');
        }, 62.5);
      }).on('mouseup', function() {
        if (inputMousedown) {
          setTimeout(function() {
            dropdownToggle.trigger('click');
          }, 62.5)
        }
      }).on('keyup', function(event) {
        if ([38, 40].includes(event.keyCode)) {
          dropdownMenu.find('a:eq(0)').focus();
        }
      }).on('focusout', function() {
        $(this).val(oldLabel);
      });

      dropdownToggle.on('focus', function() {
        if (inputMousedown) {
          setTimeout(function() {
            $(this).trigger('click');
          }, 62.5);

          inputMousedown = false;
        }
      }).on('click', function() {
        dropdownToggleClicked = true;

        setTimeout(function() {
          $(id).focus();
        }, 62.5);
      });

      dropdownMenu.on('click', 'a', function() {
        hiddenInput.val($(this).data('value'));
        $(id).val($(this).text());

        oldValue = hiddenInput.val();
        oldLabel = $(id).val();

        hiddenInput[0].dispatchEvent(new Event('input'));
        $(id)[0].dispatchEvent(new Event('input'));
      });

      dropdown.on('hidden.bs.dropdown', function(event) {
        $(id).val(oldLabel);

        dropdownHide = true;

        $(id).focus();
      });
    }

    window.addEventListener('load', handleLookup{{ $id }}Load)

  </script>
@endpush
