<script lang="ts">
	import Border from '$lib/components/commons/Border.svelte';
	import BuildingIcon from '$lib/components/icons/BuildingIcon.svelte';
	import TagIcon from '$lib/components/icons/TagIcon.svelte';
	import UserIcon from '$lib/components/icons/UserIcon.svelte';

	import { data } from '$lib/const';
	const count = data.projects.personal.length + data.projects.work.length;
</script>

<div class="flex items-end gap-2">
	<h2 class="text-3xl font-bold">Projects</h2>
	<span
		class="hover"
		title={`${data.projects.personal.length} personal & ${data.projects.work.length} work`}
		>— {count.toLocaleString()}</span
	>
</div>

<Border />

<section class="grid grid-cols-2 gap-4">
	{#each data.projects.personal as p}
		<div class="flex flex-col">
			<h3 class="text-2xl font-bold">
				{#if p.link}
					<a href={p.link} target="_blank">{p.name}</a>
				{:else}
					{p.name}
				{/if}
			</h3>
			<div>{p.description}</div>
			<div class="hover flex items-center gap-1">
				<span title="personal project"><UserIcon class="h-4 w-4 text-primary" /></span>
				<span><TagIcon class="h-4 w-4 text-primary" /></span>
				<span class="line-clamp-1" title={p.tags.join(', ')}>{p.tags.join(', ')}</span>
			</div>
		</div>
	{/each}
	{#each data.projects.work as p}
		<div class="flex flex-col">
			<h3 class="text-2xl font-bold">
				{#if p.link}
					<a href={p.link} target="_blank">{p.name}</a>
				{:else}
					{p.name}
				{/if}
			</h3>
			<div>{p.description}</div>
			<div class="hover flex items-center gap-1">
				<span title="work project"><BuildingIcon class="h-4 min-w-4 text-primary" /></span>
				<span><TagIcon class="h-4 min-w-4 text-primary" /></span>
				<span class="line-clamp-1" title={p.tags.join(', ')}>{p.tags.join(', ')}</span>
			</div>
		</div>
	{/each}
</section>
