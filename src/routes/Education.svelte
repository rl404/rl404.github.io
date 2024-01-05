<script lang="ts">
	import Border from '$lib/components/commons/Border.svelte';
	import CalendarIcon from '$lib/components/icons/CalendarIcon.svelte';
	import LocationIcon from '$lib/components/icons/LocationIcon.svelte';
	import { data } from '$lib/const';
</script>

<div class="flex items-end gap-2">
	<h2 class="text-3xl font-bold">Education</h2>
	<span class="hover">— {data.educations.length.toLocaleString()}</span>
</div>

<Border />

<section class="grid gap-4">
	{#each data.educations as edu}
		<div class="grid grid-cols-12 gap-2">
			<div class="col-span-12 flex flex-col sm:col-span-3">
				<h3 class="text-2xl font-bold">
					<a href={edu.link} target="_blank">{edu.school}</a>
				</h3>
				<div class="hover flex items-center gap-1">
					<LocationIcon class="h-4 w-4 text-primary" />
					<span>{edu.location}</span>
				</div>
				<div class="hover flex items-center gap-1">
					<CalendarIcon class="h-4 w-4 text-primary" />
					<span>{edu.startDate} - {edu.endDate}</span>
				</div>
			</div>
			<div class="col-span-12 flex flex-col sm:col-span-9">
				<h3 class="text-xl font-bold">{edu.position}</h3>
				<ul class="list-inside list-disc">
					{#each edu.tasks as w}
						<li>{w}</li>
					{/each}
				</ul>
			</div>
		</div>
	{/each}
</section>
