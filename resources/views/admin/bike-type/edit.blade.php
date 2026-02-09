<x-layouts.app heading="Edit Bike Type" title="{{ $bikeType->name }}">

    <x-slot:breadcrumbs>
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="/admin">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="/admin/bike-types">Bike Type</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $bikeType->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </x-slot:breadcrumbs>

    <div class="max-w-5xl mx-auto">

        <!-- Image Upload Preview -->
       <div class="flex justify-center mb-8">
    <div class="relative w-40 h-40 group"> <!-- group added for hover -->

        <!-- Circle Image -->
        <div
            class="w-full h-full rounded-full bg-gray-100 border flex items-center justify-center overflow-hidden shadow-md">

            <img id="previewImage"
                 src="{{ imageUrl($bikeType->image) }}"
                 class="w-full h-full object-cover rounded-full {{ $bikeType->image ? '' : 'hidden' }}">
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

        <!-- ❌ Centered Remove Button (hidden until hover) -->
        <button type="button"
            id="removeImageBtn"
            class="absolute inset-0 m-auto w-10 h-10 bg-white/80 backdrop-blur-md border border-gray-300 text-gray-700 rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition duration-300 {{ $bikeType->image ? '' : 'hidden' }}">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>

        </button>


    </div>
</div>



        <!-- FORM -->
        <form action="{{ route('admin.bike-types.update',$bikeType->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow p-8 border border-gray-200">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <input type="hidden" name="remove_image" id="removeImageFlag" value="0">

                <!-- Left Column -->
                <div class="space-y-5">
                    <x-form.file id="image" name="image" label="Bike Image" />

                    <x-form.input name="name" value="{{ old('name',$bikeType->name) }}" label="Bike Type Name"
                        placeholder="ex: Mountain Bike" required />

                    <x-form.input name="slug" value="{{ old('slug',$bikeType->slug) }}" label="Slug"
                        placeholder="ex: mountain-bike" required />

                    <x-form.input name="code" value="{{ old('code',$bikeType->code) }}" label="Code"
                        placeholder="ex: MTB001" required />
                </div>

                <!-- Right Column -->
                <div class="space-y-5">

                    <x-form.input name="description" value="{{ old('description', $bikeType->description) }}"
                        label="Description" rows="4" placeholder="Short description about this bike type..." />

                    <x-form.input name="features" value="{{ old('features',$bikeType->features) }}"
                        label="Features (comma separated)" rows="4"
                        placeholder="ex: Strong Frame, Disc Brakes, Suspension" />

                    <x-form.radio name="status" selected="{{ old('status', $bikeType->status) }}" :options="$status"
                        label="Status" variant="pill" required />
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 mt-8">
                <x-form.link href="{{ route('admin.bike-types.index') }}" color="white">
                    Cancel
                </x-form.link>

                <x-form.button color="primary">
                    Update Bike Type
                </x-form.button>
            </div>

        </form>
    </div>

    <!-- Preview Image Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('image');
    const preview = document.getElementById('previewImage');
    const removeBtn = document.getElementById('removeImageBtn');
    const removeFlag = document.getElementById('removeImageFlag');

    // File upload preview
    input.addEventListener('change', e => {
        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();
        reader.onload = event => {
            preview.src = event.target.result;
            preview.classList.remove('hidden');
            removeBtn.classList.remove('hidden');
            removeFlag.value = "0"; // new image uploaded, so do NOT remove old
        };
        reader.readAsDataURL(file);
    });

    // Remove image click
    removeBtn.addEventListener('click', () => {
        preview.src = "";
        preview.classList.add('hidden');
        removeBtn.classList.add('hidden');

        input.value = "";         // clear upload field
        removeFlag.value = "1";   // tell backend to delete image
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
