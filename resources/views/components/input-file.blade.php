@props([
    'name' => 'image',
    'src' => '',
    'alt' => '',
])

<script>
    function imageViewer(src = '') {
        return {
            imageUrl: src,
            initialImageUrl: src,

            fileChosen(event) {
                if (!event.target.files.length) {
                    this.initialImageUrl ? this.imageUrl = this.initialImageUrl : this.imageUrl = ''
                }

                let file = event.target.files[0],
                    reader = new FileReader()

                reader.readAsDataURL(file)
                reader.onload = e => this.imageUrl = e.target.result
            }
        }
    }
</script>
<div x-data="imageViewer('{{ $src }}')">
    <template x-if="imageUrl">
            <img :src="imageUrl"
                 class="object-cover rounded border border-gray-200 max-h-48"
                 alt="{{ $alt }}"
            >
    </template>
    <template x-if="!imageUrl">
        <div
                class="border rounded border-gray-200 bg-gray-100"
                style="width: 100px; height: 100px;"
        ></div>
    </template>

    <div class="flex flex-col lg:flex-row">
        <div>
            <input class="mt-2" name="{{ $name }}" type="file" accept="image/*" @change="fileChosen">
        </div>
    </div>

</div>
