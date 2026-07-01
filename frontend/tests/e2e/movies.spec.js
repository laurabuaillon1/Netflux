// @ts-check
import { test, expect } from "@playwright/test";

test.describe("Gestion des films en E2E", () => {
  test.beforeEach(async ({ page }) => {
    await page.goto("/");
    await page.evaluate(() => {
      localStorage.clear();
    });
  });

  //----------------//
  //-----FILMS-----//
  //---------------//
  test("devrait afficher la liste des films", async ({ page }) => {
    await page.goto("/movies");

    // Expect a title "to contain" a substring.
    await expect(page.locator(".movie-card").first()).toBeVisible();
  });

  test("devrait filtrer par genre la liste des films", async ({ page }) => {
    await page.goto("/movies");
    await expect(page.locator("select#genre")).toBeVisible();
    await expect(page.locator("select#genre option", { hasText: "Action" })).toBeAttached();
    await page.selectOption("select#genre", { label: "Action" });

    await expect(page.locator(".movie-card").first()).toBeVisible();
  });

  test("devrait afficher les détails d'un film", async ({ page }) => {
    await page.goto("/movies");
    const premiereCarte = page.locator(".movie-card").first();
    await premiereCarte.hover();
    await page.click("a.info-btn");

    //viser une URL avec id (ex:/movies/:id)
    await expect(page).toHaveURL(/\/movies\/\d+/);
  });

  test("devrait afficher la liste des favoris à un utilisateur connecté", async ({ page }) => {
    //Se connecte avant
    await page.goto("/login");
    await page.fill("input#email", "admin@netflux.fr");
    await page.fill("input#password", "admin123");
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL("/");

    await page.goto("/")
    await page.click('a:has-text("favoris")');
  })

  
  
});
