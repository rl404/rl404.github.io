<script lang="ts">
	import Border from '$lib/components/commons/Border.svelte';
	import CalendarIcon from '$lib/components/icons/CalendarIcon.svelte';
	import LocationIcon from '$lib/components/icons/LocationIcon.svelte';

	import { data } from '$lib/const';
</script>

<div class="flex items-end gap-2">
	<h2 class="text-3xl font-bold">Activities and Achievements</h2>
	<span class="hover whitespace-nowrap">— {data.activities.length.toLocaleString()}</span>
</div>

<Border />

<section class="grid gap-4">
	{#each data.activities as act}
		<div class="grid grid-cols-12 gap-2">
			<div class="col-span-12 flex flex-col sm:col-span-3">
				<h3 class="text-2xl font-bold">
					<a href={act.link} target="_blank">{act.place}</a>
				</h3>
				<div class="hover flex items-center gap-1">
					<LocationIcon class="h-4 w-4 text-primary" />
					<span>{act.location}</span>
				</div>
				<div class="hover flex items-center gap-1">
					<CalendarIcon class="h-4 w-4 text-primary" />
					<span>{act.startDate} - {act.endDate}</span>
				</div>
			</div>
			<div class="col-span-12 flex flex-col sm:col-span-9">
				<h3 class="text-xl font-bold">{act.position}</h3>
				<ul class="list-disc pl-4">
					{#each act.tasks as w}
						<li>{w}</li>
					{/each}
				</ul>
			</div>
		</div>
	{/each}
</section>
