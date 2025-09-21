// @ts-check
import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

// https://astro.build/config
export default defineConfig({
	vite: {
        server: {
            allowedHosts: ["localhost", "docs.local.test",]
        }
    },
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
                    label: "Proof of Concept",
                    link: "/poc"
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
