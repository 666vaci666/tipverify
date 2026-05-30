@extends('layouts.app')

@section('title', $user->name . ' — TipVerify')

@section('content')

    {{-- Hlavička profilu --}}
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xl">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">Tipster od {{ $user->created_at->format('d.m.Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Štatistiky --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-gray-900">{{ $total }}</div>
            <div class="text-xs text-gray-500 mt-1">Celkom tipov</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $wins }}</div>
            <div class="text-xs text-gray-500 mt-1">Výhry</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-red-500">{{ $losses }}</div>
            <div class="text-xs text-gray-500 mt-1">Prehry</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $winRate }}%</div>
            <div class="text-xs text-gray-500 mt-1">Úspešnosť</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold {{ $roi >= 0 ? 'text-green-600' : 'text-red-500' }}">
                {{ $roi > 0 ? '+' : '' }}{{ $roi }}%
            </div>
            <div class="text-xs text-gray-500 mt-1">ROI</div>
        </div>
    </div>

    {{-- Zoznam tipov --}}
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h2 class="font-semibold text-gray-900">Tipy</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Zápas</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Tip</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Kurz</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Dátum</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tips as $tip)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $tip->match_teams }}</td>
                        <td class="px-4 py-3">{{ $tip->prediction }}</td>
                        <td class="px-4 py-3 font-mono">{{ $tip->odds }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $tip->match_date }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colors = [
                                    'win'     => 'bg-green-100 text-green-700',
                                    'loss'    => 'bg-red-100 text-red-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'void'    => 'bg-gray-100 text-gray-600',
                                ];
                            @endphp
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $colors[$tip->status] ?? '' }}">
                                {{ strtoupper($tip->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            Žiadne tipy.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="/" class="text-sm text-gray-500 hover:text-gray-700">← Späť na zoznam</a>
    </div>

@endsection