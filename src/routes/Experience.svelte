<script lang="ts">
	import Border from '$lib/components/commons/Border.svelte';
	import CalendarIcon from '$lib/components/icons/CalendarIcon.svelte';
	import LocationIcon from '$lib/components/icons/LocationIcon.svelte';
	import UsersIcon from '$lib/components/icons/UsersIcon.svelte';
	import { data } from '$lib/const';

	let useSimple: boolean = false;
</script>

<div class="flex items-center justify-between gap-2">
	<div class="flex items-end gap-2">
		<h2 class="text-3xl font-bold">Experience</h2>
		<span class="hover">— {data.experiences.length.toLocaleString()}</span>
	</div>
	<div class="hover flex items-center gap-2">
		<input id="useSimple" type="checkbox" bind:checked={useSimple} />
		<label for="useSimple">Simpler Tasks</label>
	</div>
</div>

<Border />

<section class="grid gap-4">
	{#each data.experiences as exp}
		<div class="grid grid-cols-12 gap-1">
			<div class="col-span-12 flex flex-col sm:col-span-3">
				<h3 class="text-2xl font-bold">
					<a href={exp.link} target="_blank">{exp.company}</a>
				</h3>
				<div class="hover flex items-center gap-1">
					<UsersIcon class="h-4 w-4 text-primary" />
					<span>{exp.team}</span>
				</div>
				<div class="hover flex items-center gap-1">
					<LocationIcon class="h-4 w-4 text-primary" />
					<span>{exp.location}</span>
				</div>
				<div class="hover flex items-center gap-1">
					<CalendarIcon class="h-4 w-4 text-primary" />
					<span>{exp.startDate} - {exp.endDate}</span>
				</div>
			</div>
			<div class="col-span-12 flex flex-col sm:col-span-9">
				<h3 class="text-xl font-bold">{exp.position}</h3>
				<ul class="list-disc pl-4">
					{#each useSimple ? exp.simpleTasks : exp.tasks as w}
						<li>{w}</li>
					{/each}
				</ul>
			</div>
		</div>
	{/each}
</section>
