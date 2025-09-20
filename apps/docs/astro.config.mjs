// @ts-check
import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

// https://astro.build/config
export default defineConfig({
	integrations: [
		starlight({
			title: 'My Docs',
			social: [{ icon: 'github', label: 'GitHub', href: 'https://github.com/titerin' }],
			sidebar: [
                {
                    label: 'Objectifs',
                    link: '/goals'
                },
                {
                    label: "Decision Records",
                    autogenerate: { directory: "adr" }
                },
                {
                    label: 'Roadmap',
                    link: '/roadmap'
                }
			],
		}),
	],
});
