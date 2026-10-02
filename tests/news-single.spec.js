// tests/news-single.spec.js
import { test, expect } from '@playwright/test';
import { ensureNewsPost, anyMovieId } from './news-helpers.js';

test.describe('single news article', () => {
  let withFilm, noFilm;
  test.beforeAll(async () => {
    const movieId = await anyMovieId();
    withFilm = await ensureNewsPost({ title: 'Știre cu film atașat', related: String(movieId) });
    noFilm   = await ensureNewsPost({ title: 'Știre fără film', topicSlug: 'editorial', related: '' });
  });

  test('emits NewsArticle schema, not Movie', async ({ page }) => {
    await page.goto(withFilm.link);
    await expect(page.locator('main[itemtype="https://schema.org/NewsArticle"]')).toBeVisible();
    await expect(page.locator('[itemtype="https://schema.org/Movie"]')).toHaveCount(0);
    await expect(page.locator('h1[itemprop="headline"]')).toHaveText('Știre cu film atașat');
  });

  test('shows related-film block only when related films set', async ({ page }) => {
    await page.goto(withFilm.link);
    await expect(page.locator('.news-related')).toBeVisible();
    await expect(page.locator('.news-related__cta').first()).toHaveText(/Detalii film/i);

    await page.goto(noFilm.link);
    await expect(page.locator('.news-related')).toHaveCount(0);
  });
});
