<script lang="ts">
	import { onMount } from 'svelte';

	let publicGAID = 'G-RD1JM9E22V';
	let domain = 'https://www.googletagmanager.com';
	let scriptID = 'google-analytics-script';
	let mounted = false;

	async function addGoogleAnalyticsScript(
		propID: string,
		domain: string,
		dataLayerName = 'dataLayer'
	) {
		return new Promise((resolve, reject) => {
			const head = document.head || document.getElementsByTagName('head')[0];
			const script = document.createElement('script');
			script.id = scriptID;
			script.async = true;
			script.src = `${domain}/gtag/js?id=${propID}&l=${dataLayerName}`;
			script.setAttribute('data-testid', 'google_analytics_script');
			script.onload = resolve;
			script.onerror = reject;
			head.appendChild(script);
		});
	}

	onMount(async () => {
		// We add the script only once even when the component rendered twice.
		if (window.document.getElementById(scriptID)) return;

		window.dataLayer = window.dataLayer || [];
		window.gtag = function () {
			window.dataLayer.push(arguments);
		};
		window.gtag('js', new Date());
		window.gtag('config', publicGAID);

		try {
			await addGoogleAnalyticsScript(publicGAID, domain);
		} catch (err) {
			const s = window.document.getElementById(scriptID);
			if (s) {
				s.remove();
			}
			return;
		}

		mounted = true;
	});

	$: {
		if (mounted && window.gtag) {
			window.gtag('config', publicGAID);
		}
	}
</script>

<svelte:head>
	<link rel="preconnect" href={domain} />
</svelte:head>
