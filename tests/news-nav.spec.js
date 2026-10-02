import { test, expect } from '@playwright/test';

test('desktop nav has a Știri link to /stiri', async ({ page }) => {
  await page.goto('/');
  const link = page.locator('a[href$="/stiri"]', { hasText: 'Știri' }).first();
  await expect(link).toHaveCount(1);
});
