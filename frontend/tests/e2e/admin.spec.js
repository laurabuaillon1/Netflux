import { test, expect } from "@playwright/test";

test.describe("Gestion des utilisateurs", () => {
  test.beforeEach(async ({ page }) => {
    await page.goto("/");
    await page.evaluate(() => localStorage.clear());

    //Connexion en tant qu'administrateur
    await page.goto("/login");
    await page.fill("input#email", "admin@netflux.fr");
    await page.fill("input#password", "admin123");
    await page.click('button[type="submit"]');

    await page.waitForURL('/')

});

test("devrait avoir accès au Panel admin en tant qu'admin", async ({ page }) => {
    await page.goto("/");
    await page.click('a:has-text("Panel")');
    await expect(page).toHaveURL('/admin')
  });

  
});
