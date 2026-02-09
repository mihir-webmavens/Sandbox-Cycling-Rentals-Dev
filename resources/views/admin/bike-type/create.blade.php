<x-layouts.app heading="Create Bike Type" title="Create Bike Type">

    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="/admin">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="/admin/bike-types">Bike Type</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Create</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="max-w-5xl mx-auto">

        <!-- Image Upload Preview -->
        <div class="flex justify-center mb-8">
            <div class="relative w-40 h-40">
                <!-- Circle Image Wrapper -->
                <div class="w-full h-full rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden shadow-md hover:shadow-lg transition">
                    <img id="previewImage" src="" alt="" class="w-full h-full object-cover rounded-full hidden">
                </div>

                <!-- Upload Button -->
                <label for="image"
                    class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow cursor-pointer hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </label>
            </div>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.bike-types.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow p-8 border border-gray-200">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Left Column -->
                <div class="space-y-5">
                    <x-form.file id="image" name="image" label="Bike Image" />

                    <x-form.input 
                        name="name" 
                        value="{{ old('name') }}" 
                        label="Bike Type Name" 
                        placeholder="ex: Mountain Bike" 
                        required 
                    />

                    <x-form.input 
                        name="slug" 
                        value="{{ old('slug') }}" 
                        label="Slug" 
                        placeholder="ex: mountain-bike" 
                        required 
                    />

                    <x-form.input 
                        name="code" 
                        value="{{ old('code') }}" 
                        label="Code" 
                        placeholder="ex: MTB001" 
                        required 
                    />
                </div>

                <!-- Right Column -->
                <div class="space-y-5">

                    <x-form.input 
                        name="description" 
                        value="{{ old('description') }}" 
                        label="Description" 
                        rows="4" 
                        placeholder="Short description about this bike type..."
                    />

                    <x-form.input 
                        name="features" 
                        value="{{ old('features') }}" 
                        label="Features (comma separated)" 
                        rows="4"
                        placeholder="ex: Strong Frame, Disc Brakes, Suspension"
                    />

                    <x-form.radio 
                        name="status"  
                        selected="{{ old('status', '1') }}" 
                        :options="$status" 
                        label="Status"
                        variant="pill"
                        required
                    />
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 mt-8">
                <x-form.link href="{{ route('admin.bike-types.index') }}" color="white">
                    Cancel
                </x-form.link>

                <x-form.button color="primary">
                    Create Bike Type
                </x-form.button>
            </div>

        </form>
    </div>

    <!-- Preview Image Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('image');
        const preview = document.getElementById('previewImage');

        input.addEventListener('change', e => {
            const file = e.target.files[0];

            // If no file selected (user removed image)
            if (!file) {
                preview.src = "";
                preview.classList.add('hidden');
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = event => {
                preview.src = event.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const nameInput = document.getElementById("name");
    const slugInput = document.getElementById("slug");

    nameInput.addEventListener("input", () => {
        const name = nameInput.value.toLowerCase();

        const slug = name
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // remove accents
            .replace(/[^a-z0-9\s-]/g, "")  // remove invalid chars
            .replace(/\s+/g, "-")          // spaces → hyphens
            .replace(/-+/g, "-")           // collapse multiple hyphens
            .replace(/^-+|-+$/g, "");      // trim hyphens

        slugInput.value = slug;
    });
});
</script>



</x-layouts.app>
