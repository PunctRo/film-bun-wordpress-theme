import { test, expect } from '@playwright/test';
import { ensureNewsPost } from './news-helpers.js';

test.skip('related-films metabox appears on stiri edit screen', async ({ page, context }) => {
  // Log into wp-admin
  await page.goto('/wp-login.php');
  await page.fill('#user_login', process.env.WP_USER);
  await page.fill('#user_pass', process.env.WP_APP_PASSWORD); // use real admin pass if app-pass not accepted on login form
  await page.click('#wp-submit');

  const { id } = await ensureNewsPost({ title: 'Metabox test' });
  await page.goto(`/wp-admin/post.php?post=${id}&action=edit`);
  await expect(page.locator('#news_related_films')).toBeVisible();
});
