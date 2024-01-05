<script lang="ts">
	import Border from '$lib/components/commons/Border.svelte';
	import Head from '$lib/components/commons/Head.svelte';
	import Activity from './Activity.svelte';
	import Details from './Details.svelte';
	import Education from './Education.svelte';
	import Experience from './Experience.svelte';
	import Language from './Language.svelte';
	import Name from './Name.svelte';
	import Project from './Project.svelte';
	import Skill from './Skill.svelte';
	import Summary from './Summary.svelte';
</script>

<Head />

<main class="container mx-auto my-24 grid max-w-6xl gap-4 px-4">
	<Name />
	<Details />
	<Border />

	<Summary />
	<Border />

	<Experience />
	<Border />

	<Education />
	<Border />

	<Activity />
	<Border />

	<div class="grid grid-cols-2 gap-4">
		<div class="col-span-2 md:col-span-1">
			<Language />
		</div>
		<div class="col-span-2 md:col-span-1">
			<Skill />
		</div>
	</div>
	<Border />

	<Project />
	<Border />

	<div class="hover text-center">- Thank you for visiting -</div>
</main>
