<script lang="ts">
	import { data } from '$lib/const';
	import type { ProfilePage, WithContext } from 'schema-dts';

	const schema: WithContext<ProfilePage> = {
		'@context': 'https://schema.org',
		'@type': 'ProfilePage',
		mainEntity: {
			'@type': 'Person',
			name: data.name,
			image: 'https://www.rl404.com/profile.jpg',
			description: data.summary,
			birthDate: data.birth.date,
			birthPlace: data.birth.place,
			gender: data.gender,
			address: {
				'@type': 'PostalAddress',
				addressRegion: data.address.region,
				addressCountry: data.address.country,
				postalCode: data.address.postalCode
			},
			telephone: data.phone,
			email: data.email,
			url: 'https://www.rl404.com',
			sameAs: [data.github.link, data.linkedin.link],
			jobTitle: data.experiences[0].position,
			worksFor: {
				'@type': 'Organization',
				name: data.experiences[0].company,
				url: data.experiences[0].link,
				address: data.experiences[0].location
			},
			alumniOf: [
				...data.experiences.slice(1).map((e) => ({
					'@type': 'Organization',
					name: e.company,
					url: e.link,
					address: e.location
				})),
				...data.educations.map((e) => ({
					'@type': 'EducationalOrganization',
					name: e.school,
					url: e.link,
					address: e.location
				}))
			] as any,
			knowsLanguage: data.languages.map((l) => ({
				'@type': 'Language',
				name: l.name,
				description: l.level
			})),
			publishingPrinciples: data.projects.personal.map((p) => ({
				'@type': 'CreativeWork',
				name: p.name,
				description: p.description,
				url: p.link
			}))
		}
	};
</script>

<svelte:head>
	<link rel="canonical" href="https://www.rl404.com" />
	{@html `<script type="application/ld+json">${JSON.stringify(schema)}${'<'}/script>`}
</svelte:head>
