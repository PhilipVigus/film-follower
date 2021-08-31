<section class="mt-4">
    <h3 class="font-bold text-lg">Trailers</h3>

    <ul>
        <template x-for="(trailer, index) in result.item.trailers" :key="index">
            <a :href="trailer.link" target="_blank">
                <li class="hover:underline" x-text="trailer.type"></li>
            </a>
        </template>
    </ul>
</section>
