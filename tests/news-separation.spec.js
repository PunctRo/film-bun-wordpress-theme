import { test, expect } from '@playwright/test';
import { ensureNewsPost } from './news-helpers.js';

test.describe('news ⇄ movie isolation', () => {
  let news;
  test.beforeAll(async () => { news = await ensureNewsPost({ title: 'Izolare: știre de test' }); });

  test('news does not appear on the homepage movie feed', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('text=Izolare: știre de test')).toHaveCount(0);
  });

  test('news does not appear in a movie category archive', async ({ page }) => {
    await page.goto('/horror/');
    await expect(page.locator('text=Izolare: știre de test')).toHaveCount(0);
  });

  test('/stiri archive shows the news item', async ({ page }) => {
    await page.goto('/stiri/');
    await expect(page.locator('.news-card', { hasText: 'Izolare: știre de test' })).toBeVisible();
  });

  test('REST: stiri endpoint and posts endpoint are disjoint types', async ({ request }) => {
    const stiri = await request.get(`/wp-json/wp/v2/stiri?per_page=100`);
    const ids = (await stiri.json()).map(p => p.id);
    expect(ids).toContain(news.id);
    const asPost = await request.get(`/wp-json/wp/v2/posts/${news.id}`);
    expect(asPost.status()).toBe(404); // a stiri id is not a 'post'
  });
});
