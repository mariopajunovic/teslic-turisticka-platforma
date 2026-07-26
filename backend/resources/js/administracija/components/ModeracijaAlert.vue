<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    base: { type: String, required: true },
    id: { type: [Number, String], default: null },
    status: { type: String, default: 'nacrt' },
    pending: { type: Object, default: null },
    subjekt: { type: String, default: 'vlasnik' },
    zivo: { type: String, default: 'objava' },
});

const put = (akcija, data = {}) =>
    router.post(`/administracija/${props.base}/${props.id}/${akcija}`, data, { preserveScroll: true });

const izmjenaAkcija = ref(null);
const izmjenaRazlog = ref('');
function posaljiIzmjenaAkcija() {
    if (!izmjenaRazlog.value.trim()) return;
    put(izmjenaAkcija.value === 'vrati' ? 'vrati-izmjene' : 'odbij-izmjene', { pending_reason: izmjenaRazlog.value });
    izmjenaAkcija.value = null;
    izmjenaRazlog.value = '';
}

const novaAkcija = ref(null);
const novaRazlog = ref('');
function posaljiNovaAkcija() {
    if (!novaRazlog.value.trim()) return;
    put(novaAkcija.value === 'vrati' ? 'vrati' : 'odbij', { rejection_reason: novaRazlog.value });
    novaAkcija.value = null;
    novaRazlog.value = '';
}
</script>

<template>
    <div v-if="pending" class="rounded-xl border border-[#d63638]/40 bg-[#fcebeb] p-4 md:p-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-[15px] font-bold text-ink">Izmjene na čekanju</h2>
            <div class="flex gap-2">
                <button type="button" class="rounded-lg bg-brand px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90" @click="put('odobri-izmjene')">Odobri izmjene</button>
                <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="izmjenaAkcija = izmjenaAkcija === 'vrati' ? null : 'vrati'">Vrati na doradu</button>
                <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="izmjenaAkcija = izmjenaAkcija === 'odbij' ? null : 'odbij'">Odbij izmjene</button>
            </div>
        </div>
        <p class="mt-1 text-[12px] text-ink-2">{{ subjekt === 'autor' ? 'Autor' : 'Vlasnik' }} je poslao izmjene. Živa {{ zivo }} ostaje aktivna dok ne odobriš.</p>

        <div v-if="izmjenaAkcija" class="mt-3 space-y-2 rounded-lg border border-line bg-surface p-3">
            <label class="text-[12px] font-bold text-ink">{{ izmjenaAkcija === 'vrati' ? `Šta ${subjekt} treba da ispravi?` : 'Razlog odbijanja izmjena' }}</label>
            <textarea v-model="izmjenaRazlog" rows="2" class="w-full rounded-lg border border-line bg-surface p-2 text-[13px] text-ink focus:border-brand focus:outline-none"></textarea>
            <button type="button" :disabled="!izmjenaRazlog.trim()" class="rounded-lg bg-[#8C5810] px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90 disabled:opacity-40" @click="posaljiIzmjenaAkcija">{{ izmjenaAkcija === 'vrati' ? `Pošalji ${subjekt}u na doradu` : 'Odbij izmjene' }}</button>
        </div>

        <div v-if="pending.diff && pending.diff.length" class="mt-3 space-y-2">
            <div v-for="r in pending.diff" :key="r.polje" class="rounded-lg border border-line bg-surface p-2.5">
                <p class="text-[12px] font-bold text-ink">{{ r.polje }}</p>
                <div class="mt-1 grid gap-1 text-[13px] sm:grid-cols-2">
                    <div class="text-ink-3 line-through">{{ r.staro || '-' }}</div>
                    <div class="font-medium text-ink">{{ r.novo || '-' }}</div>
                </div>
            </div>
        </div>
        <p v-else class="mt-3 text-[13px] text-ink-2">Nema promjena u tekstualnim poljima.</p>

        <div v-if="pending.naslovnaNova || (pending.galerijaNova && pending.galerijaNova.length)" class="mt-3">
            <p class="text-[12px] font-bold text-ink">Nove slike na čekanju</p>
            <div class="mt-1.5 flex flex-wrap gap-2">
                <img v-if="pending.naslovnaNova" :src="pending.naslovnaNova" class="h-16 w-24 rounded-lg object-cover" alt="" />
                <img v-for="(g, i) in (pending.galerijaNova || [])" :key="i" :src="g" class="h-16 w-24 rounded-lg object-cover" alt="" />
            </div>
        </div>
    </div>

    <div v-else-if="id && status === 'poslano'" class="rounded-xl border border-[#8C5810]/40 bg-[#fff8ee] p-4 md:p-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-[15px] font-bold text-ink">Novi unos na čekanju</h2>
            <div class="flex gap-2">
                <button type="button" class="rounded-lg bg-brand px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90" @click="put('odobri')">Odobri i objavi</button>
                <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="novaAkcija = novaAkcija === 'vrati' ? null : 'vrati'">Vrati na doradu</button>
                <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="novaAkcija = novaAkcija === 'odbij' ? null : 'odbij'">Odbij</button>
            </div>
        </div>
        <p class="mt-1 text-[12px] text-ink-2">Novi unos čeka pregled. Odobri za objavu, ili ga vrati {{ subjekt }}u na doradu / odbij uz razlog.</p>

        <div v-if="novaAkcija" class="mt-3 space-y-2 rounded-lg border border-line bg-surface p-3">
            <label class="text-[12px] font-bold text-ink">{{ novaAkcija === 'vrati' ? `Šta ${subjekt} treba da ispravi?` : 'Razlog odbijanja' }}</label>
            <textarea v-model="novaRazlog" rows="2" class="w-full rounded-lg border border-line bg-surface p-2 text-[13px] text-ink focus:border-brand focus:outline-none"></textarea>
            <button type="button" :disabled="!novaRazlog.trim()" class="rounded-lg bg-[#8C5810] px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90 disabled:opacity-40" @click="posaljiNovaAkcija">{{ novaAkcija === 'vrati' ? 'Pošalji na doradu' : 'Odbij unos' }}</button>
        </div>
    </div>
</template>
