@foreach ($fields as $field)
    @php
        $type = $field['type'] ?? 'text';
        $name = $field['name'] ?? '';
        $label = $field['label'] ?? ucfirst($name);
        $options = $field['options'] ?? [];
        $isMultiple = $field['multiple'] ?? false;
        $oldValue = old($name);
    @endphp

    <div>
        <label class="block text-purple-300 mb-1 font-medium">
            {{ $label }}
        </label>

        @if ($type === 'select')
            <select name="{{ $name }}" @if($isMultiple) multiple @endif
                    class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10">
                <option value="">-- Select --</option>
                @foreach ($options as $value => $optionLabel)
                    <option value="{{ $value }}"
                        @if(($isMultiple && is_array($oldValue) && in_array($value, $oldValue)) || (!$isMultiple && $oldValue == $value))
                            selected
                        @endif>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>

        @elseif($type === 'file')
            <input type="file" name="{{ $name }}"
                   class="w-full text-white border border-white/10 rounded px-4 py-2 bg-white/10" />

        @else
            @php
                $allowedTypes = ['text', 'email', 'number', 'password', 'date', 'tel', 'url', 'hidden', 'checkbox', 'radio'];
                $inputType = in_array($type, $allowedTypes) ? $type : 'text';
            @endphp
            <input type="{{ $inputType }}" name="{{ $name }}"
                   @if($inputType !== 'file') value="{{ $oldValue }}" @endif
                   class="w-full rounded px-4 py-2 bg-white/10 text-white border border-white/10" />
        @endif

        @error($name)
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
@endforeach
