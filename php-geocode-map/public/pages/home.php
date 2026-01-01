<script>
    window.MARKERS = <?= json_encode($markers, JSON_UNESCAPED_UNICODE); ?>;
    window.FAILED = <?= json_encode($failed,  JSON_UNESCAPED_UNICODE); ?>;
</script>

<main class="mx-auto max-w-6xl px-4 py-6 space-y-6 text-black">
    <section class="rounded-lg border border-slate-200 bg-[#E9FCFA] shadow-sm overflow-hidden">
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 px-4 py-3">
            <form method="POST">
                <input type="hidden" name="action" value="geocode">
                <button
                    type="submit"
                    id="btnGeocode"
                    class="items-center justify-center rounded-lg bg-[#25E2CC] px-4 py-2 text-sm font-semibold text-black hover:bg-[#FBCA18] transition-all duration-300 ease-in-out">
                    Geocode Et
                </button>
            </form>
            <button
                type="button"
                id="btnOpenMapFullScreen"
                class="items-center justify-center rounded-lg bg-[#25E2CC] px-4 py-2 text-sm font-semibold text-black hover:bg-[#FBCA18] transition-all duration-300 ease-in-out">
                Tam Ekran
            </button>
        </div>

        <div id="map" class="h-[420px] w-full"></div>
    </section>

    <section>
        <div class="rounded-lg border border-slate-200 bg-[#E9FCFA] shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
                <div class="flex gap-3 items-center text-base font-semibold text-black">
                    <h2>Adresler</h2>
                </div>
                <form method="GET" class="m-0">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            name="failed"
                            value="1"
                            class="h-4 w-4 rounded border-slate-300 accent-black"
                            <?= $failedOnly ? 'checked' : '' ?>
                            onchange="this.form.submit()">
                        <span class="text-sm text-black/70">Sadece failed olanları göster</span>
                    </label>
                </form>
            </div>
            <ul class="divide-y divide-slate-200">
                <?php foreach ($items as $it): ?>
                    <li class="px-4 py-3 flex items-center justify-between gap-3">
                        <div>
                            <div class="font-semibold text-black"><?= htmlspecialchars($it['title']) ?></div>
                            <div class="text-sm text-black/70"><?= htmlspecialchars($it['address']) ?></div>
                        </div>
                        <?php if (($it['status'] ?? '') === 'success'): ?>
                            <span class="shrink-0 rounded-full bg-[#25E2CC] px-2.5 py-1 text-xs font-semibold text-black">success</span>
                        <?php else: ?>
                            <span class="shrink-0 rounded-full bg-[#FBCA18] px-2.5 py-1 text-xs font-semibold text-black">failed</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</main>

<div id="modalMapFullScreen" class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-sm" aria-hidden="true">
    <div class="w-full h-full p-4">
        <div class="h-full rounded-lg border border-slate-200 bg-[#E9FCFA] shadow-sm overflow-hidden flex flex-col">
            <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
                <div class="font-semibold text-black">Harita</div>
                <button type="button" id="btnExitMapFullScreen"
                    class="inline-flex items-center justify-center rounded-lg bg-[#25E2CC] px-4 py-2 text-sm font-semibold text-black hover:bg-[#FBCA18] transition">
                    Çık
                </button>
            </div>
            <div id="mapFullscreen" class="flex-1 w-full"></div>
        </div>
    </div>
</div>