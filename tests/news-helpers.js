// tests/news-helpers.js
import { request as pwRequest } from '@playwright/test';

const BASE = 'http://localhost:8000';
const AUTH = 'Basic ' + Buffer.from(
  `${process.env.WP_USER}:${process.env.WP_APP_PASSWORD}`
).toString('base64');

/** Create (or reuse) a published news post. Returns {id, link}. */
export async function ensureNewsPost(opts = {}) {
  const {
    title = 'Trailer nou pentru Dune: Partea a treia',
    topicSlug = 'trailer',
    related = '',           // comma string of movie IDs
  } = opts;

  const ctx = await pwRequest.newContext({
    baseURL: BASE,
    extraHTTPHeaders: { Authorization: AUTH, 'Content-Type': 'application/json' },
  });

  // Resolve the topic term id.
  const topicRes = await ctx.get(`/wp-json/wp/v2/news_topic?slug=${topicSlug}`);
  const topicId = (await topicRes.json())[0].id;

  const res = await ctx.post('/wp-json/wp/v2/stiri', {
    data: {
      title,
      status: 'publish',
      excerpt: 'Warner Bros. a lansat primele imagini din continuarea trilogiei.',
      content: '<p>Conținut de test pentru știre.</p>',
      news_topic: [topicId],
      meta: { related_films: related },
    },
  });
  if (![200, 201].includes(res.status())) {
    throw new Error(`Create stiri failed: ${res.status()} ${await res.text()}`);
  }
  const body = await res.json();
  await ctx.dispose();
  return { id: body.id, link: body.link };
}

/** Find any published movie post id (for related-film tests). */
export async function anyMovieId() {
  const ctx = await pwRequest.newContext({ baseURL: BASE });
  const res = await ctx.get('/wp-json/wp/v2/posts?per_page=1');
  const id = (await res.json())[0].id;
  await ctx.dispose();
  return id;
}
