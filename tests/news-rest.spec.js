import { test, expect } from '@playwright/test';

test.describe('Stiri CPT registration', () => {
  test('stiri post type is registered and REST-exposed', async ({ request }) => {
    const res = await request.get('/wp-json/wp/v2/types/stiri');
    expect(res.status()).toBe(200);
    const body = await res.json();
    expect(body.rest_base).toBe('stiri');
  });

  test('news_topic taxonomy exists with seeded terms', async ({ request }) => {
    const res = await request.get('/wp-json/wp/v2/news_topic?per_page=50');
    expect(res.status()).toBe(200);
    const slugs = (await res.json()).map(t => t.slug);
    for (const s of ['trailer', 'streaming', 'premiera', 'editorial']) {
      expect(slugs).toContain(s);
    }
  });
});
