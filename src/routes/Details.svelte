<script lang="ts">
	import EnvelopIcon from '$lib/components/icons/EnvelopIcon.svelte';
	import GithubIcon from '$lib/components/icons/GithubIcon.svelte';
	import LinkedinIcon from '$lib/components/icons/LinkedinIcon.svelte';
	import LocationIcon from '$lib/components/icons/LocationIcon.svelte';
	import { data } from '$lib/const';
</script>

<section class="grid grid-cols-12">
	<div class="hover col-span-12 flex items-center gap-1 sm:col-span-6 md:col-span-4 lg:col-span-3">
		<LocationIcon class="h-4 w-4 text-primary" />
		<span>{data.address.region}, {data.address.country}, {data.address.postalCode}</span>
	</div>
	<div class="hover col-span-12 flex items-center gap-1 sm:col-span-6 md:col-span-4 lg:col-span-3">
		<EnvelopIcon class="h-4 w-4 text-primary" />
		<span>{data.email}</span>
	</div>
	<a
		href={data.github.link}
		target="_blank"
		class="hover col-span-12 flex items-center gap-1 sm:col-span-6 md:col-span-4 lg:col-span-3"
	>
		<GithubIcon class="h-4 w-4 text-primary" />
		<span>{data.github.name}</span>
	</a>
	<a
		href={data.linkedin.link}
		target="_blank"
		class="hover col-span-12 flex items-center gap-1 sm:col-span-6 md:col-span-4 lg:col-span-3"
	>
		<LinkedinIcon class="h-4 w-4 text-primary" />
		<span>{data.linkedin.name}</span>
	</a>
</section>
