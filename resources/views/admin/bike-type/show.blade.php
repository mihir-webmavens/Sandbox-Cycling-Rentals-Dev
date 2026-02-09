<x-layouts.app heading="Bike Type Details" :title="$bikeType->name">

    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="/admin">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="/admin/bike-types">Bike Type</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $bikeType->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="max-w-5xl mx-auto">

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- Header Image -->
            <div class="relative w-full h-64">
                <img src="{{ imageUrl($bikeType->image) }}" alt="{{ $bikeType->name }}"
                    class="w-full h-full object-cover">

                <!-- Status Badge -->
                <span
                    class="absolute top-4 right-4 px-4 py-1 text-sm font-semibold rounded-full shadow
                    {{ $bikeType->status->value === \App\Enums\BikeTypeStatusEnum::ACTIVE->value ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                    {{ $bikeType->status->value === \App\Enums\BikeTypeStatusEnum::ACTIVE->value ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <!-- Info Section -->
            <div class="p-8 space-y-6">

                <!-- Title + Code -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $bikeType->name }}</h1>
                    <p class="text-gray-500 mt-1">Code: <span class="font-semibold">{{ $bikeType->code }}</span></p>
                </div>

                <!-- Description -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $bikeType->description }}
                    </p>
                </div>

                <!-- Features -->
                @if($bikeType->features)
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Features</h2>

                        <ul class="list-disc ml-6 space-y-1 text-gray-600">
                            @foreach(explode(',', $bikeType->features) as $feature)
                                <li>{{ trim($feature) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Slug -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Slug</h2>
                    <p class="text-gray-600">{{ $bikeType->slug }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 border-t border-gray-200 flex items-center justify-between">

                    <x-form.link href="{{ route('admin.bike-types.index') }}">Back</x-form.link>


                </div>

            </div>
        </div>

    </div>

</x-layouts.app>
