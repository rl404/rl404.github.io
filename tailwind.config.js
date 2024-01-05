/** @type {import('tailwindcss').Config} */
export default {
	content: ['./src/**/*.{html,js,svelte,ts}'],
	theme: {
		extend: {
			colors: {
				primary: '#428375',
				secondary: '#42837580'
			},
			textColor: {
				body: '#e9e8e8'
			},
			backgroundColor: {
				body: '#303030'
			}
		}
	},
	plugins: []
};
