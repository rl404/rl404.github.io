<script lang="ts">
	import Border from '$lib/components/commons/Border.svelte';
	import { data } from '$lib/const';
</script>

<div class="flex items-end gap-2">
	<h2 id="language" class="text-3xl font-bold">Languages</h2>
	<span class="hover">— {data.languages.length.toLocaleString()}</span>
</div>

<Border />

<section class="grid gap-4">
	{#each data.languages as lang}
		<div class="flex gap-2">
			<span>{lang.name}</span>
			<span class="hover">— {lang.level}</span>
		</div>
	{/each}
</section>
