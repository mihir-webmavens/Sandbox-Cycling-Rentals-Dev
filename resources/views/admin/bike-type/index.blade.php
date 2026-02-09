<x-layouts.app heading="Bike Type" :title="__('Bike Type')" filterAction="{{ route('admin.bike-types.index') }}">

    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="/admin">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Bike Type</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <x-slot:filter>
        <x-filter.input name="name" label="Name" placeholder="Search by name" />
        <x-filter.input name="code" label="Code" placeholder="Search by code" />
        <x-filter.select name="sort" label="Sort By" placeholder="Select by "
            :options="['latest' => 'Latest First', 'oldest'=> 'Earliest First', 'acs'=> 'Name (A → Z)', 'desc'=>'Name (Z → A)']" />
        <x-filter.submit class="flex items-center justify-end" />
    </x-slot:filter>

    @can('bike-type.create')
    <div class="flex items-center justify-end mb-5">
        <x-action-button action="create" url="{{ route('admin.bike-types.create') }}" suffix="Bike Type"/>
    </div>
    @endcan

    @if ($bikeTypes->isNotEmpty())
    <!-- Grid of Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-2">
        @foreach ($bikeTypes as $bikeType)

        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col border border-gray-100 dark:border-gray-700 group">

            <!-- Image Banner -->
            <a href="{{ route('admin.bike-types.show', $bikeType->id) }}" class="relative w-full h-40 overflow-hidden">
                <img src="{{ imageUrl($bikeType->image) }}"
                    alt="{{ $bikeType->name }}"
                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">

                <!-- Status Badge -->
                <span class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold rounded-full shadow-md

                    {{ $bikeType->status->value === \App\Enums\BikeTypeStatusEnum::ACTIVE->value ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                    {{ $bikeType->status->label() }}
                </span>
            </a>

            <!-- Info Section -->
            <div class="p-5 flex flex-col flex-grow">
                <a href="{{ route('admin.bike-types.show', $bikeType->id) }}">
                    <h2
                        class="text-lg font-bold text-gray-800 dark:text-white mb-2 ">
                        {{ $bikeType->name }}
                    </h2>
                </a>

                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                    {{ $bikeType->description }}
                </p>

                <!-- Actions -->
                <div
                    class="mt-auto pt-3 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex gap-2">
                        <!-- View -->
                        <a href="{{ route('admin.bike-types.show', $bikeType->id) }}"
                            class="p-2 bg-blue-100 dark:bg-blue-700 hover:bg-blue-200 dark:hover:bg-blue-600 text-blue-600 dark:text-blue-200 rounded-full transition"
                            title="View">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </a>
                        @can('BikeType-edit')
                        <a href="{{ route('admin.bike-types.edit', $bikeType->id) }}"
                            class="p-2 bg-yellow-100 dark:bg-yellow-700 hover:bg-yellow-200 dark:hover:bg-yellow-600 text-yellow-600 dark:text-yellow-100 rounded-full transition"
                            title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </a>
                        @endcan
                        @can('BikeType-delete')
                        <form method="POST" action="{{ route('admin.bike-types.destroy', $bikeType->id) }}"
                            onsubmit="return confirm('Are you sure you want to delete this bike type?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700 text-red-600 dark:text-red-100 rounded-full transition"
                                title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <line x1="10" y1="11" x2="10" y2="17" />
                                    <line x1="14" y1="11" x2="14" y2="17" />
                                </svg>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if ($bikeTypes->hasPages())
    <div class="mt-10">
        {{ $bikeTypes->links() }}
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div
        class="col-span-full text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-inner border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col items-center space-y-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.75 17L4 21V5a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H9.75z" />
            </svg>
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">No Bike Types Found</h2>
            <p class="text-sm text-gray-500">Looks like there are no bike types yet. Start by creating one.</p>
            <x-form.link href="{{ route('admin.bike-types.create') }}">+ Add New Bike Type</x-form.link>
        </div>
    </div>
    @endif
</x-layouts.app>
