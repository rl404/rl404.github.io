<script lang="ts">
	import Analytics from './Analytics.svelte';

	export let title: string = "Axel Oktavian Antonio's Portfolio";
	export let description: string =
		"All Axel's information related with education, experience, and portfolio.";
	export let image: string = '/profile.jpg';
</script>

<svelte:head>
	<title>{title}</title>
	<meta name="description" content={description} />
	<meta property="og:title" content={title} />
	<meta property="og:description" content={description} />
	<meta property="og:image" content={image} />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="Axel's Portfolio" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta http-equiv="content-type" content="text/html charset=utf-8" />
	<meta name="theme-color" content="#428375" />
	<meta name="twitter:card" content="summary_large_image" />
</svelte:head>

<Analytics />
