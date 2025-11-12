<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="space-y-8">
                
                <!-- Welcome Message -->
                <h1 class="text-2xl font-bold text-gray-800">
                    Welcome to Dashboard. Hi, {{ Auth::user()->name ?? 'Admin' }}!
                </h1>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <x-admin.stat-card title="Activity This day" value="5090" />
                    <x-admin.stat-card title="Form Report This day" value="90" />
                    <x-admin.stat-card title="Consultation This day" value="90" />
                    <x-admin.stat-card title="Consultation Activity" value="8" />
                </div>

                <!-- Tables Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Form Report Table -->
                    <x-admin.report-table :reports="$reports" />

                    <!-- Consultation Table -->
                    <x-admin.consultation-table :consultations="$consultations" />
                </div>

            </div>
        </div>
    </div>
</x-app-layout>