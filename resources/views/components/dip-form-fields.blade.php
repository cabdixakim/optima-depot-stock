@props(['tanks', 'bookBalance20' => 0, 'dip' => null])

<div>
    <label class="block text-sm font-medium text-gray-700">Tank</label>
    <select name="tank_id" class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">Select tank…</option>
        @foreach($tanks as $tank)
            <option value="{{ $tank->id }}"
                @if(old('tank_id', optional($dip)->tank_id) == $tank->id) selected @endif>
                {{ $tank->depot->name }} — {{ $tank->product->name }} (T{{ $tank->id }})
            </option>
        @endforeach
    </select>
    @error('tank_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700">Date</label>
        <input type="date" name="date" value="{{ old('date', optional($dip)->date?->toDateString() ?? now()->toDateString()) }}"
               class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Dip Height (cm)</label>
        <input type="number" step="0.01" name="dip_height_cm" value="{{ old('dip_height_cm', optional($dip)->dip_height_cm) }}"
               class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div>
        <label class="block text-sm font-medium text-gray-700">Temperature (°C)</label>
        <input type="number" step="0.1" name="temperature" value="{{ old('temperature', optional($dip)->temperature ?? 25) }}"
               class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Density (kg/L)</label>
        <input type="number" step="0.0001" name="density" value="{{ old('density', optional($dip)->density ?? 0.835) }}"
               class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Strapping CSV (optional)</label>
        <input type="text" name="strapping_chart_path" value="{{ old('strapping_chart_path') }}"
               placeholder="C:\path\strap.csv"
               class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Note (optional)</label>
    <textarea name="note" rows="2"
              class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="Any remark…">{{ old('note', optional($dip)->note) }}</textarea>
</div>

{{-- Quick preview --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div class="rounded-lg border bg-gray-50 p-4">
        <p class="text-xs font-medium text-gray-500">Observed (L)</p>
        <p class="pv-observed mt-1 text-lg font-semibold text-gray-900">—</p>
    </div>
    <div class="rounded-lg border bg-gray-50 p-4">
        <p class="text-xs font-medium text-gray-500">@20°C (L)</p>
        <p class="pv-at20 mt-1 text-lg font-semibold text-gray-900">—</p>
    </div>
    <div class="rounded-lg border bg-gray-50 p-4">
        <p class="text-xs font-medium text-gray-500">Variance</p>
        <p class="pv-variance mt-1 text-lg font-semibold text-gray-900">—</p>
    </div>
</div>
