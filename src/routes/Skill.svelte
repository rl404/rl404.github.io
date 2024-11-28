<script lang="ts">
	import Border from '$lib/components/commons/Border.svelte';
	import { data } from '$lib/const';

	const count =
		data.skills.language.length +
		data.skills.database.length +
		data.skills.pubsub.length +
		data.skills.monitoring.length +
		data.skills.version.length +
		data.skills.devops.length;
</script>

<div class="flex items-end gap-2">
	<h2 id="skill" class="text-3xl font-bold">Skills</h2>
	<span class="hover">— {count.toLocaleString()}</span>
</div>

<Border />

<section class="grid grid-cols-2 gap-2">
	<div class="flex flex-col">
		<h3 class="hover">Language</h3>
		<div>{data.skills.language.join(', ')}</div>
	</div>
	<div class="flex flex-col">
		<h3 class="hover">Database</h3>
		<div>{data.skills.database.join(', ')}</div>
	</div>
	<div class="flex flex-col">
		<h3 class="hover">Pubsub</h3>
		<div>{data.skills.pubsub.join(', ')}</div>
	</div>
	<div class="flex flex-col">
		<h3 class="hover">Monitoring</h3>
		<div>{data.skills.monitoring.join(', ')}</div>
	</div>
	<div class="flex flex-col">
		<h3 class="hover">Version Control</h3>
		<div>{data.skills.version.join(', ')}</div>
	</div>
	<div class="flex flex-col">
		<h3 class="hover">DevOps</h3>
		<div>{data.skills.devops.join(', ')}</div>
	</div>
</section>
