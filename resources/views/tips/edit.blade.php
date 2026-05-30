@extends('layouts.app')

@section('title', 'Upraviť tip — TipVerify')

@section('content')

    <div class="max-w-xl">
        <h1 class="text-2xl font-bold mb-6">Upraviť tip</h1>

        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <form method="POST" action="/tips/{{ $tip->id }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="match_teams" class="block text-sm font-medium text-gray-700 mb-1">Zápas</label>
                    <input type="text" id="match_teams" name="match_teams"
                           value="{{ old('match_teams', $tip->match_teams) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('match_teams')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="prediction" class="block text-sm font-medium text-gray-700 mb-1">Tip / Predikcia</label>
                    <input type="text" id="prediction" name="prediction"
                           value="{{ old('prediction', $tip->prediction) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('prediction')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="odds" class="block text-sm font-medium text-gray-700 mb-1">Kurz</label>
                    <input type="number" id="odds" name="odds"
                           value="{{ old('odds', $tip->odds) }}"
                           step="0.01" min="1.01"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('odds')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="match_date" class="block text-sm font-medium text-gray-700 mb-1">Dátum zápasu</label>
                    <input type="date" id="match_date" name="match_date"
                           value="{{ old('match_date', $tip->match_date) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('match_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status"
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['pending', 'win', 'loss', 'void'] as $s)
                            <option value="{{ $s }}" {{ old('status', $tip->status) === $s ? 'selected' : '' }}>
                                {{ strtoupper($s) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-5 py-2 rounded text-sm hover:bg-blue-700">
                        Uložiť zmeny
                    </button>
                    <a href="/" class="text-sm text-gray-500 hover:text-gray-700 py-2">Zrušiť</a>
                </div>
            </form>
        </div>
    </div>

@endsection