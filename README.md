# Film Bun – custom WordPress theme

A custom WordPress theme I built from scratch for [film-bun.ro](https://film-bun.ro), a Romanian movie recommendations site. No page builder and no parent theme: plain PHP templates, Tailwind CSS built with Vite, and small vanilla JS/jQuery modules.

film-bun.ro ran on this theme until I ported it to Astro and moved the site to Cloudflare. This repository is a snapshot of the WordPress version.

## What's in it

- **Content model**: custom taxonomies for actors, directors and release year (`includes/class-movie-taxonomies.php`), movie metadata meta boxes, a separate News post type with Customizer settings and related-films meta boxes.
- **Templates**: front page, archives, category/tag/taxonomy pages with custom headers, single movie and news pages, curated landing pages, search, 404.
- **Editor-friendly**: movie metadata, related content and news settings are edited from wp-admin and the Customizer.
- **Custom features**: comments with star ratings and AJAX voting (IP stored only as a salted hash), search query logging and affiliate click tracking, with stats exposed through REST endpoints under `film-bun/v1`.
- **SEO**: Rank Math filters for unique paginated titles and schema data.
- **Tests**: Playwright end-to-end specs for the news section and comments, plus a PHP test for the news helpers.
- **Deployment**: GitHub Actions builds the assets and deploys the theme over rsync/SSH, then purges the LiteSpeed cache.

## Structure

```
functions.php          loads everything from includes/
includes/              taxonomies, post types, meta boxes, REST routes, helpers
template-parts/        header, footer, cards, pagination, single content
assets/                Tailwind source, JS, images
tests/                 Playwright and PHP tests
.github/workflows/     deploy pipeline
```

## Local development

```
npm install
npm run dev     # Vite dev server
npm run build   # production assets
```

Drop the folder into `wp-content/themes/` and activate it.

---

Bogdan Busuioc · [devbybb.com](https://devbybb.com)
